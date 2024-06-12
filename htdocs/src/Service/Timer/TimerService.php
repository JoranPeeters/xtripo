<?php

namespace App\Service\Timer;

use App\Service\Logger\LoggerService;

class TimerService
{
    public function __construct(
        private readonly LoggerService $logger,
    ) {
    }

    public function calculateTimeForGeneratedRoadtrip(float $startOpenAi): void
    {
        $endTimeOpenAi = microtime(true);
        $duration = $endTimeOpenAi - $startOpenAi;
        $this->logger->logMessage('OpenAI - Saving new roadtrip + OpenAI API call + flushing database duration: ' . $duration . ' seconds');
    }

    public function calculateTimeForTripadvisorApi(float $startTripadvisor): void
    {
        $endTimeTripadvisor = microtime(true);
        $duration = $endTimeTripadvisor - $startTripadvisor;
        $this->logger->logMessage('Tripadvisor - Fetching all data from tripadvisor + searching for existing places + flushing all data to database in: ' . $duration . ' seconds');
    }

    public function calculateOveralTimeForAllRequests(float $startOveral): void
    {
        $endTimeOveral = microtime(true);
        $duration = $endTimeOveral - $startOveral;
        $this->logger->logMessage('Overal - Total time for all requests: ' . $duration . ' seconds');
    }
}
