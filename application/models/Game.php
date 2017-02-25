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
    /** @var Uuid **/
    protected $Id;

    /** @var null|Player **/
    protected $Player1;

    /** @var null|Player **/
    protected $Player2;

    /** @var null|Player **/
    protected $Winner;

    /** @var \DateTime **/
    protected $StartDate;

    /** @var \DateTime **/
    protected $EndDate;

    /** @var  int */
    protected $LocalPlayerCount;

    /**
     * Game constructor.
     * @param int $gameTypeId
     * @param null|Entities\Game $game
     */
    public function __construct(int $gameTypeId, Entities\Game $game = null)
    {
        if ($game != null)
        {
            $this->Id = $game->GetId();
            $this->Player1 = $game->GetPlayer1();
            $this->Player2 = $game->GetPlayer2();
            $this->Winner = $game->GetWinner();
            $this->StartDate = $game->GetDateCreated();
            $this->DateCreated = $game->GetDateEnded();
            $this->SetLocalPlayerCount($game->GetGameType()->GetId());
        }
        else
        {
            $this->SetLocalPlayerCount($gameTypeId);
        }
    }

    /**
     * @param int $id
     * @return Game
     */
    private function SetLocalPlayerCount(int $id) : Game
    {
        switch ($id)
        {
            case GameType::Singleplayer :
                $this->LocalPlayerCount = 1;
                break;
            case GameType::Multiplayer :
                $this->LocalPlayerCount = 1;
                break;
            case GameType::Hotseat :
                $this->LocalPlayerCount = 2;
                break;
        }
    }

    /** @return Uuid */
    public function GetId() : Uuid
    {
        return $this->Id;
    }

    /** @return Player */
    public function GetPlayer1() : Player
    {
        return $this->Player1;
    }

    /**
     * @param Player $player
     * @return Game
     */
    public function SetPlayer1(Player $player) : Game
    {
        $this->Player1 = $player;
        return $this;
    }

    /** @return Player */
    public function GetPlayer2() : Player
    {
        return $this->Player2;
    }

    /**
     * @param Player $player
     * @return Game
     */
    public function SetPlayer2(Player $player) : Game
    {
        $this->Player2 = $player;
        return $this;
    }

    /** @return Player */
    public function GetWinner() : Player
    {
        return $this->Winner;
    }

    /**
     * @param Player $player
     * @return Game
     */
    public function SetWinner(Player $player) : Game
    {
        $this->Winner = $player;
        return $this;
    }

    public function MapToDoctrine()
    {
        /** @var EntityManager $em */
        $em = $this->doctrine->GetEntityManager();
        $game = $em->getRepository('models\Entities\GameType')->find($this->Id);

        if ($game == null)
        {
            $game = new Entities\Game();
        }
    }
}