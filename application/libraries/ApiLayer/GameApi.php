<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/25/2017
 * Time: 3:35 PM
 */

namespace libraries\ApiLayer;


use Doctrine\ORM\EntityManager;
use models\Entities\GameType;
use models\Entities\Player;
use models\Game;

class GameApi implements IGameApi
{
    /** @var \Doctrine\ORM\EntityManager */
    private $_em;

    public function __construct(EntityManager $em)
    {
        $this->_em = $em;
    }

    /**
     * @param int $gameTypeId
     * @return Game
     */
    public function InstantiateGame(int $gameTypeId) : Game
    {
        /** @var GameType $gameType */
        $gameType = $this->_em->getRepository('models\Entities\GameType')->find($gameTypeId);
        $game = new Game();
        $game
            ->SetLocalPlayerCount($gameType)
            ->SetGameType($gameType);
        return $game;
    }

    /**
     * @param string $name
     * @return Player
     */
    public function CreatePlayer(string $name) : Player
    {
        $player = $this->_em->getRepository('models\Entities\Player')->findBy(['CharacterName' => $name]);

        if ($player == null)
        {
            $player = new Player();
            $player->SetCharacterName($name);
            $this->_em->persist($player);
            $this->_em->flush();
        }

        return $player;
    }
}