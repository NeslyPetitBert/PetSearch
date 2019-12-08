<?php

namespace App\Controller\Admin;

use App\Form\PetType;
use App\Entity\Secondary\Pet;
use App\Repository\PetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/dashboard")
 */
class AdminPetController extends AbstractController
{

    private $petRepo;

    public function __construct(PetRepository $petRepo)
    {
        $this->petRepo = $petRepo;
    }
    
    /**
     * Permet d'afficher les animaux Pet
     *
     * @Route("/admin/pets", name="pets_index")
     * 
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @return Response
     */
    public function petsAll(Request $request, PaginatorInterface $paginator) : Response
    {

        // Les stats des animaux
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

        // Le tableau de animaux :
        $pets = $paginator->paginate(
            $this->petRepo->findAll(),
            $request->query->getInt('page', 1),
            10);

        return $this->render('dashboard/petsearch/pet/index.html.twig', [
            // Le tableau des animaux :
            'pets' => $pets,

            // Les stats des animaux :
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


    /**
     * Permet d'afficher et de traiter le formulaire de création d'un animal Pet
     *
     * @Route("/admin/pets/new", name="pet_register")
     *
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @param EntityManagerInterface $emi
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function billingCreate(Request $request, EntityManagerInterface $emi): Response
    {
        $emi = $this->getDoctrine()->getManager('customer');

        $pet = new Pet();
        
        $form = $this->createForm(PetType::class, $pet);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){

            // Avec les deux lignes suivantes, l'animal serait automatiquement assocé à utilsateur connecté dans l'application, pas besoin de proposer une liste déroulante.
            // Mais l'authentification n'étant pas gérée pour le User, mais pour AdminUser, il ne sera donc jamais appelé, le choix de l'utilisateur est proposer via une liste
            // déroulante configurer dans le FormType et dans le twig add et update.

            // $user =  $this->getUser();

            //$pet->setUserIduser($user);
            
            $emi->persist($pet);
            $emi->flush();

            $this->addFlash('success', "L'animal a été créé avec succès");

            return $this->redirectToRoute('admin_pet_show', [
                'idpet' => $pet->getIdpet(),
            ]);

        }

        return $this->render('dashboard/petsearch/pet/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher un animal Pet
     * 
     * @Route("/admin/pets/{idpet}", name="admin_pet_show", methods={"GET"})
     * 
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @param Pet $pet
     * @return Response
     */
    public function adminShowPet(Pet $pet): Response
    {
        return $this->render('dashboard/petsearch/pet/show.html.twig', [
            'pet' => $pet,
        ]);
    }


    /**
     * Permet d'afficher et de traiter le formulaire de modification d'un animal Pet
     *
     * @Route("/admin/pets/{idpet}/update", name="pet_edit")
     * 
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     *
     * @param EntityManagerInterface $emi
     * @param Pet $pet
     * @param Request $request
     * @return Response
     */
    public function petEdit(Request $request, Pet $pet, EntityManagerInterface $emi): Response
    {
        $emi = $this->getDoctrine()->getManager('customer');

        $form =$this->createForm(PetType::class, $pet);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $emi->persist($pet);
            $emi->flush();

            $this->addFlash('success', "L'animal a été modifié avec succès");

            return $this->redirectToRoute('admin_pet_show', [
                'idpet' => $pet->getIdpet(),
            ]);

        }

        return $this->render('dashboard/petsearch/pet/edit.html.twig', [
            'form' => $form->createView(),
            'pet' => $pet,
        ]);
    }

    /**
     * Permet de supprimer un animal Pet
     * 
     * @Route("/admin/pets/{idpet}/delete", name="pet_delete")
     *
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @param EntityManagerInterface $emi
     * @param Pet $pet
     * @return Response
     */
    public function petDelete(Pet $pet, EntityManagerInterface $emi): Response
    {
        $emi = $this->getDoctrine()->getManager('customer');

        $emi->remove($pet);
        $emi->flush();

        $this->addFlash('danger', "Animal supprimé avec succès");

        return $this->redirectToRoute('pets_index');
    }

}
