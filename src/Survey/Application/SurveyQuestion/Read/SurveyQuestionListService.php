<?php

namespace SurveySystem\Survey\Application\SurveyQuestion\Read;

use Doctrine\ORM\NoResultException;
use Doctrine\ORM\NonUniqueResultException;
use SurveySystem\Survey\Domain\SurveyQuestion\SurveyQuestionRepository;

final class SurveyQuestionListService
{
    private SurveyQuestionRepository $surveyQuestionRepository;

    /**
     * @param SurveyQuestionRepository $surveyQuestionRepository
     */
    public function __construct(SurveyQuestionRepository $surveyQuestionRepository)
    {
        $this->surveyQuestionRepository = $surveyQuestionRepository;
    }

    /**
     * @param string $surveyId
     * @param array $filters
     * @return SurveyQuestionListResponse
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function execute(string $surveyId, array $filters = []) : SurveyQuestionListResponse
    {
        $surveyQuestions = $this->surveyQuestionRepository->getList($surveyId, $filters);
        $totalSurveyQuestions = $this->surveyQuestionRepository->total($surveyId, $filters);
        return SurveyQuestionListResponse::create($surveyQuestions, $totalSurveyQuestions);
    }
}
