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

    public function save(Roadtrip $roadtrip, bool $flush = false): void
    {
        $this->getEntityManager()->persist($roadtrip);

        if ($flush) {
            $this->flush();
        }
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    public function remove(Roadtrip $roadtrip): void
    {
        $this->getEntityManager()->remove($roadtrip);
    }
}
