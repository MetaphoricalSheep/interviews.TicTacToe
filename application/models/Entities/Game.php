<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/20/2017
 * Time: 11:30 PM
 */

namespace models\Entities;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use libraries\traits\Timestampable;
use Ramsey\Uuid\Uuid;


/**
 * Class Game
 * @package model\Entities
 *
 * @Entity(repositoryClass="models\Repositories\GameRepository")
 * @Table(name="Game")
 */
class Game
{
    use Timestampable;

    /**
     * @var Uuid
     * @Id
     * @Column(type="uuid")
     * @GeneratedValue(strategy="CUSTOM")
     * @CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     **/
    protected $Id;

    /**
     * @var Player
     * @ManyToOne(targetEntity="Player", inversedBy="Games")
     * @JoinColumn(name="Player1Id", referencedColumnName="Id", nullable=false)
     **/
    protected $Player1;

    /**
     * @var Player
     * @ManyToOne(targetEntity="Player", inversedBy="Games")
     * @JoinColumn(name="Player2Id", referencedColumnName="Id", nullable=false)
     **/
    protected $Player2;

    /**
     * @var Player
     * @ManyToOne(targetEntity="Player", inversedBy="GamesWon")
     * @JoinColumn(name="WinnerId", referencedColumnName="Id", nullable=true)
     **/
    protected $Winner;

    /** @Column(type="datetime", name="DateEnded", nullable=true) **/
    protected $DateEnded;

    /**
     * @var GameType
     * @ManyToOne(targetEntity="GameType")
     * @JoinColumn(name="GameTypeId", referencedColumnName="Id", nullable=false)
     */
    protected $GameType;

    /**
     * @return Uuid
     */
    public function GetId() : Uuid
    {
        return $this->Id;
    }

    /**
     * @return Player
     */
    public function GetPlayer1() : Player
    {
        return $this->Player1;
    }

    /**
     * @param Player $player
     * @return Game
     */
    public function SetPlayer1($player) : Game
    {
        $player->AddToPlayer1Games($this);
        $this->Player1 = $player;
        return $this;
    }

    /**
     * @return Player
     */
    public function GetPlayer2() : Player
    {
        return $this->Player2;
    }

    /**
     * @param Player $player
     * @return Game
     */
    public function SetPlayer2($player) : Game
    {
        $player->AddToPlayer2Games($this);
        $this->Player2 = $player;
        return $this;
    }

    /**
     * @return null|Player
     */
    public function GetWinner() : ?Player
    {
        return $this->Winner;
    }

    /**
     * @param Player $player
     * @return Game
     */
    public function SetWinner($player) : Game
    {
        $player->AddToWins($this);
        $this->Winner = $player;
        return $this;
    }

    /** @return null|\DateTime */
    public function GetDateEnded() : ?\DateTime
    {
        return $this->DateEnded;
    }

    /**
     * @param \DateTime $date
     * @return Game
     */
    public function SetDateEnded(\DateTime $date) : Game
    {
        $this->DateEnded = $date;
        return $this;
    }

    /** @return GameType */
    public function GetGameType() : GameType
    {
        return $this->GameType;
    }

    /**
     * @param GameType $gameType
     * @return Game
     */
    public function SetGameType(GameType $gameType) : Game
    {
        $this->GameType = $gameType;
        return $this;
    }
}