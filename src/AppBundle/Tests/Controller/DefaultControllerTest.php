<?php

namespace AppBundle\Tests\Controller;

class DefaultControllerTest extends AbstractTest
{
    public function testIndex()
    {
        $client = static::createClient();

        $this->logIn($client);

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
    }
}
