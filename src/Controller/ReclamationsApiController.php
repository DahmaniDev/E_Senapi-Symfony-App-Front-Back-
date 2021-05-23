<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Reclamation;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;

class ReclamationsApiController extends AbstractController
{
    /**
     * @Route("/reclamations_api", name="reclamations_api")
     */
    public function getReclamations(): Response
    {
        
        $donnees = $this->getDoctrine()
            ->getRepository(Reclamation::class)
            ->findAll();
            dump($donnees);
            exit();
        $json = $normalizer->normalize($donnees,'json',['groups'=>'reclamation']);
        return new JsonResponse($json, 200);
    }

    /**
     * @Route("/reclamations_api_by_user", name="reclamations_api_by_user")
     */
    public function getReclamationsByUser(NormalizerInterface $normalizer, Request $request): Response
    {
        
        $idSent=$request->query->get('id');
        $donnees = $this->getDoctrine()
            ->getRepository(Reclamation::class)
            ->findBy(array('idUserRec' => $idSent));
            $json = $normalizer->normalize($donnees,'json',['groups'=>'reclamation']);
        return new JsonResponse($json, 200);
    }

    /**
     * @Route("/reclamations_api_add", name="reclamations_api_add")
     */
    public function addReclamation(NormalizerInterface $normalizer, Request $request, EntityManagerInterface $em): Response
    {
        $reclamation = new Reclamation();
        $reclamation->setStatut("En attente");
        $reclamation->setSujet($request->query->get('sujet'));
        $reclamation->setContenu($request->query->get('contenu'));
        $reclamation->setAdminTrait($request->query->get('idAdmin'));
        

        
            $users = $this->getDoctrine()
                ->getRepository(User::class)
                ->findBy(array('id' => (int)$request->query->get('idUser')));
            
                foreach($users as $user){
                    $reclamation->setIdUser($user);
                }
            if($user == null){
                return new JsonResponse('Not Success : ', 200);
            }
            else{
                $em->persist($reclamation);
                $em->flush();
                return new JsonResponse('Success', 200);
            }
            

    }

    /**
     * @Route("/reclamations_api_repondre", name="reclamations_api_repondre")
     */
    public function repondreReclamation(Request $request, EntityManagerInterface $em, \Swift_Mailer $mailer): Response
    {
        
        //Récuperer la reclamation et l'utilisateur qui l'a envoyé
        
        $idRec=$request->query->get('idRec');
        //Récuperer l'id de l'admin traitant
        $idAdmin=$request->query->get('idAdmin');
        //Récuperer le contenu de reponse
        $reponse=$request->query->get('reponse');

        $reclamations=$this->getDoctrine()
            ->getRepository(Reclamation::class)
            ->findBy(array('id' => $idRec));
        foreach($reclamations as $reclamation){
            $user=$reclamation->getIdUserRec();
            $reclamation->setAdminTrait((int) $idAdmin);
            $reclamation->setStatut("Résolu");
            $em->persist($reclamation);
            $em->flush();
            $message = (new \Swift_Message('Réponse Réclamation'))
            ->setFrom('esenpai.devnation@gmail.com')
            ->setTo($user->getEmail())
            ->setBody($reponse);

            $mailer->send($message);
        }

        

       

        return new JsonResponse('Success', 200);
    }

}
