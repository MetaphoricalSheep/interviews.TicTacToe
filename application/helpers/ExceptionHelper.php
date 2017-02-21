<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 8:29 PM
 */

function ExceptionDictionary()
{
    $exceptions = [
        9000 => [
            "Type" => "InvalidPositionException",
            "Description" => "When board position is out of bounds."
        ],
        9001 => [
            "Type" => "OutOfTurnException",
            "Description" => "When a player tries to play out of turn."
        ],
    ];
}