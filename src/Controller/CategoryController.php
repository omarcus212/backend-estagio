<?php

namespace Contatoseguro\TesteBackend\Controller;

use Contatoseguro\TesteBackend\Service\CategoryService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CategoryController
{
    private CategoryService $service;

    public function __construct()
    {
        $this->service = new CategoryService();
    }

    public function getAll(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $adminUserId = $request->getHeader('admin_user_id')[0];

        $stm = $this->service->getAll($adminUserId);
        $response->getBody()->write(json_encode($stm->fetchAll(\PDO::FETCH_ASSOC)));
        return $response->withStatus(200);
    }

    public function getOne(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $adminUserId = $request->getHeader('admin_user_id')[0];
        $stm = $this->service->getOne($adminUserId, $args['id']);

        $response->getBody()->write(json_encode($stm->fetchAll()));
        return $response->withStatus(200);
    }

    public function insertOne(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $body = $request->getParsedBody();
        $adminUserId = $request->getHeader('admin_user_id')[0];

        if ($this->service->insertOne($body, $adminUserId)) {

            $response->getBody()->write(json_encode([
                'res' => 'sucess',
                'userMessage' => 'Category created successfully'
            ]));
            return $response->withStatus(200);

        } else {

            $response->getBody()->write(json_encode([
                'res' => 'fail',
                'userMessage' => 'the category could not be created successfully'
            ]));

            return $response->withStatus(404);
        }

    }

    public function updateOne(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $body = $request->getParsedBody();
        $adminUserId = $request->getHeader('admin_user_id')[0];

        if ($this->service->updateOne($args['id'], $body, $adminUserId)) {

            $response->getBody()->write(json_encode([
                'res' => 'sucess',
                'userMessage' => 'Category updated successfully'
            ]));
            return $response->withStatus(200);

        } else {

            $response->getBody()->write(json_encode([
                'res' => 'fail',
                'userMessage' => 'the category could not be updated successfully'
            ]));
            return $response->withStatus(404);
        }
    }

    public function deleteOne(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $adminUserId = $request->getHeader('admin_user_id')[0];

        if ($this->service->deleteOne($args['id'], $adminUserId)) {

            $response->getBody()->write(json_encode([
                'res' => 'sucess',
                'userMessage' => 'Category delete successfully'
            ]));
            return $response->withStatus(200);

        } else {

            $response->getBody()->write(json_encode([
                'res' => 'sucess',
                'userMessage' => 'the category could not be delete successfully'
            ]));
            return $response->withStatus(404);
        }
    }
}
