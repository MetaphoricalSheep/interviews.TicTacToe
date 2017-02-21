<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/20/2017
 * Time: 11:30 PM
 */

namespace models\Entities;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use libraries\traits\Timestampable;


/**
 * Class Game
 * @package model\Entities
 *
 * @Entity(repositoryClass="models\Repositories\GameRepository") @Table(name="Game")
 */
class Game
{
    use Timestampable;

    /**
     * @var integer
     * @Id @Column(type="integer") @GeneratedValue
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
     * @JoinColumn(name="WinnerId", referencedColumnName="Id", nullable=false)
     **/
    protected $Winner;

    /** @Column(type="datetime", name="DateEnded", nullable=true) **/
    protected $DateEnded;

    /**
     * @return int
     */
    public function GetId() : int
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
     */
    public function SetPlayer1($player)
    {
        $player->AddToPlayer1Games($this);
        $this->Player1 = $player;
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
     */
    public function SetPlayer2($player)
    {
        $player->AddToPlayer2Games($this);
        $this->Player2 = $player;
    }

    /**
     * @return Player
     */
    public function GetWinner() : Player
    {
        return $this->Winner;
    }

    /**
     * @param Player $player
     */
    public function SetWinner($player)
    {
        $player->AddToWins($this);
        $this->Winner = $player;
    }
}