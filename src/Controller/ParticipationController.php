<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Participation;
use App\Entity\User;
use App\Repository\EvenementRepository;
use App\Repository\ParticipationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class ParticipationController extends AbstractController
{
    /**
         * @Route("/parti", name="parti")
     */
    public function index(EvenementRepository $repositoryE,ParticipationRepository $repositoryP, PaginatorInterface $pagination, Request $request): Response
    {

        $em=$repositoryE->findAll();
        $ep=$repositoryP->findAll();

        $listeoffre=$pagination->paginate(
            $em,
            $request->query->get('page',1 ),3
        );

        return $this->render('participation/index.html.twig', [
            'evenement' => $listeoffre
        ]);
    }


    /**
     * @Route("/participer/{idu}/{id}", name="abonner")
     */
    public function show(\Symfony\Component\Security\Core\User\UserInterface $u,Evenement $evenement,EvenementRepository  $repository,\Swift_Mailer $mailer,ParticipationRepository $repositoryP): Response
    {
        $p=new Participation();
        $p->setIdUser($u);
        $c=$evenement->getId();
        $p->setIdEvenement($c);
        $em = $this->getDoctrine()->getManager();
        $em=$repositoryP->findBy(array('idUser' => $u->getId(), 'idEvenement' => $c));
        if ($em!=null){
            echo "<script>alert(\"Vous avez deja..    \")</script>";
            return $this->redirectToRoute('parti');
        }else {


            $ep = $this->getDoctrine()->getManager();
            $ep->persist($p);
            $ep->flush();
            $evenement->setNbmaxparticipants($evenement->getNbmaxparticipants() - 1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();


            $email = $u->getEmail();
            $message = (new \Swift_Message('' . $evenement->getTitre()))
                ->setFrom('testt121095@gmail.com')
                ->setTo($email)
                ->setBody(
                    'Vous êtes abonnée a l\'evenement ' . $evenement->getTitre()
                );
            $mailer->send($message);


            return $this->redirectToRoute('parti');
        }


    }

    /**
     * @Route("/desabonner/{idu}/{id}", name="desabonner")
     */
    public function desabonne(\Symfony\Component\Security\Core\User\UserInterface $u,Evenement $evenement,ParticipationRepository  $repository,\Swift_Mailer $mailer): Response
    {
        $p=new Participation();
        $p=$repository->findOneBy(array('idUser' => $u, 'idEvenement' => $evenement));



        $em = $this->getDoctrine()->getManager();


        $em->remove($p);
        $em->flush();
        $evenement->setNbmaxparticipants($evenement->getNbmaxparticipants()+1);

        $em->persist($evenement);
        $em->flush();


        return $this->redirectToRoute('parti');



    }

    /**
     * @Route("/consulterparticipation/{id}", name="consulterparticipation", methods={"GET"})
     */
    public function cons(Evenement $evenement): Response
    {
        return $this->render('participation/ConsulterEvenement.html.twig', [
            'evenement' => $evenement,
        ]);
    }


    /**
     * @Route("/listparticipation/{id}", name="listparticipation")
     */
    public function index1(\Symfony\Component\Security\Core\User\UserInterface $u,EvenementRepository $repositoryE,ParticipationRepository $repositoryP): Response
    {

        $em=$repositoryE->findAll();
        $ep=$repositoryP->findByIdUser($u);
        return $this->render('participation/list.html.twig', [
            'evenement' => $em,'participation'=> $ep
        ]);
    }




}
