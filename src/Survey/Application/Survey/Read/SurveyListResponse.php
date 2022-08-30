<?php

namespace SurveySystem\Survey\Application\Survey\Read;

use SurveySystem\Shared\Domain\DateTime;
use function Lambdish\Phunctional\map;
use SurveySystem\Survey\Domain\Survey\Survey;
use SurveySystem\Shared\Application\Response\ListResponse;

class SurveyListResponse extends ListResponse
{
    /**
     * @param array $surveys
     * @param int $total
     * @param array $totalSurveysFillment
     * @return static
     */
    public static function create(array $surveys, int $total, array $totalSurveysFillment): self
    {
        $items = map(function (Survey $survey) use ($totalSurveysFillment) {
            return [
                'id' => $survey->id(),
                'name' => $survey->name(),
                'description' => $survey->description(),
                'enabled' => $survey->enabled(),
                'createdAt' => DateTime::create($survey->createdAt())->toDateTimeString(),
                'updated' => DateTime::create($survey->updatedAt())->toDateTimeString(),
                'totalFulfillment' => $totalSurveysFillment[$survey->id()] ?? 0
            ];
        }, $surveys);

        return new self($items, $total);
    }
}
