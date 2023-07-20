<?php

namespace App\Repository;

use App\Entity\Skill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Skill>
 *
 * @method Skill|null find($id, $lockMode = null, $lockVersion = null)
 * @method Skill|null findOneBy(array $criteria, array $orderBy = null)
 * @method Skill[]    findAll()
 * @method Skill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Skill::class);
    }

    //    /**
    //     * @return Skill[] Returns an array of Skill objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Skill
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function findSkillByUsersProm($prom): ?array
    {
        /*   return $this->createQueryBuilder('skill')
            ->leftJoin('skill.learners', 'learner')
            ->andWhere('learner.prom = :prom')
            ->setParameter(':prom', $prom)
            ->getQuery()
            ->getResult();
    } */

        return $this->createQueryBuilder('skill')
            ->leftJoin('skill.learners', 'learner')
            ->andWhere('learner.prom = :prom')
            ->setParameter(':prom', $prom)
            ->leftJoin('skill.skillGroup', 'skillGroup')
            ->leftJoin('learner.prom', 'prom')
            ->orderBy('skill.id', 'DESC')
            ->addSelect('learner')
            ->addSelect('skill')
            ->addSelect('prom')
            //       ->Select('count(skillGroup.id)')
            ->getQuery()
            ->getArrayResult(); //->getResult();
    }
}
