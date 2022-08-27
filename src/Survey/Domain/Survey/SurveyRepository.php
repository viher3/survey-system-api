<?php

namespace SurveySystem\Survey\Domain\Survey;

interface SurveyRepository
{
    /**
     * @param Survey $survey
     * @return void
     */
    public function save(Survey $survey): void;

    /**
     * @param SurveyId $id
     * @return Survey|null
     */
    public function search(SurveyId $id): ?Survey;

    /**
     * @param array $filters
     * @return array
     */
    public function getList(array $filters = []) : array;

    /**
     * @param array $filters
     * @return int
     */
    public function total(array $filters = []) : int;
}
