<?php

namespace SurveySystem\Survey\Infrastructure\Persistence;

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
}
