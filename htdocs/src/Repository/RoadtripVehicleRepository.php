<?php

namespace App\Repository;

use App\Entity\RoadtripVehicle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RoadtripVehicle>
 *
 * @method RoadtripVehicle|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoadtripVehicle|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoadtripVehicle[]    findAll()
 * @method RoadtripVehicle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoadtripVehicleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RoadtripVehicle::class);
    }

    //    /**
    //     * @return RoadtripVehicle[] Returns an array of RoadtripVehicle objects
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

    //    public function findOneBySomeField($value): ?RoadtripVehicle
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
