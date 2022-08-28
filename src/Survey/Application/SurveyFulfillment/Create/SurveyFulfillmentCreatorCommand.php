<?php

namespace SurveySystem\Survey\Application\SurveyFulfillment\Create;

class SurveyFulfillmentCreatorCommand
{
    private string $surveyId;

    private array $replies;

    /**
     * @param string $surveyId
     * @param array $replies
     */
    public function __construct(string $surveyId, array $replies)
    {
        $this->surveyId = $surveyId;
        $this->replies = $replies;
    }

    /**
     * @return string
     */
    public function surveyId(): string
    {
        return $this->surveyId;
    }

    /**
     * @return array
     */
    public function replies(): array
    {
        return $this->replies;
    }
}
