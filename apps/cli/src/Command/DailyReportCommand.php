<?php

namespace SurveySystem\Apps\Cli\Command;

use SurveySystem\Survey\Application\Report\Daily\Generate\DailyReportGenerator;
use SurveySystem\Survey\Domain\Survey\SurveyId;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DailyReportCommand extends Command
{
    protected static $defaultName = 'app:reports:daily:generate';
    private DailyReportGenerator $dailyReportGenerator;

    public function __construct(DailyReportGenerator $dailyReportGenerator)
    {
        parent::__construct(self::$defaultName);
        $this->dailyReportGenerator = $dailyReportGenerator;
    }

    protected function configure(): void
    {
        $this->addArgument('surveyId', InputArgument::REQUIRED);
        $this->addArgument('date', InputArgument::REQUIRED);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $surveyId = new SurveyId($input->getArgument('surveyId'));
        $initDate = new \DateTime($input->getArgument('date'));
        $endDate = clone $initDate;
        $endDate->setTime(23,59,59);

        $output->writeln('Generating ...');

        $this->dailyReportGenerator->setOutput($output);
        $this->dailyReportGenerator->execute($surveyId, $initDate, $endDate);

        $output->writeln('Done!');

        return Command::SUCCESS;
    }
}
