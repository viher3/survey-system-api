<?php

namespace SurveySystem\Survey\Domain\SurveyFulfillment;

use SurveySystem\Survey\Domain\SurveyQuestion\SurveyQuestionId;

class SurveyFulfillmentReply
{
    private string $id;

    private string $surveyQuestionId;

    private SurveyFulfillment $surveyFulfillment;

    private string $values;

    private \DateTimeInterface $createdAt;

    /**
     * @param string $id
     * @param SurveyFulfillment $surveyFulfillment
     * @param SurveyQuestionId $surveyQuestionId
     * @param array $values
     */
    public function __construct(
        string $id,
        SurveyFulfillment $surveyFulfillment,
        SurveyQuestionId $surveyQuestionId,
        array $values
    )
    {
        $this->id = $id;
        $this->surveyFulfillment = $surveyFulfillment;
        $this->surveyQuestionId = $surveyQuestionId->value();
        $this->values = json_encode($values);
        $this->createdAt = new \DateTime();
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function surveyQuestionId(): string
    {
        return $this->surveyQuestionId;
    }

    /**
     * @return \DateTimeInterface
     */
    public function createdAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return array
     */
    public function values(): array
    {
        return json_decode($this->values, true);
    }
}
