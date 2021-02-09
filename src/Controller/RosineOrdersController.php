<?php

namespace App\Controller;

use App\Entity\RosineOrders;
use App\Form\RosineOrdersType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rosine/orders")
 */
class RosineOrdersController extends AbstractController
{
    /**
     * @Route("/", name="rosine_orders_index", methods={"GET"})
     */
    public function index(): Response
    {
        $rosineOrders = $this->getDoctrine()
            ->getRepository(RosineOrders::class)
            ->findAll();

        return $this->render('rosine_orders/index.html.twig', [
            'rosine_orders' => $rosineOrders,
        ]);
    }

    /**
     * @Route("/new", name="rosine_orders_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rosineOrder = new RosineOrders();
        $form = $this->createForm(RosineOrdersType::class, $rosineOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rosineOrder);
            $entityManager->flush();

            return $this->redirectToRoute('rosine_orders_index');
        }

        return $this->render('rosine_orders/new.html.twig', [
            'rosine_order' => $rosineOrder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{companyId}", name="rosine_orders_show", methods={"GET"})
     */
    public function show(RosineOrders $rosineOrder): Response
    {
        return $this->render('rosine_orders/show.html.twig', [
            'rosine_order' => $rosineOrder,
        ]);
    }

    /**
     * @Route("/{companyId}/edit", name="rosine_orders_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RosineOrders $rosineOrder): Response
    {
        $form = $this->createForm(RosineOrdersType::class, $rosineOrder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rosine_orders_index');
        }

        return $this->render('rosine_orders/edit.html.twig', [
            'rosine_order' => $rosineOrder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{companyId}", name="rosine_orders_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RosineOrders $rosineOrder): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rosineOrder->getCompanyId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rosineOrder);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rosine_orders_index');
    }
}
