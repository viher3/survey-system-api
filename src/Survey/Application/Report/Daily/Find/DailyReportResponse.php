<?php

namespace SurveySystem\Survey\Application\Report\Daily\Find;

use SurveySystem\Survey\Domain\Report\DailyReport;
use function Lambdish\Phunctional\map;

class DailyReportResponse
{
    private function __construct(private array $dailyReports)
    {
    }

    /**
     * @param array $dailyReports
     * @return DailyReportResponse
     */
    public static function create(array $dailyReports)
    {
        // group by [date]
        $groupedDailyReport = [];

        foreach($dailyReports as $dailyReport){
            $date = $dailyReport['date'];
            $dateString = $date->format('d/m/Y');

            $item = [
                'id' => $dailyReport['id'],
                'question' => $dailyReport['question'],
                'questionId' => $dailyReport['questionId'],
                'questionPosition' => $dailyReport['questionPosition'],
                'date' => $date,
                'average' => $dailyReport['average'],
                'mode' => $dailyReport['mode']
            ];

            $groupedDailyReport[$dateString][] = $item;
        }

        foreach($groupedDailyReport as $date => $items){
            $groupedSortedQuestions = [];
            foreach($items as $item){
                $position = $item['questionPosition'];
                $groupedSortedQuestions[$position] = $item;
            }

            ksort($groupedSortedQuestions);

            $groupedDailyReport[$date] = $groupedSortedQuestions;
        }

        return new self($groupedDailyReport);
    }

    /**
     * @return array
     */
    public function getDailyReports(): array
    {
        return $this->dailyReports;
    }
}
