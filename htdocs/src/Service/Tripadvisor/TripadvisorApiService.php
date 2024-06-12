<?php

namespace App\Service\Tripadvisor;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Service\Logger\LoggerService;

class TripadvisorApiService
{
    public function __construct(
        private HttpClientInterface $client,
        private LoggerService $logger,
    ) {}

    public function makeApiRequest(string $endpoint, array $queryParams): ?array
    {
        $response = $this->client->request('GET', $endpoint, [
            'query' => $queryParams,
            'headers' => [
                'accept' => 'application/json',
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            $this->logger->logError('API request failed', [
                'endpoint' => $endpoint,
                'queryParams' => $queryParams,
                'statusCode' => $response->getStatusCode(),
                'response' => $response->getContent(false),
            ]);

            return [];
        }

        return $response->toArray();
    }
}
