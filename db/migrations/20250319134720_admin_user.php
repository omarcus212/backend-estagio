<?php

use Phinx\Migration\AbstractMigration;

class AdminUser extends AbstractMigration
{
  public function up()
  {
    $table = $this->table('admin_user');
    $table->addColumn('company_id', 'integer', ['signed' => false])
      ->addColumn('email', 'string', ['limit' => 255])
      ->addColumn('name', 'string', ['limit' => 255])
      ->addIndex('email', ['unique' => true])
      ->addForeignKey('company_id', 'company', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
      ->create();

    $this->execute("INSERT INTO admin_user (id, company_id, email, name) VALUES
            (1, 1, 'rivers.cuomo@xpto.com', 'rivers'),
            (2, 1, 'kim.deal@xpto.com', 'kim'),
            (3, 1, 'corin.tucker@xpto.com', 'corin'),
            (4, 1, 'jeff.magnum@xpto.com', 'jeff')
        ");
  }

  public function down()
  {
    $this->table('admin_user')->drop()->save();
  }
}