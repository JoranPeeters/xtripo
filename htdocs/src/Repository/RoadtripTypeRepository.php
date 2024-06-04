<?php

namespace App\Repository;

use App\Entity\RoadtripType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RoadtripType>
 *
 * @method RoadtripType|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoadtripType|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoadtripType[]    findAll()
 * @method RoadtripType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoadtripTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RoadtripType::class);
    }

    //    /**
    //     * @return RoadtripType[] Returns an array of RoadtripType objects
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

    //    public function findOneBySomeField($value): ?RoadtripType
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
