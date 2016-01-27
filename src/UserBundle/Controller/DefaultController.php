<?php

namespace UserBundle\Controller;

use DateTime;
use EntityBundle\Entity\AttachType;
use EntityBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/",name="home")
     * @Template()
     */
    public function indexAction()
    {
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

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->getUser();

        return  array('user' => $user);
    }
}
