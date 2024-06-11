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

    public function findNearbyPlaces(float $latitude, float $longitude, string $category, float $radiusKm): array
    {
        $latRange = $radiusKm / 110.574; // Latitude degrees per km
        $longRange = $radiusKm / (111.320 * cos(deg2rad($latitude))); // Longitude degrees per km

        return $this->createQueryBuilder('p')
            ->where('p.latitude BETWEEN :lat_min AND :lat_max')
            ->andWhere('p.longitude BETWEEN :long_min AND :long_max')
            ->andWhere('p.category = :category')
            ->setParameter('lat_min', $latitude - $latRange)
            ->setParameter('lat_max', $latitude + $latRange)
            ->setParameter('long_min', $longitude - $longRange)
            ->setParameter('long_max', $longitude + $longRange)
            ->setParameter('category', $category)
            ->getQuery()
            ->getResult();
    }

    public function savePlace(array $placeData, string $category, Roadtrip $roadtrip): void
    {
        $place = new Place();
        $place->setName($placeData['name'] ?? '')
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
              ->setCategory($category)
              ->setPlaceId($placeData['place_id'] ?? '')
              ->setPhotoUrl($placeData['photo_url'] ?? '')
              ->AddRoadtrip($roadtrip);

        $this->getEntityManager()->persist($place);
        $this->getEntityManager()->flush();
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
