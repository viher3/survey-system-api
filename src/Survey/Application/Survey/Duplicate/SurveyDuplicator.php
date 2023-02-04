<?php

namespace SurveySystem\Survey\Application\Survey\Duplicate;

use SurveySystem\Survey\Domain\Survey\Survey;
use SurveySystem\Survey\Domain\Survey\SurveyId;
use SurveySystem\Survey\Domain\Survey\SurveyNotFound;
use SurveySystem\Survey\Domain\Survey\SurveyRepository;

final class SurveyDuplicator
{
    /**
     * @param SurveyRepository $surveyRepository
     */
    public function __construct(
        private SurveyRepository $surveyRepository
    )
    {
    }

    /**
     * @param SurveyDuplicatorCommand $command
     * @return SurveyDuplicatorCommand
     * @throws SurveyNotFound
     */
    public function execute(
        SurveyDuplicatorCommand $command
    ) : SurveyDuplicatorCommand
    {
        $surveyId = new SurveyId($command->getSurveyId());
        $survey = $this->surveyRepository->search($surveyId);

        if(!$survey){
            throw new SurveyNotFound($surveyId);
        }

        $duplicatedSurvey = new Survey(
            (new SurveyId())->value(),
            $survey->name(),
            $survey->description() . ' duplicated',
            $survey->enabled()
        );

        // TODO: duplicate questions

        $this->surveyRepository->save($duplicatedSurvey);
    }
}