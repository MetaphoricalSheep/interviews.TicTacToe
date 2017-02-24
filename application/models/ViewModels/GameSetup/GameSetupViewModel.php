<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 11:09 PM
 */

namespace models\ViewModels\GameSetup;


use Illuminate\Support\Collection;
use models\ViewModels\BaseViewModel;

class GameSetupViewModel extends BaseViewModel
{
    /** @var Collection */
    private $GameTypes;

    /**
     * NewGameViewModel constructor.
     * @param Collection|null $gameTypes
     * @return
     */
    public function __construct($gameTypes = null)
    {
        if ($gameTypes == null)
        {
            return $this;
        }

        $this->SetGameTypes($gameTypes);
        parent::__construct();

        return $this;
    }

    /**
     * @return Collection
     */
    public function GetGameTypes() : Collection
    {
        return $this->GameTypes;
    }

    /**
     * @param Collection $gameTypes
     * @return NewGameViewModel
     */
    public function SetGameTypes($gameTypes) :NewGameViewModel
    {
        $this->GameTypes = $gameTypes;
        return $this;
    }
}