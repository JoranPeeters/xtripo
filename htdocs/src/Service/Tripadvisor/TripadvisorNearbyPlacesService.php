<?php

namespace App\Service\Tripadvisor;

use App\Service\Tripadvisor\TripadvisorApiService;
use App\Service\Tripadvisor\TripadvisorPlaceDetailService;

class TripadvisorNearbyPlacesService
{
    public function __construct(
        private readonly TripadvisorApiService $tripadvisorApiService,
        private readonly TripadvisorPlaceDetailService $tripadvisorPlaceDetailService,
    ) {
    }

    public function searchNearbyPlaces(string $latLongCoordinate): array
    {
         $nearbyPlaces = [
            'restaurants' => $this->searchNearbyRestaurants($latLongCoordinate),
            'attractions' => $this->searchNearbyAttractions($latLongCoordinate),
            'hotels' => $this->searchNearbyHotels($latLongCoordinate),
            'geos' => $this->searchNearbyGeos($latLongCoordinate),
        ];

        $nearbyPlaceIds = $this->getNearbyPlaceIds($nearbyPlaces);
        $nearbyPlaceDetails = $this->tripadvisorPlaceDetailService->getPlaceDetails($nearbyPlaceIds);

        return $nearbyPlaces;
    }

    private function searchNearbyRestaurants(string $latLongCoordinate): array
    {
        $results = $this->tripadvisorApiService->makeApiRequest('https://api.content.tripadvisor.com/api/v1/location/nearby_search', [
            'latLong' => $latLongCoordinate,
            'key' => $_ENV['TRIPADVISOR_API_KEY'],
            'radius' => 5,
            'radiusUnit' => 'km',
            'language' => 'en',
            'category' => 'restaurants',
        ]);

        if (!isset($results['data'])) {
            return [];
        }

        return $results['data'];
    }

    private function searchNearbyAttractions(string $latLongCoordinate): array
    {
        $results = $this->tripadvisorApiService->makeApiRequest('https://api.content.tripadvisor.com/api/v1/location/nearby_search', [
            'latLong' => $latLongCoordinate,
            'key' => $_ENV['TRIPADVISOR_API_KEY'],
            'radius' => 20,
            'radiusUnit' => 'km',
            'language' => 'en',
            'category' => 'attractions',
        ]);

        if (!isset($results['data'])) {
            return [];
        }

        return $results['data'];
    }

    private function searchNearbyHotels(string $latLongCoordinate): array
    {
        $results = $this->tripadvisorApiService->makeApiRequest('https://api.content.tripadvisor.com/api/v1/location/nearby_search', [
            'latLong' => $latLongCoordinate,
            'key' => $_ENV['TRIPADVISOR_API_KEY'],
            'radius' => 10,
            'radiusUnit' => 'km',
            'language' => 'en',
            'category' => 'hotels',
        ]);

        if (!isset($results['data'])) {
            return [];
        }

        return $results['data'];
    }

    private function searchNearbyGeos(string $latLongCoordinate): array
    {
        $results = $this->tripadvisorApiService->makeApiRequest('https://api.content.tripadvisor.com/api/v1/location/nearby_search', [
            'latLong' => $latLongCoordinate,
            'key' => $_ENV['TRIPADVISOR_API_KEY'],
            'radius' => 20,
            'radiusUnit' => 'km',
            'language' => 'en',
            'category' => 'geos',
        ]);

        if (!isset($results['data'])) {
            return [];
        }

        return $results['data'];
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
