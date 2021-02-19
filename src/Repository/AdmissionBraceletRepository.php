<?php

namespace App\Repository;

use App\Entity\AdmissionBracelet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AdmissionBracelet|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdmissionBracelet|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdmissionBracelet[]    findAll()
 * @method AdmissionBracelet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdmissionBraceletRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdmissionBracelet::class);
    }

    // /**
    //  * @return AdmissionBracelet[] Returns an array of AdmissionBracelet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AdmissionBracelet
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
