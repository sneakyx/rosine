<?php

namespace App\Controller;

use App\Entity\RosineDraftsPositions;
use App\Form\RosineDraftsPositionsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rosine/drafts/positions")
 */
class RosineDraftsPositionsController extends AbstractController
{
    /**
     * @Route("/", name="rosine_drafts_positions_index", methods={"GET"})
     */
    public function index(): Response
    {
        $rosineDraftsPositions = $this->getDoctrine()
            ->getRepository(RosineDraftsPositions::class)
            ->findAll();

        return $this->render('rosine_drafts_positions/index.html.twig', [
            'rosine_drafts_positions' => $rosineDraftsPositions,
        ]);
    }

    /**
     * @Route("/new", name="rosine_drafts_positions_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rosineDraftsPosition = new RosineDraftsPositions();
        $form = $this->createForm(RosineDraftsPositionsType::class, $rosineDraftsPosition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rosineDraftsPosition);
            $entityManager->flush();

            return $this->redirectToRoute('rosine_drafts_positions_index');
        }

        return $this->render('rosine_drafts_positions/new.html.twig', [
            'rosine_drafts_position' => $rosineDraftsPosition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{companyId}", name="rosine_drafts_positions_show", methods={"GET"})
     */
    public function show(RosineDraftsPositions $rosineDraftsPosition): Response
    {
        return $this->render('rosine_drafts_positions/show.html.twig', [
            'rosine_drafts_position' => $rosineDraftsPosition,
        ]);
    }

    /**
     * @Route("/{companyId}/edit", name="rosine_drafts_positions_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RosineDraftsPositions $rosineDraftsPosition): Response
    {
        $form = $this->createForm(RosineDraftsPositionsType::class, $rosineDraftsPosition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rosine_drafts_positions_index');
        }

        return $this->render('rosine_drafts_positions/edit.html.twig', [
            'rosine_drafts_position' => $rosineDraftsPosition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{companyId}", name="rosine_drafts_positions_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RosineDraftsPositions $rosineDraftsPosition): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rosineDraftsPosition->getCompanyId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rosineDraftsPosition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rosine_drafts_positions_index');
    }
}
