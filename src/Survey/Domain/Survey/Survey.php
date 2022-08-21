<?php

namespace SurveySystem\Survey\Domain\Survey;

use SurveySystem\Shared\Domain\Aggregate\AggregateRoot;

class Survey extends AggregateRoot
{
    private string $id;

    private string $name;

    private ?string $description;

    private \DateTimeInterface $createdAt;

    private \DateTimeInterface $updatedAt;

    private bool $enabled;

    /**
     * @param string $id
     * @param string $name
     * @param string|null $description
     * @param bool $enabled
     */
    public function __construct(string $id, string $name, ?string $description = null, bool $enabled = true)
    {
        $this->id = $id;
        $this->name = $name;
        $this->enabled = $enabled;
        $this->description = $description;
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
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function description(): ?string
    {
        return $this->description;
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
     * @return bool
     */
    public function enabled(): bool
    {
        return $this->enabled;
    }
}
