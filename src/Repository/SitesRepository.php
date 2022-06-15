<?php

namespace App\Repository;

use App\Entity\Sites;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sites|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sites|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sites[]    findAll()
 * @method Sites[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SitesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sites::class);
    }

    
}