<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/24/2017
 * Time: 5:34 PM
 */

namespace models;


use Doctrine\ORM\EntityManager;
use models\Entities\GameType;
use models\Entities\Player;
use Ramsey\Uuid\Uuid;

class Game
{
    /** @var null|GameType */
    private $_game = null;

    /** @var null|Uuid **/
    private $_id;

    /** @var null|Player **/
    private $_player1;

    /** @var null|Player **/
    private $_player2;

    /** @var null|Player **/
    private $_winner;

    /** @var \DateTime **/
    private $_startDate;

    /** @var \DateTime **/
    private $_endDate;

    /** @var int */
    private $_localPlayerCount;

    /** @var  GameType */
    private $_gameType;

    /** @var array  */
    private $_board = ["", "", "", "", "", "", "", "", ""];

    /**
     * Game constructor.
     * @param Entities\Game|null $game
     */
    public function __construct(Entities\Game $game = null)
    {
        $this->_game = $game;

        if ($game != null)
        {
            $this->_id = $game->GetId();
            $this->_player1 = $game->GetPlayer1();
            $this->_player2 = $game->GetPlayer2();
            $this->_winner = $game->GetWinner();
            $this->_startDate = $game->GetDateCreated();
            $this->_dateCreated = $game->GetDateEnded();
            $this->_gameType = $game->GetGameType();
            $this->_board = $game->GetState()->GetBoard();
            $this->SetLocalPlayerCount($game->GetGameType());
        }
    }

    /**
     * @param GameType $gameType
     * @return Game
     */
    public function SetLocalPlayerCount(GameType $gameType) : Game
    {
        switch ($gameType->GetId())
        {
            case GameType::Singleplayer :
                $this->_localPlayerCount = 1;
                break;
            case GameType::Multiplayer :
                $this->_localPlayerCount = 1;
                break;
            case GameType::Hotseat :
                $this->_localPlayerCount = 2;
                break;
        }

        return $this;
    }

    /** @return int */
    public function GetLocalPlayerCount() : int
    {
        return $this->_localPlayerCount;
    }

    /** @return Uuid */
    public function GetId() : Uuid
    {
        return $this->_id;
    }

    /** @return Player */
    public function GetPlayer1() : Player
    {
        return $this->_player1;
    }

    /**
     * @param Player $player
     * @return Game
     */
    public function SetPlayer1(Player $player) : Game
    {
        $this->_player1 = $player;
        return $this;
    }

    /** @return Player */
    public function GetPlayer2() : Player
    {
        return $this->_player2;
    }

    /**
     * @param Player $player
     * @return Game
     */
    public function SetPlayer2(Player $player) : Game
    {
        $this->_player2 = $player;
        return $this;
    }

    /** @return Player */
    public function GetWinner() : Player
    {
        return $this->_winner;
    }

    /**
     * @param Player $player
     * @return Game
     */
    public function SetWinner(Player $player) : Game
    {
        $this->_winner = $player;
        return $this;
    }

    /**
     * @return GameType
     */
    public function GetGameType() : GameType
    {
        return $this->_gameType;
    }

    /**
     * @param GameType $gameType
     * @return Game
     */
    public function SetGameType(GameType $gameType) : Game
    {
        $this->_gameType = $gameType;
        return $this;
    }

    /**
     * @return array
     */
    public function GetBoard() : array
    {
        return $this->_board;
    }

    /**
     * @param array $board
     * @return Game
     */
    public function SetBoard(array $board) : Game
    {
        $this->_board = $board;
        return $this;
    }
}