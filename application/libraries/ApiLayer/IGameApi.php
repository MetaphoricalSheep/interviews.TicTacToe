<?php

namespace libraries\ApiLayer;


use models\Player;
use models\Game;

interface IGameApi
{
    /**
     * @param int $gameTypeId
     * @return Game
     */
    public function InstantiateGame(int $gameTypeId) : Game;

    /**
     * @param string $name
     * @return Player
     */
    public function CreatePlayer(string $name) : Player;

    /**
     * @param array $players
     * @param string $id
     * @return string
     */
    public function CreateGame(array $players, string $id) : string;

    /**
     * @param string $id
     * @return Game
     */
    public function GetGame(string $id) : Game;
}
