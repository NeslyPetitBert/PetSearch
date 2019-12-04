<?php

namespace App\Controller\Admin;

use App\Entity\Main\AdminUser;
use App\Form\AdminAccountType;
use App\Form\AdminRegistrationType;
use App\Repository\AdminUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/dashboard")
 */
class AdminAccountController extends AbstractController
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
     * Permet d'afficher et e gérer le formulaire de connexion
     *
     * @Route("/login", name="admin_account_login")
     *
     * @param AuthenticationUtils $utils
     * @return Response
     */
    public function adminLogin(AuthenticationUtils $utils): Response
    {
        $error = $utils->getLastAuthenticationError();
        $AdminUserName = $utils->getLastUsername();

        return $this->render('dashboard/admin/account/login.html.twig', [
            'hasError' => $error != null,
            'userName' => $AdminUserName,
        ]);
    }

    /**
     * Permet de se déconnecter
     *
     * @Route("/logout", name="admin_account_logout")
     *
     * @return void
     */
    public function logout(): void {}



    /**
     * Permet d'afficher les comptes utilisateurs créés
     *
     * @Route("/accounts", name="admin_accounts_index")
     * 
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @return Response
     */
    public function adminUserAccount() : Response
    {
        $adminUsers = $this->adminUserRepo()->findAll();
        return $this->render('dashboard/admin/account/index.html.twig', [
            'adminUsers' => $adminUsers,
        ]);
    }


    /**
     * Permet d'afficher le formulaire d'inscription
     *
     * @Route("/accounts/add", name="admin_account_new")
     * 
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @return Response
     */
    public function adminRegister(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        //instantiation AdminUser
        $adminUser = new AdminUser();

        //create form to registering the AdminUser
        $form = $this->createForm(AdminRegistrationType::class, $adminUser);

        //data recovery via http request
        $form->handleRequest($request);

        //Verification of the form to see if it has been submitted and if it is valid
        if($form->isSubmitted() && $form->isValid()){
            //password encoding
            $hash = $encoder->encodePassword($adminUser, $adminUser->getHash());
            $adminUser->setHash($hash);
            //persistence of the adminUser
            $this->manager->persist($adminUser);
            //registering the adminUser in the database
            $this->manager->flush();

            // flash message
            $this->addFlash('success', "Le compte utilisateur <strong>{$adminUser->getFullName()} </strong> a été créé avec succès");

            return $this->redirectToRoute('admin_account_show', [
                'adminUser' => $adminUser,
                'id' => $adminUser->getId(),
            ]);

        }

        return $this->render('dashboard/admin/account/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    // @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")

    /**
     * @Route("/accounts/{id}", name="admin_account_show", methods={"GET"})
     * 
     * @param AdminUser $adminUser
     * @return Response
     */
    public function adminShowAccount(AdminUser $adminUser): Response
    {
        return $this->render('dashboard/admin/account/show.html.twig', [
            'adminUser' => $adminUser,
        ]);
    }


    /**
     * Permet d'afficher et de traiter le formulaire de modification de profil
     *
     * @Route("/accounts/{id}/modify", name="admin_account_edit")
     *
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @param Request $request
     * @param AdminUser $adminUser
     * @return Response
     */
    public function adminUserProfile(Request $request, AdminUser $adminUser): Response
    {
        // $user = $this->getUser();

        $form =$this->createForm(AdminAccountType::class, $adminUser);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($adminUser);
            $this->manager->flush();

            $this->addFlash('success', "Le compte utilisateur <strong>{$adminUser->getFullName()} </strong> a été modifié avec succès");

            return $this->redirectToRoute('admin_account_show', [
                'id' => $adminUser->getId(),
            ]);

        }

        return $this->render('dashboard/admin/account/edit.html.twig', [
            'form' => $form->createView(),
            'adminUser' => $adminUser,
        ]);
    }


    /**
     * Permet d'afficher et de traiter le formulaire de modification de profil de l'administrateur connecté
     *
     * @Route("/account/profile", name="admin_account_profile")
     *
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @param Request $request
     * @return Response
     */
    public function profile(Request $request): Response
    {
        $adminUser = $this->getUser();

        $form =$this->createForm(AdminAccountType::class, $adminUser);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($adminUser);
            $this->manager->flush();

            $this->addFlash('success', "Votre compte administrateur a été modifié avec succès");

            return $this->redirectToRoute('account_profile');

        }

        return $this->render('dashboard/admin/account/profile.html.twig', [
            'form' => $form->createView(),
            'user' => $adminUser,
        ]);
    }

    

    /**
     * @Route("/accounts/{id}/remove", name="admin_account_delete")
     *
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @param AdminUser $adminUser
     * @return Response
     */
    public function adminDeleteAccount(AdminUser $adminUser): Response
    {
        $this->manager->remove($adminUser);
        $this->manager->flush();

        $this->addFlash('danger', "Compte supprimé avec succès");

        return $this->redirectToRoute('admin_accounts_index');
    }
}
