<?php

namespace App\Repository;

use App\Entity\Instruments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Instruments|null find($id, $lockMode = null, $lockVersion = null)
 * @method Instruments|null findOneBy(array $criteria, array $orderBy = null)
 * @method Instruments[]    findAll()
 * @method Instruments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InstrumentsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Instruments::class);
    }

    // /**
    //  * @return Instruments[] Returns an array of Instruments objects
    //  */

    public function findByFamilly($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.familleInstruments = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    
     /**
     * Return le nombre d'instruments dans la bdd
     */
    public function numberOfInstruments(){
        return $this->createQueryBuilder('i')
            ->select('count(i.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /*
    public function findOneBySomeField($value): ?Instruments
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
