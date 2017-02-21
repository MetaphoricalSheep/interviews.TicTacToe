<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 8:50 PM
 */

namespace TicTacToe\libraries\game;


interface IPiece
{
    public function GetName();
    public function GetSymbol();
}