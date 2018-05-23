<?php
require 'Slim/Slim.php';
require 'tf2api.php';
use Slim\Slim;
\Slim\Slim::registerAutoloader();

$app = new Slim();

$app->get('/inv', 'list_inventory');
$app->get('/wep', 'list_mywep');
$app->get('/sch', 'list_schema');
$app->run();

?>
