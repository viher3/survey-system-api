<?php

namespace SurveySystem\Apps\Api\Controller\SurveyQuestion;

use Assert\Assertion;
use SurveySystem\Survey\Application\SurveyQuestion\Create\SurveyQuestionCreator;
use SurveySystem\Survey\Application\SurveyQuestion\Create\SurveyQuestionCreatorCommand;
use function Lambdish\Phunctional\map;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

            $this->surveyQuestionCreator->execute(
                new SurveyQuestionCreatorCommand(
                    $params['question'],
                    $params['surveyId'],
                    $params['position'],
                    $params['enabled'] ?? true,
                    $params['options'] ?? []
                )
            );

            return $this->json([], 200);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param array $params
     * @return void
     */
    private function assertParams(array $params) : void
    {
        // Required params
        $notEmptyParams = ['question', 'surveyId', 'position', 'options'];

        map(function(string $param) use($params){
            $value = $params[$param] ?? null;
            Assertion::notEmpty($value, 'Required param "' . $param . '" is empty.');
        }, $notEmptyParams);

        // Validate Options
        map(function(array $option){
            Assertion::notEmpty($option['type'], 'Property "type" not found for option.');
        }, $params['options']);
    }
}
