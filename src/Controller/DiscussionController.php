<?php

namespace App\Controller;

use App\Entity\Discussion;
use App\Form\DiscussionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/discussion")
 */
class DiscussionController extends AbstractController
{
    /**
     * @Route("/", name="discussion_index", methods={"GET"})
     */
    public function index(): Response
    {
        $discussions = $this->getDoctrine()
            ->getRepository(Discussion::class)
            ->findAll();

        return $this->render('discussion/index.html.twig', [
            'discussions' => $discussions,
        ]);
    }

    /**
     * @Route("/new", name="discussion_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = $this->getUser();
        $discussion = new Discussion(1,$user);
        $form = $this->createForm(DiscussionType::class, $discussion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($discussion);
            
            $entityManager->flush();

            return $this->redirectToRoute('discussion_index');
        }

        return $this->render('discussion/new.html.twig', [
            'discussion' => $discussion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="discussion_show", methods={"GET"})
     */
    public function show(Discussion $discussion): Response
    {
        return $this->render('discussion/show.html.twig', [
            'discussion' => $discussion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="discussion_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Discussion $discussion): Response
    {
        $form = $this->createForm(DiscussionType::class, $discussion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('discussion_index');
        }

        return $this->render('discussion/edit.html.twig', [
            'discussion' => $discussion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="discussion_delete", methods={"POST"})
     */
    public function delete(Request $request, Discussion $discussion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$discussion->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($discussion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('discussion_index');
    }
}
