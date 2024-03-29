<?php

namespace SurveySystem\Survey\Domain\SurveyFulfillment;

use Doctrine\ORM\EntityRepository;
use SurveySystem\Survey\Domain\Survey\SurveyId;

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
    public function listWithReplies(string $id, array $filters = []) : array;

    /**
     * @param string $id
     * @param array $filters
     * @return int
     */
    public function totalWithReplies(string $id, array $filters = []) : int;

    /**
     * @param SurveyId $id
     * @param array $filters
     * @return array
     */
    public function findAllSurveyFulfillments(SurveyId $id, array $filters = []) :  array;
}
