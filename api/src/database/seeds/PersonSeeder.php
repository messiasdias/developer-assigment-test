<?php
namespace App\Database;

use App\Database\Seed;

class PersonSeeder extends Seed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $data = [];

        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'name' => $faker->firstName ." ". $faker->lastName,
                'email' => $faker->email,
                'phone' => $faker->e164PhoneNumber,
                'city' => $faker->city,
                'dateOfBirth' => $faker->date(),
                'created_at' =>  "{$faker->date()} {$faker->time()}",
                'updated_at' =>  "{$faker->date()} {$faker->time()}",
            ];
        }

        $this->table('person')->insert($data)->save();
    }
}
