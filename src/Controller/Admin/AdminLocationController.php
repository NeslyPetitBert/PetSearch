<?php

namespace App\Controller\Admin;

use App\Form\LocationType;
use App\Entity\Secondary\Location;
use App\Repository\LocationRepository;
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
class AdminLocationController extends AbstractController
{
    private $locRepo;

    public function __construct(LocationRepository $locRepo)
    {
        $this->locRepo = $locRepo;
    }
    
    /**
     * Permet d'afficher les localisations Location
     *
     * @Route("/admin/locations", name="locations_index")
     * 
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @return Response
     */
    public function locationsAll(Request $request, PaginatorInterface $paginator) : Response
    {

        $locations = $paginator->paginate(
            $this->locRepo->findAll(),
            $request->query->getInt('page', 1),
            10);

        return $this->render('dashboard/petsearch/location/index.html.twig', [
            'locations' => $locations,
        ]);
    }


    /**
     * Permet d'afficher et de traiter le formulaire de création d'une localisation Location
     *
     * @Route("/admin/locations/new", name="location_register")
     *
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function locationCreate(Request $request): Response
    {
        
        $emi = $this->getDoctrine()->getManager('customer');

        $location = new Location();
        
        $form = $this->createForm(LocationType::class, $location);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $emi->persist($location);
            $emi->flush();

            $this->addFlash('success', "La localisation a été créée avec succès");

            return $this->redirectToRoute('admin_location_show', [
                'idlocation' => $location->getIdlocation(),
            ]);

        }

        return $this->render('dashboard/petsearch/location/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher une localisation Location
     * 
     * @Route("/admin/locations/{idlocation}", name="admin_location_show", methods={"GET"})
     * 
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @param Location $location
     * @return Response
     */
    public function adminShowLocation(Location $location): Response
    {
        return $this->render('dashboard/petsearch/location/show.html.twig', [
            'location' => $location,
        ]);
    }


    /**
     * Permet d'afficher et de traiter le formulaire de modification d'une localisation Location
     *
     * @Route("/admin/locations/{idlocation}/update", name="location_edit")
     * 
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     *
     * @param Location $location
     * @param Request $request
     * @return Response
     */
    public function locationEdit(Request $request, Location $location): Response
    {
        $emi = $this->getDoctrine()->getManager('customer');

        $form =$this->createForm(LocationType::class, $location);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $emi->persist($location);
            $emi->flush();

            $this->addFlash('success', "La localisation a été modifiée avec succès");

            return $this->redirectToRoute('admin_location_show', [
                'idlocation' => $location->getIdlocation(),
            ]);

        }

        return $this->render('dashboard/petsearch/location/edit.html.twig', [
            'form' => $form->createView(),
            'location' => $location,
        ]);
    }

    /**
     * Permet de supprimer une Localisation Location
     * 
     * @Route("/admin/locations/{idlocation}/delete", name="location_delete")
     *
     * @Security("is_granted('ROLE_ADMIN')", message="Vous n'êtes pas autorisé à effectuer cette action !")
     * 
     * @param Location $location
     * @return Response
     */
    public function locationDelete(Location $location): Response
    {
        $emi = $this->getDoctrine()->getManager('customer');

        $emi->remove($location);
        $emi->flush();

        $this->addFlash('danger', "Localisation supprimée avec succès");

        return $this->redirectToRoute('locations_index');
    }

}
