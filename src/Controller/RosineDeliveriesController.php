<?php

namespace App\Controller;

use App\Entity\RosineDeliveries;
use App\Form\RosineDeliveriesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rosine/deliveries")
 */
class RosineDeliveriesController extends AbstractController
{
    /**
     * @Route("/", name="rosine_deliveries_index", methods={"GET"})
     */
    public function index(): Response
    {
        $rosineDeliveries = $this->getDoctrine()
            ->getRepository(RosineDeliveries::class)
            ->findAll();

        return $this->render('rosine_deliveries/index.html.twig', [
            'rosine_deliveries' => $rosineDeliveries,
        ]);
    }

    /**
     * @Route("/new", name="rosine_deliveries_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rosineDelivery = new RosineDeliveries();
        $form = $this->createForm(RosineDeliveriesType::class, $rosineDelivery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rosineDelivery);
            $entityManager->flush();

            return $this->redirectToRoute('rosine_deliveries_index');
        }

        return $this->render('rosine_deliveries/new.html.twig', [
            'rosine_delivery' => $rosineDelivery,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{companyId}", name="rosine_deliveries_show", methods={"GET"})
     */
    public function show(RosineDeliveries $rosineDelivery): Response
    {
        return $this->render('rosine_deliveries/show.html.twig', [
            'rosine_delivery' => $rosineDelivery,
        ]);
    }

    /**
     * @Route("/{companyId}/edit", name="rosine_deliveries_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RosineDeliveries $rosineDelivery): Response
    {
        $form = $this->createForm(RosineDeliveriesType::class, $rosineDelivery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rosine_deliveries_index');
        }

        return $this->render('rosine_deliveries/edit.html.twig', [
            'rosine_delivery' => $rosineDelivery,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{companyId}", name="rosine_deliveries_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RosineDeliveries $rosineDelivery): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rosineDelivery->getCompanyId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rosineDelivery);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rosine_deliveries_index');
    }
}
