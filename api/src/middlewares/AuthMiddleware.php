<?php
namespace App\Middlewares;

use Slim\Psr7\Factory\ResponseFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class AuthMiddleware extends Middleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        //Temporary|Demo authorization
        if($request->getHeaderLine('Authorization')) {
          return $handler->handle($request);
        }

        $response = (new ResponseFactory)
        ->createResponse(401)
        ->withHeader('Content-Type', 'application/json');
        
        $response
        ->getBody()
        ->write(
            json_encode([
              'status' => ['message' => "Unauthorized", 'code' => 401]
            ])
        );

        return $response;
    }
}
