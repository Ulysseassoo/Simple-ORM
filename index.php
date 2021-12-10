<?php


require_once(__DIR__.'/../vendor/autoload.php');
require(__DIR__.'/../Controller/TicketController.php');
require(__DIR__.'/../Controller/CommentController.php');

use Bramus\Router\Router;

$router = new Router();

$router->get('/tickets', 'App\Controller\TicketController@findAll');