<?php

namespace App\Controller\Stats;


use App\Repository\UserRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class UserStat extends AbstractController
{

    private $manager;

   
    private $userRepo;
 

    public function __construct(
        EntityManagerInterface $manager, 
 
        userRepository $userRepo 
   
        )
    {
        $this->manager = $manager;
 
        $this->userRepo = $userRepo;
    
    }


    /**
     * @Route("/dashboard/admin/users", name="user")
     * 
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @return Response
     */
    public function indexDashboard(): Response
    {
        $user_mail = $this->userRepo->getMailStat();
        $user_nb_actif = $this->userRepo->getNbActiveUsers();
        $user_zip = $this->userRepo->getNbUserZip();
        $user_sexe = $this->userRepo->getNbUserSexe();
        $user_age = $this->userRepo->getNbUserAge();
        $user_wk = $this->userRepo->getNewUserWeek();
        $user_day = $this->userRepo->getNewUserDay();
        $user_mounth = $this->userRepo->getNewUserMounth();
        $user_year = $this->userRepo->getNewUserYear();
    
        


        return $this->render('dashboard/petsearch/user/index.html.twig', [
            'user_mail' => $user_mail,
            'user_nb_actif' => $user_nb_actif,
            'user_zip' => $user_zip,
            'user_sexe' => $user_sexe,
            'user_age' => $user_age,
            'user_wk' => $user_wk,
            'user_day' => $user_day,
            'user_mounth' => $user_mounth,
            'user_year' => $user_year,
      
        ]);
    }
}
