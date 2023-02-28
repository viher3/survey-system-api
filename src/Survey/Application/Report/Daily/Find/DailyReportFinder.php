<?php

namespace SurveySystem\Survey\Application\Report\Daily\Find;

use SurveySystem\Survey\Domain\Report\DailyReportRepository;

final class DailyReportFinder
{
    public function __construct(
        private DailyReportRepository $dailyReportRepository
    )
    {
    }

    /**
     * @param DailyReportRequest $request
     * @return DailyReportResponse
     */
    public function execute(DailyReportRequest $request) : DailyReportResponse
    {
        $dailyReports = $this->dailyReportRepository->getList([
            'surveyId' => $request->getSurveyId(),
            'initDate' => $request->getInitDate(),
            'endDate' => $request->getEndDate()
        ]);

        return DailyReportResponse::create($dailyReports);
    }
}
