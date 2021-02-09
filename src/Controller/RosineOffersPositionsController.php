<?php

namespace App\Controller;

use App\Entity\RosineOffersPositions;
use App\Form\RosineOffersPositionsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rosine/offers/positions")
 */
class RosineOffersPositionsController extends AbstractController
{
    /**
     * @Route("/", name="rosine_offers_positions_index", methods={"GET"})
     */
    public function index(): Response
    {
        $rosineOffersPositions = $this->getDoctrine()
            ->getRepository(RosineOffersPositions::class)
            ->findAll();

        return $this->render('rosine_offers_positions/index.html.twig', [
            'rosine_offers_positions' => $rosineOffersPositions,
        ]);
    }

    /**
     * @Route("/new", name="rosine_offers_positions_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rosineOffersPosition = new RosineOffersPositions();
        $form = $this->createForm(RosineOffersPositionsType::class, $rosineOffersPosition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rosineOffersPosition);
            $entityManager->flush();

            return $this->redirectToRoute('rosine_offers_positions_index');
        }

        return $this->render('rosine_offers_positions/new.html.twig', [
            'rosine_offers_position' => $rosineOffersPosition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{companyId}", name="rosine_offers_positions_show", methods={"GET"})
     */
    public function show(RosineOffersPositions $rosineOffersPosition): Response
    {
        return $this->render('rosine_offers_positions/show.html.twig', [
            'rosine_offers_position' => $rosineOffersPosition,
        ]);
    }

    /**
     * @Route("/{companyId}/edit", name="rosine_offers_positions_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RosineOffersPositions $rosineOffersPosition): Response
    {
        $form = $this->createForm(RosineOffersPositionsType::class, $rosineOffersPosition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rosine_offers_positions_index');
        }

        return $this->render('rosine_offers_positions/edit.html.twig', [
            'rosine_offers_position' => $rosineOffersPosition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{companyId}", name="rosine_offers_positions_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RosineOffersPositions $rosineOffersPosition): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rosineOffersPosition->getCompanyId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rosineOffersPosition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rosine_offers_positions_index');
    }
}
