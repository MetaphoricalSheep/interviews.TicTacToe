<?php
/**
 * Created by PhpStorm.
 * User: Pieter-Uys Fourie
 * Date: 2/21/2017
 * Time: 11:05 PM
 */

namespace controllers;


use CI_Controller;
use models\ViewModels\BaseViewModel;

class NewGameController extends CI_Controller
{
    public function index()
    {
        $vm = new NewGameViewModel();

        $this->load->view('welcome_message', $data);
    }
}