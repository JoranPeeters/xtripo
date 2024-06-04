<?php

namespace App\Service\Database;

use App\Entity\Vehicle;
use App\Repository\VehicleRepository;

class VehicleService
{
    
    public function __construct(
        private readonly VehicleRepository $vehicleRepository,
    ) {
    }

    public function addVehicle(array $vehicles): void
    {
        foreach ($vehicles as $vehicleData) {
            if (!$this->vehicleRepository->findOneBy(['type' => $vehicleData['type']])) {
                $type = new Vehicle();
                $type
                    ->setType($vehicleData['type'])
                    ->setModels($vehicleData['models'])
                    ->setFuelTypes($vehicleData['fuel_types']);

                $this->vehicleRepository->save($type,true);
            }
        }
    }
}

