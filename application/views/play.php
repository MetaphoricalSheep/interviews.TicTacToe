<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/** @var models\ViewModels\Play\IPlayViewModel $viewModel */
?><div id="wrapper" class="toggled">
    <?php ($partial = $viewModel->GetPartial('_resultsbar')) && $this->load->view($partial, ["viewModel" => $viewModel]); ?>
    <div class="container-fluid Play resultBar">
        <div>
            <h1>Tic Tac Toe</h1>
            <h2>New Game</h2>
        </div>

        <div class="row justify-content-center">
            <div class="col- board" data-game-id="<?=$viewModel->GetGameId()?>"
                 data-player1="<?=$viewModel->GetPlayer1()?>" data-player2="<?=$viewModel->GetPlayer2()?>">
                <canvas id="tic-tac-toe-board"></canvas>
            </div>
        </div>
    </div>
</div>
