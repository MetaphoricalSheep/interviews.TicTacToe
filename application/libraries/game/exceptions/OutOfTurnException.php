<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 9:04 PM
 */

namespace libraries\game\exceptions;


class OutOfTurnException extends \Exception
{
    protected $Message = "It is not currently player %s's turn.";
    protected $Code = 9001;

    public function __construct($symbol)
    {
        $message = sprintf($this->Message, $symbol);
        parent::__construct($message, $this->Code);
    }

}