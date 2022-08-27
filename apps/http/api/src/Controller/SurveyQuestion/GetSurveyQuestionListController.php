<?php

namespace SurveySystem\Apps\Api\Controller\SurveyQuestion;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use SurveySystem\Survey\Application\SurveyQuestion\Read\SurveyQuestionListService;

class GetSurveyQuestionListController extends AbstractController
{
    private SurveyQuestionListService $surveyQuestionListService;

    /**
     * @param SurveyQuestionListService $surveyQuestionListService
     */
    public function __construct(SurveyQuestionListService $surveyQuestionListService)
    {
        $this->surveyQuestionListService = $surveyQuestionListService;
    }

    /**
     * @param string $id
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(string $id, Request $request) : JsonResponse
    {
        $response = $this->surveyQuestionListService->execute($id, $request->request->all());
        return new JsonResponse($response->toArray(), 200);
    }
}
