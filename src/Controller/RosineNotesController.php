<?php

namespace App\Controller;

use App\Entity\RosineNotes;
use App\Form\RosineNotesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rosine/notes")
 */
class RosineNotesController extends AbstractController
{
    /**
     * @Route("/", name="rosine_notes_index", methods={"GET"})
     */
    public function index(): Response
    {
        $rosineNotes = $this->getDoctrine()
            ->getRepository(RosineNotes::class)
            ->findAll();

        return $this->render('rosine_notes/index.html.twig', [
            'rosine_notes' => $rosineNotes,
        ]);
    }

    /**
     * @Route("/new", name="rosine_notes_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rosineNote = new RosineNotes();
        $form = $this->createForm(RosineNotesType::class, $rosineNote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rosineNote);
            $entityManager->flush();

            return $this->redirectToRoute('rosine_notes_index');
        }

        return $this->render('rosine_notes/new.html.twig', [
            'rosine_note' => $rosineNote,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{noteId}", name="rosine_notes_show", methods={"GET"})
     */
    public function show(RosineNotes $rosineNote): Response
    {
        return $this->render('rosine_notes/show.html.twig', [
            'rosine_note' => $rosineNote,
        ]);
    }

    /**
     * @Route("/{noteId}/edit", name="rosine_notes_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RosineNotes $rosineNote): Response
    {
        $form = $this->createForm(RosineNotesType::class, $rosineNote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rosine_notes_index');
        }

        return $this->render('rosine_notes/edit.html.twig', [
            'rosine_note' => $rosineNote,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{noteId}", name="rosine_notes_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RosineNotes $rosineNote): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rosineNote->getNoteId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rosineNote);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rosine_notes_index');
    }
}
