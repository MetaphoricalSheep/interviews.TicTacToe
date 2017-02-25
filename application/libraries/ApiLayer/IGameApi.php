<?php

namespace libraries\ApiLayer;


use models\Entities\Player;
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
}
