<?php

namespace App\Repository;

use App\Entity\Secondary\Token;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Token|null find($id, $lockMode = null, $lockVersion = null)
 * @method Token|null findOneBy(array $criteria, array $orderBy = null)
 * @method Token[]    findAll()
 * @method Token[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Token::class);
    }

    // /**
    //  * @return Token[] Returns an array of Token objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Token
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getNbToken() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();
        $sql = 'select count(*) as nombre_tokens from token
            where createdat < NOW()';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();
    }

    public function getNbConnexion() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();
        $sql = '
        CAST( createdAt AS date) as y,
        count(*)as nb
        FROM token
        WHERE createdAt < NOW()
        group by y
        ORDER by y DESC
        limit 1';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();
    }

    public function getDevices() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();
        $sql = '
        select decive as device,count(*) as nb FROM token where createdAt < now() group by decive ORDER by nb DESC';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();
    }

    
    public function getNbConnexionUserDevice() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();
        $sql = '
        select count(*) as nb,user_iduser, decive
        FROM token
        where createdAt < now()
        and type="Bearer"
        group by user_iduser,decive
        ORDER by nb DESC
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();
    }

    public function getTempsMoyenConnexion() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();
        $sql = '
        select sec_to_time(
             avg(
                  timediff(
                       now(),(
                            select t.createdAt 
                            from token t 
                            where t.type="Bearer" 
                            group by t.user_iduser 
                            order by t.createdAt ASC
                             limit 1)
                             )
                     )
            ) 
        from token

        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();
    }


}
