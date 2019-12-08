<?php

namespace App\Controller\Admin;

use App\Form\AccountType;
use App\Entity\Secondary\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/dashboard")
 */
class AdminAccountUserController extends AbstractController
{

    private $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }
    
    /**
     * Permet d'afficher les comptes utilisateurs créés
     *
     * @Route("/admin/user-accounts/", name="accounts_index")
     * 
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @return Response
     */
    public function userAccount(Request $request, PaginatorInterface $paginator) : Response
    {

        $users = $paginator->paginate(
            $this->userRepo->findAll(),
            $request->query->getInt('page', 1),
            10);

        return $this->render('dashboard/petsearch/user/account/index.html.twig', [
            'users' => $users,
        ]);
    }


    /**
     * Permet d'afficher le formulaire de création de compte
     *
     * @Route("/admin/user-accounts/new", name="account_register")
     *
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @param EntityManagerInterface $emi
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function userCreate(Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $emi): Response
    {
        $emi = $this->getDoctrine()->getManager('customer');
        //instantiation User
        $user = new User();

        //create form to registering the User
        $form = $this->createForm(RegistrationType::class, $user);

        //data recovery via http request
        $form->handleRequest($request);

        //Verification of the form to see if it has been submitted and if it is valid
        if($form->isSubmitted() && $form->isValid()){
            //password encoding
            $password = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            //persistence of the user
            $emi->persist($user);
            //registering the user in the database
            $emi->flush();

            // flash message
            $this->addFlash('success', "Le compte utilisateur <strong>{$user->getFirstName()} {$user->getLastName()} </strong> a été créé avec succès");

            return $this->redirectToRoute('admin_user_account_show', [
                'iduser' => $user->getIduser(),
            ]);

        }

        return $this->render('dashboard/petsearch/user/account/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher et de traiter le formulaire de création de compte utilisateur User
     * 
     * @Route("/admin/user-accounts/{iduser}", name="admin_user_account_show", methods={"GET"})
     * 
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @param User $user
     * @return Response
     */
    public function adminShowUserAccount(User $user): Response
    {
        return $this->render('dashboard/petsearch/user/account/show.html.twig', [
            'user' => $user,
        ]);
    }


    /**
     * Permet d'afficher et de traiter le formulaire de modification de profil User
     *
     * @Route("/admin/user-accounts/{iduser}/update", name="account_profile")
     * 
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     *
     * @param EntityManagerInterface $emi
     * @param Request $request
     * @return Response
     */
    public function userEdit(Request $request, User $user, EntityManagerInterface $emi): Response
    {
        $emi = $this->getDoctrine()->getManager('customer');

        $form =$this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $emi->persist($user);
            $emi->flush();

            $this->addFlash('success', "Le compte utilisateur <strong>{$user->getFirstName()} {$user->getLastName()} </strong> a été modifié avec succès");

            return $this->redirectToRoute('admin_user_account_show', [
                'iduser' => $user->getIduser(),
            ]);

        }

        return $this->render('dashboard/petsearch/user/account/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/admin/user-accounts/{iduser}/delete", name="account_delete")
     *
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @param EntityManagerInterface $emi
     * @param User $user
     * @return Response
     */
    public function userDeleteAccount(User $user, EntityManagerInterface $emi): Response
    {
        $emi = $this->getDoctrine()->getManager('customer');
        $emi->remove($user);
        $emi->flush();

        $this->addFlash('danger', "Compte supprimé avec succès");

        return $this->redirectToRoute('accounts_index');
    }

}
