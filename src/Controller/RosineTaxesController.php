<?php

namespace App\Controller;

use App\Entity\RosineTaxes;
use App\Form\RosineTaxesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rosine/taxes")
 */
class RosineTaxesController extends AbstractController
{
    /**
     * @Route("/", name="rosine_taxes_index", methods={"GET"})
     */
    public function index(): Response
    {
        $rosineTaxes = $this->getDoctrine()
            ->getRepository(RosineTaxes::class)
            ->findAll();

        return $this->render('rosine_taxes/index.html.twig', [
            'rosine_taxes' => $rosineTaxes,
        ]);
    }

    /**
     * @Route("/new", name="rosine_taxes_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rosineTax = new RosineTaxes();
        $form = $this->createForm(RosineTaxesType::class, $rosineTax);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rosineTax);
            $entityManager->flush();

            return $this->redirectToRoute('rosine_taxes_index');
        }

        return $this->render('rosine_taxes/new.html.twig', [
            'rosine_tax' => $rosineTax,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{taxId}", name="rosine_taxes_show", methods={"GET"})
     */
    public function show(RosineTaxes $rosineTax): Response
    {
        return $this->render('rosine_taxes/show.html.twig', [
            'rosine_tax' => $rosineTax,
        ]);
    }

    /**
     * @Route("/{taxId}/edit", name="rosine_taxes_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RosineTaxes $rosineTax): Response
    {
        $form = $this->createForm(RosineTaxesType::class, $rosineTax);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rosine_taxes_index');
        }

        return $this->render('rosine_taxes/edit.html.twig', [
            'rosine_tax' => $rosineTax,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{taxId}", name="rosine_taxes_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RosineTaxes $rosineTax): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rosineTax->getTaxId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rosineTax);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rosine_taxes_index');
    }
}
