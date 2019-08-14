<?php

namespace App\Repository;

use App\Entity\FamilleInstruments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FamilleInstruments|null find($id, $lockMode = null, $lockVersion = null)
 * @method FamilleInstruments|null findOneBy(array $criteria, array $orderBy = null)
 * @method FamilleInstruments[]    findAll()
 * @method FamilleInstruments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FamilleInstrumentsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FamilleInstruments::class);
    }

    // /**
    //  * @return FamilleInstruments[] Returns an array of FamilleInstruments objects
    //  */

    /**
     * Return le nombre de famille dans la bdd
     */
    public function numberOfFamilly(){
        return $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FamilleInstruments
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
