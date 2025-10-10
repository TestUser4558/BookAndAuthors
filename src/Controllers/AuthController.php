<?php

namespace Src\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\PhpRenderer;
use Slim\Factory\AppFactory;
use Src\Controllers\PostController;

class AuthController extends Controller
{
    public function registerPage (RequestInterface $request, ResponseInterface $response, $args) {
        return $this->renderer->render($response, '/auth/register.php');
    }

    public function register(RequestInterface $request, ResponseInterface $response, $args) {
        $login = $request->getParsedBody()['login'];
        $password = $request->getParsedBody()['password'];
        $password_rep = $request->getParsedBody()['password_rep'];
        $users = \ORM::forTable('users');
        $user = $users->where('users.login', $login)->findOne();
        if ($user) {
            $this->messages->addMessage('userMessage', 'This username already used ');
            return $response->withStatus(302)->withHeader('Location', "/register");
        }
        if ($password !== $password_rep) {
            $this->messages->addMessage('userMessage', 'Password missmach');
            return $response->withStatus(302)->withHeader('Location', "/register");
        }
        $values=[
            'login' => $login,
            'password' => $password
        ];
        $users->create($values)->save();

        return $response->withStatus(302)->withHeader('Location', "/login");
    }
    public function loginPage (RequestInterface $request, ResponseInterface $response, $args) {
        return $this->renderer->render($response, '/auth/login.php');
    }
    public function login(RequestInterface $request, ResponseInterface $response, $args) {
        $login = $request->getParsedBody()['login'];
        $password = $request->getParsedBody()['password'];
        $user = \ORM::forTable("users")->where('users.login', $login)->findOne();
        if ($user == null) {
            $this->messages->addMessage('userMessage', 'This user does not exist');
            return $response->withStatus(302)->withHeader('Location', "/login");
        }
        if ( $password == $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            return $response->withStatus(302)->withHeader('Location', "/admin/books");
        }
        $this->messages->addMessage('userMessage', 'Password incorrect');
        return $response->withStatus(302)->withHeader('Location', "/login");
    }
    public function logout(RequestInterface $request, ResponseInterface $response, $args) {
        session_destroy();
        return $response->withStatus(302)->withHeader('Location', "/");
    }
}
