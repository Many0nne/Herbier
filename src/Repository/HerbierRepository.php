<?php

namespace App\Repository;

use App\Entity\Herbier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Herbier>
 *
 * @method Herbier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Herbier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Herbier[]    findAll()
 * @method Herbier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HerbierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Herbier::class);
    }

//    /**
//     * @return Herbier[] Returns an array of Herbier objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Herbier
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
