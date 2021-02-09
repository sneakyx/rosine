<?php

namespace App\Controller;

use App\Entity\RosineLocations;
use App\Form\RosineLocationsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rosine/locations")
 */
class RosineLocationsController extends AbstractController
{
    /**
     * @Route("/", name="rosine_locations_index", methods={"GET"})
     */
    public function index(): Response
    {
        $rosineLocations = $this->getDoctrine()
            ->getRepository(RosineLocations::class)
            ->findAll();

        return $this->render('rosine_locations/index.html.twig', [
            'rosine_locations' => $rosineLocations,
        ]);
    }

    /**
     * @Route("/new", name="rosine_locations_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rosineLocation = new RosineLocations();
        $form = $this->createForm(RosineLocationsType::class, $rosineLocation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rosineLocation);
            $entityManager->flush();

            return $this->redirectToRoute('rosine_locations_index');
        }

        return $this->render('rosine_locations/new.html.twig', [
            'rosine_location' => $rosineLocation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{locId}", name="rosine_locations_show", methods={"GET"})
     */
    public function show(RosineLocations $rosineLocation): Response
    {
        return $this->render('rosine_locations/show.html.twig', [
            'rosine_location' => $rosineLocation,
        ]);
    }

    /**
     * @Route("/{locId}/edit", name="rosine_locations_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RosineLocations $rosineLocation): Response
    {
        $form = $this->createForm(RosineLocationsType::class, $rosineLocation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rosine_locations_index');
        }

        return $this->render('rosine_locations/edit.html.twig', [
            'rosine_location' => $rosineLocation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{locId}", name="rosine_locations_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RosineLocations $rosineLocation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rosineLocation->getLocId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rosineLocation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rosine_locations_index');
    }
}
