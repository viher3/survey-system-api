<?php

namespace SurveySystem\Apps\Api\Controller\SurveyFulfillment;

use Assert\Assertion;
use function Lambdish\Phunctional\map;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use SurveySystem\Survey\Application\SurveyFulfillment\Create\SurveyFulfillmentCreator;
use SurveySystem\Survey\Application\SurveyFulfillment\Create\SurveyFulfillmentCreatorCommand;

class CreateSurveyFulfillmentController extends AbstractController
{
    private SurveyFulfillmentCreator $surveyFulfillmentCreator;

    /**
     * @param SurveyFulfillmentCreator $surveyFulfillmentCreator
     */
    public function __construct(SurveyFulfillmentCreator $surveyFulfillmentCreator)
    {
        $this->surveyFulfillmentCreator = $surveyFulfillmentCreator;
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

            $this->surveyFulfillmentCreator->execute(
                new SurveyFulfillmentCreatorCommand($params['surveyId'], $params['replies'])
            );

            return $this->json([
                'surveyFulfillmentId' => $this->surveyFulfillmentCreator->surveyFulfillmentId()
            ], 200);
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
        $notEmptyParams = ['surveyId', 'replies'];

        map(function(string $param) use($params){
            $value = $params[$param] ?? null;
            Assertion::notEmpty($value, 'Required param "' . $param . '" is empty.');
        }, $notEmptyParams);

        // Validate Options
        map(function(array $reply){
            Assertion::notEmpty($reply['question_id'], 'Property "question_id" not found for reply.');
            Assertion::notEmpty($reply['values'], 'Property "values" not found or empty for reply.');
        }, $params['replies']);
    }
}
