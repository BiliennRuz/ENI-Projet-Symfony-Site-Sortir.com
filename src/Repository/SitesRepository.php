<?php

namespace App\Repository;

use App\Service\SearchDataNom;
use App\Entity\Sites;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query;
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

    public function add(Sites $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Sites $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Récupère les sites en lien avec une recherche
     * @return Sites[]
     */
    public function findSearch(SearchDataNom $search): array
    {

        $query = $this
            ->createQueryBuilder('s');
            //->select('c', 'p')
            //->join('p.categories', 'c');

            
        if (!empty($search->nom)) {
            $query = $query
                ->andWhere('s.nomSite LIKE :nom')
                ->setParameter('nom', "%{$search->nom}%");
        }

        return $query->getQuery()->getResult();

    }
    
}