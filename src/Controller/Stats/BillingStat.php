<?php
namespace App\Controller\Stats;

use App\Entity\Secondary\Billing;
use Doctrine\ORM\EntityManagerInterface as ORMEntityManagerInterface;
use App\Repository\BillingRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;



class BillingStat extends AbstractController{

    /**
     * @Route("/dashboard/billing", name="dashboard")
     */
    public function start(): Response {
        return $this->render('dashboard/dashboard.html.twig');
    }


 
    public function getMailStat(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $res = $entityManager->getRepository(Billing::class)->getSommeBilling();


        return $this->json([
            "res"=> $res
        ]);

    }


    public function getNbBillAll(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $res = $entityManager->getRepository(Billing::class)->getNbBillAll();


        return $this->json([
            "res"=> $res
        ]);

    }

    public function getNbBillInactif(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $res = $entityManager->getRepository(Billing::class)->getNbBillInactif();


        return $this->json([
            "res"=> $res
        ]);

    }

    public function getNbBillActif(ORMEntityManagerInterface $entityManager): Response {
        $entityManager = $this->getDoctrine()->getManager('customer');
        $res = $entityManager->getRepository(Billing::class)->getNbBillActif();


        return $this->json([
            "res"=> $res
        ]);

    }