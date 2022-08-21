<?php

namespace SurveySystem\Survey\Application\Create;

class SurveyQuestionCreatorCommand
{
    private string $question;
    private string $surveyId;
    private int $position;
    private bool $enabled;
    private array $options;

    /**
     * @param string $question
     * @param string $surveyId
     * @param int $position
     * @param bool $enabled
     * @param array $options
     */
    public function __construct(
        string $question,
        string $surveyId,
        int $position,
        bool $enabled=true,
        array $options = []
    )
    {
        $this->question = $question;
        $this->surveyId = $surveyId;
        $this->position = $position;
        $this->enabled = $enabled;
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function question(): string
    {
        return $this->question;
    }

    /**
     * @return string
     */
    public function surveyId(): string
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

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
