<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 8:36 AM
 */

namespace libraries\TicTacToe;


use libraries\TicTacToe\exceptions\OutOfTurnException;
use libraries\TicTacToe\enums\StateEnum;
use libraries\TicTacToe\exceptions\InvalidPositionException;

class State
{
    /** @var string */
    protected $Turn = BasePiece::Cross;

    /** @var  int **/
    protected $Round = 1;

    /** @var int **/
    protected $State = StateEnum::NewGame;

    /** @var array **/
    protected $Board = ["", "", "", "", "", "", "", "", ""];

    /** @var int **/
    protected $Position;

    /** @var IPiece **/
    protected $Piece;

    /**
     * State constructor.
     * @param State|null $previousState
     * @return State
     */
    public function __construct($previousState = null)
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
    public function SetPosition($position) : State
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
     * @param int $state
     * @return State
     */
    public function SetState(int $state) : State
    {
        $this->State = $state;
        return $this;
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
    public function SetPiece($piece) : State
    {
        if ($piece->GetSymbol() != $this->Turn)
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
     * @param int $round
     * @return State
     */
    public function SetRound(int $round) : State
    {
        $this->Round = $round;
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
     * @return array
     */
    public function GetBoard() : array
    {
        return $this->Board;
    }

    public function SetBoard(array $board) : State
    {
        $this->Board = $board;
        return $this;
    }

    /**
     * @param int $position
     * @param IPiece $piece
     * @return State
     */
    public function TransitionState($position, $piece) : State
    {
        $this->State = StateEnum::InProgress;

        $this->SetPosition($position);
        $this->SetPiece($piece);

        $this->Move();
        $this->TerminalCheck();

        if ($this->State != StateEnum::InProgress)
        {
            return $this;
        }

        $this->AdvanceRound();

        return $this;
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
        if ($this->Round > 4)
        {
            $board = $this->Board;

            for ($r = 0; $r <= 6; $r+=3)
            {
                $p = $board[$r];
                if ($p != "" && $p == $board[$r + 1] &&  $p == $board[$r + 2])
                {
                    $this->DeclareWinner($p);
                    return;
                }
            }
            unset($r, $p);

            for ($c = 0; $c <= 2; $c++)
            {
                $p = $board[$c];
                if ($p != "" && $p == $board[$c + 3] && $p == $board[$c + 6])
                {
                    $this->DeclareWinner($p);
                    return;
                }
            }
            unset($c, $p);

            for ($r = 0, $d = 4; $r <= 2 ; $r+=2, $d-=2)
            {
                $p = $board[$r];
                if ($p != "" && $p == $board[$r + $d] && $p == $board[$r + 2 * $d])
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
    }

    private function DeclareWinner($piece)
    {
        $this->State = ($piece == BasePiece::Cross) ? StateEnum::Player1Wins : StateEnum::Player2Wins;
    }

    private function DeclareDraw()
    {
        $this->State = StateEnum::Draw;
        $this->AdvanceRound();
    }

    private function AdvanceRound()
    {
        $this->Turn = ($this->Turn == BasePiece::Cross) ? BasePiece::Naught : BasePiece::Cross;
        $this->Round++;
    }
}
