<?php

namespace SurveySystem\Survey\Infrastructure\Persistence;

use Doctrine\ORM\EntityRepository;
use SurveySystem\Survey\Domain\SurveyFulfillment\SurveyFulfillment;
use SurveySystem\Survey\Domain\SurveyFulfillment\SurveyFulfillmentRepository;
use SurveySystem\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use SurveySystem\Survey\Domain\SurveyQuestion\SurveyQuestion;

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
     * @param array $surveyIds
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
     * @param array $filters
     * @return array
     */
    public function listWithReplies(array $filters = []) : array
    {
        return $this->getRepository()->createQueryBuilder('f')
                    ->select('f.id, f.name, r.id AS questionId, r.id AS replyId, r.values, f.createdAt')
                    ->join('f.replies', 'r')
                    ->join(SurveyQuestion::class, 'q', 'WITH', 'r.surveyQuestionId = q.id')
                    ->orderBy('createdAt', 'desc')
                    ->getQuery()
                    ->getResult();
    }

    /**
     * @param array $filters
     * @return int
     */
    public function total(array $filters = []) : int
    {
        try{
            $queryBuilder = $this->getRepository()->createQueryBuilder('f')->select('count(1)');
            return (int) $queryBuilder->getQuery()->getSingleScalarResult();
        }catch (\Exception $e){
            return 0;
        }
    }

    /**
     * @return EntityRepository
     */
    private function getRepository() : EntityRepository
    {
        return $this->repository(SurveyFulfillment::class);
    }
}
