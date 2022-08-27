<?php

namespace SurveySystem\Survey\Application\Survey\Read;

use function Lambdish\Phunctional\map;
use SurveySystem\Survey\Domain\Survey\Survey;
use SurveySystem\Shared\Application\Response\ListResponse;

class SurveyListResponse extends ListResponse
{
    /**
     * @param array $surveys
     * @param int $total
     * @return static
     */
    public static function create(array $surveys, int $total): self
    {
        $items = map(function (Survey $survey) {
            return [
                'id' => $survey->id(),
                'name' => $survey->name(),
                'description' => $survey->description(),
                'enabled' => $survey->enabled(),
                'createdAt' => $survey->createdAt()->format('d/m/Y H:i:s'),
                'updated' => $survey->updatedAt()->format('d/m/Y H:i:s')
            ];
        }, $surveys);

        return new self($items, $total);
    }
}
