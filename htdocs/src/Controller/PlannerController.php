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
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
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
        private readonly Security $security

        )
    {}

    #[Route('/planner', name: 'app_planner')]
    public function index(Request $request): Response
    {
        $roadtrip = new Roadtrip();
        $form = $this->createForm(RoadtripFormType::class, $roadtrip);

        $form->handleRequest($request);

        // if ($form->isSubmitted() && !$form->isValid()) {
        //     dd($form->getErrors(true, false)); // Dump form errors
        // }

        if ($form->isSubmitted() && $form->isValid()) {

            // Set the current user as the roadtrip creator
            $roadtrip->setUser($this->getUser());

            // Link the entities based on the API response
            //$this->linkEntities($roadtrip);

            // Save and persist the roadtrip details
            $this->roadtripRepository->save($roadtrip, true);

            dd($roadtrip); //API Call Can be made This is a stopping point
            // Generate the roadtrip details via OpenAI API
            $roadtripDetails = $this->openAIService->generateRoadtrip($roadtrip);

            // Redirect user to the roadtrip view page
            return $this->redirectToRoute('app_roadtrip_view', ['id' => $roadtrip->getId()]);
        }

        return $this->render('planner/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    private function linkEntities(Roadtrip $roadtrip) : void 
    {   
        $vehicle = $this->vehicleRepository->findOneBy(['type' => $roadtrip->getVehicle()]);
        $roadtrip->setVehicle($vehicle);

        $country = $this->countryRepository->findOneBy(['name' => $roadtrip->getCountry()]);
        $roadtrip->setCountry($country->getName());

        $roadtripTypes = $this->roadtripTypeRepository->findOneBy(['name' => $roadtrip->getRoadtripTypes()]);
        $roadtrip->addRoadtripType($roadtripTypes);
    }

    // // #[Route('/get-vehicle-models', name: 'get_vehicle_models', methods: ['GET'])]
    // // public function getVehicleModels(Request $request): JsonResponse
    // // {
    // //     $vehicleType = $request->request->get('vehicle_type');
    // //     $models = $this->entityManager->getRepository(Vehicle::class)->findBy(['type' => $vehicleType]);
        
    // //     $modelChoices = [];
    // //     foreach ($models as $vehicle) {
    // //         $modelChoices[$vehicle->getModel()] = $vehicle->getModel();
    // //     }

    // //     dd($modelChoices);
    // //     return new JsonResponse($modelChoices);
    // // }
}

