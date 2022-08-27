<?php

namespace SurveySystem\Survey\Application\Survey\Find;

use SurveySystem\Survey\Domain\Survey\SurveyId;
use SurveySystem\Survey\Domain\Survey\SurveyNotFound;
use SurveySystem\Survey\Domain\Survey\SurveyRepository;

final class SurveyDetailFinder
{
    /**
     * @var SurveyRepository
     */
    private SurveyRepository $surveyRepository;

    /**
     * @param SurveyRepository $surveyRepository
     */
    public function __construct(SurveyRepository $surveyRepository)
    {
        $this->surveyRepository = $surveyRepository;
    }

    /**
     * @param SurveyId $id
     * @return SurveyDetailFinderResponse
     * @throws SurveyNotFound
     */
    public function execute(SurveyId $id) : SurveyDetailFinderResponse
    {
        $survey = $this->surveyRepository->search($id);

        if(!$survey){
            throw new SurveyNotFound($id);
        }

        return SurveyDetailFinderResponse::create($survey);
    }
}
