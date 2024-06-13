<?php

namespace App\Repository;

use App\Entity\Place;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Roadtrip;

class PlaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Place::class);
    }

    public function savePlace(array $placeData, Roadtrip $roadtrip): void
    {
        $place = new Place();
        $place->setName($placeData['name'] ?? '')
              ->setDay($placeData['day'] ?? 0)
              ->setDescription($placeData['description'] ?? '')
              ->setWebsiteUrl($placeData['website_url'] ?? '')
              ->setTripadvisorUrl($placeData['tripadvisor_url'] ?? '')
              ->setPopularity(1)
              ->setPriceLevel($placeData['price_level'] ?? '')
              ->setRating($placeData['rating'] ?? 0.0)
              ->setRatingImageUrl($placeData['rating_image_url'] ?? '')
              ->setNumReviews($placeData['num_reviews'] ?? 0)
              ->setAddress($placeData['address'] ?? '')
              ->setLatitude($placeData['latitude'] ?? 0.0)
              ->setLongitude($placeData['longitude'] ?? 0.0)
              ->setAmenities($placeData['amenities'] ?? [])
              ->setCategory($placeData['category'] ?? [])
              ->setPlaceId($placeData['place_id'] ?? '')
              ->setPhotoUrl($placeData['photo_url'] ?? '')
              ->AddRoadtrip($roadtrip);

        $this->save($place);
    }

    public function save(Place $place, bool $flush = false): void
    {
        $this->getEntityManager()->persist($place);

        if ($flush) {
            $this->flush();
        }
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    public function remove(Place $place): void
    {
        $this->getEntityManager()->remove($place);
    }
    
}
