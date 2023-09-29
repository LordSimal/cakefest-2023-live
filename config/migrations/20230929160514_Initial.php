<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $this->table('repositories')
            ->addColumn('name', 'string')
            ->addColumn('url', 'string')
            ->addColumn('forks', 'integer')
            ->addColumn('open_issues', 'integer')
            ->addColumn('external_ident', 'biginteger')
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('modified', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->create();

        $this->table('branches')
            ->addColumn('name', 'string')
            ->addColumn('repository_id', 'integer')
            ->addColumn('created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('modified', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->create();
    }
}
