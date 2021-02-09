<?php

namespace App\Controller;

use App\Entity\RosineConfig;
use App\Form\RosineConfigType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rosine/config")
 */
class RosineConfigController extends AbstractController
{
    /**
     * @Route("/", name="rosine_config_index", methods={"GET"})
     */
    public function index(): Response
    {
        $rosineConfigs = $this->getDoctrine()
            ->getRepository(RosineConfig::class)
            ->findAll();

        return $this->render('rosine_config/index.html.twig', [
            'rosine_configs' => $rosineConfigs,
        ]);
    }

    /**
     * @Route("/new", name="rosine_config_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rosineConfig = new RosineConfig();
        $form = $this->createForm(RosineConfigType::class, $rosineConfig);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rosineConfig);
            $entityManager->flush();

            return $this->redirectToRoute('rosine_config_index');
        }

        return $this->render('rosine_config/new.html.twig', [
            'rosine_config' => $rosineConfig,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{config}", name="rosine_config_show", methods={"GET"})
     */
    public function show(RosineConfig $rosineConfig): Response
    {
        return $this->render('rosine_config/show.html.twig', [
            'rosine_config' => $rosineConfig,
        ]);
    }

    /**
     * @Route("/{config}/edit", name="rosine_config_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RosineConfig $rosineConfig): Response
    {
        $form = $this->createForm(RosineConfigType::class, $rosineConfig);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rosine_config_index');
        }

        return $this->render('rosine_config/edit.html.twig', [
            'rosine_config' => $rosineConfig,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{config}", name="rosine_config_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RosineConfig $rosineConfig): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rosineConfig->getConfig(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rosineConfig);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rosine_config_index');
    }
}
