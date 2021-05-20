<?php
namespace App\Controllers;
use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Person;

class PersonController extends Controller
{
  /**
   * Get all persons
   *
   * @param Request $request
   * @param Response $response
   * @param mixed $args
   *
   * @return void
   */
  public function all(Request $request, Response $response, $args = []) {
    $persons = Person::all();
    if ($persons) {
      return $this->json($persons);
    }
    return $this->json([]);
  }

  /**
   * Find an person
   *
   * @param Request $request
   * @param Response $response
   * @param mixed $args
   *
   * @return void
   */
  public function find(Request $request, Response $response, $args = []) {
    $person = Person::find($args['id'] ?? 0);
    if ($person) {
      return $this->json($person);
    }
    return $this->json(null, 404);
  }

  /**
   * Create an person
   *
   * @param Request $request
   * @param Response $response
   * @param mixed $args
   *
   * @return void
   */
  public function create(Request $request, Response $response, $args = []) {
    if (!$request->getParsedBody()) {
      return $this->json(null, 400);
    }

    //validations here

    $data = $this->only($request, ['name', 'email', 'phone', 'city', 'dateOfBirth']);
    if (Person::where($data)->first()) {
      return $this->json(null, 406);
    }

    $person = Person::create($data);
    $person->save();
    return $this->json($person, 201);
  }

  /**
   * Update an person
   *
   * @param Request $request
   * @param Response $response
   * @param mixed $args
   *
   * @return void
   */
  public function update(Request $request, Response $response, $args = []) {
      if (!$request->getParsedBody()) {
        return $this->json(null, 400);
      }

      //validations here

      $data = $this->only($request, ['id', 'email', 'phone', 'city', 'dateOfBirth']);
      $person = Person::find($data['id']);
      
      if (!$person) {
        return $this->json(null, 404);
      }

      $person->fill($data)->save();
      return $this->json($person, 200);
  }

  /**
   * Delete an person
   *
   * @param Request $request
   * @param Response $response
   * @param mixed $args
   *
   * @return void
   */
  public function delete(Request $request, Response $response, $args = []) {
    if (!$request->getParsedBody()) {
      return $this->json(null, 400);
    }

    //validations here

    $data = $this->only($request, ['id']);
    $person = Person::find($data['id']);

    if (!$person) {
      return $this->json(null, 404);
    }

    return $this->json(['success' => $person->delete()]);
  }
}
