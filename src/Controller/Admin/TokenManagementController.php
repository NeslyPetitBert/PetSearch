<?php

namespace App\Controller\Admin;
 
use App\Entity\Secondary\Token;
use App\Repository\TokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/dashboard")
 */
class TokenManagementController extends AbstractController
{
    private $tokRepo;

    public function __construct(TokenRepository $tokRepo)
    {
        $this->tokRepo = $tokRepo;
    }

    
    /**
     * Permet d'afficher les tokens générés
     * 
     * @Route("/tokens", name="tokens_index")
     * 
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @param Request $request
     * 
     * @param PaginatorInterface $paginator
     */
    public function tokenAll(Request $request, PaginatorInterface $paginator) : Response
    {
        $tokens = $paginator->paginate(
            $this->tokRepo->findAll(),
            $request->query->getInt('page', 1),
            10);

        return $this->render('dashboard/petsearch/token/index.html.twig', [
            'tokens' => $tokens,
        ]);
    }


    /**
     * Permet d'afficher un token
     * 
     * @Route("/admin/tokens/{idtoken}", name="admin_token_show", methods={"GET"})
     * 
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @param Token $token
     * @return Response
     */
    public function adminShowToken(Token $token): Response
    {
        return $this->render('dashboard/petsearch/token/show.html.twig', [
            'token' => $token,
        ]);
    }

    /**
     * Permet de supprimer un token
     * 
     * @Route("/admin/tokens/{idtoken}/delete", name="token_delete")
     *
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @param EntityManagerInterface $emi
     * 
     * @param Token $token
     * @return Response
     */
    public function tokenDelete(Token $token, EntityManagerInterface $emi): Response
    {
        $emi = $this->getDoctrine()->getManager('customer');

        $emi->remove($token);
        $emi->flush();

        $this->addFlash('danger', "Token supprimé avec succès");

        return $this->redirectToRoute('tokens_index');
    }

}
