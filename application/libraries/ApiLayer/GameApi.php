<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/25/2017
 * Time: 3:35 PM
 */

namespace libraries\ApiLayer;


use Doctrine\ORM\EntityManager;
use libraries\TicTacToe\exceptions\GameNotFoundException;
use models\Entities\GameType;
use models\Entities as Entities;
use models\Player;
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
        $dbPlayer = $this->_em->getRepository('models\Entities\Player')->findOneBy(['CharacterName' => $name]);

        if ($dbPlayer == null)
        {
            $dbPlayer = new Entities\Player();
            $dbPlayer->SetCharacterName($name);
            $this->_em->persist($dbPlayer);
            $this->_em->flush();
        }

        return new Player($dbPlayer);
    }

    /**
     * @param array $players
     * @param string $id
     * @return string
     */
    public function CreateGame(array $players, string $id): string
    {
        $em = $this->_em;
        /** @var \models\Entities\Player $player1 */
        $player1 = $em->getRepository('models\Entities\Player')->find($players[0]);
        /** @var \models\Entities\Player $player2 */
        $player2 = $em->getRepository('models\Entities\Player')->find($players[1]);
        /** @var \models\Entities\GameType $type */
        $type = $em->getRepository('models\Entities\GameType')->find($id);

        $game = new Entities\Game();
        $game
            ->SetPlayer1($player1)
            ->SetPlayer2($player2)
            ->SetGameType($type);

        try
        {
            $em->persist($game);
            $em->flush();

            return $game->GetId();
        }
        catch (\Exception $e)
        {
            return "";
        }
    }

    /**
     * @param string $id
     * @return Game
     * @throws GameNotFoundException
     */
    public function GetGame(string $id) : Game
    {
        $dbGame = $this->_em->getRepository('models\Entities\Game')->find($id);

        if ($dbGame == null)
        {
            throw new GameNotFoundException($id);
        }

        return new Game($dbGame);
    }
}