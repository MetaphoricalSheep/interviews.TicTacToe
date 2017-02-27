<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/26/2017
 * Time: 11:25 AM
 */

namespace models;


class Player
{
    /** @var string */
    public $Id;
    /** @var string */
    public $Name;
    /** @var string */

    /**
     * Player constructor.
     * @param Entities\Player $player
     */
    public function __construct(Entities\Player $player)
    {
        $this->Id = $player->GetId()->toString();
        $this->Name = $player->GetCharacterName();
    }
}