<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ResponsesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        // Set the table name
        $this->setTable('responses'); // 'branches' is the table in the database

        // Set the display field
        $this->setDisplayField('name'); // 'name' is the column to display in the dropdown
        
    }
}
