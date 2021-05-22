<?php
namespace App\Middlewares;

use Slim\Psr7\Factory\ResponseFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class GetParsedBody extends Middleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $parsedBody = array_merge(
          $request->getParsedBody() ?? [], 
          $request->getQueryParams() ?? [],
          json_decode($request->getBody()->__toString(), true) ?? []
        );
        return $handler->handle($request->withParsedBody($parsedBody));
    }
}
