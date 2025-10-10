<?php
namespace Src\Controllers;

use ORM;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\PhpRenderer;
use Slim\Factory\AppFactory;
use Src\Controllers\PostController;

class AuthorController extends Controller
{
    public function index(RequestInterface $request, ResponseInterface $response, $args) {
        $authors= \ORM::forTable('authors')->findMany();
        return $this->renderer->render($response, '/admin/authors.php', ['authors'=> $authors]);
    }
    public function create(RequestInterface $request, ResponseInterface $response, $args) {
        return $this->renderer->render($response, '/admin/createAuthor.php');
    }
    public function store(RequestInterface $request, ResponseInterface $response, $args) {
        $authors = \ORM::forTable('authors');
        $values = [
        'name' => $request->getParsedBody()['name'],
        ];
        $authors->create($values)->save();
        return $response->withStatus(302)->withHeader('Location', "/admin/authors");
    }
    public function edit(RequestInterface $request, ResponseInterface $response, $args) {
        $author = \ORM::forTable("authors")->findOne($args['id']);
        return $this->renderer->render($response, '/admin/editAuthors.php', ['author' => $author]);
    }
    public function update(RequestInterface $request, ResponseInterface $response, $args) {
        $author = \ORM::forTable('authors')->findOne($args['id']);
        $values = [
        'name' => $request->getParsedBody()['name']
        ];
        $author->set($values)->save();
        return $response->withStatus(302)->withHeader('Location', "/admin/authors");
    }
    public function delete(RequestInterface $request, ResponseInterface $response, $args) {
        $id = $args['id'];
        $authors = \ORM::forTable('authors')->findOne($id);
        $authors ->delete();
        return $response->withStatus(302)->withHeader('Location', "/admin/authors");
    }
}
