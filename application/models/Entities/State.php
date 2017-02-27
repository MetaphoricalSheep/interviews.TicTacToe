<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/20/2017
 * Time: 11:30 PM
 */

namespace models\Entities;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;
use libraries\TicTacToe\BasePiece;
use libraries\TicTacToe\enums\StateEnum;
use libraries\traits\Timestampable;
use Ramsey\Uuid\Uuid;


/**
 * Class State
 * @package model\Entities
 *
 * @Entity(repositoryClass="models\Repositories\StateRepository")
 * @Table(name="State")
 */
class State
{
    use Timestampable;

    /**
     * @var Uuid
     * @Id
     * @Column(type="uuid")
     * @GeneratedValue(strategy="CUSTOM")
     * @CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     **/
    protected $Id;

    /**
     * @var int
     * @Column(type="integer", name="Round", nullable=false)
     */
    protected $Round = 1;

    /**
     * @var int
     * @Column(type="integer", name="State", nullable=false)
     */
    protected $State = StateEnum::NewGame;

    /**
     * @var array
     * @Column(type="json_array", name="Board", nullable=false)
     */
    protected $Board = ["", "", "", "", "", "", "", "", ""];

    /**
     * @var string
     * @Column(type="string", name="Turn", nullable=false)
     */
    protected $Turn = BasePiece::Cross;

    /**
     * @var Game
     * @OneToOne(targetEntity="Game", cascade={"persist"})
     * @JoinColumn(name="GameId", referencedColumnName="Id", nullable=false)
     */
    protected $Game;

    /**
     * @return Uuid
     */
    public function GetId() : Uuid
    {
        return $this->Id;
    }

    /**
     * @return int
     */
    public function GetRound() : int
    {
        return $this->Round;
    }

    /**
     * @param int $round
     * @return State
     */
    public function SetRound(int $round) : State
    {
        $this->Round = $round;
        return $this;
    }

    /**
     * @return int
     */
    public function GetState() : int
    {
        return $this->State;
    }

    /**
     * @param int $state
     * @return State
     */
    public function SetState(int $state) : State
    {
        $this->State = $state;
        return $this;
    }

    /**
     * @return array
     */
    public function GetBoard() : array
    {
        return $this->Board;
    }

    /**
     * @param array $board
     * @return State
     */
    public function SetBoard(array $board) : State
    {
        $this->Board = $board;
        return $this;
    }

    /**
     * @param int $pos
     * @param string $piece
     * @return State
     */
    public function UpdateBoard(int $pos, string $piece) : State
    {
        $this->Board[$pos] = $piece;
        return $this;
    }

    /**
     * @return string
     */
    public function GetTurn() : string
    {
        return $this->Turn;
    }

    /**
     * @param string $turn
     * @return State
     */
    public function SetTurn(string $turn) : State
    {
        $this->Turn = $turn;
        return $this;
    }

    /**
     * @return Game
     */
    public function GetGame() : Game
    {
        return $this->Game;
    }

    /**
     * @param Game $game
     * @return State
     */
    public function SetGame(Game $game) : State
    {
        $this->Game = $game;
        return $this;
    }

    public function MapToEngine() : \libraries\TicTacToe\State
    {
        $state = new \libraries\TicTacToe\State();
        return $state
            ->SetTurn($this->Turn)
            ->SetRound($this->Round)
            ->SetState($this->State)
            ->SetBoard($this->Board);
    }

    /**
     * @param \libraries\TicTacToe\State $state
     * @return State
     */
    public function MapFromEngine(\libraries\TicTacToe\State $state) : State
    {
        $this
            ->SetBoard($state->GetBoard())
            ->SetRound($state->GetRound())
            ->SetTurn($state->GetTurn())
            ->SetState($state->GetState());

        return $this;
    }
}


