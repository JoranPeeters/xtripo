<?php

namespace App\Repository;

use App\Entity\RoadtripAccommodation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RoadtripAccommodation>
 *
 * @method RoadtripAccommodation|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoadtripAccommodation|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoadtripAccommodation[]    findAll()
 * @method RoadtripAccommodation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoadtripAccommodationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RoadtripAccommodation::class);
    }

    //    /**
    //     * @return RoadtripAccommodation[] Returns an array of RoadtripAccommodation objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?RoadtripAccommodation
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
