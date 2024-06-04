<?php

namespace App\Repository;

use App\Entity\RentalVehicle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RentalVehicle>
 *
 * @method RentalVehicle|null find($id, $lockMode = null, $lockVersion = null)
 * @method RentalVehicle|null findOneBy(array $criteria, array $orderBy = null)
 * @method RentalVehicle[]    findAll()
 * @method RentalVehicle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RentalVehicleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RentalVehicle::class);
    }

    //    /**
    //     * @return RentalVehicle[] Returns an array of RentalVehicle objects
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

    //    public function findOneBySomeField($value): ?RentalVehicle
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
