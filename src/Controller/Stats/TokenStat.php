<?php
namespace App\Controller\Stats;

use App\Entity\Secondary\Token;
use Doctrine\ORM\EntityManagerInterface as ORMEntityManagerInterface;
use App\Repository\TokenRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;



class TokenStat extends AbstractController{

    /**
     * @Route("/dashboard/token", name="dashboard")
     */
    public function start(): Response {
        return $this->render('dashboard/dashboard.html.twig');
    }


 
    public function getNbConnexion(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $res = $entityManager->getRepository(Token::class)->getNbConnexion();


        return $this->json([
            "res"=> $res
        ]);

    }

    public function getDevices(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $res = $entityManager->getRepository(Token::class)->getDevices();


        return $this->json([
            "res"=> $res
        ]);

    }  
     public function getNbConnexionUserDevice(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $res = $entityManager->getRepository(Token::class)->getNbConnexionUserDevice();


        return $this->json([
            "res"=> $res
        ]);

   }

   public function getTempsMoyenConnexion(ORMEntityManagerInterface $entityManager): Response {
    $entityManager = $this->getDoctrine()->getManager('customer');
    $res = $entityManager->getRepository(Token::class)->getTempsMoyenConnexion();


    return $this->json([
        "res"=> $res
    ]);

}

}