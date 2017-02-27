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

    /**
     * @param string $gameId
     * @param string $piece
     * @param string $playerId
     * @param int $x
     * @param int $y
     * @return int
     */
    public function Move(string $gameId, string $piece, string $playerId, int $x, int $y) : int;
}
