<?php

namespace App\Repository;

use App\Entity\Configuration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Configuration>
 *
 * @method Configuration|null find($id, $lockMode = null, $lockVersion = null)
 * @method Configuration|null findOneBy(array $criteria, array $orderBy = null)
 * @method Configuration[]    findAll()
 * @method Configuration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConfigurationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Configuration::class);
    }

    public function add(Configuration $configuration, bool $flush = false): void
    {
        $this->getEntityManager()->persist($configuration);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Configuration $configuration, bool $flush = false): void
    {
        $this->getEntityManager()->remove($configuration);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
