<?php

namespace SurveySystem\Survey\Application\SurveyFulfillment\Read;

use function Lambdish\Phunctional\map;
use SurveySystem\Shared\Application\Response\ListResponse;

class SurveyFulfillmentListResponse extends ListResponse
{
    public static function create(array $surveysFulfillment, int $total)
    {
        $items = map(function (array $surveyFulfillment) {
            return [
                'id' => $surveyFulfillment['id'],
                'name' => $surveyFulfillment['name'],
                // TODO ...
            ];
        }, $surveysFulfillment);

        return new self($items, $total);
    }
}
