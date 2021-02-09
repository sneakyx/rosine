<?php

namespace App\Controller;

use App\Entity\RosinePaymentsMethods;
use App\Form\RosinePaymentsMethodsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rosine/payments/methods")
 */
class RosinePaymentsMethodsController extends AbstractController
{
    /**
     * @Route("/", name="rosine_payments_methods_index", methods={"GET"})
     */
    public function index(): Response
    {
        $rosinePaymentsMethods = $this->getDoctrine()
            ->getRepository(RosinePaymentsMethods::class)
            ->findAll();

        return $this->render('rosine_payments_methods/index.html.twig', [
            'rosine_payments_methods' => $rosinePaymentsMethods,
        ]);
    }

    /**
     * @Route("/new", name="rosine_payments_methods_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rosinePaymentsMethod = new RosinePaymentsMethods();
        $form = $this->createForm(RosinePaymentsMethodsType::class, $rosinePaymentsMethod);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rosinePaymentsMethod);
            $entityManager->flush();

            return $this->redirectToRoute('rosine_payments_methods_index');
        }

        return $this->render('rosine_payments_methods/new.html.twig', [
            'rosine_payments_method' => $rosinePaymentsMethod,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{methId}", name="rosine_payments_methods_show", methods={"GET"})
     */
    public function show(RosinePaymentsMethods $rosinePaymentsMethod): Response
    {
        return $this->render('rosine_payments_methods/show.html.twig', [
            'rosine_payments_method' => $rosinePaymentsMethod,
        ]);
    }

    /**
     * @Route("/{methId}/edit", name="rosine_payments_methods_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RosinePaymentsMethods $rosinePaymentsMethod): Response
    {
        $form = $this->createForm(RosinePaymentsMethodsType::class, $rosinePaymentsMethod);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rosine_payments_methods_index');
        }

        return $this->render('rosine_payments_methods/edit.html.twig', [
            'rosine_payments_method' => $rosinePaymentsMethod,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{methId}", name="rosine_payments_methods_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RosinePaymentsMethods $rosinePaymentsMethod): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rosinePaymentsMethod->getMethId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rosinePaymentsMethod);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rosine_payments_methods_index');
    }
}
