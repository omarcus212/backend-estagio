<?php

use Phinx\Migration\AbstractMigration;

class Comments extends AbstractMigration
{
  public function up()
  {
    $table = $this->table('comments', ['id' => false, 'primary_key' => 'id']);

    $table->addColumn('id', 'integer', ['signed' => false, 'identity' => true])
      ->addColumn('product_id', 'integer', ['signed' => false])
      ->addColumn('admin_user_id', 'integer', ['signed' => false])
      ->addColumn('parent_id', 'integer', ['signed' => false, 'null' => true])
      ->addColumn('comment_text', 'text')
      ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
      ->addColumn('updated_at', 'datetime', [
        'default' => 'CURRENT_TIMESTAMP',
        'update' => 'CURRENT_TIMESTAMP'
      ])
      ->addForeignKey('product_id', 'product', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
      ->addForeignKey('admin_user_id', 'admin_user', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
      ->addForeignKey('parent_id', 'comments', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
      ->create();

    $this->execute("
            CREATE VIEW view_product_comments AS
            SELECT 
            c.id,
            c.product_id,
            c.comment_text,
            c.admin_user_id,
            au.name AS admin_name,
            p.title AS product_title,
            c.created_at,
            c.updated_at,
            c.parent_id,
            parent.comment_text AS parent_content,
            parent_au.name AS parent_admin_name
            FROM comments c
            INNER JOIN product p ON c.product_id = p.id
            INNER JOIN admin_user au ON c.admin_user_id = au.id
            LEFT JOIN comments parent ON c.parent_id = parent.id
            LEFT JOIN admin_user parent_au ON parent.admin_user_id = parent_au.id;
        ");
  }

  public function down()
  {
    $this->table('comments')->drop()->save();
  }
}