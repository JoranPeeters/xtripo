<?php
// src/Service/OpenAIService.php

namespace App\Service\OpenAI;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\Roadtrip;
use App\Repository\RoadtripTypeRepository;

class OpenAIService
{
    private $client;

    public function __construct(
        HttpClientInterface $client,
        private readonly RoadtripTypeRepository $roadtripTypeRepository
    )
    {
        $this->client = $client;
    }

    public function getEuropeanCountries(): array
    {
        $model = 'gpt-4o';
        $temperature = 0.3;
        $systemPrompt = 'You are a data deliverer. Present your response once, in a valid JSON object following a specific template.
                        Create a JSON array of objects. Each object should have a "country" key with the country name as the value, and a "cities" key with an array of major cities in that country.
                        Output only the JSON array, without any additional text before or after. Your data is always accurate and correct.
                        Example: [{"country": "Albania", "cities": ["Tirana", "Durrës", "Vlorë", "Shkodër", "Fier"]}, {"country": "Andorra", "cities": ["Andorra la Vella", "Escaldes-Engordany", "Encamp", "Sant Julià de Lòria", "La Massana"]}]';

        $prompt = 'Create a JSON array of all European countries that are currently safe to travel to, 
        meaning there are no wars or conflicts in the country. For each country, include an array of its major cities. 
        Output only the JSON array, without any additional text before or after.';

        return $this->openAiApiCall($prompt, $model, $systemPrompt, $temperature);
    }

    public function generateRoadtrip(Roadtrip $roadtrip): array
    {
        $roadtripTypes = implode(', ', $roadtrip->getRoadtripTypes()->map(function ($type) {
            return $type->getName();
        })->toArray());

        $model = 'gpt-4o';
        $temperature = 1;
        $systemPrompt = 'You are a travel planning assistant specialized in generating detailed road trips. 
        The user has provided information about a new road trip, including their preferences for specific road trip types. 
        You need to generate a complete road trip plan based on these preferences, including all waypoints. 
        Each waypoint should contain the following details:

            - Day: The day of the trip this waypoint corresponds to. Every day should have a list of waypoints.
            - Location Name: The name of the location.
            - Description: A brief description of the location.
            - Advice: Specific advice or tips for this location.
            - Longitude: The longitude coordinate of the location.
            - Latitude: The latitude coordinate of the location.
            - Distance: The distance from previous waypoint in kilometers.
            - Type: Only Select from these types! Users predefined road trip types: ' . $roadtripTypes . '.
            - City: The city where the waypoint is located.
            - Best Hours: The best hours to visit this location.
            
            The road trip should be unique and unforgettable, incorporating both popular attractions and hidden gems that people don\'t expect. taking into account the user road trip types.
            These hidden gems should be lesser-known but highly recommended spots that will make the trip truly special. You can also choose how many waypoints there will be in one day based on the user information.
            Ensure the road trip follows the most efficient route, avoiding any backtracking or repeated paths for the traveler.
            
            Please provide the road trip plan as a JSON array of waypoints.
            You can determine how many waypoints per day, but keep it reasonable for a day\'s travel.  
            You are restricted to only give the JSON array as a response. No additional text should be included.
            Here is an example format of a waypoint:
            
                {
                    "day": 1,
                    "waypoints": [
                      {
                        "location_name": "Eiffel Tower", 
                        "description": "An iconic symbol of Paris and one of the most recognizable structures in the world.",
                        "advice": "Best time to visit is early morning to avoid the crowds.",
                        "longitude": "2.2945" (Float),  
                        "latitude": "48.8584" (Float), 
                        "distance": 10 (int), 
                        "type": "City Exploration",
                        "city": "Paris"
                        "best_hours": "07:00 - 09:00"
                      },
                      {
                        "location_name": "Brandenburg Gate",
                        "description": "A famous landmark and symbol of Berlin, located in the heart of the city.",
                        "advice": "Visit at sunset for the best photo opportunities.",
                        "longitude": "13.3777" (Float),
                        "latitude": "52.5163" (Float),
                        "distance": 1052.9 (int),
                        "type": "City Exploration",
                        "city": "Berlin"
                        "best_hours": "18:00 - 20:00"
                      }
                    ]
                  },
                  {
                    "day": 2,
                    "waypoints": [
                      {
                        "location_name": "Atomium",
                        "description": "A unique building in Brussels that symbolizes an iron crystal magnified 165 billion times.",
                        "advice": "Visit at night when it\'s illuminated for a magical experience.",
                        "longitude": "4.3416" (Float),
                        "latitude": "50.8949" (Float),
                        "distance": 759.7 (int),
                        "type": "landmark",
                        "city": "Brussels"
                        "best_hours": "20:00 - 22:00"
                      },
                      {
                        "location_name": "Manneken Pis",
                        "description": "A small bronze sculpture in Brussels depicting a naked little boy urinating into a fountain.",
                        "advice": "Don\'t miss the chance to see this quirky statue up close.",
                        "longitude": "4.3488" (Float),
                        "latitude": "50.8466" (Float),
                        "distance": 8.8 (int),
                        "type": "City Exploration",
                        "city": "Brussels"
                        "best_hours": "10:00 - 12:00"
                      }
                    ]
                  }';

            $userPrompt = [
                'country' => $roadtrip->getCountry()->getName(),
                'travelers' => $roadtrip->getTravelers(),
                'start_date' => $roadtrip->getStartDate()->format('Y-m-d'),
                'end_date' => $roadtrip->getEndDate()->format('Y-m-d'),
                'rent_car' => $roadtrip->getRentCar() ? 'yes' : 'no',
                'vehicle' => $roadtrip->getVehicle() ? $roadtrip->getVehicle()->getVehicleType() : null,
                'cost_preferences' => $roadtrip->getCostPreferences(),
                'distance' => $roadtrip->getDistance(),
                'roadtrip_types' => $roadtripTypes,
            ];
        
            $prompt = "The user has specified preferences for the following road trip types: " . $roadtripTypes . ". 
            Please ensure that the generated waypoints align with these interests to create an interest-based road trip.\n\nUser-provided road trip data: " . json_encode($userPrompt, JSON_PRETTY_PRINT);
        
            return $this->openAiApiCall($prompt, $model, $systemPrompt, $temperature);   
    }

