<?php

namespace App\Controller\Stats;


use App\Repository\TokenRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class TokenStat extends AbstractController
{

    private $manager;

   
    private $tokenRepo;
 

    public function __construct(
        EntityManagerInterface $manager, 
 
        TokenRepository $tokenRepo 
   
        )
    {
        $this->manager = $manager;
 
        $this->tokenRepo = $tokenRepo;
    
    }


    /**
     * @Route("/dashboard/admin/tokens", name="token")
     * 
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @return Response
     */
    public function indexDashboard(): Response
    {
        $token_device = $this->tokenRepo->getDevices();
        $token_nb_conn_device = $this->tokenRepo->getNbConnexionUserDevice();
        $token_moy_con = $this->tokenRepo->getTempsMoyenConnexion();
        


        return $this->render('dashboard/petsearch/token/index.html.twig', [
            'token_device' => $token_device,
            'token_nb_conn_device' => $token_nb_conn_device,
            'token_moy_con' => $token_moy_con,
      
        ]);
    }
}
