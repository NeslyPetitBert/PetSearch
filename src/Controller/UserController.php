<?php

namespace App\Controller;

use App\Entity\Main\AdminUser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\Security\Core\Exception\AccessDeniedException;
//use Symfony\Component\Security\Core\User\UserInterface;


class UserController extends AbstractController
{
    // @Security("is_granted('ROLE_USER')", message="Vous n'êtes pas autorisé à effectuer cette action !")
    
    /**
     * @Route("/user/{id}", name="user_show")
     * 
     * 
     *
     * @param AdminUser $adminUser
     * @return Response
     */
    public function showUser(AdminUser $adminUser)
    {
        return $this->render('user/index.html.twig', [
            'adminUser' => $adminUser,
        ]);
    }

}
