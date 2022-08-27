<?php

namespace SurveySystem\Survey\Domain\SurveyQuestion;

class SurveyQuestionOption
{
    private string $id;

    private string $type;

    private string $values;

    private SurveyQuestion $question;

    private int $position;

    private bool $enabled;

    private \DateTime $createdAt;

    private \DateTime $updatedAt;

    /**
     * @param string $id
     * @param SurveyQuestion $question
     * @param string $type
     * @param array $values
     * @param int $position
     * @param bool $enabled
     */
    public function __construct(
        string $id,
        SurveyQuestion $question,
        string $type,
        array $values,
        int $position,
        bool $enabled = true)
    {
        $this->id = $id;
        $this->type = (new SurveyQuestionOptionType($type))->value();
        $this->values = json_encode($values);
        $this->question = $question;
        $this->position = $position;
        $this->enabled = $enabled;
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
    public function type(): string
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function values(): array
    {
        return json_decode($this->values, true);
    }

    /**
     * @return int
     */
    public function position(): int
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
     * @return \DateTime
     */
    public function createdAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function updatedAt(): \DateTime
    {
        return $this->updatedAt;
    }
}
