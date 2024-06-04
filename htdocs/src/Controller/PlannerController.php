<?php

// src/Controller/PlannerController.php

namespace App\Controller;

use App\Entity\Roadtrip;
use App\Form\RoadtripType;
use App\Service\OpenAI\OpenAIService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\RoadtripRepository;
use App\Repository\VehicleRepository;
use App\Repository\CountryRepository;
use App\Repository\TypeRepository;

class PlannerController extends AbstractController
{

    public function __construct(
        // private readonly RoadtripRepository $roadtripRepository,
        // private readonly VehicleRepository $vehicleRepository,
        // private readonly CountryRepository $countryRepository,
        // private readonly TypeRepository $typeRepository,
        // private readonly EntityManagerInterface $entityManager, 
        // private readonly OpenAIService $openAIService, 
        // private  readonly Security $security
        )
    {}

    #[Route('/planner', name: 'app_planner')]
    public function index(Request $request): Response
    {
        // $roadtrip = new Roadtrip();
        // $form = $this->createForm(RoadtripType::class, $roadtrip);

        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {

        //     // Set the current user as the roadtrip creator
        //     $roadtrip->setUser($this->getUser());

        //     // Link the entities based on the API response
        //     $this->linkEntities($roadtrip);

        //     // Save and persist the roadtrip details
        //     $this->roadtripRepository->save($roadtrip, true);

        //     dd($roadtrip);
        //     // Generate the roadtrip details via OpenAI API
        //     $roadtripDetails = $this->openAIService->generateRoadtrip($roadtrip);

        //     // Save the OpenAI output to the roadtrip
        //     $roadtrip->setOpenAiOutput($roadtripDetails);
        //     $this->entityManager->persist($roadtrip);
        //     $this->entityManager->flush();

        //     // Redirect user to the roadtrip view page
        //     return $this->redirectToRoute('app_roadtrip_view', ['id' => $roadtrip->getId()]);
        //}

        return $this->render('planner/index.html.twig', [
            // 'form' => $form->createView(),
        ]);
    }


    // private function linkEntities(Roadtrip $roadtrip) : void 
    // {   
    //     $vehicle = $this->vehicleRepository->findOneBy(['type' => $roadtrip->getVehicleType()]);
    //     $roadtrip->setVehicle($vehicle);

    //     $country = $this->countryRepository->findOneBy(['name' => $roadtrip->getDestination()]);
    //     $roadtrip->setDestination($country->getName());

    //     $types = $this->typeRepository->findOneBy(['name' => $roadtrip->getTypes()]);
    //     $roadtrip->setTypes($types);
    // }

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

