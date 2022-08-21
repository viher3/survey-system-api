<?php

namespace SurveySystem\Survey\Domain\SurveyQuestion;

use SurveySystem\Survey\Domain\Survey\Survey;
use SurveySystem\Shared\Domain\Aggregate\AggregateRoot;

class SurveyQuestion extends AggregateRoot
{
    private string $id;

    private string $question;

    private int $position;

    private bool $enabled;

    private Survey $survey;

    private \DateTimeInterface $createdAt;

    private \DateTimeInterface $updatedAt;

    private $options;

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
        int    $position,
        bool   $enabled = true)
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
     * @param SurveyQuestionId $id
     * @param string $question
     * @param Survey $survey
     * @param int $position
     * @param bool $enabled
     * @return void
     */
    public static function create(SurveyQuestionId $id, string $question, Survey $survey, int $position, bool $enabled = true): self
    {
        return new self(
            $id->value(),
            $question,
            $survey,
            $position,
            $enabled
        );
    }

    /**
     * @param string $type
     * @param array $values
     * @param int $position
     * @param bool $enabled
     * @return void
     */
    public function addOption(
        SurveyQuestionOptionType $type,
        array                    $values,
        int                      $position,
        bool                     $enabled = true
    ): void
    {
        $this->options[] = new SurveyQuestionOption(
            SurveyQuestionOptionId::random()->value(),
//                $this,
            $type->value(),
            $values,
            $position,
            $enabled
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

    /**
     * @return array
     */
    public function getOptions(): array
    {
        $options = [];

        foreach($this->options as $option){
            $options[] = $option;
        }

        return $options;
    }
}
