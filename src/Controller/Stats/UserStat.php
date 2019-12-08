<?php
namespace App\Controller\Stats;

use App\Entity\Secondary\User;
use Doctrine\ORM\EntityManagerInterface as ORMEntityManagerInterface;
use App\Repository\UserRepository;

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
     * @Route("/dashboard/user/mail", name="getMailStat")
     */
    public function getMailStat(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $listUsers = $entityManager->getRepository(User::class)->getMailStat();
        $listDomain = [];
        $listDatas = [];
        for ($i = 0; $i < count($listUsers); $i ++) {
            array_push($listDomain, $listUsers[$i]["domaine"]);
            array_push($listDatas, $listUsers[$i]["nb_domaine"]);
        }

        return $this->json([
            "Labels"=> $listDomain,
            "Data" => $listDatas
        ]);

    }

    /**
     * @Route("/dashboard/users", name="getNbUsers")
     */
    public function getNbUsers(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $nbusers = $entityManager->getRepository(User::class)->getNbUsers();
    

        return $this->render('dashboard/chartUser/index.html.twig', [
            "nombre"=> $nbusers
        ]);

    }

    /**
     * @Route("/dashboard/users", name="getNbActiveUsers")
     */
    public function getNbActiveUsers(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $nbusers = $entityManager->getRepository(User::class)->getNbActiveUsers();
    



        return $this->render('dashboard/chartUser/nbNewUser.html.twig', [
            "nombreActif"=> $nbusers
        ]);

    }

    /**
     * @Route("/dashboard/user/nbzip", name="getNbUserZip")
     */
    public function getNbUserZip(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $nbusers = $entityManager->getRepository(User::class)->getNbUserZip();
    

        return $this->json([
            "nombre"=> $nbusers
        ]);

    }

    /**
     * @Route("/dashboard/user/nbsexe", name="getNbUserSexe")
     */
    public function getNbUserSexe(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $nbusers = $entityManager->getRepository(User::class)->getNbUserSexe();
    

        return $this->json([
            "nombre"=> $nbusers
        ]);

    }

    /**
     * @Route("/dashboard/user/nbbyage", name="getNbUserAge")
     */
    public function getNbUserAge(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $nbusers = $entityManager->getRepository(User::class)->getNbUserAge();
        return $this->json([
            "nombre"=> $nbusers
        ]);

    }
    /**
     * @Route("/dashboard/user/nbnewweek", name="getNewUserWeek")
     */
    public function getNewUserWeek(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $nbusers = $entityManager->getRepository(User::class)->getNewUserWeek();
        return $this->json([
            "nombre"=> $nbusers
        ]);

    }
    /**
     * @Route("/dashboard/user/nbnewday", name="getNewUserDay")
     */
    public function getNewUserDay(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $nbusers = $entityManager->getRepository(User::class)->getNewUserDay();
        return $this->json([
            "nombre"=> $nbusers
        ]);

    }
    /**
     * @Route("/dashboard/user/nbnewmounth", name="getNewUserMounth")
     */
    public function getNewUserMounth(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $nbusers = $entityManager->getRepository(User::class)->getNewUserMounth();
        return $this->json([
            "nombre"=> $nbusers
        ]);

    }
    /**
     * @Route("/dashboard/user/nbnewyear", name="getNewUserYear")
     */
    public function getNewUserYear(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $nbusers = $entityManager->getRepository(User::class)->getNewUserYear();
        return $this->json([
            "nombre"=> $nbusers
        ]);

    }

}