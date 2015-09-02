<?php

namespace Foo;

interface TicTacToeInterface {

    /**
     * $x,$y - 0-2
     * @param $x integer
     * @param $y integer
     */
    public function putX($x,$y);

    /**
     * $x,$y - 0-2
     * @param $x integer
     * @param $y integer
     */
    public function putO($x,$y);

    /**
     * @return boolean
     */
    public function isEnded();

    /**
     * @return boolean
     */
    public function isTied();

    /**
     * ('X' or 'O' or false)
     * @return string|false
     */
    public function getWinner();
}