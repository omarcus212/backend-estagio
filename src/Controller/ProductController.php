<?php

namespace Contatoseguro\TesteBackend\Controller;

use Contatoseguro\TesteBackend\Model\Product;
use Contatoseguro\TesteBackend\Service\CategoryService;
use Contatoseguro\TesteBackend\Service\ProductService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ProductController
{
    private ProductService $service;
    private CategoryService $categoryService;

    public function __construct()
    {
        $this->service = new ProductService();
        $this->categoryService = new CategoryService();
    }

    public function getAll(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $adminUserId = $request->getHeader('admin_user_id')[0];
        $order = isset($_GET['order']) ? $_GET['order'] : 'desc';
        $category = isset($_GET['category']) && $_GET['category'] !== "" ? $_GET['category'] : "";
        $active = isset($_GET['active']) ? $_GET['active'] : 'all';

        $stm = $this->service->getAll($adminUserId, $active, $category, $order);
        $response->getBody()->write(json_encode($stm->fetchAll(\PDO::FETCH_ASSOC)));
        return $response->withStatus(200);
    }

    public function getOne(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $stm = $this->service->getOne($args['id']);
        $product = Product::hydrateByFetch($stm->fetch());

        $adminUserId = $request->getHeader('admin_user_id')[0];
        $productCategory = $this->categoryService->getProductCategory($product->id)->fetchAll(\PDO::FETCH_ASSOC);

        for ($i = 0; $i < count($productCategory); $i++) {
            $fetchedCategory = $this->categoryService->getOne($adminUserId, $productCategory[$i]["id"])->fetch();
            $product->setCategory($fetchedCategory["title"]);
            $response->getBody()->write(json_encode($product));
        }

        return $response->withStatus(200);
    }

    public function insertOne(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $body = $request->getParsedBody();
        $adminUserId = $request->getHeader('admin_user_id')[0];


        if ($this->service->insertOne($body, $adminUserId)) {
            $response->getBody()->write(json_encode([
                'res' => 'sucess',
                'userMessage' => 'Product created successfully'
            ]));
            return $response->withStatus(200);
        } else {
            $response->getBody()->write(json_encode([
                'res' => 'sucess',
                'userMessage' => 'the product could not be created successfully'
            ]));
            return $response->withStatus(200);
        }
    }

    public function updateOne(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $body = $request->getParsedBody();
        $adminUserId = $request->getHeader('admin_user_id')[0];

        if ($this->service->updateOne($args['id'], $body, $adminUserId)) {

            $response->getBody()->write(json_encode([
                'res' => 'sucess',
                'userMessage' => 'Product updated successfully'
            ]));
            return $response->withStatus(200);

        } else {

            $response->getBody()->write(json_encode([
                'res' => 'sucess',
                'userMessage' => 'the product could not be updated successfully'
            ]));
            return $response->withStatus(200);
        }
    }

    public function deleteOne(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $adminUserId = $request->getHeader('admin_user_id')[0];

        if ($this->service->deleteOne($args['id'], $adminUserId)) {

            $response->getBody()->write(json_encode([
                'res' => 'sucess',
                'userMessage' => 'Product remove successfully'
            ]));
            return $response->withStatus(200);

        } else {

            $response->getBody()->write(json_encode([
                'res' => 'sucess',
                'userMessage' => 'the Product could not be remove successfully'
            ]));
            return $response->withStatus(404);

        }
    }
    public function delete(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $adminUserId = $request->getHeader('admin_user_id')[0];

        if ($this->service->delete($args['id'], $adminUserId)) {

            $response->getBody()->write(json_encode([
                'res' => 'sucess',
                'userMessage' => 'Product delete successfully'
            ]));
            return $response->withStatus(200);

        } else {

            $response->getBody()->write(json_encode([
                'res' => 'sucess',
                'userMessage' => 'the Product could not be delete successfully'
            ]));
            return $response->withStatus(404);

        }
    }
}
