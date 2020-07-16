<?php

namespace App\Repository;

use App\Entity\ComptabiliteLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ComptabiliteLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method ComptabiliteLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method ComptabiliteLine[]    findAll()
 * @method ComptabiliteLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComptabiliteLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComptabiliteLine::class);
    }

    // /**
    //  * @return ComptabiliteLine[] Returns an array of ComptabiliteLine objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ComptabiliteLine
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
