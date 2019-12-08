<?php

namespace App\Repository;

use App\Entity\Secondary\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Location|null find($id, $lockMode = null, $lockVersion = null)
 * @method Location|null findOneBy(array $criteria, array $orderBy = null)
 * @method Location[]    findAll()
 * @method Location[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

    // /**
    //  * @return Location[] Returns an array of Location objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Location
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getNewLocWeek() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();
        $sql = '
        SELECT EXTRACT(YEAR FROM createdAt) as year,
        WEEKOFYEAR(createdAt) as wk,
        count(*)as nbloc
        FROM location WHERE createdAt < NOW()
        group by year,wk ORDER by year,wk DESC
        limit 1';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();
    }

    public function getNewLocDay() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();
        $sql = '
        SELECT
        CAST( createdAt AS date) as y,
        count(*)as nbLoc
        FROM location
        WHERE createdAt < NOW()
        group by y
        ORDER by y DESC
        limit 1';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();
    }
    
    public function getNewLocMounth() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();
        $sql = '
        SELECT EXTRACT(YEAR_MONTH FROM createdAt) as y,
        count(*)as nbLoc
        FROM location WHERE createdAt < NOW()
        group by y ORDER by y DESC
        limit 1';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();
    }
    
    public function getNewLocYear() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();
        $sql = '
        SELECT EXTRACT(YEAR FROM createdAt) as year,
        count(*)as nbLoc
        FROM Location WHERE createdAt < NOW()
        group by year ORDER by year DESC
        limit 1';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();
    }




}
