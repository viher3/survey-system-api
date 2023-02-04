<?php

namespace SurveySystem\Apps\Api\Controller\Survey;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use SurveySystem\Survey\Application\Survey\Duplicate\SurveyDuplicator;
use SurveySystem\Survey\Application\Survey\Duplicate\SurveyDuplicatorCommand;

class PostSurveyDuplicatorController extends AbstractController
{
    /**
     * @param SurveyDuplicator $surveyDuplicator
     */
    public function __construct(
        private SurveyDuplicator $surveyDuplicator
    )
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws AssertionFailedException
     */
    public function __invoke(Request $request) : JsonResponse
    {
        try{
            $id = $request->query->get('id');
            Assertion::notEmpty($id, 'Survey id parameter is required');

            $surveyDuplicatorCommand = new SurveyDuplicatorCommand($id);
            $this->surveyDuplicator->execute($surveyDuplicatorCommand);

            return new JsonResponse([], 204);
        }catch (\Exception $e){
            return new JsonResponse([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
