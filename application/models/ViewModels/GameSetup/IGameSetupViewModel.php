<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 11:16 PM
 */

namespace models\ViewModels\GameSetup;


use Illuminate\Support\Collection;
use models\Entities\GameType;
use models\Entities\Player;

interface IGameSetupViewModel
{
    /** @return GameType */
    public function GetGameType() : GameType;

    /**
     * @param GameType $gameType
     * @return IGameSetupViewModel
     */
    public function SetGameType(GameType $gameType) : IGameSetupViewModel;

    /** @return int */
    public function GetLocalPlayerCount() : int;

    /**
     * @param int $count
     * @return IGameSetupViewModel
     */
    public function SetLocalPlayerCount(int $count) : IGameSetupViewModel;

    /** @return Collection */
    public function GetPlayers() : Collection;

    /**
     * @param Collection $players
     * @return IGameSetupViewModel
     */
    public function SetPlayers(Collection $players) : IGameSetupViewModel;

    /**
     * @param Player $player
     * @return IGameSetupViewModel
     */
    public function AddPlayer(Player $player) : IGameSetupViewModel;
}