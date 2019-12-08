<?php
namespace App\Controller\Stats;

use App\Entity\Secondary\Location;
use Doctrine\ORM\EntityManagerInterface as ORMEntityManagerInterface;
use App\Repository\LocationRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;



class LocationStat extends AbstractController{

    /**
     * @Route("/dashboard/location", name="dashboard")
     */
    public function start(): Response {
        return $this->render('dashboard/dashboard.html.twig');
    }


 
    public function getNewLocWeek(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $res = $entityManager->getRepository(Location::class)->getNewLocWeek();


        return $this->json([
            "res"=> $res
        ]);

    }


    public function getNewLocDay(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $res = $entityManager->getRepository(Location::class)->getNewLocDay();


        return $this->json([
            "res"=> $res
        ]);

    }

    public function getNewLocMounth(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $res = $entityManager->getRepository(Location::class)->getNewLocMounth();


        return $this->json([
            "res"=> $res
        ]);

    }

    public function getNewLocYear(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $res = $entityManager->getRepository(Location::class)->getNewLocYear();


        return $this->json([
            "res"=> $res
        ]);

    }

}