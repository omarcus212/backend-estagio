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

    $this->execute("INSERT INTO product_category (id, cat_id, product_id) VALUES
            (1, 1, 1), (2, 1, 2), (3, 1, 3), (4, 2, 4), (5, 2, 5), (6, 3, 6),
            (7, 3, 7), (8, 4, 8), (9, 6, 8), (10, 4, 9), (11, 6, 9), (12, 4, 10),
            (13, 6, 10), (14, 4, 11), (15, 6, 11), (16, 5, 12), (17, 5, 13), (18, 5, 14),
            (19, 5, 15), (20, 5, 16), (21, 6, 17), (22, 6, 18)
        ");
  }

  public function down()
  {
    $this->table('product_category')->drop()->save();
  }
}