<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/20/2017
 * Time: 10:48 PM
 */

namespace TicTacToe\application\libraries\traits;

/**
 * Class Timestampable
 * @package TicTacToe\application\libraries\traits
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
trait Timestampable
{
    /** @Column(type="datetime", name="DateCreated") **/
    protected $DateCreated;

    /** @Column(type="datetime", name="DateModified") **/
    protected $DateModified;

    public function __construct()
    {
        if ($this->DateCreated == null)
        {
            $this->DateCreated = new \DateTime();
        }

        if ($this->DateModified == null)
        {
            $this->DateModified = $this->DateCreated;
        }
    }

    public function GetDateCreated()
    {
        return $this->DateCreated;
    }

    public function GetDateModified()
    {
        return $this->DateModified;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateDateModified()
    {
        $this->DateModified = new \DateTime();
    }
}