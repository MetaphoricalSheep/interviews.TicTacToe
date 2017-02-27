<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 11:16 PM
 */

namespace models\ViewModels\Play;

use models\ViewModels\IViewModel;

interface IPlayViewModel extends IViewModel
{
    /** @return string */
    public function GetGameId() : string;

    /**
     * @param string $id
     * @return IPlayViewModel
     */
    public function SetGameId(string $id) : IPlayViewModel;

    /**
     * @return string
     */
    public function GetPlayer1() : string;

    /**
     * @param string $id
     * @return IPlayViewModel
     */
    public function SetPlayer1(string $id) : IPlayViewModel;

    /**
     * @return string
     */
    public function GetPlayer2() : string;

    /**
     * @param string $id
     * @return IPlayViewModel
     */
    public function SetPlayer2(string $id) : IPlayViewModel;

    /**
     * @return array
     */
    public function GetBoard() : array;

    /**
     * @param array $board
     * @return IPlayViewModel
     */
    public function SetBoard(array $board) : IPlayViewModel;
}