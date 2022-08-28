<?php

namespace SurveySystem\Survey\Infrastructure\Persistence;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use SurveySystem\Survey\Domain\SurveyQuestion\SurveyQuestion;
use SurveySystem\Survey\Domain\SurveyQuestion\SurveyQuestionId;
use SurveySystem\Survey\Domain\SurveyQuestion\SurveyQuestionRepository;
use SurveySystem\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class DoctrineSurveyQuestionRepository extends DoctrineRepository implements SurveyQuestionRepository
{
    /**
     * @param SurveyQuestionId $id
     * @return SurveyQuestion|null
     */
    public function search(SurveyQuestionId $id): ?SurveyQuestion
    {
        return $this->repository(SurveyQuestion::class)->find($id);
    }

    /**
     * @param SurveyQuestion $surveyQuestion
     * @return void
     */
    public function save(SurveyQuestion $surveyQuestion): void
    {
        $this->persist($surveyQuestion);
    }

    /**
     * @param string $surveyId
     * @param array $filters
     * @return QueryBuilder
     */
    private function getListQueryBuilder(string $surveyId, array $filters = []) : QueryBuilder
    {
        return $this->getRepository()
            ->createQueryBuilder('s')
            ->where('s.survey = :survey')
            ->leftjoin('s.options', 'o')
            ->setParameter('survey', $surveyId)
            ->orderBy('s.position', 'ASC');
    }

    /**
     * @param array $filters
     * @return array
     */
    public function getList(string $surveyId, array $filters = []) : array
    {
        $queryBuilder = $this->getListQueryBuilder($surveyId, $filters);
        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param array $filters
     * @return int
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function total(string $surveyId, array $filters = []) : int
    {
        try{
            $queryBuilder = $this->getListQueryBuilder($surveyId, $filters)->select('count(1)');
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
        return $this->repository(SurveyQuestion::class);
    }
}
