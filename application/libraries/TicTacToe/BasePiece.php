<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 8:54 PM
 */

namespace libraries\TicTacToe;


abstract class BasePiece implements IPiece
{
    const Naught = 'O';
    const Cross = 'X';

    /** @var  string **/
    protected $Name;

    /** @var  string **/
    protected $Symbol;

    public function GetName()
    {
        return $this->Name;
    }

    public function GetSymbol()
    {
        return $this->Symbol;
    }
}