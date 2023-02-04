<?php

namespace SurveySystem\Survey\Application\SurveyQuestion\Create;

use SurveySystem\Survey\Domain\Survey\SurveyId;
use SurveySystem\Survey\Domain\Survey\SurveyRepository;
use SurveySystem\Survey\Domain\SurveyQuestion\SurveyQuestion;
use SurveySystem\Survey\Domain\SurveyQuestion\SurveyQuestionOptionType;
use SurveySystem\Survey\Domain\SurveyQuestion\SurveyQuestionRepository;
use function Lambdish\Phunctional\map;

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
    public function execute(SurveyQuestionCreatorCommand $command) : void
    {
        $surveyQuestion = SurveyQuestion::create(
            $command->question(),
            $this->surveyRepository->search(new SurveyId($command->surveyId())),
            $command->position(),
            $command->enabled()
        );

        map(function(array $option) use ($surveyQuestion){
            $surveyQuestion->addOption(
                new SurveyQuestionOptionType($option['type']),
                $option['values'],
                $option['position'],
                $option['enabled'] ?? true
            );
        }, $command->getOptions());

        $this->surveyQuestionRepository->save($surveyQuestion);
    }
}
