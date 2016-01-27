<?php

namespace UserBundle\Controller;

use DateTime;
use EntityBundle\Entity\User;
use EntityBundle\Form\PersonType;
use EntityBundle\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends Controller
{
    /**
     * @Route("/register",name="register")
     * @Template("UserBundle:Default:register.html.twig")
     */
    public function indexAction(Request $request)
    {

        $user = new User();
        $error ="";
        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class, array('attr'  => array('placeholder' => 'Nom d\'utilisateur', 'maxLength' => 16)))
            ->add('email', EmailType::class, array('attr'  => array('placeholder' => 'Email', 'maxLength' => 64)))
            ->add('password', PasswordType::class, array('attr'  => array('placeholder' => 'Mot de passe','minLength' => 8, 'maxLength' => 16)))
            ->add('person', PersonType::class)
            ->add('S\'inscrire', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tmp_user = new User();
            $em = $this->getDoctrine()->getManager();
            $tmp_user = $em->getRepository("EntityBundle:User")->findByUsername($user->getUsername());
            $em->flush();

            if($tmp_user != null){
                $error = " found username";

            }else{
                $tmp_user = $em->getRepository("EntityBundle:User")->findByEmail($user->getEmail());
                $em->flush();
                if($tmp_user != null){
                    $error = " found email";
                }else{
                    // inserer membre
                    $encoder = $this->container->get('security.password_encoder');
                    $encoded = $encoder->encodePassword($user, $user->getPassword());
                    $user->setPassword($encoded);
                    $user->setIsActive(true);
                    $user->setRole("ROLE_USER");
                    $now = new DateTime();
                    $user->setCreationDate($now);
                    $em->persist($user);
                    $em->flush();
                    $error ="inserted";
                }


            }
        }
        return array( 'form' => $form->createView() , 'error'=>$error );
    }
}
