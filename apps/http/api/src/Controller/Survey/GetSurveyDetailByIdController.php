<?php

namespace SurveySystem\Apps\Api\Controller\Survey;

use SurveySystem\Survey\Domain\Survey\SurveyId;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use SurveySystem\Survey\Application\Survey\Find\SurveyDetailFinder;

class GetSurveyDetailByIdController extends AbstractController
{
    private SurveyDetailFinder $surveyDetailFinder;

    public function __construct(SurveyDetailFinder $surveyDetailFinder)
    {
        $this->surveyDetailFinder = $surveyDetailFinder;
    }

    public function __invoke(string $id) : JsonResponse
    {
        $response = $this->surveyDetailFinder->execute(new SurveyId($id));
        return new JsonResponse($response->getSurvey(), 200);
    }
}
