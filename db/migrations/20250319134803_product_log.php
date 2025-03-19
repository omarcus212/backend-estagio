<?php

use Phinx\Migration\AbstractMigration;

class ProductLog extends AbstractMigration
{
  public function up()
  {
    $table = $this->table('product_log');
    $table->addColumn('product_id', 'integer', ['signed' => false])
      ->addColumn('admin_user_id', 'integer', ['signed' => false])
      ->addColumn('action', 'string', ['limit' => 255])
      ->addColumn('timestamp', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
      ->addForeignKey('admin_user_id', 'admin_user', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
      ->addForeignKey('product_id', 'product', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
      ->create();

    $this->execute("INSERT INTO product_log (id, product_id, admin_user_id, action, timestamp) VALUES
            (1, 1, 1, 'create', '2023-12-20 21:32:22'),
            (2, 1, 2, 'update', '2023-12-20 21:32:22'),
            (3, 1, 3, 'update', '2023-12-20 21:32:22')");

  }

  public function down()
  {
    $this->table('product_log')->drop()->save();
  }
}