<?php

namespace App\Repository;

use App\Entity\Checkin;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Checkin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Checkin|null findOneBy(array $criteria, array $orderBy = null)
 * @method Checkin[]    findAll()
 * @method Checkin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CheckinRepository extends ServiceEntityRepository
{
    private $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct($registry, Checkin::class);
    }

    /**
     * Archives (or actually annonymes) older checkins
     */
    public function archive()
    {
        $qb = $this->em->createQueryBuilder();
         $q = $qb->update(Checkin::class, 'c')
            ->setParameter('now', new \DateTime('now'))
            ->setParameter(1, null)
            ->where('c.dateToArchive = :now')
            ->set('c.person', '?1')
            ->set('c.userUrl', '?1')
            ->getQuery();
        $p = $q->execute();
    }



    // /**
    //  * @return Checkin[] Returns an array of Checkin objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Checkin
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
