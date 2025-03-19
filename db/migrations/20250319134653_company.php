<?php

use Phinx\Migration\AbstractMigration;

class Company extends AbstractMigration
{
  public function up()
  {
    $table = $this->table('company');
    $table->addColumn('name', 'string', ['limit' => 255])
      ->addColumn('active', 'boolean')
      ->addIndex('name', ['unique' => true])
      ->create();

    $this->execute("INSERT INTO company (id, name, active) VALUES (1, 'XPTO Ltda.', 1);");
  }

  public function down()
  {
    $this->table('company')->drop()->save();
  }
}