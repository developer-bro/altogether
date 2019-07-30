<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\User;
use Doctrine\ORM\Query;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Task::class);
    }

    // /**
    //  * @return Task[] Returns an array of Task objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Task
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findLatest($user, $job)
    {

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
                	SELECT t, j, u
                	FROM App\Entity\Task t JOIN t.job j JOIN j.user u
                	WHERE u.id = :user AND j.id = :job
                	ORDER BY t.id DESC
            		')
                ->setParameter('user', $user)
                ->setParameter('job', $job)
            ;
            
            return $query->execute();
    }
    public function findLatest1($user)
    {

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
                	SELECT t, u
                	FROM App\Entity\Task t JOIN t.user u
                	WHERE u.id = :user
                	ORDER BY t.id DESC
            		')
                ->setParameter('user', $user)
            ;
            
            return $query->execute();
    }

    public function deleteTask($user, $id)
    {

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
                	DELETE 
                	FROM App\Entity\Task t
                	WHERE t.user = :user AND t.id = :id
            		')
                ->setParameter('user', $user)
                ->setParameter('id', $id)
            ;
            
            return $query->execute();
    }

    
}
