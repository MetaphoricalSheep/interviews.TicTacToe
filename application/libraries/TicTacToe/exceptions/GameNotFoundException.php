<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 8:23 PM
 */

namespace libraries\TicTacToe\exceptions;


class GameNotFoundException extends \Exception
{
    protected $Message = "Game %s does not exist.";
    protected $Code = 8000;

    /**
     * GameNotFoundException constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        $message = sprintf($this->Message, $id);
        parent::__construct($message, $this->Code);
    }
}