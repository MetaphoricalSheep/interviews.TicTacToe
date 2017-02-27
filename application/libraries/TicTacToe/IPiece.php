<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 8:50 PM
 */

namespace libraries\TicTacToe;


interface IPiece
{
    public function GetName();
    public function GetSymbol();
}