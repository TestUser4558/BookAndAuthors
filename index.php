<?php

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Flash\Messages;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Message;
use Slim\Views\PhpRenderer;
use Src\Controllers\AdminController;
use Src\Controllers\HomeController;
use Src\Controllers\BookController;
use Src\Middleware\AuthMiddleware;
use Src\Controllers\AuthController;
use Src\Controllers\AuthorController;

require __DIR__ . '/vendor/autoload.php';
session_start();
$container = new Container();
AppFactory::setContainer ($container);
$app = AppFactory::create();
$container->set(PhpRenderer::class, function() use ($container) {
    return new PhpRenderer (__DIR__ . '/templates', ['messages'=> $container->get(Messages::class)]);
});
$container->set(Message::class, function() {
    return new Messages();
});


ORM::configure('mysql:host=database;dbname=docker');
ORM::configure('username', 'root');
ORM::configure('password', 'tiger');

$app->get('/', [HomeController::class, "index"]);
$app->get('/login', [AuthController::class, "loginPage"]);
$app->get('/logout', [AuthController::class, "logout"]);
$app->post('/auth/login', [AuthController::class, "login"]);
$app->get('/register', [AuthController::class, "registerPage"]);
$app->post('/auth/register', [AuthController::class, "register"]);
$app->group('/', function() use ($app){
    $app->get('/admin/books', [AdminController::class, 'index']);
    $app->get('/admin/books/{id}', [BookController::class, 'rent']);
    $app->post('/admin/books/{id}', [BookController::class, 'book']);
    $app->get('/admin/create', [AdminController::class, "create"]);
    $app->get('/admin/{id}/edit', [AdminController::class, "edit"]);
    $app->get('/admin/{id}/delete', [AdminController::class, "delete"]);
    $app->post('/admin/create', [AdminController::class, "store"]);
    $app->post('/admin/{id}/edit', [AdminController::class, "update"]);
    $app->get('/admin/{id}/return', [BookController::class, "rtrn"]);
    $app->get('/admin/authors', [AuthorController::class, 'index']);
    $app->get('/admin/authors/create', [AuthorController::class, "create"]);
    $app->post('/admin/authors/create', [AuthorController::class, "store"]);
    $app->get('/admin/authors/{id}/edit', [AuthorController::class, "edit"]);
    $app->post('/admin/authors/{id}/edit', [AuthorController::class, "update"]);
    $app->get('/admin/authors/{id}/delete', [AuthorController::class, "delete"]);
})->add(new AuthMiddleware($container->get(ResponseFactory::class)));
$app->run();
