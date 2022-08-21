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
}
