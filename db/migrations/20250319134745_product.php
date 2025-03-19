<?php

use Phinx\Migration\AbstractMigration;

class Product extends AbstractMigration
{
  public function up()
  {
    $table = $this->table('product');
    $table->addColumn('company_id', 'integer', ['signed' => false])
      ->addColumn('title', 'string', ['limit' => 255])
      ->addColumn('price', 'float')
      ->addColumn('active', 'boolean')
      ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
      ->addForeignKey('company_id', 'company', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
      ->create();

    // Inserir dados iniciais na tabela 'product'
    $this->execute("INSERT INTO product (id, company_id, title, price, active, created_at) VALUES
            (1, 1, 'white shirt', 70.5, 1, '2023-12-20 21:05:48'),
            (2, 1, 'blue trouser', 68.5, 1, '2023-12-20 21:05:48'),
            (3, 1, 'brown hat', 20.7, 1, '2023-12-20 21:05:48'),
            (4, 1, 'iphone 8', 18.0, 1, '2023-12-20 21:05:48'),
            (5, 1, 'iphone 10', 2790.75, 1, '2023-12-20 21:05:48'),
            (6, 1, 'dell vostro', 2450.5, 1, '2023-12-20 21:05:48'),
            (7, 1, 'acer aspire', 1804.05, 1, '2023-12-20 21:05:48'),
            (8, 1, 'pink sofa', 1396.5, 1, '2023-12-20 21:08:27'),
            (9, 1, 'small wardrobe', 680.25, 1, '2023-12-20 21:08:27'),
            (10, 1, 'king size bed', 4520.83, 1, '2023-12-20 21:08:27'),
            (11, 1, 'big red couch', 2520.83, 0, '2023-12-20 21:08:27'),
            (12, 1, 'chocolate snack', 20.0, 1, '2023-12-20 21:12:22'),
            (13, 1, 'honey flavoured cookie', 10.21, 0, '2023-12-20 21:12:22'),
            (14, 1, 'strawberry bubblegum', 4520.83, 1, '2023-12-20 21:12:22'),
            (15, 1, 'muffin', 14.24, 1, '2023-12-20 21:12:22'),
            (16, 1, 'coffee candy', 1.8, 0, '2023-12-20 21:12:22'),
            (17, 1, 'air conditioning', 2700.0, 1, '2023-12-20 21:19:58'),
            (18, 1, 'refrigerator', 680.5, 1, '2023-12-21 15:31:45')
        ");
  }

  public function down()
  {
    $this->table('product')->drop()->save();
  }
}