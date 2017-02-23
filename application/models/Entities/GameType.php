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
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;


/**
 * Class GameType
 * @package models\Entities
 *
 * @Entity(repositoryClass="models\Repositories\GameTypeRepository") @Table(name="GameType")
 */
class GameType
{
    /**
     * @var integer
     * @Id @Column(type="integer") @GeneratedValue
     **/
    protected $Id;

    /**
     * @var string
     * @Column(type="string", name="Name")
     **/
    protected $Name;

    /**
     * @var string
     * @Column(type="string", name="Label")
     **/
    protected $Label;

    /**
     * @var string
     * @Column(type="string", name="StartLabel")
     */
    protected $StartLabel;

    /**
     * @var string
     * @Column(type="string", name="StartUrl")
     */
    protected $StartUrl;

    /**
     * @return int
     */
    public function GetId() : int
    {
        return $this->Id;
    }

    /**
     * @return string
     */
    public function GetName() : string
    {
        return $this->Name;
    }

    /**
     * @param string
     * @return GameType
     */
    public function SetName($name) : GameType
    {
        $this->Name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function GetLabel() : string
    {
        return $this->Label;
    }

    /**
     * @param string
     * @return GameType
     */
    public function SetLabel($label) : GameType
    {
        $this->Label = $label;
        return $this;
    }

    /** @return string */
    public function GetStartLabel() : string
    {
        return $this->StartLabel;
    }

    /**
     * @param string $label
     * @return GameType
     */
    public function SetStartLabel(string $label) : GameType
    {
        $this->StartLabel = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function GetStartUrl() : string
    {
        return $this->StartUrl;
    }

    /**
     * @param string $url
     * @return GameType
     */
    public function SetStartUrl(string $url) : GameType
    {
        $this->StartUrl = $url;
        return $this;
    }
}