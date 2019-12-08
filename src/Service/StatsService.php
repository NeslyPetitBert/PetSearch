<?php
namespace App\Service;

//use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;

Class StatsService {

    private $manager;

    /**
     * StatsService constructor.
     * @param ObjectManager $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Permet de faire un count de toutes les factures Billings.
     */
    public function getBillingsCount(){
        return $this->manager->createQuery('SELECT COUNT(b) FROM App\Entity\Secondary\Billing b')->getSingleScalarResult();
    }

    /**
     * Permet de faire un count de toutes les localisations présentes dans la la table location.
     */
    public function getLocationsCount(){
        return $this->manager->createQuery('SELECT COUNT(l) FROM App\Entity\Secondary\Location l')->getSingleScalarResult();
    }

    /**
     * Permet de faire un count de tous les animaux Pet.
     */
    public function getPetsCount(){
        return $this->manager->createQuery('SELECT COUNT(p) FROM App\Entity\Secondary\Pet p')->getSingleScalarResult();
    }

    /**
     * Permet de faire un count de tous les token Token.
     */
    public function getTokensCount(){
        return $this->manager->createQuery('SELECT COUNT(tk) FROM App\Entity\Secondary\token tk')->getSingleScalarResult();
    }

    /**
     * Permet de faire un count de tous les Utilisateurs.
     */
    public function getAdminUsersCount(){
        return $this->manager->createQuery('SELECT COUNT(au) FROM App\Entity\Secondary\AdminUser au')->getSingleScalarResult();
    }

    public function getStats(){
         $billings = $this->getBillingsCount();
         $locations = $this->getLocationsCount();
         $pets = $this->getPetsCount();
         $tokens = $this->getTokensCount();
         $users = $this->getAdminUsersCount();

         return compact('billings', 'locations', 'pets', 'tokens', 'users');
    }
}