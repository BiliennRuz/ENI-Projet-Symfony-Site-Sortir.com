<?php

namespace App\Repository;

use App\Entity\Sorties;
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
        SELECT p.pseudo as Pseudo, p.prenom AS Prenom, p.nom AS Nom FROM App\Entity\Participants p
        JOIN App\Entity\Inscriptions i 
        WHERE i.sortiesNoSortie = :sortie
    ";
    $query = $em->createQuery($dql);
    $query->setParameter("sortie","%$noSortie%");
    return $query->getResult();
}

    public function countInscrip($noSortie){
    $em = $this->getEntityManager();
    $dql  = "
        SELECT COUNT(*)
        FROM App\Entity\Participants p
        INNER JOIN App\Entity\Inscriptions i
        ON p.id = i.participantsNoParticipant
        WHERE i.sortiesNoSortie LIKE :sorti
    ";
    $query = $em->createQuery($dql);
    $query     ->setParameter("sorti","%$noSortie%" );
    return $query->getResult();
}

    public function inscripTrueFalse($noSortie, $id){
    $em = $this->getEntityManager();
    $dql  = "
        SELECT COUNT(*)
        FROM App/Entity/Inscriptions i
        WHERE participantsNoParticipant = :parti
        ANDWHERE i.sortiesNoSortie = :sorti
    ";
    $query = $em->createQuery($dql);
    $query     ->setParameter("sorti","%$noSortie%" )
                    ->setParameter( "parti","%$id%" );
    return $query->getResult();
}
}