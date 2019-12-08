<?php

namespace App\Controller\Stats;


use App\Repository\PetRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PetStat extends AbstractController
{

    private $manager;

   
    private $petRepo;
 

    public function __construct(
        EntityManagerInterface $manager, 
 
        PetRepository $petRepo 
   
        )
    {
        $this->manager = $manager;
 
        $this->petRepo = $petRepo;
    
    }


    /**
     * @Route("/dashboard/admin/pets", name="pet")
     * 
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @return Response
     */
    public function petDashboard(): Response
    {

        $pet_nb_sexe = $this->petRepo->getNbPetSexe();
        $pet_nb_age = $this->petRepo->getNbPetAge();
        $pet_nb_type = $this->petRepo->getNbPetType();
        $pet_nb_race = $this->petRepo->getNbPetRace();
        $pet_new_wk = $this->petRepo->getNewPetWeek();
        $pet_new_day = $this->petRepo->getNewPetDay();
        $pet_new_mounth = $this->petRepo->getNewPetMounth();
        $pet_new_year = $this->petRepo->getNewPetYear();
        $pet_aqui_wk = $this->petRepo->getAquisedPetWeek();
        $pet_aqui_day = $this->petRepo->getAquisedPetDay();
        $pet_aqui_mounth = $this->petRepo->getAquisedPetMounth();
        $pet_aqui_year = $this->petRepo->getAquisedPetYear();


        return $this->render('dashboard/petsearch/pet/index.html.twig', [

            'pet_nb_sexe' => $pet_nb_sexe,
            'pet_nb_age' => $pet_nb_age,
            'pet_nb_type' => $pet_nb_type,
            'pet_nb_race' => $pet_nb_race,
            'pet_new_day' => $pet_new_day,
            'pet_new_wk' => $pet_new_wk,
            'pet_new_mounth' => $pet_new_mounth,
            'pet_new_year' => $pet_new_year,
            'pet_aqui_wk' => $pet_aqui_wk,
            'pet_aqui_day' => $pet_aqui_day,
            'pet_aqui_mounth' => $pet_aqui_mounth,
            'pet_aqui_year' => $pet_aqui_year,
      
        ]);
    }
}
