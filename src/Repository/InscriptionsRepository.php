<?php

namespace App\Repository;

use App\Entity\Inscriptions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Inscriptions>
 *
 * @method Inscriptions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inscriptions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inscriptions[]    findAll()
 * @method Inscriptions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InscriptionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inscriptions::class);
    }

    public function add(Inscriptions $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Inscriptions $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Inscriptions[] Returns an array of Inscriptions objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Inscriptions
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function Sinscrire($noSortie, $id){

    $inscrit = new Inscriptions();
    $inscrit->setDateInscription(new \DateTime());
    $inscrit->setSortiesNoSortie($noSortie);
    $inscrit->setParticipantsNoParticipant($id);

    $em = $this->getEntityManager();
    $em->persist($inscrit);
    $em->flush();

}

public function desister($noSortie, $id){
    $em = $this->getEntityManager();
    $dql  = "
        DELETE App\Entity\Inscriptions i
        WHERE i.participantsNoParticipant = :parti AND i.sortiesNoSortie = :sorti
    ";
    $query = $em->createQuery($dql);
    $query     ->setParameter("sorti",$noSortie )
                    ->setParameter( "parti",$id );
    $query->execute();
}
}
