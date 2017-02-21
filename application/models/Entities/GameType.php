<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/20/2017
 * Time: 11:30 PM
 */

namespace models\Entities;

use Doctrine\ORM\Mapping\Entity;
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
     * @Id @Column(type="string", name="Name")
     **/
    protected $Name;

    /**
     * @var string
     * @Id @Column(type="string", name="Label")
     **/
    protected $Label;

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
     */
    public function SetName($name)
    {
        $this->Name = $name;
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
     */
    public function SetLabel($label)
    {
        $this->Label = $label;
    }
}