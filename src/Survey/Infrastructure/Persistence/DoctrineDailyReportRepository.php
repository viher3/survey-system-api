<?php

namespace SurveySystem\Survey\Infrastructure\Persistence;

use Doctrine\ORM\EntityRepository;
use SurveySystem\Survey\Domain\Report\DailyReport;
use SurveySystem\Survey\Domain\Report\DailyReportRepository;
use SurveySystem\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use SurveySystem\Survey\Domain\SurveyQuestion\SurveyQuestion;

class DoctrineDailyReportRepository extends DoctrineRepository implements DailyReportRepository
{
    /**
     * @param array $filters
     * @return array
     */
    public function getList(array $filters = []) : array
    {
        $queryBuilder = $this->getRepository()
                             ->createQueryBuilder('q')
                             ->select('q.id, q.questionId, q.date, q.average, q.mode, qst.question, qst.position as questionPosition')
                             ->innerJoin(SurveyQuestion::class, 'qst', 'WITH', 'qst.id = q.questionId')
                             ->orderBy('q.date', 'ASC');

        if(!empty($filters['surveyId'])){
            $queryBuilder->andWhere('q.surveyId = :surveyId')->setParameter('surveyId', $filters['surveyId']);
        }
        if(!empty($filters['initDate'])){
            $queryBuilder->andWhere('q.date >= :initDate')->setParameter('initDate', $filters['initDate']);
        }
        if(!empty($filters['endDate'])){
            $filters['endDate']->setTime(23,59,59);
            $queryBuilder->andWhere('q.date <= :endDate')->setParameter('endDate', $filters['endDate']);
        }

        return $queryBuilder->getQuery()->getArrayResult();
    }

    /**
     * @param \DateTimeInterface $date
     * @return void
     */
    public function deleteByDay(\DateTimeInterface $date)
    {
        $date->setTime(0,0,0);
        $endDate = clone $date;
        $endDate->setTime(23,59,59);

        $this->getRepository()->createQueryBuilder('q')
                ->where('q.date >= :initDate')
                ->andWhere('q.date <= :endDate')
                ->setParameter('initDate', $date)
                ->setParameter('endDate', $endDate)
                ->delete()
                ->getQuery()
                ->execute();
    }

    /**
     * @param array $filters
     * @return int
     */
    public function total(array $filters = []) : int
    {
        try{
            $queryBuilder = $this->getRepository()->createQueryBuilder('s')->select('count(1)');
            return (int) $queryBuilder->getQuery()->getSingleScalarResult();
        }catch (\Exception $e){
            return 0;
        }
    }

    /**
     * @param DailyReport $report
     * @return void
     */
    public function save(DailyReport $report): void
    {
        $this->persist($report);
    }

    /**
     * @return EntityRepository
     */
    private function getRepository() : EntityRepository
    {
        return $this->repository(DailyReport::class);
    }
}
