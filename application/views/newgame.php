<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/** @var models\ViewModels\NewGame\INewGameViewModel $viewModel */
?><div class="container-fluid NewGame">
    <div>
        <h1>Tic Tac Toe</h1>
        <h2>New Game</h2>
    </div>

    <div class="row justify-content-center">
        <div class="col">
            <div class="menu">
                <?php
                    $gameTypes = $viewModel->GetGameTypes();
                    $gameTypes->each(function($item) {
                        /** @var \models\Entities\GameType $item */
                        // Disable multiplayer for now
                        if ($item->GetId() != 2) {
                            echo anchor(sprintf('/game-setup/%s', $item->GetId()), $item->GetLabel(), [
                                'class' => sprintf('item item-%s %s', $item->GetId(),
                                    ($item->GetId() == 1) ? 'active' : ''),
                                'data-id' => $item->GetId(),
                                'data-controller' => $item->GetStartUrl(),
                                'data-start-label' => $item->GetStartLabel(),
                            ]);
                        }
                    });

                    /** @var \models\Entities\GameType $first */
                    $first = $gameTypes->first();

                    echo anchor(sprintf('/game-setup/%s', $first->GetId()), $first->GetStartLabel(), ['class' => 'start']);
                ?>
            </div>
        </div>
    </div>
</div>

