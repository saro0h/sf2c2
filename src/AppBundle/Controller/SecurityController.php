<?php

namespace AppBundle\Controller;

use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    /**
     * @Route(
     *     "/{_locale}/login",
     *     name="login",
     *     requirements={ "_locale" = "fr|en" }
     * )
     * @Template
     */
    public function loginAction()
    {
        return array();
    }

    /**
     * @Route("/{_locale}/register", name="register")
     * @Template
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('user', $user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('notice', 'You have been successfully added to the big family of the hangman game!');

            return $this->redirectToRoute('game_home');
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/users", name="users")
     * @Template
     */
    public function listUsersAction()
    {
        return array('users' => $this->getDoctrine()->getRepository('AppBundle:User')->findAll());

    }
}
