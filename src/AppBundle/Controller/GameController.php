<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route(
 *     "{_locale}/game",
 *     requirements={ "_locale" = "fr|en" }
 * )
 */
class GameController extends Controller
{
    /**
     * @Route("/", name="game_home")
     */
    public function homeAction()
    {
        return $this->render('AppBundle:Game:home.html.twig');
    }

    /**
     * @Route("/won", name="game_won")
     * @Template
     */
    public function wonAction()
    {
        return array();
    }

    /**
     * @Route("/failed", name="game_failed")
     */
    public function failedAction()
    {
        return new Response($this->renderView('AppBundle:Game:failed.html.twig'));
    }

    /**
     * @Template
     */
    public function testimonialsAction()
    {
        return array('testimonials' => array(
            'John Doe' => 'I love this game, so addictive!',
            'Martin Durand' => 'Best web application ever',
            'Paul Smith' => 'Awesomeness!',
        ));
    }
}
