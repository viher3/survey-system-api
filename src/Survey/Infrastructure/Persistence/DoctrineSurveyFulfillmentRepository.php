<?php

namespace SurveySystem\Survey\Infrastructure\Persistence;

use Doctrine\ORM\EntityRepository;
use SurveySystem\Survey\Domain\SurveyFulfillment\SurveyFulfillment;
use SurveySystem\Survey\Domain\SurveyFulfillment\SurveyFulfillmentRepository;
use SurveySystem\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class DoctrineSurveyFulfillmentRepository extends DoctrineRepository implements SurveyFulfillmentRepository
{
    /**
     * @param SurveyFulfillment $surveyFulfillment
     * @return void
     */
    public function save(SurveyFulfillment $surveyFulfillment): void
    {
        $this->persist($surveyFulfillment);
    }

    /**
     * @return array
     */
    public function totalCountGroupedBySurveyIds(array $surveyIds): array
    {
         $totalCountGroupBySurvey = [];

         $totalCountResponse = $this->getRepository()
            ->createQueryBuilder('f')
            ->select('count(1) AS total, s.id AS surveyId')
            ->join('f.survey', 's')
            ->where('s.id IN (:surveyIds)')
            ->setParameter('surveyIds', $surveyIds)
            ->groupBy('f.survey')
            ->getQuery()
            ->getArrayResult();

         foreach($totalCountResponse as $totalCount){
             $totalCountGroupBySurvey[$totalCount['surveyId']]  = $totalCount['total'];
         }

         return $totalCountGroupBySurvey;
    }

    /**
     * @return EntityRepository
     */
    private function getRepository() : EntityRepository
    {
        return $this->repository(SurveyFulfillment::class);
    }
}
