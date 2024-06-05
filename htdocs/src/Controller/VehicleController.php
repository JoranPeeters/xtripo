<?php
// src/Controller/VehicleController.php

namespace App\Controller;

use App\Repository\VehicleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class VehicleController extends AbstractController
{
    private VehicleRepository $vehicleRepository;

    public function __construct(VehicleRepository $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    #[Route('/get-vehicle-data/{id}', name: 'get_vehicle_data', methods: ['GET'])]
    public function getVehicleData(int $id): JsonResponse
    {
        $vehicle = $this->vehicleRepository->find($id);

        if (!$vehicle) {
            return new JsonResponse(['error' => 'Vehicle not found'], 404);
        }

        return new JsonResponse([
            'fuel_types' => $vehicle->getFuelTypes(),
            'models' => $vehicle->getModels(),
        ]);
    }
}
