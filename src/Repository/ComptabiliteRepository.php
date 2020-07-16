<?php

namespace App\Repository;

use App\Entity\Comptabilite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Comptabilite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comptabilite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comptabilite[]    findAll()
 * @method Comptabilite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComptabiliteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comptabilite::class);
    }

    // /**
    //  * @return Comptabilite[] Returns an array of Comptabilite objects
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
    public function findOneBySomeField($value): ?Comptabilite
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
