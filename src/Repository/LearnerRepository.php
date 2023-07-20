<?php

namespace App\Repository;

use App\DTO\LearnerSearchCriteria;
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
    public function findByGender($gender): array
    {
        $query = $this->createQueryBuilder("l")
            ->andWhere('l.gender = :val')
            ->setParameter('val', $gender)
            ->getQuery()
            ->getResult();
        return $query;
    }
    public function findByProm($prom): array
    {
        $query = $this->createQueryBuilder("l")
            ->andWhere('l.prom = :val')
            ->setParameter('val', $prom)
            ->getQuery()
            ->getResult();
        return $query;
    }
    public function findLearnerByUsersPromOrberBySearchCriteria($prom, LearnerSearchCriteria $learnerSearchCriteria): ?array
    {
        $qb = $this->createQueryBuilder('learner')
            ->andWhere('learner.prom = :prom')
            ->setParameter(':prom', $prom)
            ->leftJoin('learner.skills', 'skill')
            ->leftJoin('skill.skillGroup', 'skillGroup')
            ->leftJoin('learner.prom', 'prom');



        if ($learnerSearchCriteria->skill) {
            $qb
                // ->orderBy('skill.id', 'ASC');
                ->orderBy('skillGroup.id', 'ASC');
        }
        if ($learnerSearchCriteria->genre) {
            $qb
                ->orderBy('learner.gender', 'ASC');
        }
        if ($learnerSearchCriteria->age) {
            $qb
                ->orderBy('learner.age', 'ASC');
        }
        return $qb->addSelect('skill')
            ->addSelect('prom')
            ->addSelect('skillGroup')
            ->getQuery()
            ->getArrayResult(); //->getResult();
    }
}
