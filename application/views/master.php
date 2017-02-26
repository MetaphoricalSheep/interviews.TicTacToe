<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('url');
/** @var models\ViewModels\IViewModel $viewModel */
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?=$viewModel->GetTitle()?></title>
        <?php if (ENVIRONMENT == 'development') { ?>
        <link rel="stylesheet" href="<?=base_url('/css/bootstrap.css')?>">
        <link rel="stylesheet" href="<?=base_url('/css/tether-theme-arrows-dark.css')?>">
        <?php } else { ?>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css"
              integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ"
              crossorigin="anonymous">
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/css/tether-theme-arrows-dark.min.css">
        <?php } ?>
        <link rel="stylesheet" href="<?=base_url('/css/bootstrap.slate.min.css')?>">
        <link rel="stylesheet" href="<?=base_url('/css/style.css')?>">
        <?php $viewModel->LoadCss(); ?>
    </head>
    <body>
        <?php $this->load->view($viewModel->GetView(), ["viewModel" => $viewModel])?>

        <?php if (ENVIRONMENT == 'development') { ?>
        <script src="<?=base_url('/js/jquery.js')?>"></script>
        <script src="<?=base_url('/js/tether.js')?>"></script>
        <script src="<?=base_url('/js/bootstrap.js')?>"></script>
        <?php } else { ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"
                integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn"
                crossorigin="anonymous"></script>
        <?php } ?>
        <script src="<?=base_url('/js/app.js')?>"></script>
        <?php $viewModel->LoadJavaScript(); ?>
    </body>
</html>