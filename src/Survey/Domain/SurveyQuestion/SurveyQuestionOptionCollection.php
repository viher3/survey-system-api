<?php

namespace SurveySystem\Survey\Domain\SurveyQuestion;

use Ramsey\Collection\AbstractCollection;

class SurveyQuestionOptionCollection extends AbstractCollection
{
    public function getType(): string
    {
        return SurveyQuestionOption::class;
    }
}
