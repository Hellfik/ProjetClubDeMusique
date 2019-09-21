<?php

namespace App\Repository;

use App\Entity\UploadFiles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UploadFiles|null find($id, $lockMode = null, $lockVersion = null)
 * @method UploadFiles|null findOneBy(array $criteria, array $orderBy = null)
 * @method UploadFiles[]    findAll()
 * @method UploadFiles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UploadFilesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UploadFiles::class);
    }

    // /**
    //  * @return UploadFiles[] Returns an array of UploadFiles objects
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
    public function findOneBySomeField($value): ?UploadFiles
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
