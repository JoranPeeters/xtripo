<?php

namespace App\Service\Database;

use App\Entity\Country;
use App\Repository\CountryRepository;

class CountryService
{
    public function __construct(
        private readonly CountryRepository $countryRepository,
    ) {
    }

    public function addEuropeanCountries(array $europeanCountries): void
    {
        foreach ($europeanCountries as $countryData) {
            if (!$this->countryRepository->findOneBy(['name' => $countryData['country']])) {
                $country = new Country();
                $country
                    ->setName($countryData['country'])
                    ->setCities($countryData['cities'])
                    ->setPopularity(0);

                $this->countryRepository->save($country,true);
            }
        }
    }
}












