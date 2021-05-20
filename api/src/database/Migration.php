<?php

namespace App\Database;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Builder;
use Phinx\Migration\AbstractMigration;

class Migration extends AbstractMigration
{
    /** @var Manager $capsule */
    public $capsule;

    /** @var Builder $capsule */
    public $schema;

    public function init()
    {
        require __DIR__ . '/../settings.php';
        $this->capsule = new Manager;
        $this->capsule->addConnection($db_config);
        $this->capsule->bootEloquent();
        $this->capsule->setAsGlobal();
        $this->schema = $this->capsule->schema();
    }
}
