<?php

namespace SurveySystem\Survey\Domain\SurveyQuestion;

interface SurveyQuestionRepository
{
    /**
     * @param SurveyQuestion $surveyQuestion
     * @return void
     */
    public function save(SurveyQuestion $surveyQuestion): void;

    /**
     * @param SurveyQuestionId $id
     * @return SurveyQuestion|null
     */
    public function search(SurveyQuestionId $id): ?SurveyQuestion;
}
