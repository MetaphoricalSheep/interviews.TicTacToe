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
use libraries\TicTacToe\Marvin;
use libraries\TicTacToe\TicTacToe;
use models\Entities\GameType;
use models\Entities as Entities;
use models\Player;
use models\Game;
use models\Repositories\GameRepository;

class GameApi implements IGameApi
{
    /** @var \Doctrine\ORM\EntityManager */
    private $_em;
    /** @var array  */
    private $_board = [];

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

        switch ($state->GetState())
        {
            case StateEnum::Player1Wins:
                $game->SetWinner($game->GetPlayer1());
                $game->SetDateEnded(new \DateTime());
                $this->_em->persist($game);
                break;
            case StateEnum::Player2Wins:
                $game->SetWinner($game->GetPlayer2());
                $game->SetDateEnded(new \DateTime());
                $this->_em->persist($game);
                break;
            case StateEnum::Draw:
                $game->SetDateEnded(new \DateTime());
                $this->_em->persist($game);
                break;
        }

        $this->_em->persist($state);
        $this->_em->flush();

        $this->_board = $state->GetBoard();

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

    /**
     * @param int $limit
     * @return array
     */
    public function GetHistory(int $limit = 200): array
    {
        /** @var GameRepository $repo */
        $repo = $this->_em->getRepository('models\Entities\Game');
        $results = $repo->GetHistory($limit);
        $games = [];

        foreach ($results as $dbGame)
        {
            $game = new Game($dbGame);
            $games[] = $game->toArray();
        }

        return $games;
    }

    /**
     * @param string $gameId
     * @param string $piece
     * @param string $player
     * @return array
     */
    public function MoveMarvin(string $gameId, string $piece, string $player): array
    {
        /** @var Entities\Game $dbGame */
        $dbGame = $this->_em->getRepository('\models\Entities\Game')->find($gameId);
        $marvin = new Marvin();
        $move = $marvin->Move($dbGame->GetState()->MapToEngine());

        list($x, $y) = $this->GetXY($move);
        $state = $this->Move($gameId, $piece, $player, $x, $y);

        return ["state" => $state, "board" => $this->_board];
    }

    /**
     * @param $pos
     * @return array
     */
    public function GetXY($pos) : array
    {
        for ($x=0, $y=0, $p=0; $p < 9; $p++, $y++)
        {
            if ($y == 3)
            {
                $x++;
                $y=0;
            }

            if ($p == $pos) {
                return [$x, $y];
            }
        }
    }
}