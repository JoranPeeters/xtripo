<?php

namespace App\Service\Tripadvisor;

use App\Repository\PlaceRepository;
use App\Entity\Roadtrip;
use App\Repository\RoadtripRepository;
use App\Service\Tripadvisor\TripadvisorNearbyPlacesService;
use App\Service\Logger\LoggerService;

class TripadvisorService
{
    public function __construct(
        private readonly TripadvisorNearbyPlacesService $tripadvisorNearbyPlacesService,
        private readonly PlaceRepository $placeRepository,
        private readonly RoadtripRepository $roadtripRepository,
        private readonly TripadvisorPlaceDetailService $tripadvisorPlaceDetailService,
        private readonly LoggerService $logger,
    ) {
    }

    public function fetchAndSaveAllNearbyPlaces(array $waypoints, int $roadtripId): void
    {
        $coordinates = $this->getLatitudeLongitude($waypoints);
        $nearbyPlaceIds = $this->getNearbyPlaceIds($coordinates);
        $newPlaceIds = $this->checkForExistingPlacesAndSetToRoadtrip($nearbyPlaceIds, $roadtripId);
        $newPlaceDetails = $this->tripadvisorPlaceDetailService->getPlaceDetails($newPlaceIds);
        $this->saveAllNearbyPlaces($newPlaceDetails, $roadtripId);
    }

    private function saveAllNearbyPlaces(array $newPlaces, int $roadtripId): void
    {
        $roadtrip = $this->roadtripRepository->find($roadtripId);
        foreach ($newPlaces as $newPlace) {
            $this->placeRepository->savePlace($newPlace, $roadtrip);
        }

        $this->logger->logMessage('Tripadvisor - Saved ' . count($newPlaces) . ' new places to roadtrip with ID: ' . $roadtripId);
        $this->placeRepository->flush();
    }

    public function getAllNearbyPlaces(Roadtrip $roadtrip): array
    {
        $allNearbyPlaces = $roadtrip->getPlaces();

        if(!$allNearbyPlaces) {
            throw new \Exception('No nearby places found for roadtrip with ID: ' . $roadtrip->getId());
            $this->logger->logError('No nearby places found for roadtrip with ID: ' . $roadtrip->getId());
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

    private function getNearbyPlaceIds(array $coordinates): array
    {
        $nearbyPlaceIds = [];
        foreach ($coordinates as $latLongCoordinate) {
            $nearbyPlaceIds[] = $this->tripadvisorNearbyPlacesService->searchNearbyPlaces($latLongCoordinate, 'en');
        }

        return $nearbyPlaceIds;
    }

    private function checkForExistingPlacesAndSetToRoadtrip(array $nearbyPlaceIds, int $roadtripId): array
    {
        $newPlaceIds = [];
        $existingPlaces = [];
        $roadtrip = $this->roadtripRepository->find($roadtripId);

        if (!$roadtrip) {
            throw new \Exception("Roadtrip with ID $roadtripId not found.");
            $this->logger->logError('Roadtrip with ID ' . $roadtripId . ' not found.');
        }

        foreach ($nearbyPlaceIds as $day => $categories) {
            foreach($categories as $category => $placeIds) {
                foreach($placeIds as $placeId) {
                    $existingPlace = $this->placeRepository->findOneBy(['place_id' => $placeId]);

                    if (!$existingPlace) {
                        $newPlaceIds[$day][$category][] = $placeId;

                    } else{
                        $existingPlaces[] = $existingPlace;
                        $roadtrip->addPlace($existingPlace);
                    }
                }
            }
        }
        
        $this->logger->logMessage('Tripadvisor - Found: ' . count($newPlaceIds) . ' new places and ' . count($existingPlaces) . ' existing places.');
        $this->roadtripRepository->save($roadtrip);
        $this->roadtripRepository->flush();

        return $newPlaceIds;
    }
}
