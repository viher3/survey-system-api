<?php

namespace SurveySystem\Apps\Api\Controller\Report\Daily;

use SurveySystem\Survey\Application\Report\Daily\Find\DailyReportRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use SurveySystem\Survey\Application\Report\Daily\Find\DailyReportFinder;

class GetDailyReportListController extends AbstractController
{
    public function __construct(
        private DailyReportFinder $finder
    )
    {
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function __invoke(Request $request) : JsonResponse
    {
        $response = $this->finder->execute(
            new DailyReportRequest(
                $request->query->get('surveyId'),
                new \DateTime($request->query->get('initDate')),
                new \DateTime($request->query->get('endDate'))
            )
        );
        return new JsonResponse($response->getDailyReports(), Response::HTTP_OK);
    }
}
