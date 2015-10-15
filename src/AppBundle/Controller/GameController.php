<?php

namespace AppBundle\Controller;

use AppBundle\Game\GameRunner;
use AppBundle\Game\WordList;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Game\GameContext;
use AppBundle\Game\Loader\XmlFileLoader;
use AppBundle\Game\Loader\TextFileLoader;

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
        return $this->render('AppBundle:Game:home.html.twig', array('game' => $this->get('game_runner')->loadGame($this->getParameter('word_length'))));
    }

    /**
     * @Route("/won", name="game_won")
     * @Template
     */
    public function wonAction()
    {
        $game = $this->get('game_runner')->resetGameOnSuccess();

        return array(array('game' => $game));
    }

    /**
     * @Route("/failed", name="game_failed")
     */
    public function failedAction()
    {
        $game = $this->get('game_runner')->resetGameOnFailure();

        return new Response($this->renderView('AppBundle:Game:failed.html.twig', array('game' => $game)));
    }

    /**
     * @Route("/reset", name="game_reset")
     */
    public function resetAction()
    {
        $this->get('game_runner')->resetGame();

        return $this->redirectToRoute('game_home');
    }

    /**
     * This action plays a letter.
     *
     * @Route("/play/{letter}", name="game_play_letter", requirements={
     *   "letter"="[A-Z]"
     * })
     * @Method("GET")
     */
    public function playLetterAction($letter)
    {
        $game = $this->get('game_runner')->playLetter($letter);

        if (!$game->isOver()) {
            return $this->redirectToRoute('game_home');
        }

        return $this->redirectToRoute($game->isWon() ? 'game_won' : 'game_failed');
    }

    /**
     * This action plays a word.
     *
     * @Route("/play", name="game_play_word", condition="request.request.has('word')")
     * @Method("POST")
     */
    public function playWordAction(Request $request)
    {
        $game = $this->get('game_runner')->playWord($request->request->get('word'));

        return $this->redirectToRoute($game->isWon() ? 'game_won' : 'game_failed');
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
