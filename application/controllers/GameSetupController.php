<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 11:05 PM
 */

use models\ViewModels\GameSetup\GameSetupViewModel;

/**
 * Class NewGameController
 * @package controllers
 */
class GameSetupController extends CI_Controller
{
    /**
     * @param int $gameType
     */
    public function index(int $gameType)
    {
        $em = $this->doctrine->GetEntityManager();
        $viewModel = new GameSetupViewModel($em->getRepository('models\Entities\GameType')->find($gameType));
        $viewModel
            ->SetTitle('Tic Tac Toe - Game Setup')
            ->SetView('gamesetup');
        $this->load->view('master', ['viewModel' => $viewModel]);
    }
}