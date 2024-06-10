<?php

namespace App\Service\Tripadvisor;

use App\Service\Tripadvisor\TripadvisorApiService;

class TripadvisorPlaceDetailService
{
    public function __construct(
        private readonly TripadvisorApiService $tripadvisorApiService,
    ) {
    }

    public function getPlaceDetails(array $nearbyPlaceIds): array
    {
        $placeDetails = [];

        foreach ($nearbyPlaceIds as $category => $placeIds) {
            $placeDetails[$category] = [];
                foreach ($placeIds as $placeId) {
                    $placeDetails[$category][] = $this->getPlaceDetail($category, $placeId);
                }
        }

        dd($placeDetails);
        return $placeDetails;
    }

    private function getPlaceDetail(string $category = null, string $placeId): array
    {
        $results = $this->tripadvisorApiService->makeApiRequest('https://api.content.tripadvisor.com/api/v1/location/' . $placeId . '/details', [
            'key' => $_ENV['TRIPADVISOR_API_KEY'],
            'language' => 'en',
            'currency' => 'USD',
        ]);

        
        return $results;
    }
}
