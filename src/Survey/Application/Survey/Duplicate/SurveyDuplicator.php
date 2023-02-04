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

        $duplicatedSurvey = new Survey(
            SurveyId::random(),
            $survey->name() . ' (draft)',
            $survey->description(),
            $survey->enabled()
        );

        // TODO: duplicate questions

        $this->surveyRepository->save($duplicatedSurvey);
    }
}