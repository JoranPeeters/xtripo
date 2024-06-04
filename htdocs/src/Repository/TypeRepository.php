<?php

namespace App\Repository;

use App\Entity\Type;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Type>
 *
 * @method Type|null find($id, $lockMode = null, $lockVersion = null)
 * @method Type|null findOneBy(array $criteria, array $orderBy = null)
 * @method Type[]    findAll()
 * @method Type[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Type::class);
    }

    public function save(Type $type, bool $flush = false): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($type);

        if ($flush) {
            $entityManager->flush();
        }
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    public function remove(Type $type, bool $flush = false): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($type);

        if ($flush) {
            $entityManager->flush();
        }
    }

}
