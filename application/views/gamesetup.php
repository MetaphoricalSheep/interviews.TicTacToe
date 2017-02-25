<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/** @var models\ViewModels\GameSetup\IGameSetupViewModel $viewModel */
?><div class="container-fluid NewGame">
    <div>
        <h1>Tic Tac Toe</h1>
        <h2>Game Setup</h2>
    </div>

    <div class="row justify-content-center">
        <?php
        $players = $viewModel->GetPlayers();

        for ($count = 1; $count <= $viewModel->GetLocalPlayerCount(); $count++)
        {?>
        <div class="col">
            <h3>Player <?=$count?></h3>
        </div>
        <?php } ?>
    </div>
</div>
