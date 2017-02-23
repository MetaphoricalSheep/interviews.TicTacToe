<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 11:05 PM
 */

use models\ViewModels\NewGame\NewGameViewModel;

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
        $viewModel = new NewGameViewModel($em->getRepository('models\Entities\GameType')->findAll());
        $viewModel
            ->SetTitle('Tic Tac Toe - New Game')
            ->SetView('newgame');
        $data = ['viewModel' => $viewModel];

        $this->load->view('master', $data);
    }
}