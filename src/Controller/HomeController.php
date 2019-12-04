<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="petsearch_home")
     */
    public function home()
    {
        return $this->render('petsearch/home.html.twig');
    }
}
