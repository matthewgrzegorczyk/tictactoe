<?php
namespace Foo\Tests;

use Foo\ClassicTicTacToe;

class ClassicTicTacToeTest extends \PHPUnit_Framework_TestCase
{

    function testInitialize()
    {
        $c = new ClassicTicTacToe();
    }

    /**
     * @expectedException \Foo\FieldTakenException
     */
    function testSameField()
    {
        $c = new ClassicTicTacToe();
        $c->putX(1, 1);
        $c->putO(1, 1);
    }

    /**
     * @expectedException \Foo\WrongPlayerException
     */
    function testWrongPlayer()
    {
        $c = new ClassicTicTacToe();
        $c->putX(1, 1);
        $c->putX(1, 2);
    }

    function testGame()
    {
        $games   = Array();
        $games[] = '15263W';
        $games[] = '1274985W';
        $games[] = '159647328T';
        $games[] = '453912876T';
        $games[] = '579146823T';
        $games[] = '1974352W';
        $games[] = '15487W';
        $games[] = '74859W';
        $games[] = '74859W';
        $games[] = '24578W';
        $games[] = '31547W';
        $games[] = '97541W';

        for ($whoStarts = 0; $whoStarts <= 1; $whoStarts++)
            foreach ($games as $game) {
                $c = new ClassicTicTacToe();
                $l = strlen($game);
                for ($i = 0; $i < $l; $i++) {
                    if ($game{$i} == 'W') {
                        $this->assertTrue($c->isEnded());
                        $this->assertEquals($whoStarts ? 'O' : 'X', $c->getWinner());
                    } elseif ($game{$i} == 'T') {
                        $this->assertTrue($c->isEnded());
                        $this->assertTrue($c->isTied());
                    } else {
                        $p    = intval($game{$i});
                        $posX = floor(($p - 1) / 3);
                        $posY = ($p - 1) % 3;
                        if ($i % 2 == $whoStarts)
                            $c->putX($posX, $posY);
                        else {
                            $c->putO($posX, $posY);
                        }
                        if ($i < $l - 2) {
                            $this->assertFalse($c->isEnded());
                            $this->assertFalse($c->isTied());
                        }

                    }
                }
            }
    }

}