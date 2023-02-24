<?php

namespace SurveySystem\Survey\Domain\Report;

use SurveySystem\Shared\Domain\Aggregate\AggregateRoot;

class DailyReport extends AggregateRoot
{
    private string $id;
    private float $mode;
    private float $average;
    private string $questionId;
    private \DateTime $createdAt;
    private \DateTimeInterface $date;

    /**
     * @param string $id
     * @param string $questionId
     * @param float $average
     * @param float $mode
     * @param \DateTimeInterface $date
     */
    public function __construct(
        string $id,
        string $questionId,
        float $average,
        float $mode,
        \DateTimeInterface $date
    )
    {
        $this->id = $id;
        $this->date = $date;
        $this->mode = $mode;
        $this->average = $average;
        $this->createdAt = new \DateTime();
        $this->questionId = $questionId;
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
}
