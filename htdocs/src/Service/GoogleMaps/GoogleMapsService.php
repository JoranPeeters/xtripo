<?php
// src/Service/GoogleMaps/GoogleMapsService.php

namespace App\Service\GoogleMaps;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GoogleMapsService
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    // Google Make Route API, used for testing and experimenting
    public function makeRoute(array $waypoints)
    {
        // Convert our waypoints to Google Maps format
        $googlemapsWaypoints = $this->getGooglemapsWaypoints($waypoints);

        // For demonstration purposes, we will use only the first few waypoints
        if (count($googlemapsWaypoints) < 2) {
            throw new \Exception('Not enough waypoints to create a route.');
        }

        $origin = $googlemapsWaypoints[0]['location'];
        $destination = $googlemapsWaypoints[count($googlemapsWaypoints) - 1]['location'];
        $waypointsForRoute = array_slice($googlemapsWaypoints, 1, count($googlemapsWaypoints) - 2);

        // Send the route request to Google Maps
        return $this->sendRouteRequest($origin, $destination, $waypointsForRoute);
    }

    private function sendRouteRequest(array $origin, array $destination, array $waypoints)
    {
        $url = 'https://routes.googleapis.com/directions/v2:computeRoutes';
        
        // Set departure time to tomorrow
        $departureTime = (new \DateTime('tomorrow'))->format(\DateTime::ATOM);

        $requestBody = [
            'origin' => [
                'location' => [
                    'latLng' => [
                        'latitude' => $origin['latitude'],
                        'longitude' => $origin['longitude'],
                    ]
                ]
            ],
            'destination' => [
                'location' => [
                    'latLng' => [
                        'latitude' => $destination['latitude'],
                        'longitude' => $destination['longitude'],
                    ]
                ]
            ],
            'intermediates' => array_map(function ($waypoint) {
                return [
                    'location' => [
                        'latLng' => [
                            'latitude' => $waypoint['location']['latitude'],
                            'longitude' => $waypoint['location']['longitude'],
                        ]
                    ]
                ];
            }, $waypoints),
            'travelMode' => 'DRIVE',
            'routingPreference' => 'TRAFFIC_AWARE',
            'departureTime' => $departureTime,
            'computeAlternativeRoutes' => true,
            'routeModifiers' => [
                'avoidTolls' => false,
                'avoidHighways' => false,
                'avoidFerries' => false,
            ],
            'languageCode' => 'en-US',
            'units' => 'IMPERIAL'
        ];

        $response = $this->httpClient->request('POST', $url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'X-Goog-Api-Key' => $_ENV['GOOGLE_MAPS_API_KEY'],
                'X-Goog-FieldMask' => 'routes.duration,routes.distanceMeters,routes.polyline.encodedPolyline'
            ],
            'json' => $requestBody
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Error fetching route: ' . $response->getStatusCode() . ' - ' . $response->getContent(false));
        }

        return $response->toArray();
    }

    public function getGooglemapsWaypoints(array $waypoints): array
    {
        $waypointsForRoutes = [];
        foreach ($waypoints as $waypoint) {
            $waypointsForRoutes[] = [
                'location' => [
                    'latitude' => $waypoint->getLatitude(),
                    'longitude' => $waypoint->getLongitude()
                ],
                'stopover' => true
            ];
        }

        return $waypointsForRoutes;
    }
}
