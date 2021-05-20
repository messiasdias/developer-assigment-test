<?php
namespace App\Models;
use App\Models\Model;

class Person extends Model
{
    /**
     * $name variable
     *
     * @var string
     */
    private $name;

    /**
     * $email variable
     *
     * @var string
     */
    private $email;

    /**
     * $dateOfBirth variable
     *
     * @var string
     */
    private $dateOfBirth;

    /**
     * $city variable
     *
     * @var string
     */
    private $city;

    /**
     * $phone variable
     *
     * @var string
     */
    private $phone;

    /**
     * Set person name
     *
     * @param string $name
     *
     * @return Person
     */
    public function setName(string $name) : Person
    {
      if (strlen($name) < 4) {
        throw new \Exception('It is not a valid person name');
        return $this;
      }

      $this->name = ucwords($name);
      return $this;
    }

    /**
     * Get person name
     *
     * @return string|null
     */
    public function getName() : ?string
    {
      return $this->name;
    }

    /**
     * Set person email
     *
     * @param string $email
     * @throw \Exception
     * @return Person
     */
    public function setEmail(string $email) : Person
    {
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new \Exception('It is not a valid email address');
        return $this;
      }
      
      $this->email = strtolower($email);
      return $this;
    }

    /**
     * Get person email
     *
     * @return string|null
     */
    public function getEmail() : ?string
    {
      return $this->email;
    }


    /**
     * Set person city
     *
     * @param string $city
     *
     * @return Person
     */
    public function setCity(string $city) : Person
    {
      if (strlen($city) < 2) {
        throw new \Exception('It is not a valid city name');
        return $this;
      }

      $this->city = ucwords($city);
      return $this;
    }

    /**
     * Get person city
     *
     * @return string|null
     */
    public function getCity() : ?string
    {
      return $this->city;
    }


    /**
     * Set person phone number
     *
     * @param string $phone
     *
     * @return Person
     */
    public function setPhone(string $phone) : Person
    {
      $regex = "/\+?([0-9]{2,3})\ ?\(?([0-9]{2,3})\)?\ ?([0-9]{8,9})/";
      if ((strlen($phone) < 8) || !preg_match($regex, $phone)) {
        throw new \Exception('It is not a valid phone number');
        return $this;
      }

      $this->phone = $phone;
      return $this;
    }

    /**
     * Get person phone number
     *
     * @return string|null
     */
    public function getPhone() : ?string
    {
      return $this->phone;
    }


    /**
     * Set person date of birth
     *
     * @param string $date Format yyyy-md-dd
     *
     * @return Person
     */
    public function setDateOfBirth(string $date) : Person
    {
      if (date('Y-m-d', strtotime($date)) !== $date) {
        throw new \Exception('It is not a valid date');
        return $this;
      }

      $this->dateOfBirth = $date;
      return $this;
    }

    /**
     * Get person date of birth
     *
     * @return string|null
     */
    public function getDateOfBirth() : ?string
    {
      return $this->dateOfBirth;
    }
}
