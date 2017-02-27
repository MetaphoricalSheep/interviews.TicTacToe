<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/27/2017
 * Time: 7:28 PM
 */

namespace libraries\TicTacToe;


use libraries\TicTacToe\enums\StateEnum;

class Marvin
{
    /**
     * @param array $board
     * @param string $symbol
     * @return array
     */
    private function FilterCells(array $board, string $symbol = "") : array
    {
        return array_filter($board, function($i) use ($symbol)
        {
            return ($i == $symbol) ?? true;
        });
    }

    /**
     * @param array $emptyCells
     * @param $state
     * @return array
     */
    private function GetStates(array $emptyCells, $state) : array
    {
        $availableStates = [];

        foreach ($emptyCells as $i => $a)
        {
            $availableStates[] = $this->CalculateMove($state, $i);
        }

        return $availableStates;
    }

    private function GetPlayer2MovesCount(State $state) : int
    {
        return count($this->FilterCells($state->GetBoard(), BasePiece::Naught));
    }

    /**
     * @param State $state
     * @return int
     */
    private function TerminalScore(State $state) : int
    {
        if ($state->GetState() == StateEnum::Player1Wins)
        {
            return 10 - $this->GetPlayer2MovesCount($state);
        }
        else if ($state->GetState() == StateEnum::Player2Wins)
        {
            return -10 + $this->GetPlayer2MovesCount($state);
        }

        return 0;
    }

    /**
     * @param State $state
     * @return int
     */
    private function MinMaxValue(State $state)
    {
        if ($state->GetState() > StateEnum::InProgress)
        {
            return $this->TerminalScore($state);
        }

        $score = 1000;

        if ($state->GetTurn() === BasePiece::Cross)
        {
            $score *= -1;
        }

        $emptyCells = $this->FilterCells($state->GetBoard()) ;

        $availableStates = $this->GetStates($emptyCells, $state);

        foreach ($availableStates as $nextState)
        {
            $nextScore = $this->MinMaxValue($nextState);

            if ($state->GetTurn() === BasePiece::Cross)
            {
                if ($nextScore > $score)
                {
                    $score = $nextScore;
                }
            }
            else
            {
                if ($nextScore < $score)
                {
                    $score = $nextScore;
                }

            }
        }

        return $score;
    }

    /**
     * @param State $state
     * @param int $pos
     * @return State
     */
    private function CalculateMove(State $state, int $pos)
    {
        $engine = new TicTacToe($state);
        return $engine->Move($pos, $state->GetTurn());
    }

    /**
     * @param State $state
     * @return mixed
     */
    public function Move(State $state)
    {
        $available = $this->FilterCells($state->GetBoard());

        $availablePositions = [];

        foreach ($available as $i => $a)
        {
            $nextState = $this->CalculateMove($state, $i);
            $score = $this->MinMaxValue($nextState);
            $availablePositions[$score] = $i;
        }

        ksort($availablePositions);

        if ($state->GetTurn() === BasePiece::Cross)
        {
            $pos = array_pop($availablePositions);
        }
        else
        {
            $pos = array_shift($availablePositions);
        }

        return $pos;
    }
}