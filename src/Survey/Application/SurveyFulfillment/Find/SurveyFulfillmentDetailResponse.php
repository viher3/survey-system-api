<?php

namespace SurveySystem\Survey\Application\SurveyFulfillment\Find;

use function Lambdish\Phunctional\map;
use SurveySystem\Shared\Application\Response\ListResponse;

class SurveyFulfillmentDetailResponse extends ListResponse
{
    /**
     * @param array $surveysFulfillments
     * @param int $total
     * @return SurveyFulfillmentDetailResponse
     */
    public static function create(array $surveysFulfillments, int $total)
    {
        $items = map(function (array $surveyFulfillment) {
            return [
                'id' => $surveyFulfillment['id'],
                'question' => [
                    'id' => $surveyFulfillment['questionId'],
                    'value' => $surveyFulfillment['question'],
                    'position' => $surveyFulfillment['questionPosition']
                ],
                'reply' => [
                    'id' => $surveyFulfillment['replyId'],
                    'values' => json_decode($surveyFulfillment['values'], true)
                ],
                'createdAt' => $surveyFulfillment['createdAt']->format('d/m/Y H:i:s')
            ];
        }, $surveysFulfillments);

        return new self($items, $total);
    }
}
