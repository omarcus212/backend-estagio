<?php

namespace Contatoseguro\TesteBackend\Service;

use Contatoseguro\TesteBackend\Config\DB;

class ProductService
{
    private \PDO $pdo;
    public function __construct()
    {
        $this->pdo = DB::connect();
    }

    public function getAll($adminUserId, $active, $category, $order)
    {
        $query = "
            SELECT p.*, c.title as category
            FROM product p
            INNER JOIN product_category pc ON pc.product_id = p.id
            INNER JOIN category c ON c.id = pc.cat_id
            WHERE p.company_id = {$adminUserId} and p.active = $active 
        ";

        if ($category !== "") {
            $query .= " AND c.title = '{$category}'";
        }

        $query .= " ORDER BY p.created_at $order";

        $stm = $this->pdo->prepare($query);
        $stm->execute();

        return $stm;
    }

    public function getOne($id)
    {
        $stm = $this->pdo->prepare("
            SELECT *
            FROM product 
            WHERE id = {$id}
        ");
        $stm->execute();

        return $stm;
    }


    public function getOneProductCategory($id)
    {
        $stm = $this->pdo->prepare("
             SELECT p.*, c.title as category
            FROM product p
            INNER JOIN product_category pc ON pc.product_id = p.id
            INNER JOIN category c ON c.id = pc.cat_id
            WHERE p.id = {$id};
        ");
        $stm->execute();

        return $stm;
    }

    public function insertOne($body, $adminUserId)
    {

        $stm = $this->pdo->prepare("
           INSERT INTO product (company_id, title, price, active)
           VALUES (:company_id, :title, :price, :active)
        ");
        if (
            !$stm->execute([
                'company_id' => $body['company_id'],
                'title' => $body['title'],
                'price' => $body['price'],
                'active' => (int) $body['active']
            ])
        )
            return false;

        $productId = $this->pdo->lastInsertId();

        $stm = $this->pdo->prepare("
            INSERT INTO product_category (
                product_id,
                cat_id
            ) VALUES (
                {$productId},
                {$body['category_id']}
            );
        ");
        if (!$stm->execute())
            return false;

        $stm = $this->pdo->prepare("
            INSERT INTO product_log (
                product_id,
                admin_user_id,
                `action`
            ) VALUES (
                {$productId},
                {$adminUserId},
                'create'
            )
        ");

        return $stm->execute();
    }

    public function updateOne($id, $body, $adminUserId)
    {
        $stm = $this->pdo->prepare("
            UPDATE product
            SET company_id = :company_id,
                title =  :title,
                price = :price,
                active = :active
            WHERE id = {$id}
        ");
        if (
            !$stm->execute(
                [
                    'company_id' => $body['company_id'],
                    'title' => $body['title'],
                    'price' => $body['price'],
                    'active' => (int) $body['active']
                ]
            )
        )
            return false;

        $stm = $this->pdo->prepare("
            UPDATE product_category
            SET cat_id = {$body['category_id']}
            WHERE product_id = {$id}
        ");
        if (!$stm->execute())
            return false;

        $stm = $this->pdo->prepare("
            INSERT INTO product_log (
                product_id,
                admin_user_id,
                `action`
            ) VALUES (
                {$id},
                {$adminUserId},
                'update'
            )
        ");

        return $stm->execute();
    }

    public function deleteOne($id, $adminUserId)
    {

        $stm = $this->pdo->prepare("
            DELETE FROM product_category WHERE product_id = {$id}
        ");
        if (!$stm->execute())
            return false;

        $stm = $this->pdo->prepare("DELETE FROM product WHERE id = {$id}");
        if (!$stm->execute())
            return false;

        $stm = $this->pdo->prepare("
            INSERT INTO product_log (product_id, admin_user_id, `action`)
            VALUES (:id, :adminUserId, 'delete')
        ");

        $stm->bindParam(':id', $id, \PDO::PARAM_INT);
        $stm->bindParam(':adminUserId', $adminUserId, \PDO::PARAM_INT);

        // if (!$stm->execute())
        //     return false;
        return $stm;

    }

    public function getLog($id)
    {
        $stm = $this->pdo->prepare("
           SELECT 
            pl.id, pl.product_id, pl.action, pl.timestamp, au.name 
            FROM product_log pl 
            inner join admin_user au on au.id = pl.admin_user_id 
            where pl.product_id = {$id};
                ");
        $stm->execute();

        return $stm;
    }

    public function getOneLog($id)
    {
        $stm = $this->pdo->prepare("
           SELECT 
            pl.id, pl.product_id, pl.action, pl.timestamp, au.name 
            FROM product_log pl 
            inner join admin_user au on au.id = pl.admin_user_id 
            where pl.product_id = {$id} ORDER BY pl.id desc LIMIT 1;
                ");
        $stm->execute();

        return $stm;
    }
}
