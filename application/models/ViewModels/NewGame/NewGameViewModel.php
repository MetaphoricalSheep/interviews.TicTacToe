<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 11:09 PM
 */

namespace models\ViewModels\NewGame;


use Illuminate\Support\Collection;
use models\ViewModels\BaseViewModel;

class NewGameViewModel extends BaseViewModel
{
    /** @var Collection */
    private $GameTypes;

    /**
     * @return Collection
     */
    public function GetGameTypes() : Collection
    {
        return $this->GameTypes;
    }

    /**
     * @param Collection $gameTypes
     * @return $this
     */
    public function SetGameTypes($gameTypes)
    {
        $this->GameTypes = $gameTypes;
        return $this;
    }
}