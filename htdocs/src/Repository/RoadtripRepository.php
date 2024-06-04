<?php

namespace App\Repository;

use App\Entity\Roadtrip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Roadtrip>
 *
 * @method Roadtrip|null find($id, $lockMode = null, $lockVersion = null)
 * @method Roadtrip|null findOneBy(array $criteria, array $orderBy = null)
 * @method Roadtrip[]    findAll()
 * @method Roadtrip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoadtripRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Roadtrip::class);
    }

    //    /**
    //     * @return Roadtrip[] Returns an array of Roadtrip objects
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

    //    public function findOneBySomeField($value): ?Roadtrip
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
