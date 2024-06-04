<?php

namespace App\Command;

use App\Service\Database\VehicleService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


#[AsCommand(
    name: 'xtripo:import-vehicles',
    description: 'Import vehicles to database',
)]
class XtripoImportVehiclesCommand extends Command
{
    public function __construct(
        private readonly VehicleService $vehicleService,
    )
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Add types of road trips to the database.')
            ->setHelp('This command allows you to add types of road trips to the database...');
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $vehicles = [
            [
                "type" => "Car",
                "models" => ["Sedan", "SUV", "Hatchback", "Convertible", "Coupe", "Wagon", "Minivan"],
                "fuel_types" => ["Petrol", "Diesel", "Hybrid", "Electric"]
            ],
            [
                "type" => "Motorcycle",
                "models" => ["Cruiser", "Sport", "Touring", "Standard", "Dual-Sport", "Dirt Bike"],
                "fuel_types" => ["Petrol", "Electric"]
            ],
            [
                "type" => "Truck",
                "models" => ["Pickup", "Lorry", "Tow Truck", "Dump Truck", "Box Truck"],
                "fuel_types" => ["Petrol", "Diesel", "Electric"]
            ],
            [
                "type" => "Van",
                "models" => ["Cargo Van", "Passenger Van", "Minivan", "Campervan"],
                "fuel_types" => ["Petrol", "Diesel", "Hybrid", "Electric"]
            ],
            [
                "type" => "Bus",
                "models" => ["City Bus", "Tour Bus", "School Bus", "Shuttle Bus"],
                "fuel_types" => ["Diesel", "Electric", "Hybrid"]
            ],
            [
                "type" => "RV",
                "models" => ["Class A", "Class B", "Class C", "Travel Trailer", "Fifth-Wheel Trailer"],
                "fuel_types" => ["Petrol", "Diesel"]
            ]
        ];

        $this->vehicleService->addVehicle($vehicles);

        $output->writeln('Vehicles added successfully!');

        return Command::SUCCESS;
        
    }
}
