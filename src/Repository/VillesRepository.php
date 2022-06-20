<?php

namespace App\Repository;

use App\Service\SearchDataNom;
use App\Entity\Villes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Villes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Villes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Villes[]    findAll()
 * @method Villes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VillesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Villes::class);
    }

    public function add(Villes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Villes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Récupère les villes en lien avec une recherche
     * @return Villes[]
     */
    public function findSearch(SearchDataNom $search): array
    {

        $query = $this
            ->createQueryBuilder('s');
            
        if (!empty($search->nom)) {
            $query = $query
                ->andWhere('s.nomVille LIKE :nom')
                ->setParameter('nom', "%{$search->nom}%");
        }

        return $query->getQuery()->getResult();

    }
    
}