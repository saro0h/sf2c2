<?php

namespace AppBundle\Tests\Game;

use AppBundle\Game\WordList;

class WordListTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadDictionnariesWithNoLoader()
    {
        $this->setExpectedException('RuntimeException');

        $wordlist = new WordList();
        $wordlist->loadDictionaries(array('/path/to/fake/dictionnary.txt'));
    }

    public function testLoadDictionnaries()
    {
        $loader = $this->getMock('AppBundle\Game\Loader\TextFileLoader');

        $loader
            ->expects($this->once())
            ->method('load')
            ->will($this->returnValue(array('php')))
        ;

        $wordlist = new WordList();
        $wordlist->addLoader('txt', $loader);

        $wordlist->loadDictionaries(array('/path/to/fake/dictionnary.txt'));

        $this->assertContains('php', $wordlist->getWords()[3]);
    }
}
