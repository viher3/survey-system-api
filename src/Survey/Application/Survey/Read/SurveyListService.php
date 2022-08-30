<?php

namespace SurveySystem\Survey\Application\Survey\Read;

use SurveySystem\Survey\Domain\Survey\Survey;
use SurveySystem\Survey\Domain\Survey\SurveyRepository;
use SurveySystem\Survey\Domain\SurveyFulfillment\SurveyFulfillmentRepository;

final class SurveyListService
{
    private SurveyRepository $surveyRepository;

    private SurveyFulfillmentRepository $surveyFulfillmentRepository;

    public function __construct(
        SurveyRepository            $surveyRepository,
        SurveyFulfillmentRepository $surveyFulfillmentRepository
    )
    {
        $this->surveyRepository = $surveyRepository;
        $this->surveyFulfillmentRepository = $surveyFulfillmentRepository;
    }

    /**
     * @param array $filters
     * @return SurveyListResponse
     */
    public function execute(array $filters = []): SurveyListResponse
    {
        $surveys = $this->surveyRepository->getList($filters);
        $totalSurveys = $this->surveyRepository->total($filters);

        $surveyIds = [];

        /** @var Survey $survey */
        foreach($surveys as $survey){
            $surveyIds[] = $survey->id();
        }

        $totalSurveysFillment = $this->surveyFulfillmentRepository->totalCountGroupedBySurveyIds($surveyIds);

        return SurveyListResponse::create($surveys, $totalSurveys, $totalSurveysFillment);
    }
}
