<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 11:09 PM
 */

namespace models\ViewModels\GameSetup;


use Illuminate\Support\Collection;
use models\Entities\GameType;
use models\Entities\Player;
use models\ViewModels\BaseViewModel;

class GameSetupViewModel extends BaseViewModel implements IGameSetupViewModel
{
    /** @var GameType */
    private $GameType;

    /** @var int */
    private $LocalPlayerCount;

    /** @var Collection */
    private $Players;

    /**
     * NewGameViewModel constructor.
     * @param GameType|null
     */
    public function __construct($gameType = null)
    {
        $this->Players = new Collection();

        if ($gameType == null)
        {
            return $this;
        }

        $this->SetGameType($gameType);
        parent::__construct();

        return $this;
    }

    /** @return GameType */
    public function GetGameType(): GameType
    {
        return $this->GameType;
    }

    /**
     * @param GameType $gameType
     * @return IGameSetupViewModel
     */
    public function SetGameType(GameType $gameType): IGameSetupViewModel
    {
        $this->GameType = $gameType;
        return $this;
    }

    /** @return int */
    public function GetLocalPlayerCount(): int
    {
        return $this->LocalPlayerCount;
    }

    /**
     * @param int $count
     * @return IGameSetupViewModel
     */
    public function SetLocalPlayerCount(int $count): IGameSetupViewModel
    {
        $this->LocalPlayerCount = $count;
        return $this;
    }

    /** @return Collection */
    public function GetPlayers(): Collection
    {
        return $this->Players;
    }

    /**
     * @param Collection $players
     * @return IGameSetupViewModel
     */
    public function SetPlayers(Collection $players): IGameSetupViewModel
    {
        $this->Players = $players;
        return $this;
    }

    /**
     * @param Player $player
     * @return IGameSetupViewModel
     */
    public function AddPlayer(Player $player): IGameSetupViewModel
    {
        $this->Players->push($player);
        return $this;
    }
}