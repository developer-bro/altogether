<?php

namespace App\Repository;

use App\Entity\Walkthrough;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Walkthrough|null find($id, $lockMode = null, $lockVersion = null)
 * @method Walkthrough|null findOneBy(array $criteria, array $orderBy = null)
 * @method Walkthrough[]    findAll()
 * @method Walkthrough[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WalkthroughRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Walkthrough::class);
    }

    // /**
    //  * @return Walkthrough[] Returns an array of Walkthrough objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Walkthrough
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function findInfo()
    {

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
                	SELECT w
                	FROM App\Entity\Walkthrough w
                	WHERE w.id = :id
                	ORDER BY w.id DESC
            		')
                ->setParameter('id', 1)
            ;
            
            return $query->execute();
    }

    public function findsettingsinfo()
    {

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
                	SELECT w
                	FROM App\Entity\Walkthrough w
                	WHERE w.id = :id
                	ORDER BY w.id DESC
            		')
                ->setParameter('id', 2)
            ;
            
            return $query->execute();
    }
}
