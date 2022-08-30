<?php

namespace SurveySystem\Apps\Api\Controller\SurveyFulfillment;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use SurveySystem\Survey\Application\SurveyFulfillment\Read\SurveyFulfillmentListService;

class GetSurveyFulfillmentListController extends AbstractController
{
    private SurveyFulfillmentListService $surveyFulfillmentListService;

    /**
     * @param SurveyFulfillmentListService $surveyFulfillmentListService
     */
    public function __construct(SurveyFulfillmentListService $surveyFulfillmentListService)
    {
        $this->surveyFulfillmentListService = $surveyFulfillmentListService;
    }

    /**
     * @param Request $request
     * @return void
     */
    public function __invoke(Request $request): JsonResponse
    {
        $params = json_decode($request->getContent(), true);
        $response = $this->surveyFulfillmentListService->execute($params);
        return $this->json($response->toArray(), 200);
    }
}
