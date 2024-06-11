<?php

namespace App\Service\Database;

use App\Entity\Roadtrip;
use App\Repository\RoadtripRepository;
use App\Repository\CountryRepository;
use App\Repository\RoadtripTypeRepository;
use App\Entity\User;

class RoadtripService
{
    public function __construct(
        private readonly RoadtripRepository $roadtripRepository,
        private readonly CountryRepository $countryRepository, 
        private readonly RoadtripTypeRepository $roadtripTypeRepository
    ) {
    }

    public function saveRoadtripAndUpdatePopularity(Roadtrip $roadtrip, User $user): void
    {
        $country = $roadtrip->getCountry();
        dd($country);
        $country->setPopularity($country->getPopularity() + 1);
        $this->countryRepository->save($country);
        $roadtrip->setUser($user);

        foreach ($roadtrip->getRoadtripTypes() as $type) {
            $type->setPopularity($type->getPopularity() + 1);
            $this->roadtripRepository->save($roadtrip);
        }

        $this->roadtripRepository->flush($roadtrip);
    }
}
