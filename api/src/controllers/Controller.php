<?php
namespace App\Controllers;

use DI\Container;
use Slim\Psr7\Factory\ResponseFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Controller
{
    /**
     * $container variable
     *
     * @var Container
     */
    protected $container;

    /**
     * Contruct Controller function
     *
     * @param \DI\Container $container
     */
    public function __construct(Container $container = null)
    {
        $this->container = $container;
    }

    /**
     * Create an instance of Psr\Http\Message\ResponseInterface and return this 
     * Content-Type as application/json format
     *
     * @param array $data
     * @param int $code
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function json($data = [], int $code = 200) : Response
    {
        $response = (new ResponseFactory)
                  ->createResponse()
                  ->withStatus($code)
                  ->withHeader('Content-Type', 'application/json');

        $write = $response->getBody()->write(json_encode($data));
        return $response;
    }

    /**
     * Create an instance of Psr\Http\Message\ResponseInterface and return this 
     * with specified http code and message
     * @param int $code
     * @param String $message
     *
     * @return Response
     */
    public function error(int $code = 400, String $message = null) : Response
    {
        return (new ResponseFactory)
            ->createResponse()
            ->withStatus($code, $message);
    }

    /**
     * Return array errors as json
     * @param int $code
     * @param String $message
     *
     * @return Response
     */
    public function errors(array $errors = [], int $code = 422) : Response
    {
        return $this->json(['errors' => $errors], $code);
    }


    public function only(Request $request, $keys = []) : Array
    {
      $parsedBody = $request->getParsedBody();
      $data = [];

      if ($parsedBody) {
        foreach ($parsedBody as $key => $value) {
          if (in_array($key, $keys)) {
            $data[$key] = $value;
          }
        }
      }

      return $data;
    }
}
