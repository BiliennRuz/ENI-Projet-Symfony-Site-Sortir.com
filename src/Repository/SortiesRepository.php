<?php

namespace App\Repository;

use App\Entity\Participants;
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

    public function findByDateDebut($date){
        $em = $this->getEntityManager();
        $dql  = "
            SELECT s FROM App\Entity\Sorties s
            WHERE s.datedebut <= :date
        ";
        $query = $em->createQuery($dql);
        $query->setParameter("date",$date);
        return $query->getResult();
    }

    public function findByDateClotureAndStatus($date, $currentStatus){
        $em = $this->getEntityManager();
        $dql  = "
            SELECT s FROM App\Entity\Sorties s
            WHERE s.datecloture <= :date AND s.etatsNoEtat = :currentStatus 
        ";
        $query = $em->createQuery($dql);
        $query->setParameter("date",$date);
        $query->setParameter("currentStatus",$currentStatus);
        return $query->getResult();
    }

    // public function updateArchiveStatus($date, Sorties $entity, bool $flush = false): void{
    //     $em = $this->getEntityManager();
    //     $dql  = "
    //         UPDATE App\Entity\Sortie s
    //         SET s.etatsNoEtat = 'Activité historisée'
    //         WHERE s.datedebut <= :dateArchive
    //     ";
    //     $query = $em->createQuery($dql);
    //     $query->setParameter("dateArchive",$date);
    // }

    // // TODO : pour optimiser  Gestion auto de la cloture des sorties
    // public function updateStatusDateCloture($dateLimite, $currentStatus, $newStatus, Sorties $entity, bool $flush = false): void{
    //     $em = $this->getEntityManager();
    //     $dql  = "
    //         UPDATE App\Entity\Sortie s
    //         SET s.etatsNoEtat = :newStatus
    //         WHERE s.datecloture <= :dateLimite AND s.etatsNoEtat = :currentStatus
    //     ";
    //     $query = $em->createQuery($dql);
    //     $query->setParameter("dateLimite",$dateLimite);
    //     $query->setParameter("newStatus",$newStatus);
    //     $query->setParameter("currentStatus",$currentStatus);
    // }

    /**
     * Récupère les sorties en lien avec une recherche
     * @return Sorties[]
     */
    public function findSearch(SearchDataSorties $search, Participants $participant): array
    {

        dump($search);

        $query = $this
            ->createQueryBuilder('so');
        //    ->select('so', 'si')
        //    ->join('si.nomSite', 'so');
            
        if (!empty($search->sites)) {
            $query = $query
                // TODO : mettre à jour la requete
                ->andWhere('so.nom LIKE :site')
                ->setParameter('site', $search->sites);
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
                ->andWhere('so.organisateur = :participant')
                ->setParameter('participant', $participant->getId());
        }
        
        if (!empty($search->isInscrit)) {
            $query = $query
                // TODO : mettre à jour la requete
                ->andWhere('so.nom LIKE :participant')
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
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
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