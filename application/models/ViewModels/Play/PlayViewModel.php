<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 11:09 PM
 */

namespace models\ViewModels\Play;


use models\ViewModels\BaseViewModel;

class PlayViewModel extends BaseViewModel implements IPlayViewModel
{
    /** @var string */
    private $_gameId;

    /** @var  string */
    private $_player1;

    /** @var  string */
    private $_player2;

    /** @var  array */
    private $_board = ["", "", "", "", "", "", "", "", ""];

    /** @return string */
    public function GetGameId(): string
    {
        return $this->_gameId;
    }

    /**
     * @param string $id
     * @return IPlayViewModel
     */
    public function SetGameId(string $id): IPlayViewModel
    {
        $this->_gameId = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function GetPlayer1(): string
    {
        return $this->_player1;
    }

    /**
     * @param string $id
     * @return IPlayViewModel
     */
    public function SetPlayer1(string $id): IPlayViewModel
    {
        $this->_player1 = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function GetPlayer2(): string
    {
        return $this->_player2;
    }

    /**
     * @param string $id
     * @return IPlayViewModel
     */
    public function SetPlayer2(string $id): IPlayViewModel
    {
        $this->_player2 = $id;
        return $this;
    }

    /**
     * @return array
     */
    public function GetBoard(): array
    {
        return $this->_board;
    }

    /**
     * @param array $board
     * @return IPlayViewModel
     */
    public function SetBoard(array $board): IPlayViewModel
    {
        $this->_board = $board;
        return $this;
    }
}