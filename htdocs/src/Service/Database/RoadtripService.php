<?php

namespace App\Service\Database;

use App\Entity\Roadtrip;
use App\Repository\RoadtripRepository;
use App\Repository\CountryRepository;
use App\Repository\RoadtripTypeRepository;
use App\Entity\User;
use App\Service\Logger\LoggerService;

class RoadtripService
{
    public function __construct(
        private readonly RoadtripRepository $roadtripRepository,
        private readonly CountryRepository $countryRepository, 
        private readonly RoadtripTypeRepository $roadtripTypeRepository,
        private readonly LoggerService $logger,
    ) {
    }

    public function saveRoadtripAndUpdatePopularity(Roadtrip $roadtrip, User $user): void
    {
        $country = $roadtrip->getCountry();
        $country->setPopularity($country->getPopularity() + 1);
        $roadtrip->setUser($user);
        $roadtrip->setImageUrl('https://imageio.forbes.com/specials-images/imageserve/62bdd4a21a6dc599d18bca9b/summer-road-trips/960x0.jpg?height=474&width=711&fit=bounds');

        foreach ($roadtrip->getRoadtripTypes() as $type) {
            $type->setPopularity($type->getPopularity() + 1);
        }

        $this->countryRepository->save($country);
        $this->roadtripRepository->save($roadtrip);
    }

    public function handleNewRoadtrip(Roadtrip $roadtrip, User $user): void
    {
        $this->saveRoadtripAndUpdatePopularity($roadtrip, $user);
        $this->roadtripRepository->flush();
        $this->logger->logMessage('New roadtrip created: ' . $roadtrip->getId() . ' by user: ' . $user->getId());
    }
}
