<?php
use PHPUnit\Framework\TestCase;
use App\Controllers\PersonController;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Factory\ResponseFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PersonControllerTest extends TestCase
{ 
    /**
     * $person variable
     *
     * @var PersonController
     */
    private $controller;

     /**
     * $request variable
     *
     * @var ServerRequestInterface
     */
    private $request;
    
    /**
     * $response variable
     *
     * @var ResponseInterface
     */
    private $response;

    public function __construct()
    {
        //Run parent construct and instancing controller
        parent::__construct();
        $this->controller = new PersonController();

         //Create Server Request
         $this->request = (new ServerRequestFactory)->createServerRequest('POST', '/person');

         //Create Response
         $this->response = (new ResponseFactory)->createResponse();
    }

    /**
     * Create an test request from method, path and date
     *
     * @param string $method
     * @param string $path
     * @param string $data
     *
     * @return void
     */
    public function createRequest(string $method, string $target, array $data = [])
    {
        $request = (new ServerRequestFactory)
            ->createServerRequest($method, $target)
            ->withHeader('Content-Type', 'application/x-www-form-urlencoded')
            ->withParsedBody($data);
        return $request;
    }

    /**
     * Test if $this->controller is an instance of PersonController::class
     *
     * @return void
     */
    public function testInstance()
    {
        $this->assertInstanceOf(PersonController::class, $this->controller);
    }

    /**
     * Test PersonController create person
     *
     * @return void
     */
    public function testCreate()
    {
        //Expected - Bad request status 400
        $request = $this->createRequest('POST', '/person');
        $response = $this->controller->create($request, $this->response);
        $this->assertEquals(400, $response->getStatusCode());
        
        //Expected - Created status 201
        $data = [
            'name' => 'Jhon Snow',
            'email' => 'jhon_snow@test.com',
            'city' => 'Mystic Falls',
            'phone' => '+1 089 786543989',
            'dateOfBirth' => '1972-10-18',
        ];

        $request = $this->createRequest('POST', '/person', $data);
        $response = $this->controller->create($request, $this->response, );
        $this->assertEquals(201, $response->getStatusCode());

        //Expected -  Not Acceptable if person already exists status 406
        $request = $this->createRequest('POST', '/person', $data);
        $response = $this->controller->create($request, $this->response);
        $this->assertEquals(406, $response->getStatusCode());
    }


    /**
     * Test PersonController update person
     *
     * @return void
     */
    public function testUpdate()
    {
        //Create Server Request
        $request = $this->createRequest('PATCH', '/person');

        //Expected - Bad request status 400
        $response = $this->controller->update($request, $this->response);
        $this->assertEquals(400, $response->getStatusCode());

        //Expected - Not Found status 404
        $request = $this->createRequest('PATCH', '/person');
        $response = $this->controller->update($request, $this->response);
        $this->assertEquals(400, $response->getStatusCode());
        
        //Expected - OK status 200
        $data = [
            'id' => 1,
            'city' => 'Mystic Falls - Virginia',
        ];
        $request = $this->createRequest('PATCH', '/person', $data);
        $response = $this->controller->update($request, $this->response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * Test PersonController find an person
     *
     * @return void
     */
    public function testFind()
    {
        //Expected - OK status 200
        $request = $this->createRequest('GET', '/person/1');
        $response = $this->controller->find($request, $this->response, ['id' => 1]);
        $this->assertEquals(200, $response->getStatusCode());

        //Expected - OK status 404
        $request = $this->createRequest('GET', '/person/2');
        $response = $this->controller->find($request, $this->response, ['id' => 2]);
        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * Test PersonController find all persons
     *
     * @return void
     */
    public function testAll()
    {
        //Expected - OK status 200
        $request = $this->createRequest('GET', '/person');
        $response = $this->controller->all($request, $this->response, ['id' => 1]);
        $data = json_decode($response->getBody()->__toString());
        
        $this->assertEquals(1, count($data->data));
        $this->assertEquals(1, $data->data[0]->id);
        $this->assertEquals('Jhon Snow', $data->data[0]->name);
        $this->assertEquals('jhon_snow@test.com', $data->data[0]->email);
    }

    /**
     * Test PersonController delete an person
     *
     * @return void
     */
    public function testDelete()
    {

        $request = $this->createRequest('DELETE', '/person', ['id' => 1]);

        //Expected - OK status 200
        $response = $this->controller->delete($request, $this->response);
        $data = json_decode($response->getBody()->__toString());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $data->success);

        //Expected - Not Found status 404
        $response = $this->controller->delete($request, $this->response);
        $this->assertEquals(404, $response->getStatusCode());
    }
}