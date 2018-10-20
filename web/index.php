<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 17.10.18
 * Time: 11:49
 */


require_once __DIR__ . '/../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('../templates/');
$twig = new Twig_Environment($loader, array('debug' => true, 'employees' => '$employee'));

$database = new \App\Model\Database();

$router = new \App\Router($database, $twig);

echo $router->process($_GET);