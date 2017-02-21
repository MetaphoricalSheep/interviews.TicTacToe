<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/20/2017
 * Time: 10:48 PM
 */

namespace libraries\traits;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;

/**
 * Class Timestampable
 * @package TicTacToe\application\libraries\traits
 * @Entity
 * @HasLifecycleCallbacks
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
     * @PrePersist()
     * @PreUpdate()
     */
    public function updateDateModified()
    {
        $this->DateModified = new \DateTime();
    }
}