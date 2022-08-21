<?php

namespace SurveySystem\Apps\Api\Controller\SurveyQuestion;

use Assert\Assertion;
use SurveySystem\Survey\Application\Create\SurveyQuestionCreatorCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use SurveySystem\Survey\Application\Create\SurveyQuestionCreator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use function Lambdish\Phunctional\map;

class CreateSurveyQuestionController extends AbstractController
{
    private SurveyQuestionCreator $surveyQuestionCreator;

    /**
     * @param SurveyQuestionCreator $surveyQuestionCreator
     */
    public function __construct(SurveyQuestionCreator $surveyQuestionCreator)
    {
        $this->surveyQuestionCreator = $surveyQuestionCreator;
    }

    /**
     * @param Request $request
     * @return void
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $params = json_decode($request->getContent(), true);
            $this->assertParams($params);

            $this->surveyQuestionCreator->__invoke(
                new SurveyQuestionCreatorCommand(
                    $params['question'],
                    $params['surveyId'],
                    $params['position'],
                    $params['enabled'] ?? true
                )
            );

            return $this->json([], 200);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function assertParams(array $params) : void
    {
        $notEmptyParams = [
            'question', 'surveyId', 'position'
        ];

        map(function($value, string $param) use($notEmptyParams){
            if(in_array($param, $notEmptyParams)){
                Assertion::notEmpty($value, 'Param "' . $param . '" is empty.');
            }
        }, $params);
    }
}
