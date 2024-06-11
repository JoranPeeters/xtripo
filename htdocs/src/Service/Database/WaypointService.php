<?php

namespace App\Service\Database;

use App\Entity\Waypoint;
use App\Entity\City;
use App\Entity\Roadtrip;
use App\Repository\WaypointRepository;
use App\Repository\CityRepository;
use App\Service\OpenAI\OpenAIService;
use Psr\Log\LoggerInterface;

class WaypointService
{
    public function __construct(
        private readonly WaypointRepository $waypointRepository,
        private readonly CityRepository $cityRepository,
        private readonly OpenAIService $openAIService,
        private readonly LoggerInterface $logger,
    ) {
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
        $startTime = microtime(true);

        $roadtripWaypoints = $this->openAIService->generateRoadtrip($roadtrip);

        $endTime = microtime(true);
        $duration = $endTime - $startTime;
        $this->logger->info('OpenAI API call + flushing database duration: ' . $duration . ' seconds');
        
        $this->saveWaypoints($roadtripWaypoints, $roadtrip);

    }

    public function getFirstWaypointsOfEachDay(array $waypoints): array
    {
        $firstWaypoints = [];
        $waypointsByDay = [];

        foreach ($waypoints as $waypoint) {
            $day = $waypoint->getDay();
            if (!isset($waypointsByDay[$day])) {
                $waypointsByDay[$day] = [];
            }
            $waypointsByDay[$day][] = $waypoint;
        }

        foreach ($waypointsByDay as $day => $waypointsForDay) {
            usort($waypointsForDay, function($a, $b) {
                return $a->getCreatedAt() <=> $b->getCreatedAt(); // Using getCreatedAt method to sort waypoints
            });
            $firstWaypoints[] = $waypointsForDay[0];
        }

        return $firstWaypoints;
    }
}
