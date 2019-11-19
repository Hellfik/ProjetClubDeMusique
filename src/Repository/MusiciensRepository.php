<?php

namespace App\Repository;

use App\Entity\Musiciens;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Musiciens|null find($id, $lockMode = null, $lockVersion = null)
 * @method Musiciens|null findOneBy(array $criteria, array $orderBy = null)
 * @method Musiciens[]    findAll()
 * @method Musiciens[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MusiciensRepository extends ServiceEntityRepository
{
     public function __construct(RegistryInterface $registry)
     {
         parent::__construct($registry, Musiciens::class);
     }

     /**
      * Retourne la les resultats de la recherche
      */

      public function findFilter($search){
         return $this->createQueryBuilder('p')
                     ->where('p.nom like :search')
                     ->orWhere('p.prenom like :search')
                     ->setParameter('search', '%' . $search . '%')
                     ->getQuery()
                     ->getResult()
                     ;
     }



    // /**
    //  * @return Musiciens[] Returns an array of Musiciens objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Musiciens
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
