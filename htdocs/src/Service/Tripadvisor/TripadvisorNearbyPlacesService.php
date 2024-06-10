<?php

namespace App\Service\Tripadvisor;

use App\Repository\PlaceRepository;

class TripadvisorNearbyPlacesService
{
    private const SEARCH_RADIUS_KM = 3; // Define the search radius in kilometers

    public function __construct(
        private readonly TripadvisorApiService $tripadvisorApiService,
        private readonly TripadvisorPlaceDetailService $tripadvisorPlaceDetailService,
        private readonly PlaceRepository $placeRepository,
    ) {}

    public function searchNearbyPlaces(string $latLongCoordinate, string $language): array
    {
        $nearbyPlaces = [
            'restaurant' => $this->searchNearbyCategory($latLongCoordinate, 'restaurants', $language),
            'attraction' => $this->searchNearbyCategory($latLongCoordinate, 'attractions', $language),
            'hotel' => $this->searchNearbyCategory($latLongCoordinate, 'hotels', $language),
            'geo' => $this->searchNearbyCategory($latLongCoordinate, 'geos', $language),
        ];

        $nearbyPlaceIds = $this->getNearbyPlaceIds($nearbyPlaces);
        $nearbyPlaceDetails = $this->tripadvisorPlaceDetailService->getPlaceDetails($nearbyPlaceIds);

        return $nearbyPlaceDetails;
    }

    private function searchNearbyCategory(string $latLongCoordinate, string $category, string $language): array
    {
        [$latitude, $longitude] = explode(',', $latLongCoordinate);

        // Check existing places in the database based on proximity
        $existingPlaces = $this->placeRepository->findNearbyPlaces((float)$latitude, (float)$longitude, $category, self::SEARCH_RADIUS_KM);

        if (count($existingPlaces) > 0) {
            return $existingPlaces;
        }

        // If no existing places found, make an API request
        $results = $this->getTripAdvisorNearbyPlaces($latLongCoordinate, $category, $language);

        return $results ?? [];
    }

    private function getTripAdvisorNearbyPlaces(string $latLongCoordinate, string $category, string $language): array
    {
        $results = $this->tripadvisorApiService->makeApiRequest('https://api.content.tripadvisor.com/api/v1/location/nearby_search', [
            'latLong' => $latLongCoordinate,
            'key' => $_ENV['TRIPADVISOR_API_KEY'],
            'radius' => self::SEARCH_RADIUS_KM,
            'radiusUnit' => 'km',
            'language' => $language,
            'category' => $category,
        ]);

        return $results['data'] ?? [];
    }

    private function getNearbyPlaceIds(array $nearbyPlaces): array
    {
        $placeIds = [];
        foreach ($nearbyPlaces as $placeType => $places) {
            foreach ($places as $place) {
                $placeIds[$placeType][] = $place['location_id'];
            }
        }

        return $placeIds;
    }
}
