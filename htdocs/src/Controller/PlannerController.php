<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlannerController extends AbstractController
{
    #[Route('/planner', name: 'app_planner')]
    public function index(): Response
    {
        return $this->render('planner/index.html.twig', []);
    }
}
