<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 8:36 AM
 */

namespace TicTacToe\application\libraries\game;


use TicTacToe\application\libraries\game\enums\StateEnum;
use TicTacToe\application\model\Entities\Player;

class State
{
    /** @var Player **/
    protected $CurrentPlayer;

    /** @var string */
    protected $Turn;

    /** @var  int **/
    protected $Round = 1;

    /** @var int **/
    protected $State = 0;

    /** @var array **/
    protected $Board = [];

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

    public function IsTerminal()
    {
        
    }

    public function AdvanceRound()
    {
        $this->Turn = "X" ? "O" : "X";
        $this->Round++;
    }

    public function TransitionState()
    {

    }
}