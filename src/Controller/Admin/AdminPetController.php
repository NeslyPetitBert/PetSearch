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

    private $manager;

    private $petRepo;

    public function __construct(EntityManagerInterface $manager, PetRepository $petRepo)
    {
        $this->manager = $manager;
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

        $pets = $paginator->paginate(
            $this->petRepo->findAll(),
            $request->query->getInt('page', 1),
            10);

        return $this->render('dashboard/petsearch/pet/index.html.twig', [
            'pets' => $pets,
        ]);
    }


    /**
     * Permet d'afficher et de traiter le formulaire de création d'un animal Pet
     *
     * @Route("/admin/pets/new", name="pet_register")
     *
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function billingCreate(Request $request): Response
    {
        
        $pet = new Pet();
        
        $form = $this->createForm(PetType::class, $pet);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){

            $user =  $this->getUser();

            $pet->setUserIduser($user);
            
            $this->manager->persist($pet);
            $this->manager->flush();

            $this->addFlash('success', "L'animal a été créé avec succès");

            return $this->redirectToRoute('pets_index');

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
     * @param Pet $pet
     * @param Request $request
     * @return Response
     */
    public function petEdit(Request $request, Pet $pet): Response
    {
        $form =$this->createForm(PetType::class, $pet);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($pet);
            $this->manager->flush();

            $this->addFlash('success', "L'animal a été modifié avec succès");

            return $this->redirectToRoute('admin_pet_show', [
                'id' => $pet->getIdpet(),
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
     * @param Pet $pet
     * @return Response
     */
    public function petDelete(Pet $pet): Response
    {
        $this->manager->remove($pet);
        $this->manager->flush();

        $this->addFlash('danger', "Animal supprimé avec succès");

        return $this->redirectToRoute('admin_pets_index');
    }

}