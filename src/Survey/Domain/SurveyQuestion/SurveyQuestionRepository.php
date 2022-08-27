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

    /**
     * @param string $surveyId
     * @param array $filters
     * @return array
     */
    public function getList(string $surveyId, array $filters = []) : array;

    /**
     * @param string $surveyId
     * @param array $filters
     * @return int
     */
    public function total(string $surveyId, array $filters = []) : int;
}
