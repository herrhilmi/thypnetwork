<?php

namespace UserBundle\Controller;

use DateTime;
use EntityBundle\Entity\ami;
use EntityBundle\Entity\comment;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use EntityBundle\Entity\annonce;
use EntityBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
    * récuperer les dernières annonces postées
     */
    public function getLastAnnonces($user){


        $em = $this->getDoctrine()->getManager();
        $annonces = $em->getRepository("EntityBundle:annonce")->getLastAnnonces($user);
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

    /**
     * pour rechercher des utilisateurs
     * @Route("/search", name="search")
     * @Template("UserBundle:default:search.html.twig")
     */
    public function searchForUsers(Request $request){
        $user = $this->getConnectedUser();
        // last users registered
        $last_users = $this->getLastRegisteredUsers(5);

        // last notification received
        $notifications = $this->getLastUnseenNotifications($user);

        $found_users = null;
        $query = $request->request->get('query');
        $em = $this->getDoctrine()->getManager();
        $found_users = $em->getRepository("EntityBundle:User")->getUsersLike($query, $user);
        $em->flush();

        return  array('user' => $user, 'lastUsers'  => $last_users, 'notifications'  => $notifications,'form' => null , 'error'=>null, 'annonces'=>null, 'found_users' => $found_users);
    }


    /**
     * pour rechercher des utilisateurs
     * @Route("/commenter", name="commenter")
     */
    public function commenter(Request $request){
        $msg = $request->request->get('msg');
        $idAnnonce = $request->request->get('annonce');
        $user = $this->getConnectedUser();

        $commentaire = new comment();

        $commentaire->setIsVisible('YES');
        $commentaire->setUser($user);
        $commentaire->setMsg($msg);
        $now = new DateTime();
        $commentaire->setDate($now);

        $em = $this->getDoctrine()->getManager();
        $annonce =  $em->getRepository("EntityBundle:annonce")->findOneById($idAnnonce);
        $commentaire->setAnnonce($annonce);

        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array('password','comments','messages','username','role','roles','salt'));
        $serializer = new Serializer(array($normalizer), array(new JsonEncoder()));

        $em = $this->getDoctrine()->getManager();
        $em->persist($commentaire);
        $em->flush();

        $jsonContent = $serializer->serialize($commentaire, 'json');

        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
