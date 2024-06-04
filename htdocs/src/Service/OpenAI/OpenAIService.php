<?php
// src/Service/OpenAIService.php

namespace App\Service\OpenAI;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenAIService
{
    private $client;

    public function __construct(HttpClientInterface $client)
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

    public function generateRoadtrip(): array
    {
        $model = 'gpt-4o';
        $temperature = 1;
        $systemPrompt = 'You are a data deliverer. Present your response once, in a valid JSON object following a specific template.
                        Create a JSON array of objects. Each object should have a "country" key with the country name as the value, and a "cities" key with an array of major cities in that country.
                        Output only the JSON array, without any additional text before or after. Your data is always accurate and correct.
                        Example: [{"country": "Albania", "cities": ["Tirana", "Durrës", "Vlorë", "Shkodër", "Fier"]}, {"country": "Andorra", "cities": ["Andorra la Vella", "Escaldes-Engordany", "Encamp", "Sant Julià de Lòria", "La Massana"]}]';

        $prompt = 'Create a JSON array of all European countries that are currently safe to travel to, 
        meaning there are no wars or conflicts in the country. For each country, include an array of its major cities. 
        Output only the JSON array, without any additional text before or after.';

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