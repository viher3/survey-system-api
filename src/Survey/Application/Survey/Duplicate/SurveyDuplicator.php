<?php

namespace SurveySystem\Survey\Application\Survey\Duplicate;

use SurveySystem\Survey\Domain\Survey\Survey;
use SurveySystem\Survey\Domain\Survey\SurveyId;
use SurveySystem\Survey\Domain\Survey\SurveyNotFound;
use SurveySystem\Survey\Domain\Survey\SurveyRepository;
use SurveySystem\Survey\Domain\SurveyQuestion\SurveyQuestion;
use SurveySystem\Survey\Domain\SurveyQuestion\SurveyQuestionOption;
use SurveySystem\Survey\Domain\SurveyQuestion\SurveyQuestionRepository;
use SurveySystem\Survey\Application\SurveyQuestion\Create\SurveyQuestionCreator;
use SurveySystem\Survey\Application\SurveyQuestion\Create\SurveyQuestionCreatorCommand;

final class SurveyDuplicator
{
    /**
     * @param SurveyRepository $surveyRepository
     * @param SurveyQuestionRepository $surveyQuestionRepository
     * @param SurveyQuestionCreator $surveyQuestionCreator
     */
    public function __construct(
        private SurveyRepository $surveyRepository,
        private SurveyQuestionRepository $surveyQuestionRepository,
        private SurveyQuestionCreator $surveyQuestionCreator
    )
    {
    }

    /**
     * @param SurveyDuplicatorCommand $command
     * @return void
     * @throws SurveyNotFound
     */
    public function execute(
        SurveyDuplicatorCommand $command
    ) : void
    {
        $surveyId = new SurveyId($command->getSurveyId());
        $survey = $this->surveyRepository->search($surveyId);

        if(!$survey){
            throw new SurveyNotFound($surveyId);
        }

        $duplicatedSurveyId = SurveyId::random();
        $duplicatedSurvey = new Survey(
            $duplicatedSurveyId,
            $survey->name() . ' (draft)',
            $survey->description(),
            $survey->enabled()
        );

        $this->surveyRepository->save($duplicatedSurvey);

        // duplicate questions
        $surveyQuestions = $this->surveyQuestionRepository->getList($surveyId);

        /** @var SurveyQuestion $surveyQuestion */
        foreach($surveyQuestions as $surveyQuestion){
            $options = [];

            /** @var SurveyQuestionOption $option */
            foreach($surveyQuestion->getOptions() as $option){
                $options[] = $option->toPrimitives();
            }

            $surveyQuestionCreatorCommand = new SurveyQuestionCreatorCommand(
                $surveyQuestion->question(),
                $duplicatedSurveyId->value(),
                $surveyQuestion->position(),
                $surveyQuestion->enabled(),
                $options
            );
            $this->surveyQuestionCreator->execute($surveyQuestionCreatorCommand);
        }
    }
}