<?php

namespace SurveySystem\Survey\Application\SurveyFulfillment\Create;

use SurveySystem\Survey\Domain\Survey\SurveyId;
use SurveySystem\Survey\Domain\Survey\SurveyNotFound;
use SurveySystem\Survey\Domain\Survey\SurveyRepository;
use SurveySystem\Survey\Domain\SurveyQuestion\SurveyQuestionId;
use SurveySystem\Survey\Domain\SurveyFulfillment\SurveyFulfillment;
use SurveySystem\Survey\Domain\SurveyFulfillment\SurveyFulfillmentRepository;

class SurveyFulfillmentCreator
{
    private SurveyRepository $surveyRepository;
    private SurveyFulfillmentRepository $surveyFulfillmentRepository;

    /**
     * @param SurveyRepository $surveyRepository
     * @param SurveyFulfillmentRepository $surveyFulfillmentRepository
     */
    public function __construct(
        SurveyRepository $surveyRepository,
        SurveyFulfillmentRepository $surveyFulfillmentRepository
    )
    {
        $this->surveyRepository = $surveyRepository;
        $this->surveyFulfillmentRepository = $surveyFulfillmentRepository;
    }

    /**
     * @param SurveyFulfillmentCreatorCommand $surveyFulfillmentCreatorCommand
     * @return void
     */
    public function execute(SurveyFulfillmentCreatorCommand $surveyFulfillmentCreatorCommand) : void
    {
        $surveyId = new SurveyId($surveyFulfillmentCreatorCommand->surveyId());
        $survey = $this->surveyRepository->search($surveyId);

        if(!$survey){
            throw new SurveyNotFound($surveyId);
        }

        $surveyFulfillment = SurveyFulfillment::create($survey);

        foreach($surveyFulfillmentCreatorCommand->replies() as $reply){
            $surveyFulfillment->addReply(
                new SurveyQuestionId($reply['question_id']),
                $reply['values']
            );
        }

        $this->surveyFulfillmentRepository->save($surveyFulfillment);
    }
}
