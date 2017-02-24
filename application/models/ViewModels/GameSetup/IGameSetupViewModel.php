<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 11:16 PM
 */

namespace models\ViewModels\GameSetup;


use Illuminate\Support\Collection;

interface IGameSetupViewModel
{
    /**
     * @return Collection
     */
    public function GetGameTypes() : Collection;

    /**
     * @param Collection $gameTypes
     * @return INewGameViewModel
     */
    public function SetGameTypes($gameTypes) : INewGameViewModel;
}