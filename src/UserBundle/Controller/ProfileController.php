<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class ProfileController extends Controller
{

    /**
     * @Route("/profile",name="profile")
     * @Template("UserBundle:profile:profile_my_posts.html.twig")
     */
    public function indexAction()
    {
        $user = $this->getConnectedUser();
        return array('user' => $user);
    }

    /**
     * @Route("/friends",name="profile_friends")
     * @Template("UserBundle:profile:profile_my_friends.html.twig")
     */
    public function firendsAction()
    {

        $user = $this->getConnectedUser();
        return  array('user' => $user);
    }

    /**
     * @Route("/infos",name="profile_infos")
     * @Template("UserBundle:profile:profile_my_infos.html.twig")
     */
    public function infosAction()
    {
        $user = $this->getConnectedUser();
        return array('user' => $user);
    }

    /**
     * @Route("/edit",name="profile_edit")
     * @Template("UserBundle:profile:profile_edit.html.twig")
     */
    public function editAction()
    {
        $user = $this->getConnectedUser();
        return array('user' => $user);
    }



    public function getConnectedUser(){

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        return $user = $this->getUser();
    }
}
