<?php

namespace App\Repository;

use App\Entity\Upload;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Upload|null find($id, $lockMode = null, $lockVersion = null)
 * @method Upload|null findOneBy(array $criteria, array $orderBy = null)
 * @method Upload[]    findAll()
 * @method Upload[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UploadRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Upload::class);
    }

    // /**
    //  * @return Upload[] Returns an array of Upload objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Upload
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findFiles($user)
    {

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
                	SELECT f, u
                	FROM App\Entity\Upload f JOIN f.user u
                	WHERE u.id = :user
                	ORDER BY f.id DESC
            		')
                ->setParameter('user', $user)
            ;
            
            return $query->execute();
    }

    public function deleteFile($user, $id)
    {

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
                	DELETE 
                	FROM App\Entity\Upload f
                	WHERE f.user = :user AND f.id = :id
            		')
                ->setParameter('user', $user)
                ->setParameter('id', $id)
            ;
            
            return $query->execute();
    }

    public function updateFile($user, $id, $first)
    {

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
                	UPDATE App\Entity\Upload f
                    SET f.name = :first
                	WHERE f.user = :user AND f.id = :id
            		')
                ->setParameter('user', $user)
                ->setParameter('id', $id)
                ->setParameter('first', $first)
                ;
            
            return $query->execute();
    }

}
