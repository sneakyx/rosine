<?php

namespace App\Controller;

use App\Entity\RosinePayments;
use App\Form\RosinePaymentsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rosine/payments")
 */
class RosinePaymentsController extends AbstractController
{
    /**
     * @Route("/", name="rosine_payments_index", methods={"GET"})
     */
    public function index(): Response
    {
        $rosinePayments = $this->getDoctrine()
            ->getRepository(RosinePayments::class)
            ->findAll();

        return $this->render('rosine_payments/index.html.twig', [
            'rosine_payments' => $rosinePayments,
        ]);
    }

    /**
     * @Route("/new", name="rosine_payments_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rosinePayment = new RosinePayments();
        $form = $this->createForm(RosinePaymentsType::class, $rosinePayment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rosinePayment);
            $entityManager->flush();

            return $this->redirectToRoute('rosine_payments_index');
        }

        return $this->render('rosine_payments/new.html.twig', [
            'rosine_payment' => $rosinePayment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{companyId}", name="rosine_payments_show", methods={"GET"})
     */
    public function show(RosinePayments $rosinePayment): Response
    {
        return $this->render('rosine_payments/show.html.twig', [
            'rosine_payment' => $rosinePayment,
        ]);
    }

    /**
     * @Route("/{companyId}/edit", name="rosine_payments_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RosinePayments $rosinePayment): Response
    {
        $form = $this->createForm(RosinePaymentsType::class, $rosinePayment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rosine_payments_index');
        }

        return $this->render('rosine_payments/edit.html.twig', [
            'rosine_payment' => $rosinePayment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{companyId}", name="rosine_payments_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RosinePayments $rosinePayment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rosinePayment->getCompanyId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rosinePayment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rosine_payments_index');
    }
}
