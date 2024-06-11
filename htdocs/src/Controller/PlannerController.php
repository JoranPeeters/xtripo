<?php
// src/Controller/PlannerController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RoadtripRepository;
use App\Repository\VehicleRepository;
use App\Repository\CountryRepository;
use App\Repository\RoadtripTypeRepository;
use App\Service\OpenAI\OpenAIService;
use App\Service\Database\RoadtripService;
use App\Service\Database\WaypointService;
use App\Service\GoogleMaps\GoogleMapsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use App\Service\Tripadvisor\TripadvisorService;
use App\Entity\Roadtrip;
use App\Form\RoadtripFormType;


class PlannerController extends AbstractController
{
    public function __construct(
        private readonly RoadtripRepository $roadtripRepository,
        private readonly VehicleRepository $vehicleRepository,
        private readonly CountryRepository $countryRepository,
        private readonly RoadtripTypeRepository $roadtripTypeRepository,
        private readonly EntityManagerInterface $entityManager, 
        private readonly OpenAIService $openAIService,
        private readonly Security $security,
        private readonly WaypointService $waypointService,
        private readonly GoogleMapsService $googleMapsService,
        private readonly RoadtripService $roadtripService,
        private readonly TripadvisorService $tripadvisorService,
    ) {}
    

    #[Route('/planner', name: 'app_planner')]
    public function index(Request $request): Response
    {
        $roadtrip = new Roadtrip();
        $form = $this->createForm(RoadtripFormType::class, $roadtrip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Save the roadtrip and update the popularity of the country and roadtrip types
            $this->roadtripService->saveRoadtripAndUpdatePopularity($roadtrip, $this->getUser());

            // Generate and save the waypoints
            $this->waypointService->generateAndSaveWaypoints($roadtrip);
            $this->entityManager->refresh($roadtrip);
            $waypoints = $roadtrip->getWaypoints();

            $firstWaypoints = $this->waypointService->getFirstWaypointsOfEachDay($waypoints->toArray());
            $this->tripadvisorService->fetchAndSaveAllNearbyPlaces($firstWaypoints, $roadtrip->getId());

            // Redirect to the configure page with the roadtrip and waypoints
            return $this->redirectToRoute('app_roadtrip_configure', [
                'id' => $roadtrip->getId()
            ]);
        }

        return $this->render('planner/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
