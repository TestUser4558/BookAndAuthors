<?php

namespace Src\Controllers;

use ORM;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\PhpRenderer;
use Slim\Factory\AppFactory;
use Src\Controllers\PostController;

class AdminController extends Controller
{
    public function index (RequestInterface $request, ResponseInterface $response, $args) {
        $books = ORM::for_table('books')
            ->select('books.*')
            ->select_expr(
                '(SELECT GROUP_CONCAT(authors.name) 
                  FROM authors_books 
                  JOIN authors ON authors_books.author_id = authors.id 
                  WHERE authors_books.book_id = books.id)',
                'authors'
            )
            ->find_many();
        return $this->renderer->render($response, '/admin/index.php', ['books'=> $books]);
    }
    public function create(RequestInterface $request, ResponseInterface $response, $args) {
        $authors = \ORM::forTable('authors')->findMany();
        return $this->renderer->render($response, '/admin/create.php', ['authors'=> $authors]);
    }
    public function store(RequestInterface $request, ResponseInterface $response, $args) {
        $authors_books = \ORM::forTable('authors_books');
        $authors = $request->getParsedBody()['authors'];
        $values = [
        'name' => $request->getParsedBody()['name'],
        'available' =>  1
        ];
        $book = \ORM::forTable('books')->create($values);
        $book->save();
        foreach ($authors as $author) {
            $authors_books->create(['author_id'=>$author, 'book_id'=>$book->id])->save();
        }
        return $response->withStatus(302)->withHeader('Location', "/admin/books");
    }
    public function edit(RequestInterface $request, ResponseInterface $response, $args) {
        $book = \ORM::forTable("books")->findOne($args['id']);
        $authors = \ORM::forTable('authors')->findMany();
        return $this->renderer->render($response, '/admin/edit.php', ['book' => $book, 'authors'=> $authors]);
    }
    public function update(RequestInterface $request, ResponseInterface $response, $args) {
        $books = \ORM::forTable('books')->findOne($args['id']);
        $values = [
        'name' => $request->getParsedBody()['name']
        ];
        $authors_books = \ORM::forTable('authors_books');
        $authors = $request->getParsedBody()['authors'];
        $books = \ORM::forTable('books')->findOne($args['id']);
        $books->set($values)->save();
        $authors_books->where("book_id", $args['id'])->delete_many();
        foreach ($authors as $author) {
            $authors_books->create(['author_id'=>$author, 'book_id'=>$args['id']])->save();
        }
        return $response->withStatus(302)->withHeader('Location', "/admin/books");
    }
    public function delete(RequestInterface $request, ResponseInterface $response, $args) {
        $id = $args['id'];
        $books = \ORM::forTable('books')->findOne($id);
        $books ->delete();
        return $response->withStatus(302)->withHeader('Location', "/admin/books");
    }
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
    public function showAuthors(RequestInterface $request, ResponseInterface $response, $args) {
        $authors= \ORM::forTable('authors')->findMany();
        return $this->renderer->render($response, '/admin/authors.php', ['authors'=> $authors]);
    }
    public function createAuthor(RequestInterface $request, ResponseInterface $response, $args) {
        return $this->renderer->render($response, '/admin/createAuthor.php');
    }
    public function storeAuthor(RequestInterface $request, ResponseInterface $response, $args) {
        $authors = \ORM::forTable('authors');
        $values = [
        'name' => $request->getParsedBody()['name'],
        ];
        $authors->create($values)->save();
        return $response->withStatus(302)->withHeader('Location', "/admin/authors");
    }
    public function editAuthor(RequestInterface $request, ResponseInterface $response, $args) {
        $author = \ORM::forTable("authors")->findOne($args['id']);
        return $this->renderer->render($response, '/admin/editAuthors.php', ['author' => $author]);
    }
    public function updateAuthor(RequestInterface $request, ResponseInterface $response, $args) {
        $author = \ORM::forTable('authors')->findOne($args['id']);
        $values = [
        'name' => $request->getParsedBody()['name']
        ];
        $author->set($values)->save();
        return $response->withStatus(302)->withHeader('Location', "/admin/authors");
    }
    public function deleteAuthor(RequestInterface $request, ResponseInterface $response, $args) {
        $id = $args['id'];
        $authors = \ORM::forTable('authors')->findOne($id);
        $authors ->delete();
        return $response->withStatus(302)->withHeader('Location', "/admin/authors");
    }
}
