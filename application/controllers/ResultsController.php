<?php
/**
 * Created by PhpStorm.
 * User: pieterf
 * Date: 2017/02/27
 * Time: 10:08 AM
 */

namespace controllers;


use libraries\ApiLayer\GameApi;

class ResultsController extends \CI_Controller
{
    /** @var IGameApi GameApi  */
    private $_gameApi;

    public function __construct()
    {
        parent::__construct();
        $this->_gameApi = new GameApi($this->doctrine->GetEntityManager());
    }

    public function index() { }

    /**
     * @param string $gameId
     */
    public function GetBoard(string $gameId) : void
    {
        $game = $this->_gameApi->GetGame($gameId);
    }
}