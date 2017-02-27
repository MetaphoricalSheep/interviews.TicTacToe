<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/25/2017
 * Time: 3:35 PM
 */

namespace libraries\ApiLayer;


use Doctrine\ORM\EntityManager;
use libraries\TicTacToe\enums\StateEnum;
use libraries\TicTacToe\exceptions\GameNotFoundException;
use libraries\TicTacToe\TicTacToe;
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

        $state = new Entities\State();
        $game = new Entities\Game();

        $game
            ->SetPlayer1($player1)
            ->SetPlayer2($player2)
            ->SetGameType($type)
            ->SetState($state);

        $state->SetGame($game);

        try
        {
            $em->persist($game);
            $em->persist($state);
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

    /**
     * @param string $gameId
     * @param string $piece
     * @param string $playerId
     * @param int $x
     * @param int $y
     * @return int
     */
    public function Move(string $gameId, string $piece, string $playerId, int $x, int $y): int
    {
        /** @var Entities\Game $game **/
        $game = $this->_em->getRepository('\models\Entities\Game')->find($gameId);

        if ($game == null)
        {
            return false;
        }

        $player = $this->_em->getRepository('\models\Entities\Player')->find($playerId);

        if ($player == null)
        {
            return false;
        }

        if ($game->GetState()->GetState() > 2)
        {
            return $game->GetState()->GetState();
        }

        $engine = new TicTacToe($game->GetState()->MapToEngine());
        $state = $game->GetState()->MapFromEngine($engine->Move($this->GetPos($x, $y), $piece));

        $this->_em->persist($state);
        $this->_em->flush();

        return $state->GetState();
    }

    private function GetPos(int $x, int $y) : int
    {
        //don't judge me....I'm tired
        //todo: Be better
        if ($x == 0 && $y == 0)
            return 0;
        else if ($x == 0 && $y == 1)
            return 1;
        else if ($x == 0 && $y == 2)
            return 2;
        else if ($x == 1 && $y == 0)
            return 3;
        else if ($x == 1 && $y == 1)
            return 4;
        else if ($x == 1 && $y == 2)
            return 5;
        else if ($x == 2 && $y == 0)
            return 6;
        else if ($x == 2 && $y == 1)
            return 7;
        else
            return 8;
    }
}