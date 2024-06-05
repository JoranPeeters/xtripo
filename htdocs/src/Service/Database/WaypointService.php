<?php

namespace App\Service\Database;

use App\Entity\Waypoint;
use App\Entity\City;
use App\Entity\Roadtrip;
use App\Repository\WaypointRepository;
use App\Repository\CityRepository;

class WaypointService
{
    
    public function __construct(
        private readonly WaypointRepository $waypointRepository,
        private readonly CityRepository $cityRepository,
    ) {
    }

    public function saveWaypoints(array $waypoints, Roadtrip $roadtrip): void
    {
        foreach ($waypoints as $dayData) {
            foreach ($dayData['waypoints'] as $waypointData) {
                $city = $this->cityRepository->findOneBy(['name' => $waypointData['city']]);

                if (!$city) {
                    $currentRoadtripCountry = $roadtrip->getCountry();
                    
                    $city = new City();
                    $city->setName($waypointData['city'])
                         ->setCountry($currentRoadtripCountry)
                         ->setPopularity(0);

                    $this->cityRepository->save($city, true);
                }

                $city->setPopularity($city->getPopularity() + 1);
                $this->cityRepository->save($city);

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
                         ->setPopularity(0);

                $this->waypointRepository->save($waypoint);

                $waypoint->setPopularity($waypoint->getPopularity() + 1);
                $this->waypointRepository->save($waypoint);
            }
        }

        $this->waypointRepository->flush();
        $this->cityRepository->flush();
    }
}