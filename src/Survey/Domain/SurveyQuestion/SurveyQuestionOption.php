<?php

namespace SurveySystem\Survey\Domain\SurveyQuestion;

class SurveyQuestionOption
{
    private string $id;

    private string $type;

    private array $values;

    private int $position;

    private bool $enabled;

    private \DateTime $createdAt;

    private \DateTime $updatedAt;

    /**
     * @param string $id
     * @param string $type
     * @param array $values
     * @param int $position
     * @param bool $enabled
     */
    public function __construct(string $id, string $type, array $values, int $position, bool $enabled = true)
    {
        $this->id = $id;
        $this->type = $type;
        $this->values = $values;
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
        return $this->values;
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
