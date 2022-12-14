<?php

namespace SurveySystem\Survey\Application\Survey\Find;

use SurveySystem\Shared\Domain\DateTime;
use SurveySystem\Survey\Domain\Survey\Survey;

class SurveyDetailFinderResponse
{
    private Survey $survey;

    public function __construct(Survey $survey)
    {
        $this->survey = $survey;
    }

    public static function create(Survey $survey) : self
    {
        return new self($survey);
    }

    /**
     * @return Survey
     */
    public function getSurvey(): array
    {
        return [
            'id' => $this->survey->id(),
            'name' => $this->survey->name(),
            'description' => $this->survey->description(),
            'enabled' => $this->survey->enabled(),
            'createdAt' => DateTime::create($this->survey->createdAt())->toDateTimeString(),
            'updatedAt' => DateTime::create($this->survey->updatedAt())->toDateTimeString()
        ];
    }
}
