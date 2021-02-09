<?php

namespace App\Controller;

use App\Entity\RosineDeliveriesPositions;
use App\Form\RosineDeliveriesPositionsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rosine/deliveries/positions")
 */
class RosineDeliveriesPositionsController extends AbstractController
{
    /**
     * @Route("/", name="rosine_deliveries_positions_index", methods={"GET"})
     */
    public function index(): Response
    {
        $rosineDeliveriesPositions = $this->getDoctrine()
            ->getRepository(RosineDeliveriesPositions::class)
            ->findAll();

        return $this->render('rosine_deliveries_positions/index.html.twig', [
            'rosine_deliveries_positions' => $rosineDeliveriesPositions,
        ]);
    }

    /**
     * @Route("/new", name="rosine_deliveries_positions_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rosineDeliveriesPosition = new RosineDeliveriesPositions();
        $form = $this->createForm(RosineDeliveriesPositionsType::class, $rosineDeliveriesPosition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rosineDeliveriesPosition);
            $entityManager->flush();

            return $this->redirectToRoute('rosine_deliveries_positions_index');
        }

        return $this->render('rosine_deliveries_positions/new.html.twig', [
            'rosine_deliveries_position' => $rosineDeliveriesPosition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{companyId}", name="rosine_deliveries_positions_show", methods={"GET"})
     */
    public function show(RosineDeliveriesPositions $rosineDeliveriesPosition): Response
    {
        return $this->render('rosine_deliveries_positions/show.html.twig', [
            'rosine_deliveries_position' => $rosineDeliveriesPosition,
        ]);
    }

    /**
     * @Route("/{companyId}/edit", name="rosine_deliveries_positions_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RosineDeliveriesPositions $rosineDeliveriesPosition): Response
    {
        $form = $this->createForm(RosineDeliveriesPositionsType::class, $rosineDeliveriesPosition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rosine_deliveries_positions_index');
        }

        return $this->render('rosine_deliveries_positions/edit.html.twig', [
            'rosine_deliveries_position' => $rosineDeliveriesPosition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{companyId}", name="rosine_deliveries_positions_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RosineDeliveriesPositions $rosineDeliveriesPosition): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rosineDeliveriesPosition->getCompanyId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rosineDeliveriesPosition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rosine_deliveries_positions_index');
    }
}
