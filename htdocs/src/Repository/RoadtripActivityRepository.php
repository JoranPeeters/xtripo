<?php

namespace App\Repository;

use App\Entity\RoadtripActivity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RoadtripActivity>
 *
 * @method RoadtripActivity|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoadtripActivity|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoadtripActivity[]    findAll()
 * @method RoadtripActivity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoadtripActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RoadtripActivity::class);
    }

    //    /**
    //     * @return RoadtripActivity[] Returns an array of RoadtripActivity objects
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

    //    public function findOneBySomeField($value): ?RoadtripActivity
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
