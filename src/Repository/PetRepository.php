<?php

namespace App\Repository;

use App\Entity\Secondary\Pet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Pet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pet[]    findAll()
 * @method Pet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pet::class);
    }

    // /**
    //  * @return Pet[] Returns an array of Pet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pet
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getNbPet() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();
        $sql = 'select count(*) as nombre_pets from pet
            where createdat < NOW()';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();
    }

    public function getNbPetSexe() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();
        $sql = '
        SELECT sexe,count(*) as pet_sexe
        from pet
        where createdat < NOW()
        group by sexe';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();
    }


    public function getNbPetAge() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();
        $sql = '
        SELECT count(*)as nb FROM pet WHERE createdAt <= now() and (datediff(now(),birthday))/365 < 18
        UNION
        SELECT count(*)as nb FROM pet WHERE createdAt <= now() and (datediff(now(),birthday))/365 >= 18 and (datediff(now(),birthday))/365 < 26
        UNION
        SELECT count(*)as nb FROM pet WHERE createdAt <= now() and (datediff(now(),birthday))/365 >= 26 and (datediff(now(),birthday))/365 < 36
        UNION
        SELECT count(*)as nb FROM pet WHERE createdAt <= now() and (datediff(now(),birthday))/365 >= 36 and (datediff(now(),birthday))/365 < 50
        UNION
        SELECT count(*)as nb FROM pet WHERE createdAt <= now() and (datediff(now(),birthday))/365 >= 50';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();
    }



    public function getNbPetType() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();
        $sql = '
        SELECT count(idpet)as nb_pet,type
        FROM pet
        WHERE createdAt< now()
        group by type
        order by nb_pet DESC';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();
    }


    public function getNbPetRace() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();
        $sql = '
        SELECT count(idpet)as nb_pet,type,race
        FROM pet
        WHERE createdAt< now()
        group by type,race
        order by nb_pet DESC';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();
    }


    public function getNewPetWeek() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();
        $sql = '
        SELECT EXTRACT(YEAR FROM createdAt) as year,
        WEEKOFYEAR(createdAt) as wk,
        count(*)as nbPet
        FROM pet WHERE createdAt < NOW()
        group by year,wk ORDER by year,wk DESC
        limit 1';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();
    }
    
    public function getNewPetDay() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();
        $sql = '
        SELECT
        CAST( createdAt AS date) as y,
        count(*)as nbPet
        FROM pet
        WHERE createdAt < NOW()
        group by y
        ORDER by y DESC
        limit 1';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();
    }
    
    public function getNewPetMounth() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();
        $sql = '
        SELECT EXTRACT(YEAR_MONTH FROM createdAt) as y,
        count(*)as nbPet
        FROM pet WHERE createdAt < NOW()
        group by y ORDER by y DESC
        limit 1';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();
    }
    
    public function getNewPetYear() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();
        $sql = '
        SELECT EXTRACT(YEAR FROM createdAt) as year,
        count(*)as nbPet
        FROM Pet WHERE createdAt < NOW()
        group by year ORDER by year DESC
        limit 1';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();
    }



    public function getAquisedPetWeek() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();
        $sql = '
        SELECT EXTRACT(YEAR FROM createdAt) as year,
        WEEKOFYEAR(dateAcquisition) as wk,
        count(*)as nbPet
        FROM pet WHERE dateAcquisition < NOW()
        group by year,wk ORDER by year,wk DESC
        limit 1';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();
    }
    
    public function getAquisedPetDay() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();
        $sql = '
        SELECT
        CAST( dateAcquisition AS date) as y,
        count(*)as nbPet
        FROM pet
        WHERE dateAcquisition < NOW()
        group by y
        ORDER by y DESC
        limit 1';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();
    }
    
    public function getAquisedPetMounth() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();
        $sql = '
        SELECT EXTRACT(YEAR_MONTH FROM dateAcquisition) as y,
        count(*)as nbPet
        FROM pet WHERE dateAcquisition < NOW()
        group by y ORDER by y DESC
        limit 1';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();
    }
    
    public function getAquisedPetYear() {
        $entityManager = $this->getEntityManager();
        $conn = $entityManager->getConnection();
        $sql = '
        SELECT EXTRACT(YEAR FROM dateAcquisition) as year,
        count(*)as nbPet
        FROM Pet WHERE dateAcquisition < NOW()
        group by year ORDER by year DESC
        limit 1';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('Values'));
        return $stmt->fetchAll();
    }



}
