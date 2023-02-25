<?php

namespace SurveySystem\Survey\Infrastructure\Persistence;

use Doctrine\ORM\EntityRepository;
use SurveySystem\Survey\Domain\Report\DailyReport;
use SurveySystem\Survey\Domain\Report\DailyReportRepository;
use SurveySystem\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class DoctrineDailyReportRepository extends DoctrineRepository implements DailyReportRepository
{
    /**
     * @param array $filters
     * @return array
     */
    public function getList(array $filters = []) : array
    {
        $queryBuilder = $this->getRepository()->createQueryBuilder('s')->orderBy('s.createdAt', 'ASC');
        return $queryBuilder->getQuery()->getResult();
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
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
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
