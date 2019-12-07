<?php

namespace App\Controller\Admin;

use App\Repository\AdminUserRepository;
use App\Service\StatsService;
use Doctrine\ORM\EntityManagerInterface;
//use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AdminDashboardController extends AbstractController
{

    private $manager;

    private $adminUserRepo;

    public function __construct(EntityManagerInterface $manager, AdminUserRepository $adminUserRepo)
    {
        $this->manager = $manager;
        $this->adminUserRepo = $adminUserRepo;
    }

    protected function adminUserRepo(){
        return $this->adminUserRepo;
    }


    /**
     * @Route("/dashboard", name="administrator_index")
     * 
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @return Response
     */
    public function index(): Response
    {
        //$stats = $statsService->getStats();
        return $this->render('dashboard/dashboard.html.twig', [
            'stats' => 'stats',
        ]);
    }
}
