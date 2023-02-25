<?php

namespace SurveySystem\Survey\Application\Report\Daily\Find;

class DailyReportRequest
{
    public function __construct(
        private string $surveyId,
        private \DateTimeInterface $initDate,
        private \DateTimeInterface $endDate
    )
    {
    }

    /**
     * @return string
     */
    public function getSurveyId(): string
    {
        return $this->surveyId;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getInitDate(): \DateTimeInterface
    {
        return $this->initDate;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getEndDate(): \DateTimeInterface
    {
        return $this->endDate;
    }
}
