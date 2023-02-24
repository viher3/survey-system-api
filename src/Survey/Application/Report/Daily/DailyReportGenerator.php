<?php

namespace SurveySystem\Survey\Application\Report\Daily;

use SurveySystem\Survey\Domain\Survey\SurveyId;
use SurveySystem\Survey\Domain\SurveyFulfillment\SurveyFulfillment;
use SurveySystem\Survey\Domain\SurveyFulfillment\SurveyFulfillmentRepository;
use SurveySystem\Survey\Application\SurveyFulfillment\Find\SurveyFulfillmentDetailFinder;
use Symfony\Component\Console\Output\OutputInterface;

class DailyReportGenerator
{
    private ?OutputInterface $output;
    private SurveyFulfillmentDetailFinder $finder;
    private SurveyFulfillmentRepository $surveyFulfillmentRepository;

    /**
     * @param SurveyFulfillmentDetailFinder $finder
     * @param SurveyFulfillmentRepository $surveyFulfillmentRepository
     */
    public function __construct(
        SurveyFulfillmentDetailFinder $finder,
        SurveyFulfillmentRepository $surveyFulfillmentRepository
    )
    {
        $this->output = null;
        $this->finder = $finder;
        $this->surveyFulfillmentRepository = $surveyFulfillmentRepository;
    }

    /**
     * @param SurveyId $surveyId
     * @param \DateTimeInterface $initDate
     * @param \DateTimeInterface $endDate
     * @return void
     */
    public function execute(
        SurveyId $surveyId,
        \DateTimeInterface $initDate,
        \DateTimeInterface $endDate
    ) : void
    {
        // get surveys fulfillment
        $surveyFulfillments = $this->surveyFulfillmentRepository->findAllSurveyFulfillments(
            $surveyId,
            [
                'initDate' => $initDate,
                'endDate' => $endDate
            ]
        );

        if(!$surveyFulfillments){
            return;
        }

        $totalSurveyFulfillments = 0;
        $totalSurveyAnsweredQuestions = 0;
        $questionMarks = []; // values, total, summation

        /** @var SurveyFulfillment $surveyFulfillment */
        foreach($surveyFulfillments as $surveyFulfillment){
            $surveyFulfillmentId = $surveyFulfillment->id();
            $this->writeln('Processing ' . $surveyFulfillmentId . ' ...');

            $surveyFulfillmentResponse = $this->finder->execute($surveyFulfillmentId);
            $surveyFulfillmentReplies = $surveyFulfillmentResponse->toArray();

            if(empty($surveyFulfillmentReplies['items'])) {
                $this->writeln($surveyFulfillmentId . ' doesn\'t have any item.');
                continue;
            }

            foreach($surveyFulfillmentReplies['items'] as $item){
                $question = $item['question'];
                $questionText = $question['value'];
                $questionId = $question['id'];

                $value = implode('', $item['reply']['values']) ?? 0;
                $isNumberValue = preg_match('/\d/', $value) ? true : false;

                if(trim($value) === '') {
                    continue;
                }

                if($isNumberValue){
                    $value = (int) $value;
                }

                if(!isset($questionMarks[$questionId])){
                    $questionMarks[$questionId] = [
                        'question' => $questionText,
                        'values' => [ $value ],
                        'total' => 1,
                        'summation' => ($isNumberValue) ? $value : 0
                    ];
                    continue;
                }

                $questionMarks[$questionId]['values'][] = $value;
                $questionMarks[$questionId]['total'] += 1;

                if($isNumberValue){
                    $questionMarks[$questionId]['summation'] += (int) $value;
                }

                $totalSurveyAnsweredQuestions++;
            }

            $totalSurveyFulfillments++;
        }

        $report = [
            'questionMarks' => $questionMarks,
            'totalSurveyFulfillments' => $totalSurveyFulfillments,
            'totalSurveyAnsweredQuestions' => $totalSurveyAnsweredQuestions
        ];

        var_dump($report);
        die;
    }

    public function setOutput(OutputInterface $output) : void
    {
        $this->output = $output;
    }

    /**
     * @param string $msg
     * @return void
     */
    private function writeLn(string $msg) : void
    {
        if(!$this->output) return;
        $this->output->writeln($msg);
    }
}
