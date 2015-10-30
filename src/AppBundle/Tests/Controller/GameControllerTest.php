<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Game\Game;

class GameControllerTest extends AbstractTest
{
    protected $client;

    public function testHomepage()
    {
        $this->client->request('GET', '/en/game/');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }

    public function testDecrementAttempts()
    {
        $this->client->followRedirects(true);

        $expectedCount = Game::MAX_ATTEMPTS - 1;

        $crawler = $this->client->request('GET', '/en/game');

        $link = $crawler->selectLink('A')->link();
        $crawler = $this->client->click($link);

        $attempts = $crawler->filter('.attempts');

        $this->assertSame('You still have '.$expectedCount.' remaining attempts.', trim($attempts->text()));
    }

    public function testNoDecrementAttempts()
    {
        $this->client->followRedirects(true);

        $crawler = $this->client->request('GET', '/en/game');
        $link = $crawler->selectLink('P')->link();
        $crawler = $this->client->click($link);

        $attempts = $crawler->filter('.attempts');

        $this->assertSame('You still have '.Game::MAX_ATTEMPTS.' remaining attempts.', trim($attempts->text()));
    }

    public function testPlayerWins()
    {
        $crawler = $this->client->request('GET', '/en/game');
        $crawler = $this->client->followRedirect();

        $link = $crawler->selectLink('P')->link();
        $this->client->click($link);

        $crawler = $this->client->followRedirect();

        $link = $crawler->selectLink('H')->link();
        $crawler = $this->client->click($link);

        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->client->getResponse()->isRedirect('/en/game/won'));

        $crawler = $this->client->followRedirect();
        $title = $crawler->filter('h2');

        $this->assertSame('Congratulations!', trim($title->text()));
    }

    public function testPlayerFails()
    {
        $this->client->request('GET', '/en/game');
        $crawler = $this->client->followRedirect();

        $lettersToTry = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'I', 'J', 'K');

        foreach ($lettersToTry as $letterToTry) {
            $link = $crawler->selectLink($letterToTry)->link();
            $this->client->click($link);

            $crawler = $this->client->followRedirect();
        }

        $link = $crawler->selectLink('L')->link();
        $this->client->click($link);

        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->client->getResponse()->isRedirect('/en/game/failed'));

        $crawler = $this->client->followRedirect();
        $title = $crawler->filter('h2');

        $this->assertSame('Game Over!', trim($title->text()));
    }

    public function testPlayRightWord()
    {
        $this->client->request('GET', '/en/game');
        $crawler = $this->client->followRedirect();

        $form = $crawler->selectButton('Let me guess...')->form();
        $this->client->submit($form, array('word' => 'php'));

        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->client->getResponse()->isRedirect('/en/game/won'));

        $crawler = $this->client->followRedirect();

        $title = $crawler->filter('h2');

        $this->assertSame('Congratulations!', trim($title->text()));
    }

    public function testPlayWrongWord()
    {
        $this->client->request('GET', '/en/game');
        $crawler = $this->client->followRedirect();

        $form = $crawler->selectButton('Let me guess...')->form();
        $this->client->submit($form, array('word' => 'wrong'));

        $this->assertSame(302, $this->client->getResponse()->getStatusCode());
        $this->assertTrue($this->client->getResponse()->isRedirect('/en/game/failed'));

        $crawler = $this->client->followRedirect();

        $title = $crawler->filter('h2');

        $this->assertSame('Game Over!', trim($title->text()));
    }

    protected function setUp()
    {
        $this->client = static::createClient();
        $this->logIn($this->client);
    }

    protected function tearDown()
    {
        $this->client = null;
    }
}
