<?php

namespace App\Repository;

use App\Entity\Snowtrick;
use App\Entity\ChatMessage;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<ChatMessage>
 *
 * @method ChatMessage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChatMessage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChatMessage[]    findAll()
 * @method ChatMessage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChatMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChatMessage::class);
    }

    public function save(ChatMessage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ChatMessage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // return the number of messages linked to a snowtrick
    public function countChatMessages(Snowtrick $snowtrick) : mixed
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(c)')
            ->andWhere('c.snowtrick = :snowtrick')
            ->setParameter('snowtrick', $snowtrick)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
