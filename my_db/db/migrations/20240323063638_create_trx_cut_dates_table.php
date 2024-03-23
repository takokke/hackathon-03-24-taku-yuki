<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTrxCutDatesTable extends AbstractMigration
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
	$table = $this->table("trx_cut_dates");
	$table->addColumn('cut_date', 'date', ['null' => false])
	      ->addColumn('user_id', 'integer',['signed' => false,'null' => false])
	      ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
	      ->addForeignKey('user_id', 'trx_users', 'id')
              ->create();
    }
}
