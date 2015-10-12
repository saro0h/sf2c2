<?php

namespace AppBundle\Controller;

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
     * @Route("/my-birthday/{month}/{day}", name="birthday")
     * @Template
     */
    public function birthdayAction($month, $day)
    {
        $date = new \Datetime('2015'.'-'.$month.'-'.$day);

        return array('now' => $date);
    }
}
