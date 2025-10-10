<?php

namespace Src\Controllers;

use ORM;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\PhpRenderer;
use Slim\Factory\AppFactory;
use Src\Controllers\PostController;

class HomeController extends Controller
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
        return $this->renderer->render($response, 'index.php', ['books'=> $books]);
    }

}
