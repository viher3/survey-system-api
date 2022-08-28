<?php

namespace SurveySystem\Survey\Domain\SurveyFulfillment;

use SurveySystem\Survey\Domain\Survey\Survey;
use SurveySystem\Shared\Domain\Aggregate\AggregateRoot;
use SurveySystem\Survey\Domain\SurveyQuestion\SurveyQuestionId;

class SurveyFulfillment extends AggregateRoot
{
    private string $id;

    private Survey $survey;

    private \DateTimeInterface $createdAt;

    private $replies;

    /**
     * @param Survey $survey
     */
    public function __construct(string $id, Survey $survey)
    {
        $this->id = $id;
        $this->survey = $survey;
        $this->createdAt = new \DateTime();
        $this->replies = [];
    }

    /**
     * @param Survey $survey
     * @return static
     */
    public static function create(Survey $survey) : self
    {
        return new self(
            SurveyFulfillmentId::random()->value(),
            $survey
        );
    }

    /**
     * @param SurveyQuestionId $surveyQuestionId
     * @param array $values
     * @return void
     */
    public function addReply(SurveyQuestionId $surveyQuestionId, array $values) : void
    {
        $this->replies[] = new SurveyFulfillmentReply(
            SurveyFulfillmentReplyId::random(),
            $this,
            $surveyQuestionId,
            $values
        );
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return Survey
     */
    public function survey(): Survey
    {
        return $this->survey;
    }

    /**
     * @return \DateTimeInterface
     */
    public function createdAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
}