    public function openAiApiCall(string $prompt, string $model, string $systemPrompt, float $temperature): array
    {
        $response = $this->client->request('POST', 'https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $_ENV['OPENAI_API_KEY'],
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemPrompt
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ],
                ],
                'temperature' => $temperature,
            ],
        ]);

        $responseData = $response->toArray();
        $jsonArrayString = $responseData['choices'][0]['message']['content'] ?? '';

        //dd($jsonArrayString);

        // Ensure valid JSON format
        $jsonArrayString = $this->ensureJsonFormat($jsonArrayString);

        // Parse the JSON array string to a PHP array
        $data = json_decode($jsonArrayString, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Invalid JSON response from OpenAI: ' . json_last_error_msg());
        }

        return $data;
    }

    private function ensureJsonFormat(string $content): string
    {
        // Strip out the code block delimiters if they exist
        $jsonContent = preg_replace('/^```json\n|```$/m', '', $content);

        // Trim the content to remove any leading/trailing spaces or newlines
        $jsonContent = trim($jsonContent);

        // Check if the content is already valid JSON
        json_decode($jsonContent);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $jsonContent;
        }

        // Attempt to fix common JSON issues
        // For instance, removing trailing commas, fixing quotes, etc.
        $jsonContent = preg_replace('/,\s*([\]}])/m', '$1', $jsonContent); // Remove trailing commas

        // Check again if the content is valid JSON after attempting to fix common issues
        json_decode($jsonContent);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $jsonContent;
        }

        // If still not valid, log an error and return an empty JSON object as a fallback
        error_log('Failed to ensure valid JSON format for content: ' . $content);
        return '{}';
    }
}
