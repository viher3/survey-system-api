<?php

namespace SurveySystem\Survey\Application\SurveyFulfillment\Read;

use SurveySystem\Survey\Domain\SurveyFulfillment\SurveyFulfillmentRepository;

final class SurveyFulfillmentListService
{
    private SurveyFulfillmentRepository $surveyFulfillmentRepository;

    /**
     * @param SurveyFulfillmentRepository $surveyFulfillmentRepository
     */
    public function __construct(SurveyFulfillmentRepository $surveyFulfillmentRepository)
    {
        $this->surveyFulfillmentRepository = $surveyFulfillmentRepository;
    }

    /**
     * @param array $filters
     * @return SurveyFulfillmentListResponse
     */
    public function execute(array $filters = []) : SurveyFulfillmentListResponse
    {
        $surveysFulfillment = $this->surveyFulfillmentRepository->listWithReplies($filters);
        $totalSurveysFulfillment = $this->surveyFulfillmentRepository->total($filters);
        return SurveyFulfillmentListResponse::create($surveysFulfillment, $totalSurveysFulfillment);
    }
}
