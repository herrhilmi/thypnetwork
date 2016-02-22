<?php

namespace UserBundle\Controller;

use DateTime;
use EntityBundle\Entity\AttachType;
use EntityBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class NotificationsController extends Controller
{
    /**
     * @Route("/notifications",name="notifications")
     * @Template("UserBundle:Default:notifications.html.twig")
     */
    public function indexAction()
    {

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->getUser();
        // last users registered
        $em = $this->getDoctrine()->getManager();
        $last_users = $em->getRepository("EntityBundle:User")->findBy(array('role' => 'ROLE_USER', 'isActive' => true),array('creationDate' => 'desc'),5,0);
        $em->flush();
        // last notification received
        $em = $this->getDoctrine()->getManager();
        $notifications = $em->getRepository("EntityBundle:notification")->findBy(array('to' => $user, 'seen' => 'NO'),null,null,0);
        $em->flush();
        return  array('user' => $user, 'lastUsers'  => $last_users, 'notifications'  => $notifications);
    }
}
