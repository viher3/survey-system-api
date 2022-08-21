<?php

namespace SurveySystem\Survey\Domain\SurveyQuestion;

use SurveySystem\Survey\Domain\Survey\Survey;
use SurveySystem\Shared\Domain\Aggregate\AggregateRoot;

class SurveyQuestion extends AggregateRoot
{
    private string $id;

    private string $question;

    private ?int $position;

    private bool $enabled;

    private Survey $survey;

    private \DateTimeInterface $createdAt;

    private \DateTimeInterface $updatedAt;

    /**
     * @param SurveyQuestionId $id
     * @param string $question
     * @param Survey $survey
     * @param int|null $position
     * @param bool $enabled
     */
    public function __construct(
        string $id,
        string $question,
        Survey $survey,
        ?int $position,
        bool $enabled=true)
    {
        $this->id = $id;
        $this->question = $question;
        $this->position = $position;
        $this->enabled = $enabled;
        $this->survey = $survey;
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
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
    public function question(): string
    {
        return $this->question;
    }

    /**
     * @return int|null
     */
    public function position(): ?int
    {
        return $this->position;
    }

    /**
     * @return bool
     */
    public function enabled(): bool
    {
        return $this->enabled;
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

    /**
     * @return \DateTimeInterface
     */
    public function updatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }
}
