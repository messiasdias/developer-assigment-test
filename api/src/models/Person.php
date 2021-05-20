<?php
namespace App\Models;
use App\Models\Model;

class Person extends Model
{
  /**
   * $table variable
   *
   * @var string
   */
  protected $table = 'person';

  /**
   * $fillable variable
   *
   * Filds in table persons
   * @var array
   */
  protected $fillable = [
    'name',
    'email',
    'dateOfBirth',
    'city',
    'phone'
  ];
}