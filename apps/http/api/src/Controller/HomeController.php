<?php

namespace SurveySystem\Apps\Api\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomeController extends AbstractController
{
    public function __invoke()
    {
        return new JsonResponse(['Survey System API']);
    }
}
