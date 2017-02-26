<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 11:05 PM
 */

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
    public function index(string $gameId)
    {
        $game = $this->_gameApi->GetGame($gameId);

        $viewModel = new PlayViewModel();
        $viewModel
            ->SetTitle('Tic Tac Toe - Game Setup')
            ->SetPartial('_resultsbar')
            ->SetJavaScript('board')
            ->SetView('play');

        $this->load->view('master', ['viewModel' => $viewModel]);
    }
}