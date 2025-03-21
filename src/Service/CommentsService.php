<?php

namespace Contatoseguro\TesteBackend\Service;

use Contatoseguro\TesteBackend\Config\DB;

class CommentsService
{
    private \PDO $pdo;
    public function __construct()
    {
        $this->pdo = DB::connect();
    }
    public function getOne($id)
    {
        $query = "
       SELECT * FROM view_product_comments WHERE product_id = :product_id order by id desc;
    ";

        $stm = $this->pdo->prepare($query);
        $stm->execute(['product_id' => $id]);

        return $stm;
    }
    public function insertOne($product_id, $adminUserId, $body)
    {

        try {

            $query = "
           INSERT INTO comments (
           product_id, 
           admin_user_id, 
           comment_text  ) 
           VALUES ( :product_id,  :admin_user_id, :comment_text )
        ";
            $stm = $this->pdo->prepare($query);
            $stm->execute([
                "product_id" => $product_id,
                "admin_user_id" => $adminUserId,
                "comment_text" => $body["comment"]
            ]);

            $stm->fetchAll(\PDO::FETCH_ASSOC);
            return true;
        } catch (\PDOException $pDOException) {
            echo "Erro na consulta SQL: " . $pDOException->getMessage();
        }
    }

    public function insertReplay($parent_id, $adminUserId, $body)
    {

        try {
            $query = "
            INSERT INTO comments (
            product_id, 
            admin_user_id,
            parent_id, 
            comment_text
        ) VALUES (
            :product_id, 
            :admin_user_id,
            :parent_id ,
            :comment_text)
        ";

            $stm = $this->pdo->prepare($query);

            $stm->execute([
                "product_id" => $body["product"],
                "parent_id" => $parent_id,
                "admin_user_id" => $adminUserId,
                "comment_text" => $body["comment"]
            ]);

            $stm->fetchAll(\PDO::FETCH_ASSOC);
            return true;

        } catch (\PDOException $pDOException) {
            echo "Erro na consulta SQL: " . $pDOException->getMessage();
        }
    }
    public function getLike($id)
    {
        $query = "
            select cl.*, c.comment_text as comment_text_liked, au.name as admin_user_liked from comment_likes cl inner join admin_user au on au.id = cl.admin_user_id 
            inner join comments c on c.id = cl.comment_id where cl.comment_id = {$id};
           ";

        $stm = $this->pdo->prepare($query);
        $stm->execute();

        return $stm;
    }
    public function insertLike($comment_id, $admin_user_id)
    {
        try {
            $query = "

       INSERT INTO comment_likes 
       ( comment_id, admin_user_id) 
       VALUES 
       ( :comment_id, :admin_user_id);

        ";

            $stm = $this->pdo->prepare($query);
            $stm->execute(['comment_id' => $comment_id, 'admin_user_id' => $admin_user_id]);

            return $stm->rowCount();


        } catch (\PDOException $pDOException) {
            echo "Erro na consulta SQL: " . $pDOException->getMessage();
        }
    }

    public function deleteOne($comment_id, $admin_user_id)
    {
        try {
            $stm = $this->pdo->prepare("
            DELETE from comments where  id = {$comment_id} and admin_user_id = {$admin_user_id} ;;
        ");
            if (!$stm->execute())
                return false;

            $stm = $this->pdo->prepare("DELETE from comment_likes where comment_id = {$comment_id};");
            if (!$stm->execute())
                return false;

            return $stm;

        } catch (\PDOException $pDOException) {
            echo "Erro na consulta SQL: " . $pDOException->getMessage();
        }
    }
}
