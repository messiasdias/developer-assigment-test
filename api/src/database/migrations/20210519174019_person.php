<?php
declare(strict_types=1);

namespace App\Database;

use App\Database\Migration;

final class Person extends Migration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
      // create the table
      $table = $this->table('person');
      $table->addColumn('name', 'string')
            ->addColumn('email', 'string')
            ->addColumn('phone', 'string')
            ->addColumn('city', 'string')
            ->addColumn('dateOfBirth', 'date')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->create();   
    }
}
