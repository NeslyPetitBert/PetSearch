<?php

namespace App\Controller;

use App\Entity\Main\AdminUser;
use App\Form\AccountType;
use App\Entity\Main\PasswordUpdate;
use App\Form\RegistrationType;
use App\Form\PasswordUpdateType;
use Symfony\Component\Form\FormError;
use App\Repository\AdminUserRepository;
//use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
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
     * Permet d'afficher et de gérer le formulaire de connexion
     *
     * @Route("/login", name="account_login")
     *
     * @param AuthenticationUtils $utils
     * @return Response
     */
    public function login(AuthenticationUtils $utils): Response
    {
        $error = $utils->getLastAuthenticationError();
        $user = $utils->getLastUsername();

        return $this->render('petsearch/user/account/login.html.twig', [
            'hasError' => $error != null,
            'userName' => $user,
        ]);
    }


    /**
     * Permet de se déconnecter
     *
     * @Route("/logout", name="account_logout")
     *
     * @return void
     */
    public function logout(): void
    {

    }


    /**
     * Permet d'afficher le formulaire d'inscription
     *
     * @Route("/new-account", name="account_register")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        //instantiation AdminUser
        $user = new AdminUser();

        //create form to registering the Adminuser
        $form = $this->createForm(RegistrationType::class, $user);

        //data recovery via http request
        $form->handleRequest($request);

        //Verification of the form to see if it has been submitted and if it is valid
        if($form->isSubmitted() && $form->isValid()){
            //password encoding
            $hash = $encoder->encodePassword($user, $user->getHash());
            $user->setHash($hash);
            //persistence of the user
            $this->manager->persist($user);
            //registering the user in the database
            $this->manager->flush();

            // flash message
            $this->addFlash('success', "Le compte utilisateur <strong>{$user->getFullName()} </strong> a été créé avec succès, vous pouvez dès à présent vous connecter...");

            return $this->redirectToRoute('account_login');

        }

        return $this->render('petsearch/user/account/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    // @Security("is_granted('ROLE_USER')") 
    /**
     * Permet d'afficher et de traiter le formulaire de modification de profil
     *
     * @Route("/account/profil-update", name="account_profile")
     * 
     * 
     *
     * @param Request $request
     * @return Response
     */
    public function profile(Request $request): Response
    {
        $user = $this->getUser();

        $form =$this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->manager->persist($user);
            $this->manager->flush();

            $this->addFlash('success', "Votre compte utilisateur <strong>{$user->getFullName()} </strong>  a été modifié avec succès");

            return $this->redirectToRoute('account_profile');

        }

        return $this->render('petsearch/user/account/profile.html.twig', [
            'form' => $form->createView(),
            'adminUser' => $user,
        ]);
    }

    // @Security("is_granted('ROLE_USER')")
    /**
     * Permet d'afficher et de traiter le formulaire de modification de mot de passe
     *
     * @Route("/account/password-update", name="account_password")
     *
     * 
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        // Insctanciation de PasswordUpdate.
        $passwordUpdate = new PasswordUpdate();

        // Récupération de l'utilisateur connecter
        $user = $this->getUser();

        $form =$this->createForm(PasswordUpdateType::class, $passwordUpdate);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //Comparaison du oldPassword au password de l'user actuellement récupéré.
            if(!password_verify($passwordUpdate->getOldPassword(), $user->getHash())){
                // Si erreur
                $form->get('oldPassword')->addError(new FormError("Le mot de passe que vous avez tapé ne correspond pas à votre mot de passe actuel."));

            }else{
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->encodePassword($user, $newPassword);
                $user->setHash($hash);
                $this->manager->persist($user);
                $this->manager->flush();

                $this->addFlash('success', "Votre mot de passe a été modifié avec succès");

                return $this->redirectToRoute('account_profile');
            }

        }

        return $this->render('petsearch/user/account/update_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // @Security("is_granted('ROLE_USER')")
    /**
     * Permet d'afficher le profil de l'utilisateur connecté
     *
     * @Route("/account", name="account_index")
     *
     * 
     *
     * @return Response
     */
    public function myAccount() : Response
    {
        return $this->render('petsearch/user/account/index.html.twig', [
            'adminUser' => $this->getUser(),
        ]);
    }
}
