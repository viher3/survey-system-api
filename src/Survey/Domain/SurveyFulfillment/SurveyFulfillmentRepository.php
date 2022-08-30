<?php

namespace SurveySystem\Survey\Domain\SurveyFulfillment;

use Doctrine\ORM\EntityRepository;

interface SurveyFulfillmentRepository
{
    /**
     * @param SurveyFulfillment $surveyFulfillment
     * @return void
     */
    public function save(SurveyFulfillment $surveyFulfillment): void;

    /**
     * @param array $surveyIds
     * @return array
     */
    public function totalCountGroupedBySurveyIds(array $surveyIds): array;

    /**
     * @param array $filters
     * @return int
     */
    public function total(array $filters = []) : int;

    /**
     * @param array $filters
     * @return array
     */
    public function listWithReplies(array $filters = []) : array;
}
