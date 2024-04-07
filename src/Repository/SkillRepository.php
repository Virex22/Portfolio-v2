<?php

namespace App\Repository;

use App\Entity\Skill;
use App\Enum\ESkillType;
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

    public function findAllByType(string $type): array
    {
        if (!in_array($type, ESkillType::toArray())) {
            throw new \InvalidArgumentException('Invalid skill type');
        }

        return $this->createQueryBuilder('s')
            ->andWhere('s.type = :type')
            ->setParameter('type', $type)
            ->getQuery()
            ->getResult();
    }
}
