<?php

namespace App\Repository;

use App\Entity\SitesToParse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SitesToParse|null find($id, $lockMode = null, $lockVersion = null)
 * @method SitesToParse|null findOneBy(array $criteria, array $orderBy = null)
 * @method SitesToParse[]    findAll()
 * @method SitesToParse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SitesToParseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SitesToParse::class);
    }

    // /**
    //  * @return SitesToParse[] Returns an array of SitesToParse objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SitesToParse
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
