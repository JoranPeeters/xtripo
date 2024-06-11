<?php
// src/Controller/RoadtripController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RoadtripRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Roadtrip;
use App\Form\RoadtripFormType;
use App\Service\OpenAI\OpenAIService;
use App\Service\Database\WaypointService;
use App\Service\GoogleMaps\GoogleMapsService;
use App\Service\Database\RoadtripService;
use App\Service\Tripadvisor\TripadvisorService;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;
use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Symfony\Contracts\Translation\TranslatorInterface;

class RoadtripController extends AbstractController
{
    
    public function __construct(
        private readonly RoadtripRepository $roadtripRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly OpenAIService $openAIService,
        private readonly WaypointService $waypointService,
        private readonly GoogleMapsService $googleMapsService,
        private readonly TripadvisorService $tripadvisorService,
        private readonly LoggerInterface $logger,
        private readonly RoadtripService $roadtripService,
        private readonly TranslatorInterface $translator,
    ) {}

    #[Route('/roadtrip/new', name: 'app_roadtrip_new')]
    public function new(RoadtripRepository $roadtripRepository, RoadtripService $roadtripService, Request $request): Response
    {
        $logger = new Logger('name'); 
        $this->denyAccessUnlessGranted('ROLE_USER');
        $roadtrip = new Roadtrip();
        $form = $this->createForm(RoadtripFormType::class, $roadtrip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $startTime = microtime(true);

            $roadtripService->saveRoadtripAndUpdatePopularity($roadtrip, $this->getUser());
            $roadtripRepository->flush();
            $this->addFlash('success', $this->translator->trans('message.roadtrip.created'));
            $this->logger->info('New roadtrip created', ['roadtrip' => $roadtrip]);

           

            $this->waypointService->generateAndSaveWaypoints($roadtrip);


            $endTime = microtime(true);
            $duration = $endTime - $startTime;
            $this->logger->info('OpenAI API call + flushing database duration: ' . $duration . ' seconds');
            return $this->render('home/index.html.twig', []);

            //$this->entityManager->refresh($roadtrip);
            //$waypoints = $roadtrip->getWaypoints();

            //$firstWaypoints = $this->waypointService->getFirstWaypointsOfEachDay($waypoints->toArray());
            //$this->tripadvisorService->fetchAndSaveAllNearbyPlaces($firstWaypoints, $roadtrip->getId());

            // Redirect to the configure page with the roadtrip and waypoints
            return $this->redirectToRoute('app_roadtrip_configure', [
                'id' => $roadtrip->getId()
            ]);
        }

        return $this->render('roadtrip/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/roadtrip/{id}/configure', name: 'app_roadtrip_configure')]
    public function configure(Roadtrip $roadtrip, Security $security, TripadvisorService $tripadvisorService, LoggerInterface $logger): Response
    {
        // Check if the user is logged in
        $user = $security->getUser();
        if (!$user) {
            throw new AccessDeniedException('You must be logged in to access this page.');
        }
    
        // Check if the road trip belongs to the logged-in user
        if ($roadtrip->getUser() !== $user) {
            throw new AccessDeniedException('You do not have permission to access this road trip.');
        }
    
        try {
            $waypoints = $roadtrip->getWaypoints();
            if (empty($waypoints)) {
                throw new \Exception('No waypoints found for this roadtrip.');
            }

            $nearbyPlaces = $tripadvisorService->getAllNearbyPlaces($roadtrip);

            // Calculate the number of days for the roadtrip
            $startDate = $roadtrip->getStartDate();
            $endDate = $roadtrip->getEndDate();
            $days = $startDate->diff($endDate)->days + 1; // Adding 1 to include both start and end date
    
            return $this->render('roadtrip/configure.html.twig', [
                'roadtrip' => $roadtrip,
                'country' => $roadtrip->getCountry(),
                'waypoints' => $roadtrip->getWaypoints(),
                'days' => $days,
                'nearbyPlaces' => $nearbyPlaces,
            ]);
        } catch (\Exception $e) {
            $logger->error('Error in configure method', ['exception' => $e]);
            return new Response('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    

    #[Route('/roadtrip/{id}', name: 'app_roadtrip_view')]
    public function view(Roadtrip $roadtrip): Response
    {
        return $this->render('roadtrip/view.html.twig', [
            'roadtrip' => $roadtrip,
            'waypoints' => $roadtrip->getWaypoints()
        ]);
    }

    #[Route('/roadtrip/{id}/edit', name: 'app_roadtrip_edit')]
    public function edit(Request $request, Roadtrip $roadtrip): Response
    {
        $form = $this->createForm(RoadtripFormType::class, $roadtrip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Increment popularity for the selected country
            $country = $roadtrip->getCountry();
            $country->setPopularity($country->getPopularity() + 1);
            $this->entityManager->persist($country);

            // Increment popularity for the selected roadtrip types
            foreach ($roadtrip->getRoadtripTypes() as $type) {
                $type->setPopularity($type->getPopularity() + 1);
                $this->entityManager->persist($type);
            }

            $this->roadtripRepository->save($roadtrip, true);

            // Save the waypoints as needed
            $roadtripWaypoints = $this->openAIService->generateRoadtrip($roadtrip);
            $this->waypointService->saveWaypoints($roadtripWaypoints, $roadtrip);

            // Redirect user to the roadtrip view page
            return $this->redirectToRoute('app_roadtrip_view', ['id' => $roadtrip->getId()]);
        }

        return $this->render('roadtrip/edit.html.twig', [
            'form' => $form->createView(),
            'roadtrip' => $roadtrip
        ]);
    }
}
