<?php

namespace App\Tricks\Repository;

use App\Tricks\Entity\Tricks;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Tricks|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tricks|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tricks[]    findAll()
 * @method Tricks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TricksRepository extends ServiceEntityRepository
{
    private int $limit;

    public function __construct(ManagerRegistry $registry, int $limit)
    {
        parent::__construct($registry, Tricks::class);
        $this->limit = $limit;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Tricks $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Tricks $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findByPagination(int $pagination)
    {
        dump($pagination, $this->limit, $pagination * $this->limit);

        return $this->createQueryBuilder('t')
            ->setMaxResults($this->limit)            
            ->setFirstResult($pagination * $this->limit)
            ->getQuery()
            ->getResult()
        ;
    }
}
