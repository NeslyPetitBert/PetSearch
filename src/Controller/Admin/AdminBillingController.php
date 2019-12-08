<?php

namespace App\Controller\Admin;

use App\Form\BillingType;
use App\Entity\Secondary\Billing;
use App\Repository\BillingRepository;
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
class AdminBillingController extends AbstractController
{
    private $billingRepo;

    public function __construct(BillingRepository $billingRepo)
    {
        $this->billingRepo = $billingRepo;
    }
    
    /**
     * Permet d'afficher les factures Billing
     *
     * @Route("/admin/billings", name="billings_index")
     * 
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @return Response
     */
    public function billingsAll(Request $request, PaginatorInterface $paginator) : Response
    {

        // Les stats :
        $billings_somme = $this->billingRepo->getSommeBilling();
        $billings_nb_inactif = $this->billingRepo->getNbBillInactif();
        $billings_nb_actif = $this->billingRepo->getNbBillActif();

        // Le tableau des billings :
        $billings = $paginator->paginate(
            $this->billingRepo->findAll(),
            $request->query->getInt('page', 1),
            10);

        return $this->render('dashboard/petsearch/billing/index.html.twig', [
            // Le tableau des billings
            'billings' => $billings,

            // Les stats
            'billings_somme' => $billings_somme,
            'billings_nb_inactif' => $billings_nb_inactif,
            'billings_nb_actif' => $billings_nb_actif,
        ]);
    }


    /**
     * Permet d'afficher et de traiter le formulaire de création de facture Billing
     *
     * @Route("/admin/billings/new", name="billing_register")
     *
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @param EntityManagerInterface $emi
     * @param Request $request
     * @return Response
     */
    public function billingCreate(Request $request, EntityManagerInterface $emi): Response
    {
        $emi = $this->getDoctrine()->getManager('customer');

        $billing = new Billing();
        
        $form = $this->createForm(BillingType::class, $billing);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $emi->persist($billing);
            $emi->flush();

            $this->addFlash('success', "La facture a été créée avec succès");

            return $this->redirectToRoute('admin_billing_show', [
                'idbilling' => $billing->getIdbilling(),
            ]);

        }

        return $this->render('dashboard/petsearch/billing/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher une facture Billing
     * 
     * @Route("/admin/billings/{idbilling}", name="admin_billing_show", methods={"GET"})
     * 
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @param Billing $billing
     * @return Response
     */
    public function adminShowBilling(Billing $billing): Response
    {
        return $this->render('dashboard/petsearch/billing/show.html.twig', [
            'billing' => $billing,
        ]);
    }


    /**
     * Permet d'afficher et de traiter le formulaire de modification d'une facture Billing
     *
     * @Route("/admin/billings/{idbilling}/update", name="billing_edit")
     * 
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     *
     * @param EntityManagerInterface $emi
     * @param Billing $billing
     * @param Request $request
     * @return Response
     */
    public function billingEdit(Request $request, Billing $billing, EntityManagerInterface $emi): Response
    {
        $emi = $this->getDoctrine()->getManager('customer');

        $form =$this->createForm(BillingType::class, $billing);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $emi->persist($billing);
            $emi->flush();

            $this->addFlash('success', "La facture a été modifié avec succès");

            return $this->redirectToRoute('admin_billing_show', [
                'idbilling' => $billing->getIdbilling(),
            ]);

        }

        return $this->render('dashboard/petsearch/billing/edit.html.twig', [
            'form' => $form->createView(),
            'billing' => $billing,
        ]);
    }

    /**
     * Permet de supprimer une facture Billing
     * 
     * @Route("/admin/billings/{idbilling}/delete", name="billing_delete")
     *
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @param EntityManagerInterface $emi
     * @param Billing $billing
     * @return Response
     */
    public function billingDelete(Billing $billing, EntityManagerInterface $emi): Response
    {
        $emi = $this->getDoctrine()->getManager('customer');

        $emi->remove($billing);
        $emi->flush();

        $this->addFlash('danger', "Facture supprimée avec succès");

        return $this->redirectToRoute('billings_index');
    }

}
