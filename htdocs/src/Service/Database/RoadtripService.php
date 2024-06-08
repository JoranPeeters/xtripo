<?php

namespace App\Service\Database;

use App\Entity\Roadtrip;
use App\Repository\RoadtripRepository;
use App\Repository\CountryRepository;
use App\Repository\RoadtripTypeRepository;

class RoadtripService
{
    public function __construct(
        private readonly RoadtripRepository $roadtripRepository,
        private readonly CountryRepository $countryRepository, 
        private readonly RoadtripTypeRepository $roadtripTypeRepository
    ) {
    }

    public function saveRoadtripAndUpdatePopularity(Roadtrip $roadtrip): void
    {
        $country = $roadtrip->getCountry();
        $country->setPopularity($country->getPopularity() + 1);
        $this->countryRepository->save($country);

        foreach ($roadtrip->getRoadtripTypes() as $type) {
            $type->setPopularity($type->getPopularity() + 1);
            $this->roadtripTypeRepository->save($type);
        }

        $this->roadtripRepository->save($roadtrip, true);
    }
}
