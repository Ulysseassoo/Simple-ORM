<?php


require_once(__DIR__.'/../vendor/autoload.php');
require(__DIR__.'/../Controller/TicketController.php');
require(__DIR__.'/../Controller/CommentController.php');


use Bramus\Router\Router;

$router = new Router();

$router->get('api/tickets', 'App\Controller\TicketController@getAll');
$router->get('api/tickets/(\d+)', 'App\Controller\TicketController@getTicket');
$router->get('api/tickets/export/(\d+)', 'App\Controller\TicketController@export');
$router->post('api/tickets', 'App\Controller\TicketController@createTicket');
$router->get('api/comments', 'App\Controller\CommentController@getComments');
$router->get('api/comments/ticket/(\d+)', 'App\Controller\CommentController@getComment');
$router->post('api/comments/ticket/(\d+)', 'App\Controller\CommentController@createComment');

$router->run();