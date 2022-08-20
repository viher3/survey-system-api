<?php

namespace SurveySystem\Survey\Domain;

class SurveyNotFound extends \Exception
{
    public function __construct(SurveyId $id)
    {
        parent::__construct('Survey ' . $id . ' not found');
    }
}
