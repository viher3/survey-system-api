<?php

namespace SurveySystem\Survey\Application\SurveyQuestion\Read;

use SurveySystem\Shared\Domain\DateTime;
use function Lambdish\Phunctional\map;
use SurveySystem\Shared\Application\Response\ListResponse;
use SurveySystem\Survey\Domain\SurveyQuestion\SurveyQuestion;

class SurveyQuestionListResponse extends ListResponse
{
    /**
     * @param array $surveys
     * @param int $total
     * @return static
     */
    public static function create(array $surveys, int $total): self
    {
        $items = map(function (SurveyQuestion $surveyQuestion) {
            $options = [];

            // $surveyQuestion->getOptions()

            return [
                'id' => $surveyQuestion->id(),
                'question' => $surveyQuestion->question(),
                'enabled' => $surveyQuestion->enabled(),
                'options' => $options,
                'createdAt' => DateTime::create($surveyQuestion->createdAt())->toDateTimeString(),
                'updated' => DateTime::create($surveyQuestion->updatedAt())->toDateTimeString()
            ];
        }, $surveys);

        return new self($items, $total);
    }
}
