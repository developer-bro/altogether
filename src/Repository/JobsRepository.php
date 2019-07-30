<?php

namespace App\Repository;

use App\Entity\Jobs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\User;
use Doctrine\ORM\Query;
use Doctrine\Common\Persistence\ManagerRegistry;



/**
 * @method Jobs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Jobs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Jobs[]    findAll()
 * @method Jobs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Jobs::class);
    }

    
    //  * @return Jobs[] Returns an array of Jobs objects
    //  */
    /*
    public function findByExampleField($user)
    {
        return $this->createQueryBuilder('j')
            ->where('j.User = :user')
            ->andWhere('j.dateSaved = :val')
            ->setParameter('user', $user)
            ->setParameter('val', new \DateTime())
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Jobs
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findfortasks($user)
    {

        return $this->createQueryBuilder('j')
        ->select('j.comapnyName')
        ->where('j.User = :user')
        ->orderBy('j.id', 'DESC')
        ->setParameter('user', $user)
        ->getQuery()
            ->getResult()
            ;
            
            
    }

    public function findLatest($user)
    {

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
                	SELECT j, u
                	FROM App\Entity\Jobs j JOIN j.User u
                	WHERE u.id = :user
                	ORDER BY j.id DESC
            		')
                ->setParameter('user', $user)
            ;
            
            return $query->execute();
    }

    public function findSaved($user)
    {

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
                	SELECT j, u
                	FROM App\Entity\Jobs j JOIN j.User u
                	WHERE u.id = :user AND j.isSaved = 1
                	ORDER BY j.dateSaved DESC
            		')
                ->setParameter('user', $user)
            ;
            
            return $query->execute();
    }

    public function findApplied($user)
    {

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
                	SELECT j, u
                	FROM App\Entity\Jobs j JOIN j.User u
                	WHERE u.id = :user AND j.isApplied = 1
                	ORDER BY j.dateApplied DESC
            		')
                ->setParameter('user', $user)
            ;
            
            return $query->execute();
    }

    public function findFollowup($user)
    {

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
                	SELECT j, u
                	FROM App\Entity\Jobs j JOIN j.User u
                	WHERE u.id = :user AND j.isFollowUp = 1
                	ORDER BY j.dateInitialFollowUp DESC
            		')
                ->setParameter('user', $user)
            ;
            
            return $query->execute();
    }

    public function findInterview($user)
    {

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
                	SELECT j, u
                	FROM App\Entity\Jobs j JOIN j.User u
                	WHERE u.id = :user AND j.isInterview = 1
                	ORDER BY j.dateInterview DESC
            		')
                ->setParameter('user', $user)
            ;
            
            return $query->execute();
    }

    public function findPostInterview($user)
    {

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
                	SELECT j, u
                	FROM App\Entity\Jobs j JOIN j.User u
                	WHERE u.id = :user AND j.isPostInterviewFollowUp = 1
                	ORDER BY j.dateFollowUp DESC
            		')
                ->setParameter('user', $user)
            ;
            
            return $query->execute();
    }
}
