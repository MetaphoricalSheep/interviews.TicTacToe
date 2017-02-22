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
class NewGameController extends CI_Controller
{
    public function index()
    {
        $em = $this->doctrine->GetEntityManager();
        $viewModel = new NewGameViewModel($em->getRepository('models\Entities\GameType')->findAll());
        $viewModel
            ->SetTitle('Tic Tac Toe - New Game')
            ->SetView('NewGame/NewGame');
        $data = ['viewModel' => $viewModel];

        $this->load->view('master', $data);
    }
}