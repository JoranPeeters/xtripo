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

    public function save(RoadtripType $roadtripType, bool $flush = false): void
    {
        $this->getEntityManager()->persist($roadtripType);

        if ($flush) {
            $this->flush();
        }
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    public function remove(RoadtripType $roadtripType): void
    {
        $this->getEntityManager()->remove($roadtripType);
    }
}

