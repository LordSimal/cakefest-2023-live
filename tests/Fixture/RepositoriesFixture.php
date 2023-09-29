<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RepositoriesFixture
 */
class RepositoriesFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'url' => 'Lorem ipsum dolor sit amet',
                'forks' => 1,
                'open_issues' => 1,
                'external_ident' => 1,
                'created' => '2023-09-29 16:08:20',
                'modified' => '2023-09-29 16:08:20',
            ],
        ];
        parent::init();
    }
}
