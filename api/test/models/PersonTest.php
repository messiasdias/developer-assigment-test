<?php
use PHPUnit\Framework\TestCase;
use App\Models\Person;

class PersonTest extends TestCase
{ 
   /**
   * $person variable
   *
   * @var Person
   */
    private $person;

    public function __construct()
    {
        parent::__construct();
        $this->person = new Person();
    }

    /**
     * Test set and get Person name
     *
     * @return void
     */
    public function testSetAndGetName()
    {
        /*
        //Expect Exception - 'It is not a valid person name'
        $this->expectException(\Exception::class);
        $this->person->setName('');

        //Expect Success
        $this->assertEquals(null, $this->person->getName());
        $this->assertInstanceOf(Person::class, $this->person->setName('Jhon Snow'));
        $this->assertEquals('Jhon Snow', $this->person->getName());
        */
        $this->person->name = '';
        $this->assertEquals('', $this->person->name);

        $this->person->name = 'Jhon Snow';
        $this->assertEquals('Jhon Snow', $this->person->name);
    }

    /**
     * Test set and get Person email
     *
     * @return void
     */
    public function testSetAndGetEmail()
    {
        /*
        //Expect Exception - 'It is not a valid email address'
        $this->expectException(\Exception::class);
        $this->person->setEmail('');

        //Expect Exception - 'It is not a valid email address'
        $this->expectException(\Exception::class);
        $this->person->setEmail('jhon.snow');

        //Expect Success
        $this->assertEquals(null, $this->person->getEmail());
        $this->assertInstanceOf(Person::class, $this->person->setEmail('jhon.snow@test.com'));
        $this->assertEquals('jhon.snow@test.com', $this->person->getEmail());
        */

        $this->person->email = '';
        $this->assertEquals('', $this->person->email);

        $this->person->email = 'jhon.snow@test.com';
        $this->assertEquals('jhon.snow@test.com', $this->person->email);
    }

    /**
     * Test set and get Person phone number
     *
     * @return void
     */
    public function testSetAndGetPhone()
    {
        /*
        //Expect Exception - 'It is not a valid phone name'
        $this->expectException(\Exception::class);
        $this->person->setPhone('');

        $this->expectException(\Exception::class);
        $this->person->setPhone('98987');

        /*
          Expect Success formats: 
          +91-151-1234567, 01234567891, +912345678901, +55(81)983538086 or +55 (81) 983538086
        */
        /*
        $this->assertEquals(null, $this->person->getPhone());
        $this->assertInstanceOf(Person::class, $this->person->setPhone('+5581983538086'));
        $this->assertEquals('+5581983538086', $this->person->getPhone());
        */

        $this->person->phone = '';
        $this->assertEquals('', $this->person->phone);

        $this->person->phone = '+5581983538086';
        $this->assertEquals('+5581983538086', $this->person->phone);
    }

    /**
     * Test set and get Person phone number
     *
     * @return void
     */
    public function testSetAndGetDateOfBirth()
    {   
        /*
        //Expect Exception - 'It is not a valid date'
        $this->expectException(\Exception::class);
        $this->person->setDateOfBirth('');

        //Expect Exception - 'It is not a valid date'
        $this->expectException(\Exception::class);
        $this->person->setDateOfBirth('2021-18-05');
        */

        /*
          Expect Success formats yyyy-md-dd
        */
        /*
        $this->assertEquals(null, $this->person->getDateOfBirth());
        $this->assertInstanceOf(Person::class, $this->person->setDateOfBirth('2021-05-18'));
        $this->assertEquals('2021-05-18', $this->person->getDateOfBirth());
        */
        $this->person->dateOfBirth = '';
        $this->assertEquals('', $this->person->dateOfBirth);

        $this->person->dateOfBirth = '2021-05-18';
        $this->assertEquals('2021-05-18', $this->person->dateOfBirth);
    } 
}
?>