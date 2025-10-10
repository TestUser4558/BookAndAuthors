<?php

namespace Src\Middleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Handlers\Strategies\RequestHandler;
use Slim\Psr7\Factory\ResponseFactory;

class AuthMiddleware{
    public function __construct(private ResponseFactoryInterface $response) {
    }
    public function __invoke(RequestInterface $request, RequestHandlerInterface $handler ){
        if (!isset($_SESSION['user_id'])) {
            $response = $this->response->createResponse();
            return $response->withStatus(302)->withHeader('Location', "/login");
        }
        return $handler->handle($request);
        }
    
}
    
