<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class SentimentsTable extends Table
{
    public static function defaultConnectionName(): string
    {
        return 'sentiments'; // this tells it to use the 'sentiments' DB
    }

    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('sentiments'); // the table name in that DB
    }
}
