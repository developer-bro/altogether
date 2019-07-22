<?php

namespace App\Repository;

use App\Entity\CVupload;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CVupload|null find($id, $lockMode = null, $lockVersion = null)
 * @method CVupload|null findOneBy(array $criteria, array $orderBy = null)
 * @method CVupload[]    findAll()
 * @method CVupload[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CVuploadRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CVupload::class);
    }

    // /**
    //  * @return CVupload[] Returns an array of CVupload objects
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
    public function findOneBySomeField($value): ?CVupload
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
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
                	FROM App\Entity\CVupload f JOIN f.user u
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
                	FROM App\Entity\CVupload f
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
                	UPDATE App\Entity\CVupload f
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
