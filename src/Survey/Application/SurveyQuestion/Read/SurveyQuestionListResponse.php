<?php

namespace SurveySystem\Survey\Application\SurveyQuestion\Read;

use SurveySystem\Shared\Domain\DateTime;
use SurveySystem\Survey\Domain\SurveyQuestion\SurveyQuestionOption;
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
            // TODO: sort options
             $options = map(function(SurveyQuestionOption $option){
                 if($option->enabled()){
                     return [
                         'id' => $option->id(),
                         'type' => $option->type(),
                         'values' => $option->values(),
                         'position' => $option->position(),
                         'enabled' => DateTime::create($option->createdAt())->toDateTimeString()
                     ];
                 }
             }, $surveyQuestion->getOptions());

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
