<?php

namespace App\Controller;

use App\Entity\RosineArticles;
use App\Form\RosineArticlesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rosine/articles")
 */
class RosineArticlesController extends AbstractController
{
    /**
     * @Route("/", name="rosine_articles_index", methods={"GET"})
     */
    public function index(): Response
    {
        $rosineArticles = $this->getDoctrine()
            ->getRepository(RosineArticles::class)
            ->findAll();

        return $this->render('rosine_articles/index.html.twig', [
            'rosine_articles' => $rosineArticles,
        ]);
    }

    /**
     * @Route("/new", name="rosine_articles_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rosineArticle = new RosineArticles();
        $form = $this->createForm(RosineArticlesType::class, $rosineArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rosineArticle);
            $entityManager->flush();

            return $this->redirectToRoute('rosine_articles_index');
        }

        return $this->render('rosine_articles/new.html.twig', [
            'rosine_article' => $rosineArticle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{artNumber}", name="rosine_articles_show", methods={"GET"})
     */
    public function show(RosineArticles $rosineArticle): Response
    {
        return $this->render('rosine_articles/show.html.twig', [
            'rosine_article' => $rosineArticle,
        ]);
    }

    /**
     * @Route("/{artNumber}/edit", name="rosine_articles_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RosineArticles $rosineArticle): Response
    {
        $form = $this->createForm(RosineArticlesType::class, $rosineArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rosine_articles_index');
        }

        return $this->render('rosine_articles/edit.html.twig', [
            'rosine_article' => $rosineArticle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{artNumber}", name="rosine_articles_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RosineArticles $rosineArticle): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rosineArticle->getArtNumber(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rosineArticle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rosine_articles_index');
    }
}
