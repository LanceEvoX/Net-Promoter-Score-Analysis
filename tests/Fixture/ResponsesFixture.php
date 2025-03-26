<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ResponsesFixture
 */
class ResponsesFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'form_id' => 1,
                'branch_id' => 1,
                'respondent_id' => 'Lorem ipsum dolor sit amet',
                'firstname' => 'Lorem ipsum dolor sit amet',
                'middlename' => 'Lorem ipsum dolor sit amet',
                'lastname' => 'Lorem ipsum dolor sit amet',
                'age' => 1,
                'gender' => 'Lorem ipsum dolor sit amet',
                'location' => 'Lorem ipsum dolor sit amet',
                'visit_date' => '2025-03-26',
                'visit_time' => '15:49:05',
                'status' => 1,
                'created' => '2025-03-26 15:49:05',
            ],
        ];
        parent::init();
    }
}
