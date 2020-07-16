<?php

namespace App\Repository;

use App\Entity\ListeLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ListeLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListeLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListeLine[]    findAll()
 * @method ListeLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListeLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListeLine::class);
    }

    // /**
    //  * @return ListeLine[] Returns an array of ListeLine objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ListeLine
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
