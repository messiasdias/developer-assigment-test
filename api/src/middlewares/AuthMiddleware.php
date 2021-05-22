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
        /*
          Temporary|Demo authorization Token 

          eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.
          eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkFwcCBUZXN0IiwiaWF0IjoxNjIxNTg3MzYwfQ.
          Fw-DnZ8f78D05W6_YVA9Jh4LnODmBpWyeN-6nSz62bc
        */
        $secret = 'Fw-DnZ8f78D05W6_YVA9Jh4LnODmBpWyeN-6nSz62bc';
        if($request->getHeaderLine('Authorization') ===  $secret) {
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
