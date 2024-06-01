<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExploreTripsController extends AbstractController
{
    #[Route('/explore-trips', name: 'app_explore_trips')]
    public function index(): Response
    {
        return $this->render('explore_trips/index.html.twig', []);
    }
}
