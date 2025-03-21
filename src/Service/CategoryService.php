<?php

namespace Contatoseguro\TesteBackend\Service;

use Contatoseguro\TesteBackend\Config\DB;


class CategoryService
{
    private \PDO $pdo;
    public function __construct()
    {
        $this->pdo = DB::connect();
    }

    public function getAll($adminUserId)
    {

        $query = "
            SELECT c.id, c.company_id, c.title
            FROM category c
            WHERE c.company_id = {$this->getCompanyFromAdminUser($adminUserId)} and c.company_id != 'null'
            ORDER BY c.id desc
        ";

        $stm = $this->pdo->prepare($query);

        $stm->execute();

        return $stm;
    }

    public function getOne($adminUserId, $categoryId)
    {

        $query = "
            SELECT *
            FROM category c
            WHERE c.active = 1
            AND c.company_id = {$this->getCompanyFromAdminUser($adminUserId)}
            AND c.id = {$categoryId}
        ";

        $stm = $this->pdo->prepare($query);
        $stm->execute();

        return $stm;
    }

    public function getProductCategory($productId)
    {
        $query = "
            SELECT c.id
            FROM category c
            INNER JOIN product_category pc
                ON pc.cat_id = c.id
            WHERE pc.product_id = {$productId} GROUP BY id
        ";

        $stm = $this->pdo->prepare($query);

        $stm->execute();

        return $stm;
    }

    public function insertOne($body, $adminUserId)
    {

        try {

            $stm = $this->pdo->prepare("
            INSERT INTO category (
                company_id,
                title,
                active
            ) VALUES (
                {$this->getCompanyFromAdminUser($adminUserId)},
                '{$body['title']}',
                {$body['active']}
            )
        ");

            return $stm->execute();

        } catch (\PDOException $pDOException) {
            echo "Erro na consulta SQL: " . $pDOException->getMessage();
        }
    }

    public function updateOne($id, $body, $adminUserId)
    {

        try {

            $active = (int) $body['active'];

            $stm = $this->pdo->prepare("
            UPDATE category
            SET title = '{$body['title']}',
                active = {$active}
            WHERE id = {$id}
            AND company_id = {$this->getCompanyFromAdminUser($adminUserId)}
        ");

            return $stm->execute();

        } catch (\PDOException $pDOException) {

            echo "Erro na consulta SQL: " . $pDOException->getMessage();
        }
    }

    public function deleteOne($id, $adminUserId)
    {
        try {
            $stm = $this->pdo->prepare("
            DELETE
            FROM category
            WHERE id = {$id}
            AND company_id = {$this->getCompanyFromAdminUser($adminUserId)}
        ");

            return $stm->execute();

        } catch (\PDOException $pDOException) {

            echo "Erro na consulta SQL: " . $pDOException->getMessage();
        }
    }

    private function getCompanyFromAdminUser($adminUserId)
    {

        $query = "
            SELECT company_id
            FROM admin_user
            WHERE id ={$adminUserId}
        ";

        $stm = $this->pdo->prepare($query);
        $stm->execute();
        return $stm->fetch(\PDO::FETCH_OBJ)->company_id;

    }
}
