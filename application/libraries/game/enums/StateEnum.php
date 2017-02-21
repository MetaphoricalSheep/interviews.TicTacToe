<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 8:39 AM
 */

namespace TicTacToe\application\libraries\game\enums;


abstract class StateEnum
{
    const NewGame = 0;
    const InProgress = 1;
    const Player1Wins = 2;
    const Player2Wins = 3;
    const Draw = 4;
}