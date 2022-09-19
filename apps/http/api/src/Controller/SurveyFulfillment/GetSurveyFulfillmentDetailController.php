<?php

namespace SurveySystem\Apps\Api\Controller\SurveyFulfillment;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use SurveySystem\Survey\Application\SurveyFulfillment\Find\SurveyFulfillmentDetailFinder;

class GetSurveyFulfillmentDetailController extends AbstractController
{
    private SurveyFulfillmentDetailFinder $surveyFulfillmentDetailFinder;

    /**
     * @param SurveyFulfillmentDetailFinder $surveyFulfillmentDetailFinder
     */
    public function __construct(SurveyFulfillmentDetailFinder $surveyFulfillmentDetailFinder)
    {
        $this->surveyFulfillmentDetailFinder = $surveyFulfillmentDetailFinder;
    }

    /**
     * @param Request $request
     * @return void
     */
    public function __invoke(Request $request): JsonResponse
    {
        $id = $request->attributes->get('id');
        $params = $request->query->all();
        $response = $this->surveyFulfillmentDetailFinder->execute($id, $params);
        return $this->json($response->toArray(), 200);
    }
}
