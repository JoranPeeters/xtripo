<?php

namespace App\Service\Database;

use App\Entity\Type;
use App\Repository\TypeRepository;

class TypeService
{
    
    public function __construct(
        private readonly TypeRepository $typeRepository,
    ) {
    }

    public function addTypeOfRoadtrips(array $types): void
    {
        foreach ($types as $typeData) {
            if (!$this->typeRepository->findOneBy(['name' => $typeData])) {
                $type = new Type();
                $type
                    ->setName($typeData)
                    ->setPopularity(0);

                $this->typeRepository->save($type,true);
            }
        }
    }
}
