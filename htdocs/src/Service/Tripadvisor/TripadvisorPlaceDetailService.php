<?php

namespace App\Service\Tripadvisor;

use App\Service\Tripadvisor\TripadvisorApiService;
use App\Service\Tripadvisor\Formatter\PlaceFormatter;
use App\Repository\PlaceRepository;
use App\Service\Logger\LoggerService;

class TripadvisorPlaceDetailService
{
    public function __construct(
        private readonly TripadvisorApiService $tripadvisorApiService,
        private readonly PlaceFormatter $placeFormatter,
        private readonly PlaceRepository $placeRepository,
        private readonly LoggerService $logger,
    ) {}

    public function getPlaceDetails(array $newPlaceIds): array
    {
        $placeDetails = [];
    
        foreach ($newPlaceIds as $day => $categories) {
            foreach ($categories as $category => $placeIds) {
                $limitedPlaceIds = array_slice($placeIds, 0, 2);
                foreach ($limitedPlaceIds as $placeId) {
                    $details = $this->getPlaceDetail($category, $placeId);
                    if ($details) {
                        $placeDetails[] = $this->placeFormatter->format($details, $day);
                    }
                }
            }
        }
    
        $this->logger->logMessage('Tripadvisor - Fetched ' . count($placeDetails) . ' place details from Tripadvisor API');
        return $placeDetails;
    }
    
    
    private function getPlaceDetail(string $category, string $placeId): array
    {
        $results = $this->tripadvisorApiService->makeApiRequest('https://api.content.tripadvisor.com/api/v1/location/' . $placeId . '/details', [
            'key' => $_ENV['TRIPADVISOR_API_KEY'],
            'language' => 'en',
            'currency' => 'EUR',
        ]);
        
        $details = $results;
        $details['category'] = $category; // Add category to the details

        // Check if photo count exists and get photo URL
        if (isset($details['photo_count']) && (int)$details['photo_count'] >= 1) {
            $photoResults = $this->tripadvisorApiService->makeApiRequest('https://api.content.tripadvisor.com/api/v1/location/' . $placeId . '/photos', [
                'key' => $_ENV['TRIPADVISOR_API_KEY'],
                'language' => 'en',
                'limit' => 1,
                'source' => 'Management',
            ]);

            if (isset($photoResults['data'][0]['images']['original']['url'])) {
                $details['photo_url'] = $photoResults['data'][0]['images']['original']['url'];
            }
        }

        return $details;
    }
}
