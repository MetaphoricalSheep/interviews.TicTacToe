<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/20/2017
 * Time: 6:40 PM
 */

namespace libraries\TicTacToe;


class TicTacToe
{
    /** @var  State */
    protected $_previousState;

    public function __construct(State $state)
    {
        $this->_previousState = $state;
    }

    /**
     * @param int $pos
     * @param string $piece
     * @return State
     */
    public function Move(int $pos, string $piece) : State
    {
        if ($piece == BasePiece::Cross)
        {
            $piece = new CrossPiece();
        }
        else
        {
            $piece = new NaughtPiece();
        }

        $state = new State($this->_previousState);
        return $state->TransitionState($pos, $piece);
    }
}