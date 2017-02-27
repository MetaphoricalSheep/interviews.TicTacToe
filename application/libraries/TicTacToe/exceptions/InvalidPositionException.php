<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 8:23 PM
 */

namespace libraries\TicTacToe\exceptions;


class InvalidPositionException extends \Exception
{
    protected $Message = "The position %s is invalid. Position must be an int between 0 and 8 that is not currently occupied.";
    protected $Code = 9000;

    public function __construct($position)
    {
        $message = sprintf($this->Message, $position);
        parent::__construct($message, $this->Code);
    }
}