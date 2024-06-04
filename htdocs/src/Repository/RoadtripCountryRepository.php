<?php

namespace App\Repository;

use App\Entity\RoadtripCountry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RoadtripCountry>
 *
 * @method RoadtripCountry|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoadtripCountry|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoadtripCountry[]    findAll()
 * @method RoadtripCountry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoadtripCountryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RoadtripCountry::class);
    }

    //    /**
    //     * @return RoadtripCountry[] Returns an array of RoadtripCountry objects
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

    //    public function findOneBySomeField($value): ?RoadtripCountry
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
