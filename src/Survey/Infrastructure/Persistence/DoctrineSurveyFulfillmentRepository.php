<?php

namespace SurveySystem\Survey\Infrastructure\Persistence;

use Doctrine\ORM\EntityRepository;
use SurveySystem\Survey\Domain\SurveyFulfillment\SurveyFulfillment;
use SurveySystem\Survey\Domain\SurveyFulfillment\SurveyFulfillmentReply;
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
    public function listWithReplies(string $id, array $filters = []) : array
    {
        $surveyFulfillments = $this->getRepository()->createQueryBuilder('f')
                    ->select('f.id, q.question, r.id AS questionId, r.id AS replyId, r.values, f.createdAt, q.position as questionPosition')
                    ->leftjoin(SurveyFulfillmentReply::class, 'r', 'WITH', 'r.surveyFulfillment = f.id')
                    ->leftJoin(SurveyQuestion::class, 'q', 'WITH', 'r.surveyQuestionId = q.id')
                    ->where('f.id = :id')
                    ->setParameter('id', $id)
                    ->orderBy('f.createdAt', 'desc')
                    ->getQuery()->getResult();

        $positions = [];
        $sortedSurveyFulfillments = [];

        foreach($surveyFulfillments as $key => $surveyFulfillment){
            $positions[$key] = $surveyFulfillment['questionPosition'];
        }

        asort($positions);

        foreach($positions as $surveyFulfillmentCollectionKey => $position){
            $sortedSurveyFulfillments[] = $surveyFulfillments[$surveyFulfillmentCollectionKey];
        }

        return $sortedSurveyFulfillments;
    }

    /**
     * @param array $filters
     * @return int
     */
    public function totalWithReplies(string $id, array $filters = []) : int
    {
        try{
            $queryBuilder = $this->getRepository()
                                 ->createQueryBuilder('f')
                                 ->select('count(1)')
                                 //->join(SurveyFulfillmentReply::class, 'r', 'WITH', 'r.surveyFulfillment = f.id')
                                 ->leftjoin(SurveyFulfillmentReply::class, 'r', 'WITH', 'r.surveyFulfillment = f.id')
                                 ->leftJoin(SurveyQuestion::class, 'q', 'WITH', 'r.surveyQuestionId = q.id')
                                 ->where('f.id = :id')
                                 ->setParameter('id', $id);

            return (int) $queryBuilder->getQuery()->getSingleScalarResult();
        }catch (\Exception $e){
            return 0;
        }
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
