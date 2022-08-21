<?php

namespace SurveySystem\Survey\Domain\SurveyQuestion;

use SurveySystem\Shared\Domain\ValueObject\StringValueObject;

class SurveyQuestionOptionType extends StringValueObject
{
    const TYPE_TEXT = 'text';
    const TYPE_RADIO = 'radio';

    const TYPES = [
        self::TYPE_TEXT,
        self::TYPE_RADIO
    ];

    public function __construct(string $value)
    {
        self::assertType($value);
        parent::__construct($value);
    }


    public static function text() :self
    {
        return new self(self::TYPES[self::TYPE_TEXT]);
    }

    public static function radio() :self
    {
        return new self(self::TYPES[self::TYPE_RADIO]);
    }

    public static function assertType(string $type) : void
    {
        if(!in_array($type, self::TYPES)){
            throw new \Exception('Invalid SurveyQuestionOptionType value: ' . $type);
        }
    }
}
