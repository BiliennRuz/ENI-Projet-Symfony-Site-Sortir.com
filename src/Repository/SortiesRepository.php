<?php

namespace App\Repository;

use App\Entity\Sorties;
use App\Service\SearchDataSorties;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sorties>
 *
 * @method Sorties|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sorties|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sorties[]    findAll()
 * @method Sorties[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sorties::class);
    }

    public function add(Sorties $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Sorties $entity, bool $flush = false): void
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
    public function findSearch(SearchDataSorties $search): array
    {

        dump($search);

        $query = $this
            ->createQueryBuilder('so');
        //    ->select('so', 'si')
        //    ->join('si.nomSite', 'so');

            
        if (!empty($search->sites)) {
            $query = $query
                // TODO : mettre à jour la requete
                ->andWhere('so.nom LIKE :sites')
                ->setParameter('nom', "%{$search->nom}%");
        }

        if (!empty($search->nom)) {
            $query = $query
                ->andWhere('so.nom LIKE :nom')
                ->setParameter('nom', "%{$search->nom}%");
        }

        if (!empty($search->dateDebut)) {
            $query = $query
                ->andWhere('so.datedebut >= :dateDebut')
                ->setParameter('dateDebut', $search->dateDebut);
        }

        if (!empty($search->dateFin)) {
            $query = $query
                ->andWhere('so.datedebut <= :dateFin')
                ->setParameter('dateFin', $search->dateFin);
        }

        if (!empty($search->isOrganisateur)) {
            $query = $query
                // TODO : mettre à jour la requete
                ->andWhere('so.organisateur LIKE :nom')
                ->setParameter('isOrganisateur', $search->isOrganisateur);
        }
        
        if (!empty($search->isInscrit)) {
            $query = $query
                // TODO : mettre à jour la requete
                ->andWhere('so.nom LIKE :nom')
                ->setParameter('nom', "%{$search->nom}%");
        }
        
        if (!empty($search->isnotInscrit)) {
            $query = $query
                // TODO : mettre à jour la requete
                ->andWhere('so.nom LIKE :nom')
                ->setParameter('nom', "%{$search->nom}%");
        }

        if (!empty($search->isSortiePassee)) {
            $query = $query
                ->andWhere('so.datedebut <= :dateNow')
                ->setParameter('dateNow', new \DateTime('now'));
        }

        if (!empty($search->isnotSortieArchivee) && !empty($search->isSortiePassee)) {
            $dateArchivage = new \DateTime('now');
            $dateArchivage->modify('+1 month');
            $query = $query
                ->andWhere('so.datedebut <= :dateArchive')
                ->setParameter('dateArchive', new \DateTime('now'));
        }

        if (!empty($search->isnotSortieCloturee) && !empty($search->isSortiePassee)) {
            $query = $query
                ->andWhere('so.datecloture <= :dateNow')
                ->setParameter('dateNow', new \DateTime('now'));
        }

        return $query->getQuery()->getResult();
        /*
        return $this->paginator->paginate(
            $query,
            $search->page,
            9
        );
        */
    }

//    /**
//     * @return Sorties[] Returns an array of Sorties objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.noSortie', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Sorties
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.etatsNoEtat = :2')
//            ->setParameter('etatsNoEtat', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function inscripBySortie($noSortie){
    $em = $this->getEntityManager();
    $dql  = "
        SELECT p.pseudo, p.prenom, p.nom  FROM App\Entity\Participants p
        INNER JOIN p.inscriptions i
        WHERE i.sortiesNoSortie = :sortie
    ";
    $query = $em->createQuery($dql);
    $query->setParameter("sortie",$noSortie);
    return $query->getResult();
}

    public function countInscrip($noSortie){
    $em = $this->getEntityManager();
    $dql  = "
        SELECT COUNT(i.participantsNoParticipant) as count
        FROM App\Entity\Participants p
        INNER JOIN p.inscriptions i
        WHERE i.sortiesNoSortie = :sorti
    ";
    $query = $em->createQuery($dql);
    $query     ->setParameter("sorti",$noSortie );
    return $query->getResult();
}

    public function inscripTrueFalse($noSortie, $id){
    $em = $this->getEntityManager();
    $dql  = "
        SELECT COUNT(i.participantsNoParticipant) as count
        FROM App\Entity\Inscriptions i
        WHERE i.participantsNoParticipant = :parti AND i.sortiesNoSortie = :sorti
    ";
    $query = $em->createQuery($dql);
    $query     ->setParameter("sorti",$noSortie )
                    ->setParameter( "parti",$id );
    return $query->getResult();
}
}