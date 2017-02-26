<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 11:05 PM
 */

use libraries\ApiLayer\GameApi;
use libraries\ApiLayer\IGameApi;
use libraries\AjaxResponse;
use models\ViewModels\GameSetup\GameSetupViewModel;

/**
 * Class NewGameController
 * @package controllers
 */
class GameSetupController extends CI_Controller
{
    /** @var IGameApi GameApi  */
    private $_gameApi;

    public function __construct()
    {
        parent::__construct();
        $this->_gameApi = new GameApi($this->doctrine->GetEntityManager());
    }

    /**
     * @param int $gameTypeId
     */
    public function index(int $gameTypeId)
    {
        $game = $this->_gameApi->InstantiateGame($gameTypeId);

        $viewModel = new GameSetupViewModel();
        $viewModel
            ->SetLocalPlayerCount($game->GetLocalPlayerCount())
            ->SetGameType($game->GetGameType())
            ->SetJavaScript('character')
            ->SetJavaScript('game');
        $viewModel
            ->SetTitle('Tic Tac Toe - Game Setup')
            ->SetView('gamesetup');

        $this->load->view('master', ['viewModel' => $viewModel]);
    }

    /**
     * @param string $name
     */
    public function CreatePlayer(string $name)
    {
        $response = new AjaxResponse(true);
        $response->SetData($this->_gameApi->CreatePlayer($name));
        $response->ReturnResult();
    }

    public function CreateGame()
    {
        $playerIds = $this->input->post('players');
        $gameTypeId = $this->input->post('gameType');

        $gameId = $this->_gameApi->CreateGame($playerIds, $gameTypeId);
        $response = new AjaxResponse(true);

        if ($gameId == "")
        {
            $response
                ->SetSuccess(false)
                ->SetError("Could not create game.")
                ->SetData([])
                ->ReturnResult();
            return false;
        }

        $response
            ->SetData(["gameid" => $gameId])
            ->ReturnResult();
        return true;
    }
}