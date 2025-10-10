<?php

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Flash\Messages;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Message;
use Slim\Views\PhpRenderer;
use Src\Controllers\AdminController;
use Src\Controllers\HomeController;
use Src\Middleware\AuthMiddleware;
use Src\Controllers\AuthController;

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
    $app->get('/admin/books/{id}', [AdminController::class, 'rent']);
    $app->post('/admin/books/{id}', [AdminController::class, 'book']);
    $app->get('/admin/create', [AdminController::class, "create"]);
    $app->get('/admin/{id}/edit', [AdminController::class, "edit"]);
    $app->get('/admin/{id}/delete', [AdminController::class, "delete"]);
    $app->post('/admin/create', [AdminController::class, "store"]);
    $app->post('/admin/{id}/edit', [AdminController::class, "update"]);
    $app->get('/admin/{id}/return', [AdminController::class, "rtrn"]);
    $app->get('/admin/authors', [AdminController::class, 'showAuthors']);
    $app->get('/admin/authors/create', [AdminController::class, "createAuthor"]);
    $app->post('/admin/authors/create', [AdminController::class, "storeAuthor"]);
    $app->get('/admin/authors/{id}/edit', [AdminController::class, "editAuthor"]);
    $app->post('/admin/authors/{id}/edit', [AdminController::class, "updateAuthor"]);
    $app->get('/admin/authors/{id}/delete', [AdminController::class, "deleteAuthor"]);
})->add(new AuthMiddleware($container->get(ResponseFactory::class)));
$app->run();
