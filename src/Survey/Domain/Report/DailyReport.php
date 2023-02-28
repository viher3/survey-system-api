<?php

namespace SurveySystem\Survey\Domain\Report;

use SurveySystem\Survey\Domain\Survey\SurveyId;
use SurveySystem\Shared\Domain\Aggregate\AggregateRoot;
use SurveySystem\Survey\Domain\SurveyQuestion\SurveyQuestionId;

class DailyReport extends AggregateRoot
{
    private string $id;
    private float $mode;
    private float $average;
    private string $surveyId;
    private string $questionId;
    private ?string $values;
    private \DateTime $createdAt;
    private \DateTimeInterface $date;

    /**
     * @param string $id
     * @param SurveyQuestionId $questionId
     * @param SurveyId $surveyId
     * @param float $average
     * @param float $mode
     * @param \DateTimeInterface $date
     * @param array $values
     */
    public function __construct(
        string $id,
        SurveyQuestionId $questionId,
        SurveyId $surveyId,
        float $average,
        float $mode,
        \DateTimeInterface $date,
        array $values = []
    )
    {
        $this->id = $id;
        $this->date = $date;
        $this->mode = $mode;
        $this->average = $average;
        $this->createdAt = new \DateTime();
        $this->surveyId = $surveyId->value();
        $this->questionId = $questionId->value();
        $this->values = $values ? json_encode($values) : null;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getMode(): float
    {
        return $this->mode;
    }

    /**
     * @return float
     */
    public function getAverage(): float
    {
        return $this->average;
    }

    /**
     * @return string
     */
    public function getQuestionId(): string
    {
        return $this->questionId;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @return string|null
     */
    public function getValues(): ?string
    {
        return $this->values;
    }

    /**
     * @return string
     */
    public function getSurveyId(): string
    {
        return $this->surveyId;
    }
}
