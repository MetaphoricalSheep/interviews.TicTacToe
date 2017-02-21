<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 8:36 AM
 */

namespace TicTacToe\application\libraries\game;


use TicTacToe\application\libraries\game\enums\StateEnum;

class State
{
    /** @var string */
    protected $Turn;

    /** @var  int **/
    protected $Round = 1;

    /** @var int **/
    protected $State = 0;

    /** @var array **/
    protected $Board = [];

    /** @var int */
    protected $Player1Score = 1;

    /** @var int */
    protected $Player2Score = 2;

    public function State() { }

    /** @return int **/
    public function GetState() : int
    {
        return $this->State;
    }

    /** @return int **/
    public function GetRound() : int
    {
        return $this->Round;
    }

    /**
     * @return bool
     */
    private function IsTerminal() : bool
    {
        $board = $this->Board;

        for ($r = 0; $r <= 6; $r+=3)
        {
            $p = $board[$r];
            if ($p != null && $p == $board[$r + 1] &&  $p == $board[$r + 2])
            {
                $this->DeclareWinner($p);
                return true;
            }
        }
        unset($r, $p);

        for ($c = 0; $c <= 2; $c++)
        {
            $p = $board[$c];
            if ($p != null && $p == $board[$c + 3] && $p == $board[$c + 6])
            {
                $this->DeclareWinner($p);
                return true;
            }
        }
        unset($c, $p);

        for ($r = 0, $d = 4; $r <= 2 ; $r+=2, $d-=2)
        {
            $p = $board[$r];
            if ($p != null && $p == $board[$r + $d] && $p == $board[$r + 2 * $d])
            {
                $this->DeclareWinner($p);
                return true;
            }
        }
        unset($r, $d, $p);

        return false;
    }

    private function DeclareWinner($piece)
    {
        $this->State = ($piece == 'X') ? StateEnum::Player1Wins : StateEnum::Player2Wins;
    }

    private function AdvanceRound()
    {
        $this->Turn = "X" ? "O" : "X";
        $this->Round++;
    }

    public function TransitionState()
    {

    }
}