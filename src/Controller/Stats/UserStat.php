<?php
namespace App\Controller\Stats;

use App\Entity\Secondary\User;
use Doctrine\ORM\EntityManagerInterface as ORMEntityManagerInterface;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;



class UserStat extends AbstractController{

    /**
     * @Route("/dashboard/user", name="dashboard")
     */
    public function start(): Response {
        return $this->render('dashboard/dashboard.html.twig');
    }


        /**
     * @Route("/dashboard/user/mail", name="userMail")
     */
    public function getMailStat(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $listUsers = $entityManager->getRepository(UserRepository::class)->getMailStat;
        $listDomain = [];
        $listDatas = [];
        for ($i = 0; $i < count($listUsers); $i ++) {
            array_push($listDomain, $listUsers[$i]["domaine"]);
            array_push($listDatas, $listUsers[$i]["nb_domaine"]);
        }
        
        return $this->render('dashboard/essaie.html.twig',[
            "Labels" => $listDomain,
            "Data" => $listDatas
        ]);
    }
}