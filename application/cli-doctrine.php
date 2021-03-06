<?php

/**
 * Doctrine CLI bootstrap for CodeIgniter
 *
 */

define('APPPATH', __DIR__ . '/');
define('BASEPATH', APPPATH . '/../system/');
define('ENVIRONMENT', 'development');

require APPPATH.'config/autoload.php';
require APPPATH.'vendor/autoload.php';
require APPPATH.'libraries/Doctrine.php';
require APPPATH.'libraries/traits/Timestampable.php';

$doctrine = new Doctrine;
$em = $doctrine->GetEntityManager();

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
));

\Doctrine\ORM\Tools\Console\ConsoleRunner::run($helperSet);