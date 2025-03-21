<?php

namespace Contatoseguro\TesteBackend\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;


class InsertBodyProductMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
    {

        $body = $request->getParsedBody();
        $response = new Response();

        if (
            !isset($body['company_id']) || empty($body['company_id']) ||
            !isset($body['title']) || empty($body['title']) ||
            !isset($body['price']) || empty($body['price']) ||
            !isset($body['active']) || !is_bool($body['active']) ||
            !isset($body['category_id']) || empty($body['category_id'])
        ) {

            $response->getBody()->write(json_encode(['msg' => 'Empty or non-existent fields']));
            return $response->withStatus(404);

        } else {

            if (is_float($body['price']) == false) {
                $response->getBody()->write(json_encode(['msg' => 'Price is not float']));
                return $response->withStatus(404);
            }

            $response = $handler->handle($request);
            return $response;
        }
    }
}
