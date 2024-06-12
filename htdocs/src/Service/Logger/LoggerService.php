<?php

namespace App\Service\Logger;

use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;

#[WithMonologChannel('xtripo')]
class LoggerService
{
    public function __construct(
        private readonly LoggerInterface $logger,
    ) {
    }

    public function logMessage(string $message): void
    {
        $this->logger->info($message);
    }

    public function logError(string $message): void
    {
        $this->logger->error($message);
    }

    public function logWarning(string $message): void
    {
        $this->logger->warning($message);
    }
}
