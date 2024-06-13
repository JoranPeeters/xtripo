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
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Service\Logger\LoggerService;
use App\Service\Timer\TimerService;


class RoadtripController extends AbstractController
{
    
    public function __construct(
        private readonly RoadtripRepository $roadtripRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly OpenAIService $openAIService,
        private readonly WaypointService $waypointService,
        private readonly GoogleMapsService $googleMapsService,
        private readonly TripadvisorService $tripadvisorService,
        private readonly RoadtripService $roadtripService,
        private readonly TranslatorInterface $translator,
        private readonly LoggerService $logger,
        private readonly TimerService $timerService,
    ) {}

    #[Route('/roadtrip/new', name: 'app_roadtrip_new')]
    public function new(RoadtripService $roadtripService, WaypointService $waypointService , TimerService $timerService, Request $request): Response
    {
        
        $this->denyAccessUnlessGranted('ROLE_USER');
        $roadtrip = new Roadtrip();
        $form = $this->createForm(RoadtripFormType::class, $roadtrip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $startOpenAi= microtime(true);
            $startOveral = microtime(true);

            try {

                $roadtripService->handleNewRoadtrip($roadtrip, $this->getUser());
                $waypointService->generateRoadtripAndSaveWaypoints($roadtrip);
                $timerService->calculateTimeForGeneratedroadtrip($startOpenAi);

                $startTripadvisor = microtime(true);
                $firstWaypoints = $waypointService->getFirstWaypointsOfEachDay($roadtrip->getWaypoints()->toArray());
                $this->tripadvisorService->fetchAndSaveAllNearbyPlaces($firstWaypoints, $roadtrip->getId());
                $timerService->calculateTimeForTripadvisorApi($startTripadvisor);

                $timerService->calculateOveralTimeForAllRequests($startOveral);
                
                $this->addFlash('success', $this->translator->trans('message.roadtrip.created'));
                $this->addFlash('success', $this->translator->trans('message.tripadvisor.fetched'));

            } catch (\Throwable $e) {
                $this->addFlash('error', $this->translator->trans('message.roadtrip.error'));
                return $this->redirectToRoute('app_roadtrip_new');
            }

            return $this->redirectToRoute('app_roadtrip_configure', [
                'id' => $roadtrip->getId()
            ]);
        }

        return $this->render('roadtrip/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/roadtrip/{id}/configure', name: 'app_roadtrip_configure')]
    public function configure(Roadtrip $roadtrip, Security $security, TripadvisorService $tripadvisorService): Response
    {

        $user = $security->getUser();
        if (!$user || $roadtrip->getUser() !== $user) {
            throw new AccessDeniedException('You do not have permission to access this road trip.');
        }
    
        try {

            $waypoints = $roadtrip->getWaypoints();

            if (empty($waypoints)) {
                throw new \Exception('No waypoints found for this roadtrip.');
                $this->logger->logError('No waypoints found for roadtrip with ID ' . $roadtrip->getId());
                $this->addFlash('error', 'message.waypoints.error');
            }

            $allNearbyPlaces = $tripadvisorService->getAllNearbyPlaces($roadtrip);

            $startDate = $roadtrip->getStartDate();
            $endDate = $roadtrip->getEndDate();
            $daysCount = $startDate->diff($endDate)->days + 1;

            dd($allNearbyPlaces);
            
            return $this->render('roadtrip/configure.html.twig', [
                'roadtrip' => $roadtrip,
                'country' => $roadtrip->getCountry(),
                'waypoints' => $roadtrip->getWaypoints(),
                'days' => range(1, (int)$daysCount),
                'places' => $allNearbyPlaces,
            ]);
        } catch (\Exception $e) {
            $this->logger->logError('Error in configure method', ['exception' => $e]);
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
