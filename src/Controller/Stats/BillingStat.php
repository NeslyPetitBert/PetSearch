<?php

namespace App\Controller\Stats;

use App\Repository\BillingRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class BillingStat extends AbstractController
{
    private $manager;
    private $billingRepo;

    public function __construct(
        EntityManagerInterface $manager, 
        BillingRepository $billingRepo
        )
    {
        $this->manager = $manager;
        $this->billingRepo = $billingRepo;
    }


    /**
     * @Route("/dashboard/admin/billings", name="billings")
     * 
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @return Response
     */
    public function billingDashboard(): Response
    {
        $billings_somme = $this->billingRepo->getSommeBilling();
        $billings_nb_inactif = $this->billingRepo->getNbBillInactif();
        $billings_nb_actif = $this->billingRepo->getNbBillActif();



        return $this->render('dashboard/petsearch/billing/index.html.twig', [
            'billings_somme' => $billings_somme,
            'billings_nb_inactif' => $billings_nb_inactif,
            'billings_nb_actif' => $billings_nb_actif,
      
        ]);
    }
}