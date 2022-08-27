<?php

namespace SurveySystem\Survey\Application\Survey\Read;

use SurveySystem\Survey\Domain\Survey\SurveyRepository;

final class SurveyListService
{
    private SurveyRepository $surveyRepository;

    public function __construct(SurveyRepository $surveyRepository)
    {
        $this->surveyRepository = $surveyRepository;
    }

    /**
     * @param array $filters
     * @return SurveyListResponse
     */
    public function execute(array $filters = []) : SurveyListResponse
    {
        $surveys = $this->surveyRepository->getList($filters);
        $totalSurveys = $this->surveyRepository->total($filters);
        return SurveyListResponse::create($surveys, $totalSurveys);
    }
}
