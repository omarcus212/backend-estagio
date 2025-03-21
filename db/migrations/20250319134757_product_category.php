<?php

use Phinx\Migration\AbstractMigration;

class ProductCategory extends AbstractMigration
{
  public function up()
  {
    $table = $this->table('product_category');
    $table->addColumn('cat_id', 'integer', ['signed' => false, 'null' => false])
      ->addColumn('product_id', 'integer', ['signed' => false, 'null' => false])
      ->addForeignKey('cat_id', 'category', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
      ->addForeignKey('product_id', 'product', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
      ->create();

    $table = $this->table('product_category');
    $table->addColumn('active', 'integer', ['signed' => false, 'null' => false, 'default' => 1])
      ->update();

    $this->execute("INSERT INTO product_category (id, cat_id, product_id, active) VALUES
            (1, 1, 1,1), (2, 1, 2,1), (3, 1, 3,1), (4, 2, 4,1), (5, 2, 5,1), (6, 3, 6,1),
            (7, 3, 7,1), (8, 4, 8,1), (9, 6, 8,1), (10, 4, 9,1), (11, 6, 9,1), (12, 4, 10,1),
            (13, 6, 10,1), (14, 4, 11,1), (15, 6, 11,1), (16, 5, 12,1), (17, 5, 13,1), (18, 5, 14,1),
            (19, 5, 15,1), (20, 5, 16,1), (21, 6, 17,1), (22, 6, 18,1)
        ");
  }

  public function down()
  {
    $this->table('product_category')->drop()->save();
  }
}