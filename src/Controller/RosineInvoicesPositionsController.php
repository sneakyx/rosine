<?php

namespace App\Controller;

use App\Entity\RosineInvoicesPositions;
use App\Form\RosineInvoicesPositionsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rosine/invoices/positions")
 */
class RosineInvoicesPositionsController extends AbstractController
{
    /**
     * @Route("/", name="rosine_invoices_positions_index", methods={"GET"})
     */
    public function index(): Response
    {
        $rosineInvoicesPositions = $this->getDoctrine()
            ->getRepository(RosineInvoicesPositions::class)
            ->findAll();

        return $this->render('rosine_invoices_positions/index.html.twig', [
            'rosine_invoices_positions' => $rosineInvoicesPositions,
        ]);
    }

    /**
     * @Route("/new", name="rosine_invoices_positions_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rosineInvoicesPosition = new RosineInvoicesPositions();
        $form = $this->createForm(RosineInvoicesPositionsType::class, $rosineInvoicesPosition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rosineInvoicesPosition);
            $entityManager->flush();

            return $this->redirectToRoute('rosine_invoices_positions_index');
        }

        return $this->render('rosine_invoices_positions/new.html.twig', [
            'rosine_invoices_position' => $rosineInvoicesPosition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{companyId}", name="rosine_invoices_positions_show", methods={"GET"})
     */
    public function show(RosineInvoicesPositions $rosineInvoicesPosition): Response
    {
        return $this->render('rosine_invoices_positions/show.html.twig', [
            'rosine_invoices_position' => $rosineInvoicesPosition,
        ]);
    }

    /**
     * @Route("/{companyId}/edit", name="rosine_invoices_positions_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RosineInvoicesPositions $rosineInvoicesPosition): Response
    {
        $form = $this->createForm(RosineInvoicesPositionsType::class, $rosineInvoicesPosition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rosine_invoices_positions_index');
        }

        return $this->render('rosine_invoices_positions/edit.html.twig', [
            'rosine_invoices_position' => $rosineInvoicesPosition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{companyId}", name="rosine_invoices_positions_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RosineInvoicesPositions $rosineInvoicesPosition): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rosineInvoicesPosition->getCompanyId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rosineInvoicesPosition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rosine_invoices_positions_index');
    }
}
