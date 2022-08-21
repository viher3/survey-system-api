<?php

namespace SurveySystem\Survey\Application\Create;

use SurveySystem\Survey\Domain\Survey\SurveyId;
use SurveySystem\Survey\Domain\Survey\SurveyRepository;
use SurveySystem\Survey\Domain\SurveyQuestion\SurveyQuestion;
use SurveySystem\Survey\Domain\SurveyQuestion\SurveyQuestionId;
use SurveySystem\Survey\Domain\SurveyQuestion\SurveyQuestionRepository;

class SurveyQuestionCreator
{
    private SurveyRepository $surveyRepository;
    private SurveyQuestionRepository $surveyQuestionRepository;

    /**
     * @param SurveyRepository $surveyRepository
     * @param SurveyQuestionRepository $surveyQuestionRepository
     */
    public function __construct(
        SurveyRepository $surveyRepository,
        SurveyQuestionRepository $surveyQuestionRepository
    )
    {
        $this->surveyRepository = $surveyRepository;
        $this->surveyQuestionRepository = $surveyQuestionRepository;
    }

    /**
     * @param SurveyQuestionCreatorCommand $command
     * @return void
     */
    public function __invoke(SurveyQuestionCreatorCommand $command) : void
    {
        $surveyQuestion = SurveyQuestion::create(
            SurveyQuestionId::random(),
            $command->question(),
            $this->surveyRepository->search(new SurveyId($command->surveyId())),
            $command->position(),
            $command->enabled()
        );

        $this->surveyQuestionRepository->save($surveyQuestion);
    }
}
