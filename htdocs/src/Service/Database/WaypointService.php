<?php

namespace App\Service\Database;

use App\Entity\Waypoint;
use App\Entity\City;
use App\Entity\Roadtrip;
use App\Repository\WaypointRepository;
use App\Repository\CityRepository;
use App\Service\OpenAI\OpenAIService;
use App\Service\Logger\LoggerService;
use Doctrine\ORM\EntityManagerInterface;

class WaypointService
{
    public function __construct(
        private readonly WaypointRepository $waypointRepository,
        private readonly CityRepository $cityRepository,
        private readonly OpenAIService $openAIService,
        private readonly LoggerService $logger,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function generateRoadtripAndSaveWaypoints(Roadtrip $roadtrip): void
    {
        $this->generateAndSaveWaypoints($roadtrip);
        $this->entityManager->refresh($roadtrip);
        $this->logger->logMessage('OpenAi - Generated roadtrip and added all waypoints to: ' . $roadtrip->getId());
    }

    public function saveWaypoints(array $waypoints, Roadtrip $roadtrip): void
    {
        $currentRoadtripCountry = $roadtrip->getCountry();

        foreach ($waypoints as $dayData) {
            foreach ($dayData['waypoints'] as $waypointData) {
                $city = $this->cityRepository->findOneBy(['name' => $waypointData['city']]);

                if (!$city) {
                    $city = new City();
                    $city->setName($waypointData['city'])
                         ->setCountry($currentRoadtripCountry)
                         ->setPopularity(1);

                    $this->cityRepository->save($city, true);
                }
                
                $city->setPopularity($city->getPopularity() + 1);

                $waypoint = new Waypoint();
                $waypoint->setDay($dayData['day'])
                         ->setRoadtrip($roadtrip)
                         ->setCity($city)
                         ->setLocationName($waypointData['location_name'])
                         ->setDescription($waypointData['description'])
                         ->setAdvice($waypointData['advice'])
                         ->setLongitude($waypointData['longitude'])
                         ->setLatitude($waypointData['latitude'])
                         ->setDistance($waypointData['distance'])
                         ->setBestHours($waypointData['best_hours'])
                         ->setPopularity(1);

                $this->waypointRepository->save($waypoint);
                $this->cityRepository->save($city);
            }
        }

        $this->waypointRepository->flush();
        $this->cityRepository->flush();
    }

    public function generateAndSaveWaypoints(Roadtrip $roadtrip): void
    {
        
        $roadtripWaypoints = $this->openAIService->generateRoadtrip($roadtrip);
        $this->saveWaypoints($roadtripWaypoints, $roadtrip);

    }

    public function getFirstWaypointsOfEachDay(array $waypoints): array
    {
        $firstWaypoints = [];
        
        foreach ($waypoints as $waypoint) {
            $day = $waypoint->getDay();
            // If not added a waypoint for this day yet, or if this waypoint was created earlier than the currently stored one
            if (!isset($firstWaypoints[$day]) || $waypoint->getCreatedAt() < $firstWaypoints[$day]->getCreatedAt()) {
                $firstWaypoints[$day] = $waypoint;
            }
        }
    
        $this->logger->logMessage('Database - Found ' . count($firstWaypoints) . ' first waypoints of each day.');
        return $firstWaypoints;
    }
}
