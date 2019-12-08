<?php
namespace App\Controller\Stats;

use App\Entity\Secondary\Pet;
use Doctrine\ORM\EntityManagerInterface as ORMEntityManagerInterface;
use App\Repository\PetRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;



class PetStat extends AbstractController{

    /**
     * @Route("/dashboard/pet", name="pet")
     */
    public function start(): Response {
        return $this->render('dashboard/dashboard.html.twig');
    }


 
    public function getNbPet(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $res = $entityManager->getRepository(Pet::class)->getNbPet();


        return $this->json([
            "res"=> $res
        ]);

    }
    public function getNbPetSexe(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $res = $entityManager->getRepository(Pet::class)->getNbPetSexe();


        return $this->json([
            "res"=> $res
        ]);

    }
    public function getNbPetAge(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $res = $entityManager->getRepository(Pet::class)->getNbPetAge();


        return $this->json([
            "res"=> $res
        ]);

    }
    public function getNbPetType(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $res = $entityManager->getRepository(Pet::class)->getNbPetType();


        return $this->json([
            "res"=> $res
        ]);

    }
    public function getNbPetRace(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $res = $entityManager->getRepository(Pet::class)->getNbPetRace();


        return $this->json([
            "res"=> $res
        ]);

    }

    public function getNewPetWeek(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $res = $entityManager->getRepository(Pet::class)->getNewPetWeek();


        return $this->json([
            "res"=> $res
        ]);

    }

    public function getNewPetDay(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $res = $entityManager->getRepository(Pet::class)->getNewPetDay();


        return $this->json([
            "res"=> $res
        ]);

    }
    public function getNewPetMounth(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $res = $entityManager->getRepository(Pet::class)->getNewPetMounth();


        return $this->json([
            "res"=> $res
        ]);

    }
    public function getNewPetYear(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $res = $entityManager->getRepository(Pet::class)->getNewPetYear();


        return $this->json([
            "res"=> $res
        ]);

    }
    public function getAquisedPetWeek(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $res = $entityManager->getRepository(Pet::class)->getAquisedPetWeek();


        return $this->json([
            "res"=> $res
        ]);

    }   
     public function getAquisedPetDay(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $res = $entityManager->getRepository(Pet::class)->getAquisedPetDay();


        return $this->json([
            "res"=> $res
        ]);

    } 
       public function getAquisedPetMounth(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $res = $entityManager->getRepository(Pet::class)->getAquisedPetMounth();


        return $this->json([
            "res"=> $res
        ]);

    } 
       public function getAquisedPetYear(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $res = $entityManager->getRepository(Pet::class)->getAquisedPetYear();


        return $this->json([
            "res"=> $res
        ]);

    }






}
