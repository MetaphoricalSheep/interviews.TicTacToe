<?php
/**
 * Created by PhpStorm.
 * User: pieterf
 * Date: 2017/02/27
 * Time: 10:08 AM
 */


use libraries\AjaxResponse;
use libraries\ApiLayer\GameApi;
use libraries\ApiLayer\IGameApi;
use models\ViewModels\Results\ResultsViewModel;

class ResultsController extends \CI_Controller
{
    /** @var IGameApi GameApi  */
    private $_gameApi;

    public function __construct()
    {
        parent::__construct();
        $this->_gameApi = new GameApi($this->doctrine->GetEntityManager());
    }

    public function index()
    {
        $viewModel = new ResultsViewModel();
        $viewModel
            ->SetTitle('Tic Tac Toe - Game Setup')
            ->SetJavaScript('board')
            ->SetView('results');

        $this->load->view('master', ['viewModel' => $viewModel]);
    }

    /**
     * @param int $limit
     */
    public function GetHistory(int $limit)
    {
        $games = $this->_gameApi->GetHistory($limit);

        $response = new AjaxResponse(true);
        $response->SetData($games);
        $response->ReturnResult();
    }

    /**
     * @param string $gameId
     */
    public function GetBoard(string $gameId) : void
    {
        $game = $this->_gameApi->GetGame($gameId);

        $response = new AjaxResponse(true);
        $response->SetData($game->toArray());
        $response->ReturnResult();
    }
}