<?php

namespace App\Controller;

use App\Entity\RosineOrdersPositions;
use App\Form\RosineOrdersPositionsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rosine/orders/positions")
 */
class RosineOrdersPositionsController extends AbstractController
{
    /**
     * @Route("/", name="rosine_orders_positions_index", methods={"GET"})
     */
    public function index(): Response
    {
        $rosineOrdersPositions = $this->getDoctrine()
            ->getRepository(RosineOrdersPositions::class)
            ->findAll();

        return $this->render('rosine_orders_positions/index.html.twig', [
            'rosine_orders_positions' => $rosineOrdersPositions,
        ]);
    }

    /**
     * @Route("/new", name="rosine_orders_positions_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rosineOrdersPosition = new RosineOrdersPositions();
        $form = $this->createForm(RosineOrdersPositionsType::class, $rosineOrdersPosition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rosineOrdersPosition);
            $entityManager->flush();

            return $this->redirectToRoute('rosine_orders_positions_index');
        }

        return $this->render('rosine_orders_positions/new.html.twig', [
            'rosine_orders_position' => $rosineOrdersPosition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{companyId}", name="rosine_orders_positions_show", methods={"GET"})
     */
    public function show(RosineOrdersPositions $rosineOrdersPosition): Response
    {
        return $this->render('rosine_orders_positions/show.html.twig', [
            'rosine_orders_position' => $rosineOrdersPosition,
        ]);
    }

    /**
     * @Route("/{companyId}/edit", name="rosine_orders_positions_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RosineOrdersPositions $rosineOrdersPosition): Response
    {
        $form = $this->createForm(RosineOrdersPositionsType::class, $rosineOrdersPosition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rosine_orders_positions_index');
        }

        return $this->render('rosine_orders_positions/edit.html.twig', [
            'rosine_orders_position' => $rosineOrdersPosition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{companyId}", name="rosine_orders_positions_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RosineOrdersPositions $rosineOrdersPosition): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rosineOrdersPosition->getCompanyId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rosineOrdersPosition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rosine_orders_positions_index');
    }
}
