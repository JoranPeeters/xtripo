<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RoadtripController extends AbstractController
{
    #[Route('/roadtrip', name: 'app_roadtrip')]
    public function index(): Response
    {
        return $this->render('roadtrip/index.html.twig', [
            'controller_name' => 'RoadtripController',
        ]);
    }
}
