<?php


require_once(__DIR__.'/../vendor/autoload.php');
require(__DIR__.'/../Controller/TicketController.php');
require(__DIR__.'/../Controller/CommentController.php');


use Bramus\Router\Router;

$router = new Router();

$router->get('/tickets', 'App\Controller\TicketController@getAll');
$router->get('/tickets/(\d+)', 'App\Controller\TicketController@getTicket');
$router->get('/tickets/export/(\d+)', 'App\Controller\TicketController@export');
$router->post('/tickets', 'App\Controller\TicketController@createTicket');
$router->get('/comments', 'App\Controller\CommentController@getComments');
$router->get('/comments/ticket/(\d+)', 'App\Controller\CommentController@getComment');
$router->post('/comments/ticket/(\d+)', 'App\Controller\CommentController@createComment');

$router->run();