<?php

use Symfony\Component\Console\Application;

define('APPPATH', __DIR__ . '/');
define('BASEPATH', APPPATH . '/../system/');
define('ENVIRONMENT', 'development');

require APPPATH.'vendor/autoload.php';
require APPPATH.'libraries/Doctrine.php';
require APPPATH.'console/SeedGameTypesCommand.php';
require APPPATH.'libraries/traits/Timestampable.php';

$doctrine = new Doctrine;
$em = $doctrine->em;

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
));

$cli = new Application('tic.tac.toe-cli', 'v1.0');
$cli->setCatchExceptions(true);
$cli->setHelperSet($helperSet);
$cli->addCommands([
    new \console\SeedGameTypesCommand()
]);

$cli->run();
