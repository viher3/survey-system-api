<?php

namespace SurveySystem\Survey\Infrastructure\Persistence;

use SurveySystem\Survey\Domain\Survey;
use SurveySystem\Survey\Domain\SurveyId;
use SurveySystem\Survey\Domain\SurveyRepository;
use SurveySystem\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class DoctrineSurveyRepository extends DoctrineRepository implements SurveyRepository
{
    public function search(SurveyId $id): ?Survey
    {
        return $this->repository(Survey::class)->find($id);
    }

    /**
     * @param Survey $survey
     * @return void
     */
    public function save(Survey $survey): void
    {
        $this->persist($survey);
    }
}
