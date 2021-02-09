<?php

namespace App\Controller;

use App\Entity\RosineOffers;
use App\Form\RosineOffersType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rosine/offers")
 */
class RosineOffersController extends AbstractController
{
    /**
     * @Route("/", name="rosine_offers_index", methods={"GET"})
     */
    public function index(): Response
    {
        $rosineOffers = $this->getDoctrine()
            ->getRepository(RosineOffers::class)
            ->findAll();

        return $this->render('rosine_offers/index.html.twig', [
            'rosine_offers' => $rosineOffers,
        ]);
    }

    /**
     * @Route("/new", name="rosine_offers_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rosineOffer = new RosineOffers();
        $form = $this->createForm(RosineOffersType::class, $rosineOffer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rosineOffer);
            $entityManager->flush();

            return $this->redirectToRoute('rosine_offers_index');
        }

        return $this->render('rosine_offers/new.html.twig', [
            'rosine_offer' => $rosineOffer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{companyId}", name="rosine_offers_show", methods={"GET"})
     */
    public function show(RosineOffers $rosineOffer): Response
    {
        return $this->render('rosine_offers/show.html.twig', [
            'rosine_offer' => $rosineOffer,
        ]);
    }

    /**
     * @Route("/{companyId}/edit", name="rosine_offers_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RosineOffers $rosineOffer): Response
    {
        $form = $this->createForm(RosineOffersType::class, $rosineOffer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rosine_offers_index');
        }

        return $this->render('rosine_offers/edit.html.twig', [
            'rosine_offer' => $rosineOffer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{companyId}", name="rosine_offers_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RosineOffers $rosineOffer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rosineOffer->getCompanyId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rosineOffer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rosine_offers_index');
    }
}
