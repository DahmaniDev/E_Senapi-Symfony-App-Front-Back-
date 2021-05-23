<?php

namespace App\Controller;

use App\Entity\Entretient;
use App\Entity\Evenement;
use App\Form\EditEvenementType;
use App\Form\EvenementFormType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class EvenementController extends AbstractController
{
    /**
     * @Route("/afficher", name="afficher")
     */
    public function index(EvenementRepository $repository,PaginatorInterface $pagination,Request $request): Response
    {

       $em=$repository->findAll();
        $listeoffre=$pagination->paginate(
            $em,
            $request->query->get('page',1 ),2
        );
        return $this->render('evenement/index.html.twig', [
            'evenement' => $listeoffre
        ]);
    }



    /**
     * @Route("/ajouter", name="ajouter")
     */
    public function addQuest (Request $request)
    {

        $ent= new Evenement();
        $form = $this->createForm(EvenementFormType::class, $ent);
        $form->handleRequest($request);




        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ent);
            $em->flush();





            $this->addFlash('info', 'Envoyer réclamation avec succés !');
            return $this->redirect("/afficher");

        }
        return $this->render("evenement/AjoutEvenement.html.twig",['form'=>$form->createView()]);
    }
    /**
     * @Route("/modifier/{id}", name="modifier")
     */
    public function editQuest(Evenement $evenement, Request $request, EntityManagerInterface $em){

        $form=$this->createForm(EditEvenementType::class,$evenement);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){

            $em->persist($evenement);
            $em->flush();

            return $this->redirect("/afficher");
        }
        return $this->render('evenement/ModifierEvenement.html.twig',
            ['form'=>$form->createView()]);
    }

    /**
     * @Route ("delete/{id}", name="delete")
     */
    public function deleteEnt(Evenement $evenement, EntityManagerInterface $em){

        $em->remove($evenement);
        $em->flush();
        return $this->redirect("/afficher");
    }

    /**
     * @Route("/consulter/{id}", name="consulter", methods={"GET"})
     */
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/ConsulterEvenement.html.twig', [
            'evenement' => $evenement,
        ]);
    }
    /**
     * @param EvenementRepository    $repository
     * @param \Swift_Mailer $mailer
     * @return Response
     * @Route ("/envoyerEmail/{id}",name="envoyerEmail")
     */


}

