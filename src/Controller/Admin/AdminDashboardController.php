<?php

namespace App\Controller\Admin;

use App\Repository\BillingRepository;
use App\Repository\LocationRepository;
use App\Repository\PetRepository;
use App\Repository\TokenRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AdminDashboardController extends AbstractController
{

    private $manager;

    private $billingRepo;
    private $petRepo;
    private $userRepo;
    private $locationRepo;
    private $tokenRepo;

    public function __construct(
        EntityManagerInterface $manager, 
        BillingRepository $billingRepo,
        PetRepository $petRepo,
        UserRepository $userRepo,
        LocationRepository $locationRepo,
        TokenRepository $tokenRepo
        )
    {
        $this->manager = $manager;
        $this->billingRepo = $billingRepo;
        $this->petRepo = $petRepo;
        $this->userRepo = $userRepo;
        $this->locationRepo = $locationRepo;
        $this->tokenRepo = $tokenRepo;
    }


    /**
     * @Route("/dashboard", name="administrator_index")
     * 
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @return Response
     */
    public function indexDashboard(): Response
    {
        $billings_stats = $this->billingRepo->getNbBillAll();
        $pets_stats = $this->petRepo->getNbPet();
        $users_stats = $this->userRepo->getNbUsers();
        $locations_stats = $this->locationRepo->getNbLocation();
        $tokens_stats = $this->tokenRepo->getNbToken();

        return $this->render('dashboard/dashboard.html.twig', [
            'billings_stats' => $billings_stats,
            'pets_stats' => $pets_stats,
            'users_stats' => $users_stats,
            'locations_stats' => $locations_stats,
            'tokens_stats' => $tokens_stats,
        ]);
    }
}
