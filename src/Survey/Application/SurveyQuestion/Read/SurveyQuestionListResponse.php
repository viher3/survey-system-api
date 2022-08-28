<?php

namespace SurveySystem\Survey\Application\SurveyQuestion\Read;

use function Lambdish\Phunctional\map;
use SurveySystem\Shared\Domain\DateTime;
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

            // Get and sort survey options
            $options = [];
            $optionsToAppend = [];

            foreach($surveyQuestion->getOptions() as $surveyQuestionOption){
                $position = $surveyQuestionOption->position();
                $option = [
                    'id' => $surveyQuestionOption->id(),
                    'type' => $surveyQuestionOption->type(),
                    'values' => $surveyQuestionOption->values(),
                    'position' => $position,
                    'enabled' => DateTime::create($surveyQuestionOption->createdAt())->toDateTimeString()
                ];

                if(!isset($options[$position])){
                    $options[$position] = $option;
                }else{
                    $optionsToAppend[] = $option;
                }
            }

            if($optionsToAppend){
                $options = array_merge($optionsToAppend, $options);
            }

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
