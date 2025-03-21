<?php

namespace Contatoseguro\TesteBackend\Controller;

use Contatoseguro\TesteBackend\Service\CompanyService;
use Contatoseguro\TesteBackend\Service\ProductService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ReportController
{
    private ProductService $productService;
    private CompanyService $companyService;

    public function __construct()
    {
        $this->productService = new ProductService();
        $this->companyService = new CompanyService();
    }

    public function generate(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $adminUserId = $request->getHeader('admin_user_id')[0];
        $order = isset($_GET['order']) ? $_GET['order'] : 'desc';
        $category = isset($_GET['category']) && $_GET['category'] !== "" ? $_GET['category'] : "";
        $active = isset($_GET['active']) ? $_GET['active'] : 'all';
        $productOne = isset($_GET['product']) ? $_GET['product'] : false;

        $data = [];
        $data[] = [
            'Id do produto',
            'Nome da Empresa',
            'Nome do Produto',
            'Valor do Produto',
            'Categorias do Produto',
            'Data de Criação',
            'Logs de Alterações'
        ];

        $stm = $this->productService->getAll($adminUserId, $active, $category, $order);
        $products = $stm->fetchAll(\PDO::FETCH_OBJ);

        if ($productOne) {
            $stm = $this->productService->getOneProductCategory($productOne);
            $products = $stm->fetchAll(\PDO::FETCH_OBJ);

        }

        foreach ($products as $i => $product) {
            $stm = $this->companyService->getNameById($product->company_id);
            $companyName = $stm->fetch(\PDO::FETCH_OBJ)->name;

            $stm = $this->productService->getLog($product->id);
            $productLogs = $stm->fetchAll(\PDO::FETCH_OBJ);

            if ($productOne) {
                $stm = $this->productService->getOneLog($product->id);
                $productLogs = $stm->fetchAll(\PDO::FETCH_OBJ);

            }

            $logString = '';

            foreach ($productLogs as $log) {
                $logString .= "Ultima alteração: ({$log->name}, {$log->action}, {$log->timestamp}), 
                ";

            }

            $data[$i + 1][] = $product->id;
            $data[$i + 1][] = $companyName;
            $data[$i + 1][] = $product->title;
            $data[$i + 1][] = $product->price;
            $data[$i + 1][] = $product->category;
            $data[$i + 1][] = $product->created_at;
            $data[$i + 1][] = $logString ? $logString : 'Nenhum log de alteração';
        }

        $report = "<table style='font-size: 10px;'>";
        foreach ($data as $row) {
            $report .= "<tr>";
            foreach ($row as $column) {

                $report .= "<td>{$column}</td>";
            }
            $report .= "</tr>";
        }
        $report .= "</table>";

        $response->getBody()->write($report);
        return $response->withStatus(200)->withHeader('Content-Type', 'text/html');
    }
}
