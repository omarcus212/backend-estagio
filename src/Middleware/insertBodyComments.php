<?php

namespace Contatoseguro\TesteBackend\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;


class InsertBodyComments
{
    public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
    {

        $body = $request->getParsedBody();
        $response = new Response();

        if (
            !isset($body['comment']) || empty($body['comment'])
        ) {

            $response->getBody()->write(json_encode(['msg' => 'Empty or non-existent fields']));
            return $response->withStatus(404);

        } else {
            $response = $handler->handle($request);
            return $response;
        }
    }
}
