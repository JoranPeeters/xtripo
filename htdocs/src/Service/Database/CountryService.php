<?php

namespace App\Service\Database;

use App\Entity\Country;
use App\Entity\City;
use App\Repository\CountryRepository;
use App\Repository\CityRepository;
class CountryService
{
    public function __construct(
        private readonly CountryRepository $countryRepository,
        private readonly CityRepository $cityRepository,
    )
    {}

    public function addEuropeanCountries(array $europeanCountries): void
    {
        foreach ($europeanCountries as $countryData) {
            $country = $this->countryRepository->findOneBy(['name' => $countryData['country']]);

            if (!$country) {
                $country = new Country();
                $country->setName($countryData['country'])
                        ->setPopularity(0);
            }

            $country->setPopularity($country->getPopularity() + 1);
            $this->countryRepository->save($country);


            foreach ($countryData['cities'] as $cityName) {
                $city = $this->cityRepository->findOneBy(['name' => $cityName, 'country' => $country]);

                if (!$city) {
                    $city = new City();
                    $city->setName($cityName)
                         ->setPopularity(0)
                         ->setCountry($country);
                }

                $city->setPopularity($city->getPopularity() + 1);
                $this->cityRepository->save($city);
            }
        }

        $this->countryRepository->flush();
        $this->cityRepository->flush();
    }
}
