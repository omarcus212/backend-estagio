<?php

namespace Contatoseguro\TesteBackend\Controller;

use Contatoseguro\TesteBackend\Service\CommentsService;
use Contatoseguro\TesteBackend\Config\DB;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CommentsController
{
    private CommentsService $service;
    private \PDO $pdo;

    public function __construct(
    ) {
        $this->service = new CommentsService();
    }

    public function getOne(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $stm = $this->service->getOne($args["id"]);
        $response->getBody()->write(json_encode($stm->fetchAll(\PDO::FETCH_ASSOC)));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function insertOne(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $adminUserId = $request->getHeader('admin_user_id')[0];
        $body = $request->getParsedBody();
        $stm = $this->service->insertOne($args["id"], $adminUserId, $body);

        if ($stm) {
            $response
                ->getBody()
                ->write(json_encode([
                    'res' => 'sucess',
                    'userMessage' => 'Comment completed successfully'
                ]));
        } else {
            $response
                ->getBody()
                ->write(json_encode([
                    'res' => 'fail',
                    'userMessage' => 'Unable to complete this comment'
                ]));
        }

        return $response->withStatus(200);
    }

    public function insertReplay(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $adminUserId = $request->getHeader('admin_user_id')[0];
        $body = $request->getParsedBody();
        $stm = $this->service->insertReplay($args["commentId"], $adminUserId, $body);

        if ($stm) {
            $response
                ->getBody()
                ->write(json_encode([
                    'res' => 'sucess',
                    'userMessage' => 'Comment completed successfully'
                ]));
        } else {
            $response
                ->getBody()
                ->write(json_encode([
                    'res' => 'fail',
                    'userMessage' => 'Unable to complete this comment'
                ]));
        }

        return $response->withStatus(200);
    }

    public function getAllLike(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $stm = $this->service->getAllLike();
        $response->getBody()->write(json_encode($stm->fetchAll(\PDO::FETCH_ASSOC)));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function insertLike(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $adminUserId = $request->getHeader('admin_user_id')[0];
        $stm = $this->service->insertLike($args["commentId"], $adminUserId);
        if ($stm == 1) {
            $response
                ->getBody()
                ->write(json_encode([
                    'res' => 'sucess',
                    'userMessage' => 'Liked'
                ]));
        } else {
            $response
                ->getBody()
                ->write(json_encode([
                    'res' => 'fail',
                    'userMessage' => 'You already liked this comment'
                ]));
        }
        return $response->withStatus(200);
    }
}