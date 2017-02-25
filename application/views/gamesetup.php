<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('form');
/** @var models\ViewModels\GameSetup\IGameSetupViewModel $viewModel */
?><div class="container-fluid GameSetup">
    <div>
        <h1>Tic Tac Toe</h1>
        <h2>Game Setup</h2>
        <h3><?=$viewModel->GetGameType()->GetLabel()?></h3>
    </div>

    <div class="row justify-content-md-center character">
        <?php
        $players = $viewModel->GetPlayers();

        for ($count = 1; $count <= $viewModel->GetLocalPlayerCount(); $count++) {?>
        <div class="col-md col-xs-12">
            <h4>Player <?=$count?></h4>
            <input type="text" min="4" max="80" class="form-control character-name" id="player_<?=$count?>_name"
                   placeholder="Character Name" autocomplete="off"/>
        </div>
        <?php } ?>
    </div>

    <div class="row buttons justify-content-md-center">
        <div class="col-6 col-sm-auto">
            <?=anchor('', 'Start', ['class' => 'start']);?>
        </div>
        <div class="col-6 col-sm-auto">
            <?=anchor('', 'Back', ['class' => 'back']);?>
        </div>
    </div>
</div>
