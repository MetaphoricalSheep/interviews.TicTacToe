<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 8:36 AM
 */

namespace TicTacToe\application\libraries\game;


use libraries\game\exceptions\OutOfTurnException;
use TicTacToe\application\libraries\game\enums\StateEnum;
use TicTacToe\libraries\game\BasePiece;
use TicTacToe\libraries\game\exceptions\InvalidPositionException;
use TicTacToe\libraries\game\IPiece;

class State
{
    /** @var string */
    protected $Turn = Piece::Cross;

    /** @var  int **/
    protected $Round = 1;

    /** @var int **/
    protected $State = StateEnum::NewGame;

    /** @var array **/
    protected $Board = [];

    /** @var int **/
    protected $Position;

    /** @var IPiece **/
    protected $Piece;

    /**
     * State constructor.
     * @param $previousState
     * @return State
     */
    public function __construct($previousState)
    {
        if ($previousState != null)
        {
            $this->Turn = $previousState->Turn;
            $this->Round = $previousState->Round;
            $this->State = $previousState->State;
            $this->Board = $previousState->Board;
        }

        return $this;
    }

    /**
     * @return int
     */
    public function GetPosition() : int
    {
        return $this->Position;
    }

    /**
     * @param int $position
     * @return State $this
     * @throws InvalidPositionException
     */
    protected function SetPosition($position) : State
    {
        if ($position < 0 || $position > 8 || $this->Board[$position] != null)
        {
            throw new InvalidPositionException($position);
        }

        $this->Position = $position;

        return $this;
    }

    /** @return int **/
    public function GetState() : int
    {
        return $this->State;
    }

    /**
     * @return IPiece
     */
    public function GetPiece() : IPiece
    {
        return $this->Piece;
    }

    /**
     * @param IPiece $piece
     * @return State $this
     * @throws OutOfTurnException
     */
    protected function SetPiece($piece) : State
    {
        if ($piece != $this->Turn)
        {
            throw new OutOfTurnException($piece->GetSymbol());
        }

        $this->Piece = $piece;

        return $this;
    }

    /** @return int **/
    public function GetRound() : int
    {
        return $this->Round;
    }

    /**
     * @param int $position
     * @param IPiece $piece
     * @return int
     */
    public function TransitionState($position, $piece) : int
    {
        if ($this->Round == 9)
        {
            return $this->State;
        }

        $this->AdvanceRound();

        $this->SetPosition($position);
        $this->SetPiece($piece);

        $this->Move();
        $this->TerminalCheck();

        return $this->State;
    }

    protected function Move()
    {
        $this->Board[$this->Position] = $this->Piece->GetSymbol();
    }

    /**
     * @return void
     */
    private function TerminalCheck()
    {
        $board = $this->Board;

        for ($r = 0; $r <= 6; $r+=3)
        {
            $p = $board[$r];
            if ($p != null && $p == $board[$r + 1] &&  $p == $board[$r + 2])
            {
                $this->DeclareWinner($p);
                return;
            }
        }
        unset($r, $p);

        for ($c = 0; $c <= 2; $c++)
        {
            $p = $board[$c];
            if ($p != null && $p == $board[$c + 3] && $p == $board[$c + 6])
            {
                $this->DeclareWinner($p);
                return;
            }
        }
        unset($c, $p);

        for ($r = 0, $d = 4; $r <= 2 ; $r+=2, $d-=2)
        {
            $p = $board[$r];
            if ($p != null && $p == $board[$r + $d] && $p == $board[$r + 2 * $d])
            {
                $this->DeclareWinner($p);
                return;
            }
        }
        unset($r, $d, $p);

        if ($this->Round >= 9)
        {
            $this->DeclareDraw();
        }
    }

    private function DeclareWinner($piece)
    {
        $this->State = ($piece == 'X') ? StateEnum::Player1Wins : StateEnum::Player2Wins;
    }

    private function DeclareDraw()
    {
        $this->State = StateEnum::Draw;
    }

    private function AdvanceRound()
    {
        $this->Turn = BasePiece::Cross ? BasePiece::Naught : BasePiece::Cross;
        $this->Round++;
    }
}
