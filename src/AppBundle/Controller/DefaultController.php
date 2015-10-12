<?php

namespace AppBundle\Controller;

use AppBundle\Model\Contact;
use AppBundle\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

    /**
     * @Route("/hello/{name}", name="hello_world")
     * @Template
     */
    public function helloWorldAction($name)
    {
        return array('name' => $name);
    }

    /**
     * @Route("{_locale}/contact", name="contact")
     * @Template
     */
    public function contactAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(new ContactType(), $contact);

        $form->handleRequest($request);

        if ($form->isValid()) {
            // Send an email

            $this->addFlash('notice', 'Your request has been successfully sent.');

            return $this->redirectToRoute('game_home');
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route(
     *     "/my-birthday/{month}/{day}",
     *     name = "birthday",
     *     defaults = { "month" = "01", "day" = "01" },
     *     requirements = {
     *         "month" = "(0[0-9])|(1[0-2])",
     *         "day" = "(0[1-9])|([1-2][0-9])|(3[0-1])",
     *     },
     *     methods = { "GET" },
     *     schemes = { "http" }
     * )
     * @Template
     */
    public function birthdayAction($month, $day)
    {
        $date = new \Datetime('2015'.'-'.$month.'-'.$day);

        return array('now' => $date);
    }
}
