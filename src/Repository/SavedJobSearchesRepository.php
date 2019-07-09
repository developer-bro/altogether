<?php

namespace App\Repository;

use App\Entity\SavedJobSearches;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\User;
use Doctrine\ORM\Query;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SavedJobSearches|null find($id, $lockMode = null, $lockVersion = null)
 * @method SavedJobSearches|null findOneBy(array $criteria, array $orderBy = null)
 * @method SavedJobSearches[]    findAll()
 * @method SavedJobSearches[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SavedJobSearchesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SavedJobSearches::class);
    }

    // /**
    //  * @return SavedJobSearches[] Returns an array of SavedJobSearches objects
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
    public function findOneBySomeField($value): ?SavedJobSearches
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findLatest($user)
    {

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
                	SELECT s, u
                	FROM App\Entity\SavedJobSearches s JOIN s.user u
                	WHERE u.id = :user
                	ORDER BY s.id DESC
            		')
                ->setParameter('user', $user)
            ;
            
            return $query->execute();
    }

    public function deleteSearch($user, $id)
    {

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
                	DELETE 
                	FROM App\Entity\SavedJobSearches s
                	WHERE s.user = :user AND s.id = :id
            		')
                ->setParameter('user', $user)
                ->setParameter('id', $id)
            ;
            
            return $query->execute();
    }


}
