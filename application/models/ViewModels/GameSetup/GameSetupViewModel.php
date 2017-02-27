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
    private $_gameType;

    /** @var int */
    private $_localPlayerCount;

    /** @var Collection */
    private $_players;

    /**
     * NewGameViewModel constructor.
     * @param GameType|null
     */
    public function __construct($gameType = null)
    {
        $this->_players = new Collection();
        parent::__construct();

        if ($gameType == null)
        {
            return $this;
        }

        $this->SetGameType($gameType);

        return $this;
    }

    /** @return GameType */
    public function GetGameType(): GameType
    {
        return $this->_gameType;
    }

    /**
     * @param GameType $gameType
     * @return IGameSetupViewModel
     */
    public function SetGameType(GameType $gameType): IGameSetupViewModel
    {
        $this->_gameType = $gameType;
        return $this;
    }

    /** @return int */
    public function GetLocalPlayerCount(): int
    {
        return $this->_localPlayerCount;
    }

    /**
     * @param int $count
     * @return IGameSetupViewModel
     */
    public function SetLocalPlayerCount(int $count): IGameSetupViewModel
    {
        $this->_localPlayerCount = $count;
        return $this;
    }

    /** @return Collection */
    public function GetPlayers(): Collection
    {
        return $this->_players;
    }

    /**
     * @param Collection $players
     * @return IGameSetupViewModel
     */
    public function SetPlayers(Collection $players): IGameSetupViewModel
    {
        $this->_players = $players;
        return $this;
    }

    /**
     * @param Player $player
     * @return IGameSetupViewModel
     */
    public function AddPlayer(Player $player): IGameSetupViewModel
    {
        $this->_players->push($player);
        return $this;
    }
}