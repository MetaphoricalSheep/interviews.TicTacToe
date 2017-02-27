<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 11:05 PM
 */

use libraries\AjaxResponse;
use libraries\ApiLayer\GameApi;
use libraries\ApiLayer\IGameApi;
use models\ViewModels\Play\PlayViewModel;

/**
 * Class PlayController
 * @package controllers
 */
class PlayController extends CI_Controller
{
    /** @var IGameApi GameApi  */
    private $_gameApi;

    public function __construct()
    {
        parent::__construct();
        $this->_gameApi = new GameApi($this->doctrine->GetEntityManager());
    }

    /**
     * @param string $gameId
     */
    public function index(string $gameId) : void
    {
        $game = $this->_gameApi->GetGame($gameId);

        $viewModel = new PlayViewModel();
        $viewModel
            ->SetTitle('Tic Tac Toe - Game Setup')
            ->SetPartial('_resultsbar')
            ->SetJavaScript('board')
            ->SetView('play');
        $viewModel
            ->SetGameId($gameId)
            ->SetPlayer1($game->GetPlayer1()->GetId())
            ->SetPlayer2($game->GetPlayer2()->GetId())
            ->SetBoard($game->GetBoard());

        $this->load->view('master', ['viewModel' => $viewModel]);
    }

    /**
     * @param string $gameId
     */
    public function Move(string $gameId) : void
    {
        $piece = $this->input->post('piece');
        $player = $this->input->post('player');
        $x = $this->input->post('x');
        $y = $this->input->post('y');
        $state = $this->_gameApi->Move($gameId, $piece, $player, $x, $y);

        $response = new AjaxResponse(true);
        $response->SetData(["state" => $state, "piece" => $piece]);
        $response->ReturnResult();
    }
}