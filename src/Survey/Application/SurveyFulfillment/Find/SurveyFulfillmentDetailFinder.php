<?php

namespace SurveySystem\Survey\Application\SurveyFulfillment\Find;

use SurveySystem\Survey\Domain\SurveyFulfillment\SurveyFulfillmentRepository;

final class SurveyFulfillmentDetailFinder
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
     * @return SurveyFulfillmentDetailResponse
     */
    public function execute(array $filters = []) : SurveyFulfillmentDetailResponse
    {
        $surveysFulfillment = $this->surveyFulfillmentRepository->listWithReplies($filters);
        $totalSurveysFulfillment = $this->surveyFulfillmentRepository->total($filters);
        return SurveyFulfillmentDetailResponse::create($surveysFulfillment, $totalSurveysFulfillment);
    }
}
