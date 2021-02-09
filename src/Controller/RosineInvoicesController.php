<?php

namespace App\Controller;

use App\Entity\RosineInvoices;
use App\Form\RosineInvoicesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rosine/invoices")
 */
class RosineInvoicesController extends AbstractController
{
    /**
     * @Route("/", name="rosine_invoices_index", methods={"GET"})
     */
    public function index(): Response
    {
        $rosineInvoices = $this->getDoctrine()
            ->getRepository(RosineInvoices::class)
            ->findAll();

        return $this->render('rosine_invoices/index.html.twig', [
            'rosine_invoices' => $rosineInvoices,
        ]);
    }

    /**
     * @Route("/new", name="rosine_invoices_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rosineInvoice = new RosineInvoices();
        $form = $this->createForm(RosineInvoicesType::class, $rosineInvoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rosineInvoice);
            $entityManager->flush();

            return $this->redirectToRoute('rosine_invoices_index');
        }

        return $this->render('rosine_invoices/new.html.twig', [
            'rosine_invoice' => $rosineInvoice,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{companyId}", name="rosine_invoices_show", methods={"GET"})
     */
    public function show(RosineInvoices $rosineInvoice): Response
    {
        return $this->render('rosine_invoices/show.html.twig', [
            'rosine_invoice' => $rosineInvoice,
        ]);
    }

    /**
     * @Route("/{companyId}/edit", name="rosine_invoices_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RosineInvoices $rosineInvoice): Response
    {
        $form = $this->createForm(RosineInvoicesType::class, $rosineInvoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rosine_invoices_index');
        }

        return $this->render('rosine_invoices/edit.html.twig', [
            'rosine_invoice' => $rosineInvoice,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{companyId}", name="rosine_invoices_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RosineInvoices $rosineInvoice): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rosineInvoice->getCompanyId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rosineInvoice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rosine_invoices_index');
    }
}
