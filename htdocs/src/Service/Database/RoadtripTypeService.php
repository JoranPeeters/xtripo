<?php

namespace App\Service\Database;

use App\Entity\RoadtripType;
use App\Repository\RoadtripTypeRepository;

class RoadtripTypeService
{
    public function __construct(
        private readonly RoadtripTypeRepository $roadtriptypeRepository,
    ) {
    }

    public function addTypeOfRoadtrips(array $roadtripTypes): void
    {
        foreach ($roadtripTypes as $typeData) {
            if (!$this->roadtriptypeRepository->findOneBy(['name' => $typeData])) {
                $type = new RoadtripType();
                $type
                    ->setName($typeData)
                    ->setPopularity(0);

                $this->roadtriptypeRepository->save($type,true);
            }
        }
    }
}
