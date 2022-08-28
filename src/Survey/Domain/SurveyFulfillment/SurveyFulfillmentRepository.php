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
}
