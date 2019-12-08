<?php

namespace App\Repository;

use App\Entity\Secondary\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use DateTime;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


public function getNbUsers() {
    $entityManager = $this->getEntityManager();
    $conn = $entityManager->getConnection();
    $sql = 'select count(*) as nombre_users from user
        where createdat < NOW()';
    $stmt = $conn->prepare($sql);
    $stmt->execute(array('Values'));
    return $stmt->fetchAll();
}

public function getNbActiveUsers(){
    $entityManager = $this->getEntityManager();
    $conn = $entityManager->getConnection();
    $sql = 'select count(*) as nombre from user
        where createdat < NOW()
        and active=1';
    $stmt = $conn->prepare($sql);
    $stmt->execute(array('Values'));
    return $stmt->fetchAll();
}

public function getMailStat() {
    $entityManager = $this->getEntityManager();
    $conn = $entityManager->getConnection();
    $sql = '
        select
            substring(email,LOCATE(\'@\',email)+1,LENGTH(email)) as domaine,
            count(*) as nb_domaine
            from user
            where createdat <NOW()
            group by domaine
            order by nb_domaine DESC';
    $stmt = $conn->prepare($sql);
    $stmt->execute(array('Values'));
    return $stmt->fetchAll();
}

public function getNbUserZip() {
    $entityManager = $this->getEntityManager();
    $conn = $entityManager->getConnection();
    $sql = '
    SELECT zip,country,count(*)as nb FROM user WHERE createdAt <= now() group by zip,country order by nb DESC';
    $stmt = $conn->prepare($sql);
    $stmt->execute(array('Values'));
    return $stmt->fetchAll();
}

public function getNbUserSexe() {
    $entityManager = $this->getEntityManager();
    $conn = $entityManager->getConnection();
    $sql = '
    SELECT sexe,count(*)
    from user
    where createdat < NOW()
    group by sexe';
    $stmt = $conn->prepare($sql);
    $stmt->execute(array('Values'));
    return $stmt->fetchAll();
}

public function getNbUserAge() {
    $entityManager = $this->getEntityManager();
    $conn = $entityManager->getConnection();
    $sql = '
    SELECT count(*)as nb FROM user WHERE createdAt <= now() and (datediff(now(),birthday))/365 < 18
    UNION
    SELECT count(*)as nb FROM user WHERE createdAt <= now() and (datediff(now(),birthday))/365 >= 18 and (datediff(now(),birthday))/365 < 26
    UNION
    SELECT count(*)as nb FROM user WHERE createdAt <= now() and (datediff(now(),birthday))/365 >= 26 and (datediff(now(),birthday))/365 < 36
    UNION
    SELECT count(*)as nb FROM user WHERE createdAt <= now() and (datediff(now(),birthday))/365 >= 36 and (datediff(now(),birthday))/365 < 50
    UNION
    SELECT count(*)as nb FROM user WHERE createdAt <= now() and (datediff(now(),birthday))/365 >= 50';
    $stmt = $conn->prepare($sql);
    $stmt->execute(array('Values'));
    return $stmt->fetchAll();
}

public function getNewUserWeek() {
    $entityManager = $this->getEntityManager();
    $conn = $entityManager->getConnection();
    $sql = '
    SELECT EXTRACT(YEAR FROM createdAt) as year,
    WEEKOFYEAR(createdAt) as wk,
    count(*)as nbUser
    FROM user WHERE createdAt < NOW()
    group by year,wk ORDER by year,wk DESC
    limit 1';
    $stmt = $conn->prepare($sql);
    $stmt->execute(array('Values'));
    return $stmt->fetchAll();
}

public function getNewUserDay() {
    $entityManager = $this->getEntityManager();
    $conn = $entityManager->getConnection();
    $sql = '
    SELECT
    CAST( createdAt AS date) as y,
    count(*)as nbUser
    FROM user
    WHERE createdAt < NOW()
    group by y
    ORDER by y DESC
    limit 1';
    $stmt = $conn->prepare($sql);
    $stmt->execute(array('Values'));
    return $stmt->fetchAll();
}

public function getNewUserMounth() {
    $entityManager = $this->getEntityManager();
    $conn = $entityManager->getConnection();
    $sql = '
    SELECT EXTRACT(YEAR_MONTH FROM createdAt) as y,
    count(*)as nbUser
    FROM user WHERE createdAt < NOW()
    group by y ORDER by y DESC
    limit 1';
    $stmt = $conn->prepare($sql);
    $stmt->execute(array('Values'));
    return $stmt->fetchAll();
}

public function getNewUserYear() {
    $entityManager = $this->getEntityManager();
    $conn = $entityManager->getConnection();
    $sql = '
    SELECT EXTRACT(YEAR FROM createdAt) as year,
    count(*)as nbUser
    FROM user WHERE createdAt < NOW()
    group by year ORDER by year DESC
    limit 1';
    $stmt = $conn->prepare($sql);
    $stmt->execute(array('Values'));
    return $stmt->fetchAll();
}

}