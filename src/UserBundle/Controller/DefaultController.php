<?php

namespace UserBundle\Controller;

use DateTime;
use EntityBundle\Entity\AttachType;
use EntityBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        /*
        $user = new User();
        $plainPassword = '123456';
        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, $plainPassword);

        $user->setPassword($encoded);
        $user->setUsername("admin");
        $user->setEmail("mhilmi@hotmail.fr");
        $user->setIsActive(true);
        $user->setRole("ROLE_ADMIN");
        $now = new DateTime();
        $user->setCreationDate($now);
        $em = $this->getDoctrine()->getManager();

        $em->persist($user);
        $em->flush();
        */
        return $this->render('UserBundle:Default:index.html.twig');
    }
}
