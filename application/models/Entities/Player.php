<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/20/2017
 * Time: 9:45 PM
 */

namespace models\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use libraries\traits\Timestampable;
use Ramsey\Uuid\Uuid;


/**
 * Class Player
 * @package models\Entities
 *
 * @Entity(repositoryClass="models\Repositories\PlayerRepository")
 * @Table(name="Player")
 */
class Player
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
     * @var string
     * @Column(type="string", length=80, name="Email", nullable=true)
     **/
    protected $Email;

    /**
     * @var string
     * @Column(type="string", length=80, name="CharacterName")
     **/
    protected $CharacterName;

    /**
     * @var ArrayCollection
     * @OneToMany(targetEntity="Game", mappedBy="Player1")
     **/
    protected $Games;

    /**
     * @var ArrayCollection
     * @OneToMany(targetEntity="Game", mappedBy="Player2")
     **/
    protected $Games2;

    /**
     * @var ArrayCollection
     * @OneToMany(targetEntity="Game", mappedBy="Winner")
     **/
    protected $GamesWon;

    public function Player()
    {
        $this->Games = new ArrayCollection();
        $this->Games2 = new ArrayCollection();
        $this->GamesWon = new ArrayCollection();
    }

    /**
     * @return Uuid
     */
    public function GetId() : Uuid
    {
        return $this->Id;
    }

    /**
     * @return string
     */
    public function GetEmail() : string
    {
        return $this->Email;
    }

    /**
     * @param string $email
     * @return Player
     */
    public function SetEmail($email) : Player
    {
        $this->Email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function GetCharacterName() : string
    {
        return $this->CharacterName;
    }

    /**
     * @param string $name
     * @return Player
     */
    public function SetCharacterName($name) : Player
    {
        $this->CharacterName = $name;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function GetGames() : ArrayCollection
    {
        return new ArrayCollection(array_merge($this->Games->toArray(), $this->Games2->toArray()));
    }

    /**
     * @param Game $game
     */
    public function AddToPlayer1Games($game)
    {
        $this->Games->add($game);
    }

    /**
     * @param Game $game
     */
    public function AddToPlayer2Games($game)
    {
        $this->Games2->add($game);
    }

    /**
     * @return ArrayCollection
     */
    public function GetWins() : ArrayCollection
    {
        return $this->GamesWon;
    }

    /**
     * @param Game $game
     */
    public function AddToWins($game)
    {
        $this->GamesWon->add($game);
    }
}