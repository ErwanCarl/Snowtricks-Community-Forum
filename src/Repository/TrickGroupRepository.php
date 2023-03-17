<?php

namespace App\Repository;

use App\Entity\TrickGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TrickGroup>
 *
 * @method TrickGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrickGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrickGroup[]    findAll()
 * @method TrickGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrickGroup::class);
    }

    public function save(TrickGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TrickGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
