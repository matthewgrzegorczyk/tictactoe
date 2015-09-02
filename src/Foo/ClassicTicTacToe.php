<?php

namespace Foo;

use Foo\FieldTakenException;
use Foo\WrongPlayerException;


class ClassicTicTacToe implements TicTacToeInterface
{
    private $_board = [];
    private $_moves = 0;
    private $_lastActivePlayer = '';
    private $_activePlayer = '';
    private $_errors = [
        'wrong_player' => "You can't use same player twice in a row.",
        'field_taken' => "Field is already taken. Choose another one."
    ];

    function __construct() {
        $this->resetGame();
    }

    /**
     * Reset game to it's initial state
     */
    public function resetGame() {
        $this->_clearBoard();
        $this->_moves = 0;
        $this->_lastActivePlayer = '';
        $this->_activePlayer = '';
    }

    /**
     * $x,$y - 0-2
     * @param $x integer
     * @param $y integer
     */
    public function putX($x,$y) {
        $this->_move($x, $y, 'X');
    }

    /**
     * $x,$y - 0-2
     * @param $x integer
     * @param $y integer
     */
    public function putO($x,$y) {
        $this->_move($x, $y, 'O');
    }

    /**
     * @return boolean
     */
    public function isEnded() {
        if($this->_moves >= 9 || $this->isTied() || $this->getWinner() !== false) {
            return true;
        }
        return false;
    }

    /**
     * @return boolean
     */
    public function isTied() {
        if($this->getWinner() === false && $this->_moves >= 9) {
            return true;
        }
        return false;
    }

    /**
     * ('X' or 'O' or false)
     * @return string|false
     */
    public function getWinner() {
        // Check top row
        if ($this->_board[0][0] && $this->_board[0][0] == $this->_board[0][1] && $this->_board[0][1] == $this->_board[0][2])
            return $this->_board[0][0];

        // Check middle row
        if ($this->_board[1][0] && $this->_board[1][0] == $this->_board[1][1] && $this->_board[1][1] == $this->_board[1][2])
            return $this->_board[1][0];

        // Check bottom row
        if ($this->_board[2][0] && $this->_board[2][0] == $this->_board[2][1] && $this->_board[2][1] == $this->_board[2][2])
            return $this->_board[2][0];

        // Check first column
        if ($this->_board[0][0] && $this->_board[0][0] == $this->_board[1][0] && $this->_board[1][0] == $this->_board[2][0])
            return $this->_board[0][0];

        // Check middle column
        if ($this->_board[0][1] && $this->_board[0][1] == $this->_board[1][1] && $this->_board[1][1] == $this->_board[2][1])
            return $this->_board[0][1];

        // Check last column
        if ($this->_board[0][2] && $this->_board[0][2] == $this->_board[1][2] && $this->_board[1][2] == $this->_board[2][2])
            return $this->_board[0][2];

        // Check diagonal 1
        if ($this->_board[0][0] && $this->_board[0][0] == $this->_board[1][1] && $this->_board[1][1] == $this->_board[2][2])
            return $this->_board[0][0];

        // Check diagonal 2
        if ($this->_board[0][2] && $this->_board[0][2] == $this->_board[1][1] && $this->_board[1][1] == $this->_board[2][0])
            return $this->_board[0][2];

        return false;
    }

    /*
     * Switch player to X or O accordingly.
     */
    private function _switchPlayer() {
        $this->_lastActivePlayer = $this->_activePlayer;
        $this->_activePlayer = ($this->_activePlayer === 'X') ? 'Y' : 'X';
    }

    /*
     * Try to make a move
     *
     * @param
     * @throws Foo\FieldTakenException if field is already taken by another player.
     * @throws Foo\WrongPlayerException if trying to move same player twice in a row.
     */
    private function _move($x, $y, $mark) {
        // If it's the first move set activePlayer
        if($this->_moves === 0) {
            $this->_activePlayer = $mark;
        }

        if($mark === $this->_lastActivePlayer) {
            throw new WrongPlayerException($this->_errors['wrong_player']);
        }

        if(!in_array($this->_board[$x][$y], ['X', 'Y'])) {
            $this->_board[$x][$y] = $mark;
            $this->_switchPlayer();
            $this->_moves++;
        }
        else {
            throw new FieldTakenException($this->_errors['field_taken']);
        }
    }

    private function _clearBoard() {
        for($i = 0; $i < 3; $i++) {
            for($j = 0; $j < 3; $j++) {
                $this->_board[$i][$j] = '';
            }
        }
    }
}
