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
use App\Service\Tripadvisor\TripadvisorService;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;
use Psr\Log\LoggerInterface;

class RoadtripController extends AbstractController
{
    public function __construct(
        private readonly RoadtripRepository $roadtripRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly OpenAIService $openAIService,
        private readonly WaypointService $waypointService,
        private readonly GoogleMapsService $googleMapsService,
        private readonly TripadvisorService $tripadvisorService,
        private readonly LoggerInterface $logger
    ) {}

    #[Route('/roadtrip/{id}/configure', name: 'app_roadtrip_configure')]
    public function configure(Roadtrip $roadtrip, Security $security): Response
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
                $this->tripadvisorService->searchAllNearbyPlaces($waypoints->toArray());
                
                if (empty($waypoints)) {
                    throw new \Exception('No waypoints found for this roadtrip.');
                }
        
                return $this->render('roadtrip/configure.html.twig', [
                    'roadtrip' => $roadtrip,
                    'country' => $roadtrip->getCountry(),
                    'waypoints' => $roadtrip->getWaypoints(),
                ]);
    
        } catch (\Exception $e) {
            $this->logger->error('Error in configure method', ['exception' => $e]);
            return new Response('An error occurred: ' . $e->getMessage(), 500);
            // // Render a different template or return a custom response
            // return $this->render('roadtrip/error.html.twig', [
            //     'errorMessage' => 'An error occurred while configuring the roadtrip: ' . $e->getMessage()
            // ]);
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
