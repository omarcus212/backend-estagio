<?php

use Phinx\Migration\AbstractMigration;

class Category extends AbstractMigration
{
  public function up()
  {
    $table = $this->table('category');
    $table->addColumn('company_id', 'integer', ['signed' => false])
      ->addColumn('title', 'string', ['limit' => 255, 'null' => false])
      ->addColumn('active', 'boolean')
      ->addForeignKey('company_id', 'company', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
      ->create();

    $this->execute("INSERT INTO category (id, company_id, title, active) VALUES
            (1, 1, 'clothing', 1),
            (2, 1, 'phone', 1),
            (3, 1, 'computer', 1),
            (4, 1, 'furniture', 1),
            (5, 1, 'food', 1),
            (6, 1, 'house', 1)
        ");
  }

  public function down()
  {
    $this->table('category')->drop()->save();
  }
}