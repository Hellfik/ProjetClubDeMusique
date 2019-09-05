<?php

namespace App\Repository;

use App\Entity\ConseilAdmin;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;


/**
 * @method ConseilAdmin|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConseilAdmin|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConseilAdmin[]    findAll()
 * @method ConseilAdmin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConseilAdminRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ConseilAdmin::class);
    }

    // /**
    //  * @return ConseilAdmin[] Returns an array of ConseilAdmin objects
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
    public function findOneBySomeField($value): ?ConseilAdmin
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
