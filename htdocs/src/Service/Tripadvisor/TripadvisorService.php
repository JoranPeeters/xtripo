<?php

namespace App\Service\Tripadvisor;

use App\Repository\PlaceRepository;
use App\Entity\Roadtrip;
use App\Entity\Place;

class TripadvisorService
{
    public function __construct(
        private readonly TripadvisorNearbyPlacesService $tripadvisorNearbyPlacesService,
        private readonly PlaceRepository $placeRepository,
    ) {
    }

    public function fetchAndSaveAllNearbyPlaces(array $waypoints, int $roadtripId): void
    {
        $coordinates = $this->getLatitudeLongitude($waypoints);
        $nearbyPlaces = $this->getNearbyPlaces($coordinates);
        $this->saveAllNearbyPlaces($nearbyPlaces, $roadtripId);
    }

    private function saveAllNearbyPlaces(array $nearbyPlaces, int $roadtripId): void
    {
        foreach ($nearbyPlaces as $nearbyPlace) {
            foreach ($nearbyPlace as $place) {
                $existingPlace = $this->placeRepository->findOneBy(['place_id' => $place['place_id']]);
                if(!$existingPlace) {
                    $this->placeRepository->savePlace($place, $place['category'], $roadtripId);
                }
            }
        }
    }

    public function getAllNearbyPlaces(Roadtrip $roadtrip): array
    {
        $allNearbyPlaces = $roadtrip->getPlaces();

        if (empty($nearbyPlaces)) {
            $this->fetchAndSaveAllNearbyPlaces($roadtrip->getWaypoints()->toarray(), $roadtrip->getId());
            $allNearbyPlaces = $roadtrip->getPlaces();
        }

        return $allNearbyPlaces->toArray();
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

    private function getNearbyPlaces(array $coordinates): array
    {
        $nearbyPlaces = [];
        foreach ($coordinates as $latLongCoordinate) {
            $nearbyPlaces[] = $this->tripadvisorNearbyPlacesService->searchNearbyPlaces($latLongCoordinate, 'en');
        }

        return $nearbyPlaces;
    }
}
