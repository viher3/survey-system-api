<?php

namespace SurveySystem\Survey\Application\Survey\Duplicate;

class SurveyDuplicatorCommand
{
    public function __construct(
        private string $surveyId
    )
    {
    }

    /**
     * @return string
     */
    public function getSurveyId(): string
    {
        return $this->surveyId;
    }
}