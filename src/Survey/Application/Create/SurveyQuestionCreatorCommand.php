<?php

namespace SurveySystem\Survey\Application\Create;

class SurveyQuestionCreatorCommand
{
    private string $question;
    private int $surveyId;
    private ?int $position;
    private bool $enabled;

    public function __construct(
        string $question,
        int $surveyId,
        ?int $position,
        bool $enabled=true
    )
    {
        $this->question = $question;
        $this->surveyId = $surveyId;
        $this->position = $position;
        $this->enabled = $enabled;
    }

    /**
     * @return string
     */
    public function question(): string
    {
        return $this->question;
    }

    /**
     * @return int
     */
    public function surveyId(): int
    {
        return $this->surveyId;
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
}
