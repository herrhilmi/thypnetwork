<?php

namespace UserBundle\Controller;

use DateTime;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use EntityBundle\Entity\annonce;
use EntityBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/",name="home")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $user = $this->getConnectedUser();

        // last users registered
        $last_users = $this->getLastRegisteredUsers(5);

        // last notification received
        $notifications = $this->getLastUnseenNotifications($user);

        $annonce = new annonce();
        $error = "";
        $form = $this->createFormBuilder($annonce)
                ->add("content",TextareaType::class, array('attr'  => array('placeholder' => 'Saisissez votre texte ici...','rows' => 2, 'maxLength' => 512)))
                ->add("Publier",SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $annonce->setUser($user);
            $annonce->setIsVisible(true);
            $now = new DateTime();
            $annonce->setDate($now);

            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();
        }


        $annonces = $this->getLastAnnonces($user);
        return  array('user' => $user, 'lastUsers'  => $last_users, 'notifications'  => $notifications,'form' => $form->createView() , 'error'=>$error, 'annonces'=>$annonces);
    }

    /**
     * @Route("/most",name="most_commented")
     * @Template("UserBundle:Default:index.html.twig")
     */
    public function mostCommentedAction(Request $request)
    {
        $user = $this->getConnectedUser();

        // last users registered
        $last_users = $this->getLastRegisteredUsers(5);

        // last notification received
        $notifications = $this->getLastUnseenNotifications($user);

        $annonce = new annonce();
        $error = "";
        $form = $this->createFormBuilder($annonce)
            ->add("content",TextareaType::class, array('attr'  => array('placeholder' => 'Saisissez votre texte ici...','rows' => 2, 'maxLength' => 512)))
            ->add("Publier",SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $annonce->setUser($user);
            $annonce->setIsVisible(true);
            $now = new DateTime();
            $annonce->setDate($now);

            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();
        }

        $annonces = $this->getMoastCommentedAnnonces($user);
        return   array('user' => $user, 'lastUsers'  => $last_users, 'notifications'  => $notifications,'form' => $form->createView() , 'error'=>$error , 'annonces'=>$annonces);
    }


    public function getLastAnnonces($user){
        $em = $this->getDoctrine()->getManager();
        $amis = $em->getRepository("EntityBundle:ami")->findBy(array('user' => $user, 'state' => 'ACTIVE'));
        $em->flush();
        $amis[] = $user;

        $em = $this->getDoctrine()->getManager();
        $annonces = $em->getRepository("EntityBundle:annonce")->findBy(array('user' => $amis ),array('date' => 'DESC'), 25, 0);
        $em->flush();

        return $annonces;
    }


    public function getMoastCommentedAnnonces($user){
        $em = $this->getDoctrine()->getManager();
        $amis = $em->getRepository("EntityBundle:ami")->findBy(array('user' => $user, 'state' => 'ACTIVE'));
        $em->flush();
        $amis[] = $user;

        $em = $this->getDoctrine()->getManager();
        $annonces = $em->getRepository("EntityBundle:annonce")->findBy(array('user' => $amis ),array('comments' => 'DESC'), 25, 0);
        $em->flush();

        return $annonces;

    }





    /**
     * réucpérer les dernières notifications pas encore vues
    */
    public function getLastUnseenNotifications($user){
        $em = $this->getDoctrine()->getManager();
        $notifications = $em->getRepository("EntityBundle:notification")->findBy(array('to' => $user, 'seen' => 'NO'),null,null,0);
        $em->flush();

        return $notifications;
    }

    /**
     * récupérer l'utilisateur connecté
    */
    public function getConnectedUser(){

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        return $this->getUser();
    }

    /**
     * param $nb le nombre d'utilisateur a recupérer
     * return les derniers Users inscrits
     */
    public function getLastRegisteredUsers($nb){
        $em = $this->getDoctrine()->getManager();
        $last_users = $em->getRepository("EntityBundle:User")->findBy(array('role' => 'ROLE_USER', 'isActive' => true),array('creationDate' => 'desc'), $nb, 0);
        $em->flush();

        return $last_users;
    }

    /*
            $user = new User();
            $plainPassword = '123456';
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $plainPassword);

            $user->setPassword($encoded);
            $user->setUsername("ettanass");
            $user->setEmail("ettanass@gmail.com");
            $user->setIsActive(true);
            $user->setRole("ROLE_USER");
            $now = new DateTime();
            $user->setCreationDate($now);
            $em = $this->getDoctrine()->getManager();

            $em->persist($user);
            $em->flush();
    */
}
