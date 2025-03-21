<?php

use Phinx\Migration\AbstractMigration;

class CommentsLike extends AbstractMigration
{
  public function up()
  {
    $table = $this->table('comment_likes');

    // Adicionando colunas
    $table->addColumn('comment_id', 'integer', ['signed' => false])
      ->addColumn('admin_user_id', 'integer', ['signed' => false])
      ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
      ->addIndex(['comment_id', 'admin_user_id'], ['unique' => true]) // Chave única
      ->addForeignKey('comment_id', 'comments', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']) // Chave estrangeira
      ->addForeignKey('admin_user_id', 'admin_user', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE']) // Chave estrangeira
      ->create(); // Criação da tabela
  }

  public function down()
  {
    $this->table('comment_likes')->drop()->save();
  }
}