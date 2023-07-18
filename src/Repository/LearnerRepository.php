<?php

namespace App\Repository;

use App\Entity\Learner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Learner>
 *
 * @method Learner|null find($id, $lockMode = null, $lockVersion = null)
 * @method Learner|null findOneBy(array $criteria, array $orderBy = null)
 * @method Learner[]    findAll()
 * @method Learner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LearnerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Learner::class);
    }

//    /**
//     * @return Learner[] Returns an array of Learner objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Learner
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
