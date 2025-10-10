<?php
namespace Src\Controllers;

use ORM;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\PhpRenderer;
use Slim\Factory\AppFactory;
use Src\Controllers\PostController;

class BookController extends Controller
{
    public function rent(RequestInterface $request, ResponseInterface $response, $args) {
        $id = $args['id'];
        $history = \ORM::forTable('history')->where("book_id", $id)->findMany();
        $book= \ORM::forTable('books')->findOne($id);
        return $this->renderer->render($response, '/admin/rent.php', ['history' => $history, 'book' => $book]);
    }
    public function book(RequestInterface $request, ResponseInterface $response, $args) {
        $id = $args['id'];
        $book = \ORM::forTable('history');
        $values = [
        'user' => $request->getParsedBody()['user'],
        'owner_id' => $_SESSION['user_id'],
        'book_id' => $id,
        'date_begin' => $request->getParsedBody()['dateBegin'],
        'date_end' => $request->getParsedBody()['dateEnd'],
        ];
        $book->create($values)->save();
        \ORM::forTable('books')->findOne($id)->set(['available' => 0])->save();
        return $response->withStatus(302)->withHeader('Location', "/admin/books");
    }
    public function rtrn(RequestInterface $request, ResponseInterface $response, $args) {
        $id = $args['id'];
        \ORM::forTable('books')->findOne($id)->set(['available' => 1])->save();
        return $response->withStatus(302)->withHeader('Location', "/admin/books/{$id}");
    }
}
