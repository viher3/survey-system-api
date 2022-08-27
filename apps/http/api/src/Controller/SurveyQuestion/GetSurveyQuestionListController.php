<?php

namespace SurveySystem\Apps\Api\Controller\Survey;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use SurveySystem\Survey\Application\Survey\Read\SurveyListService;

class GetSurveyQuestionListController extends AbstractController
{
    private SurveyListService $surveyListService;

    /**
     * @param SurveyListService $surveyListService
     */
    public function __construct(SurveyListService $surveyListService)
    {
        $this->surveyListService = $surveyListService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request) : JsonResponse
    {
        $response = $this->surveyListService->execute($request->request->all());
        return new JsonResponse($response->toArray(), 200);
    }
}
