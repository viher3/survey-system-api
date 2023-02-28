<?php

namespace SurveySystem\Survey\Application\Report\Daily\Generate;

use SurveySystem\Shared\Domain\ValueObject\Uuid;
use SurveySystem\Survey\Application\SurveyFulfillment\Find\SurveyFulfillmentDetailFinder;
use SurveySystem\Survey\Domain\Report\DailyReport;
use SurveySystem\Survey\Domain\Report\DailyReportRepository;
use SurveySystem\Survey\Domain\Survey\SurveyId;
use SurveySystem\Survey\Domain\SurveyFulfillment\SurveyFulfillment;
use SurveySystem\Survey\Domain\SurveyFulfillment\SurveyFulfillmentRepository;
use SurveySystem\Survey\Domain\SurveyQuestion\SurveyQuestionId;
use Symfony\Component\Console\Output\OutputInterface;

class DailyReportGenerator
{
    private ?OutputInterface $output;
    private SurveyFulfillmentDetailFinder $finder;
    private SurveyFulfillmentRepository $surveyFulfillmentRepository;
    private DailyReportRepository $dailyReportRepository;

    /**
     * @param SurveyFulfillmentDetailFinder $finder
     * @param SurveyFulfillmentRepository $surveyFulfillmentRepository
     * @param DailyReportRepository $dailyReportRepository
     */
    public function __construct(
        SurveyFulfillmentDetailFinder $finder,
        SurveyFulfillmentRepository   $surveyFulfillmentRepository,
        DailyReportRepository         $dailyReportRepository
    )
    {
        $this->output = null;
        $this->finder = $finder;
        $this->dailyReportRepository = $dailyReportRepository;
        $this->surveyFulfillmentRepository = $surveyFulfillmentRepository;
    }

    /**
     * @param SurveyId $surveyId
     * @param \DateTimeInterface $initDate
     * @param \DateTimeInterface $endDate
     * @return void
     */
    public function execute(
        SurveyId           $surveyId,
        \DateTimeInterface $initDate,
        \DateTimeInterface $endDate
    ): void
    {
        // get surveys fulfillment
        $surveyFulfillments = $this->surveyFulfillmentRepository->findAllSurveyFulfillments(
            $surveyId,
            [
                'initDate' => $initDate,
                'endDate' => $endDate
            ]
        );

        if (!$surveyFulfillments) {
            return;
        }

        // delete existing records
        $this->writeLn('Removing existing records ...');
        $this->dailyReportRepository->deleteByDay($initDate);
        $this->writeLn('Done!');

        $questionMarks = []; // values, total, summation

        /** @var SurveyFulfillment $surveyFulfillment */
        foreach ($surveyFulfillments as $surveyFulfillment) {
            $surveyFulfillmentId = $surveyFulfillment->id();
            $this->writeln('Processing ' . $surveyFulfillmentId . ' ...');

            $surveyFulfillmentResponse = $this->finder->execute($surveyFulfillmentId);
            $surveyFulfillmentReplies = $surveyFulfillmentResponse->toArray();

            if (empty($surveyFulfillmentReplies['items'])) {
                $this->writeln($surveyFulfillmentId . ' doesn\'t have any item.');
                continue;
            }

            foreach ($surveyFulfillmentReplies['items'] as $item) {
                $question = $item['question'];
                $questionText = $question['value'];
                $questionId = $question['id'];

                $value = implode('', $item['reply']['values']) ?? 0;
                $isNumberValue = preg_match('/\d/', $value) ? true : false;

                if (trim($value) === '') {
                    continue;
                }

                if ($isNumberValue) {
                    $value = (int)$value;
                }

                if (!isset($questionMarks[$questionId])) {
                    $questionMarks[$questionId] = [
                        'question' => $questionText,
                        'values' => [$value],
                        'total' => 1,
                        'summation' => ($isNumberValue) ? $value : 0
                    ];
                    continue;
                }

                $questionMarks[$questionId]['values'][] = $value;
                $questionMarks[$questionId]['total'] += 1;

                if ($isNumberValue) {
                    $questionMarks[$questionId]['summation'] += (int)$value;
                }
            }
        }

        // calculate average and mode values
        foreach ($questionMarks as $questionId => $questionData) {
            $average = round($questionData['summation'] / $questionData['total'], 2);

            $modes = [];
            foreach ($questionData['values'] as $value) {
                if (!isset($moda[$value])) {
                    $modes[$value] = 1;
                    continue;
                }

                $modes[$value] += 1;
            }

            krsort($modes, SORT_NUMERIC);
            $maxMode = 0;
            $maxModeValue = 0;

            foreach ($modes as $replyValue => $total) {
                if ($total > $maxMode) {
                    $maxMode = $total;
                    $maxModeValue = $replyValue;
                }
            }

            // persist
            $date = clone $initDate;
            $date->setTime(0, 0, 0);

            try {
                $this->writeLn('Saving ' . $questionId . ' question report ...');
                $dailyReport = new DailyReport(
                    Uuid::random(),
                    new SurveyQuestionId($questionId),
                    $surveyId,
                    (float)$average,
                    (float)$maxModeValue,
                    $date,
                    $questionData['values']
                );

                $this->dailyReportRepository->save($dailyReport);
                $this->writeLn('OK!');
            } catch (\Exception $e) {
                $this->writeLn($e->getMessage());
            }
        }
    }

    public function setOutput(OutputInterface $output): void
    {
        $this->output = $output;
    }

    /**
     * @param string $msg
     * @return void
     */
    private function writeLn(string $msg): void
    {
        if (!$this->output) return;
        $this->output->writeln($msg);
    }
}
