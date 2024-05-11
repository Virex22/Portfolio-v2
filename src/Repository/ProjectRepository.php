<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Project>
 *
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function findOneWithContentAndSkills(int $id)
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.projectContents', 'c')
            ->addSelect('c')
            ->leftJoin('p.skills', 's')
            ->addSelect('s')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAllWithSkills()
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.skills', 's')
            ->addSelect('s')
            ->orderBy('p.startDate', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
