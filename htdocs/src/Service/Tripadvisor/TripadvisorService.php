<?php

namespace App\Service\Tripadvisor;

use App\Service\Tripadvisor\TripadvisorNearbyPlacesService;

class TripadvisorService
{
    public function __construct(
        private readonly TripadvisorNearbyPlacesService $tripadvisorNearbyPlacesService,
    ) {
    }

    public function searchAllNearbyPlaces(array $waypoints): array
    {
        $coordinates = $this->getLatitudeLongitude($waypoints);
        $nearbyPlaces = $this->getNearbyPlaceIds($coordinates);

        return [];
    }

    private function getLatitudeLongitude(array $waypoints): array
    {
        $latLongCoordinatesWaypoints = [];

        foreach ($waypoints as $waypoint) {
            $latitude = $waypoint->getLatitude();
            $longitude = $waypoint->getLongitude();
            $latLongCoordinatesWaypoints[] = $latitude . ',' . $longitude;
        }

        return $latLongCoordinatesWaypoints;
    }

    private function getNearbyPlaceIds(array $coordinates): array
    {
        $nearbyPlaces = [];
        foreach ($coordinates as $latLongCoordinate) {
            $nearbyPlaces[] = $this->tripadvisorNearbyPlacesService->searchNearbyPlaces($latLongCoordinate);
        }

        //dd($nearbyPlaces);
        return $nearbyPlaces;
    }
}
