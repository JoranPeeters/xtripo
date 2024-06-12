<?php

namespace App\Service\Tripadvisor;

use App\Repository\PlaceRepository;
use App\Service\Logger\LoggerService;

class TripadvisorNearbyPlacesService
{
    private const SEARCH_RADIUS_KM = 3; // Define the search radius in kilometers

    public function __construct(
        private readonly TripadvisorApiService $tripadvisorApiService,
        private readonly TripadvisorPlaceDetailService $tripadvisorPlaceDetailService,
        private readonly PlaceRepository $placeRepository,
        private readonly LoggerService $logger,
    ) {}

    public function searchNearbyPlaces(string $latLongCoordinate, string $language): array
    {
        $nearbyPlaces = [
            'restaurants' => $this->searchNearbyCategory($latLongCoordinate, 'restaurants', $language),
            'attractions' => $this->searchNearbyCategory($latLongCoordinate, 'attractions', $language),
            'hotels' => $this->searchNearbyCategory($latLongCoordinate, 'hotels', $language),
            'geos' => $this->searchNearbyCategory($latLongCoordinate, 'geos', $language),
        ];

        $nearbyPlaceIds = $this->getNearbyPlaceIds($nearbyPlaces);
        $this->logger->logMessage('Tripadvisor - Found: ' 
        . count($nearbyPlaceIds['restaurants'] ?? []) . ' restaurants ' 
        . count($nearbyPlaceIds['attractions'] ?? []) . ' attractions ' 
        . count($nearbyPlaceIds['hotels'] ?? []) . ' hotels ' 
        .  count($nearbyPlaceIds['geos'] ?? []) . ' geos ' .' nearby: ' 
        . $latLongCoordinate);

        return $nearbyPlaceIds;
    }

    private function searchNearbyCategory(string $latLongCoordinate, string $category, string $language): array
    {
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
