<?php

namespace UserBundle\Controller;

use EntityBundle\Entity\ami;
use EntityBundle\Entity\notification;
use EntityBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class ProfileController extends Controller
{

    /**
     * @Route("/profile/{id}",defaults={"id" = -1}, name="profile")
     * @Template("UserBundle:profile:profile_my_posts.html.twig")
     */
    public function indexAction($id)
    {
        $user = $this->getConnectedUser();
        $profile =  $this->getUserById($id);
        // derniers 5 utilisateurs inscrits
        $last_users =  $this->getLastRegisteredUsers(5);

        // etat de l'amètier
        $em = $this->getDoctrine()->getManager();
        $ami =  $em->getRepository("EntityBundle:ami")->findOneBy(array('user' => $user,'friend' => $profile));
        $em->flush();


        return  array('user' => $user, 'profile' => $profile, 'lastUsers'  => $last_users, 'ami'  => $ami);
    }


    /**
     * @Route("/friends/{id}" , defaults={"id" = -1}, name="profile_friends")
     * @Template("UserBundle:profile:profile_my_friends.html.twig")
     */
    public function firendsAction($id)
    {
        $user = $this->getConnectedUser();

        $profile =  $this->getUserById($id);

        // derniers 5 utilisateurs inscrits
        $last_users =  $this->getLastRegisteredUsers(5);


        // etat de l'amètier
        $em = $this->getDoctrine()->getManager();
        $ami =  $em->getRepository("EntityBundle:ami")->findOneBy(array('user' => $user,'friend' => $profile));
        $em->flush();


        // liste des amis
        $em = $this->getDoctrine()->getManager();
        if($profile == null){
            $friends_user = $em->getRepository("EntityBundle:ami")->findBy(array('user' => $user, 'state' => 'ACTIVE'));
        }else{
            $friends_user = $em->getRepository("EntityBundle:ami")->findBy(array('user' => $profile, 'state' => 'ACTIVE'));
        }
        $em->flush();

        return  array('user' => $user, 'profile' => $profile, 'lastUsers'  => $last_users, 'friends_user' => $friends_user,'ami'  => $ami);
    }

    /**
     * @Route("/infos/{id}" , defaults={"id" = -1}, name="profile_infos")
     * @Template("UserBundle:profile:profile_my_infos.html.twig")
     */
    public function infosAction($id)
    {
        $ami = null;
        $user = $this->getConnectedUser();
        $profile =  $this->getUserById($id);

        // derniers 5 utilisateurs inscrits
        $last_users =  $this->getLastRegisteredUsers(5);

        // etat de l'amètier
        $em = $this->getDoctrine()->getManager();
        $ami =  $em->getRepository("EntityBundle:ami")->findOneBy(array('user' => $user,'friend' => $profile));
        $em->flush();


        return array('user' => $user, 'profile' => $profile, 'lastUsers'  => $last_users,'ami'  => $ami);
    }

    /**
     * @Route("/edit",name="profile_edit")
     * @Template("UserBundle:profile:profile_edit.html.twig")
     */
    public function editAction()
    {
        $user = $this->getConnectedUser();
        return array('user' => $user,  'lastUsers'  => null, 'profile'  => null);
    }

    public function getConnectedUser(){

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        return $this->getUser();
    }


    /**
     * return un User
    */
    public function getUserById($id){
        if ($id == -1  OR !is_numeric($id) OR $id == null){
            $profile= null;
        }
        else {
            $em = $this->getDoctrine()->getManager();
            $profile = $em->getRepository("EntityBundle:User")->find($id);
            $em->flush();

            if($profile == null){
                return $this->redirect('::error404.html.twig',404);
            }
        }

        return $profile;
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

    /**
     * ajouter comme ami
     * @Route("/add-friend/{id}" , name="add_friend")
     */
    public function addFriendAction($id){
        $user = $this->getConnectedUser();
        if ( is_numeric($id) OR $id != null)
         {
            $em = $this->getDoctrine()->getManager();
            $profile = $em->getRepository("EntityBundle:User")->find($id);
            $em->flush();

             $em = $this->getDoctrine()->getManager();
             $notifType = $em->getRepository("EntityBundle:typeNotif")->findOneByTypeNotif("NEW_FRIENDSHIP");
             $em->flush();


             if($profile != null){

                 // etat de l'amètier
                $em = $this->getDoctrine()->getManager();
                $ami =  $em->getRepository("EntityBundle:ami")->findOneBy(array('user' => $user,'friend' => $profile));
                $em->flush();

                 if(null == $ami){
                     // creation de l'objet d'ametié
                     $ami = new ami();
                     $ami->setUser($user);
                     $ami->setFriend($profile);
                     $ami->setState('PENDING');

                     // recupération de l'entity manager et insertion
                     $em = $this->getDoctrine()->getManager();
                     $em->persist($ami);
                     $em->flush();

                     // création de la notification a envoyée
                     $notification = new notification();
                     $notification->setTo($profile);
                     $notification->setFrom($user);
                     $notification->setTypeNotif($notifType);
                     $notification->setSeen('NO');


                     $em = $this->getDoctrine()->getManager();
                     $em->persist($notification);
                     $em->flush();
                 }




                return  $this->forward('UserBundle:Profile:index', array('id'  => $id));

            } else {
                return $this->redirect('', array('message' => "lol"));
            }
        }

        return  $this->redirect('', array('message' => "lol"));
    }


}
