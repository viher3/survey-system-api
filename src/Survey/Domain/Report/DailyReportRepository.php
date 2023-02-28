<?php

namespace SurveySystem\Survey\Domain\Report;

interface DailyReportRepository
{
    /**
     * @param \DateTimeInterface $date
     * @return mixed
     */
    public function deleteByDay(\DateTimeInterface $date);

    /**
     * @param array $filters
     * @return int
     */
    public function total(array $filters = []) : int;

    /**
     * @param DailyReport $report
     * @return void
     */
    public function save(DailyReport $report): void;

    /**
     * @param array $filters
     * @return array
     */
    public function getList(array $filters = []) : array;
}
