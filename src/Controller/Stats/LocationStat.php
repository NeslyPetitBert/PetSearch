<?php

namespace App\Controller\Stats;


use App\Repository\LocationRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class LocationStat extends AbstractController
{

    private $manager;

   
    private $locationRepo;
 

    public function __construct(
        EntityManagerInterface $manager, 
 
        LocationRepository $locationRepo 
   
        )
    {
        $this->manager = $manager;
 
        $this->locationRepo = $locationRepo;
    
    }


    /**
     * @Route("/dashboard/admin/locations", name="location")
     * 
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @return Response
     */
    public function indexDashboard(): Response
    {
        $loc_new_wk = $this->locationRepo->getNewLocWeek();
        $loc_new_day = $this->locationRepo->getNewLocDay();
        $loc_new_mounth = $this->locationRepo->getNewLocMounth();
        $loc_new_year = $this->locationRepo->getNewLocYear();


        return $this->render('dashboard/petsearch/location/index.html.twig', [
            'loc_new_wk' => $loc_new_wk,
            'loc_new_day' => $loc_new_day,
            'loc_new_mounth' => $loc_new_mounth,
            'loc_new_year' => $loc_new_year,
      
        ]);
    }
}
