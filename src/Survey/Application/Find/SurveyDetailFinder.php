<?php

namespace SurveySystem\Survey\Application\Find;

use SurveySystem\Survey\Domain\SurveyId;
use SurveySystem\Survey\Domain\SurveyNotFound;
use SurveySystem\Survey\Domain\SurveyRepository;

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
