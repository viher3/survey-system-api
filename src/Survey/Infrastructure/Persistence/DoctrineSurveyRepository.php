<?php

namespace SurveySystem\Survey\Infrastructure\Persistence;

use Doctrine\ORM\EntityRepository;
use SurveySystem\Survey\Domain\Survey\Survey;
use SurveySystem\Survey\Domain\Survey\SurveyId;
use SurveySystem\Survey\Domain\Survey\SurveyRepository;
use SurveySystem\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class DoctrineSurveyRepository extends DoctrineRepository implements SurveyRepository
{
    /**
     * @param SurveyId $id
     * @return Survey|null
     */
    public function search(SurveyId $id): ?Survey
    {
        return $this->getRepository()->find($id);
    }

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
     * @param Survey $survey
     * @return void
     */
    public function save(Survey $survey): void
    {
        $this->persist($survey);
    }

    /**
     * @return EntityRepository
     */
    private function getRepository() : EntityRepository
    {
        return $this->repository(Survey::class);
    }
}
