<?php

use Contatoseguro\TesteBackend\Controller\CategoryController;
use Contatoseguro\TesteBackend\Controller\CompanyController;
use Contatoseguro\TesteBackend\Controller\HomeController;
use Contatoseguro\TesteBackend\Controller\ProductController;
use Contatoseguro\TesteBackend\Controller\ReportController;
use Contatoseguro\TesteBackend\Controller\CommentsController;

use Contatoseguro\TesteBackend\Middleware\InsertBodyCategoryMiddleware;
use Contatoseguro\TesteBackend\Middleware\InsertBodyComments;
use Contatoseguro\TesteBackend\Middleware\InsertBodyCommentsReplay;
use Contatoseguro\TesteBackend\Middleware\InsertBodyProductMiddleware;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

/** @var App $app*/
$app->get('/', [HomeController::class, 'home']);

$app->group('/companies', function (RouteCollectorProxy $group) {
    $group->get('', [CompanyController::class, 'getAll']);
    $group->get('/{id}', [CompanyController::class, 'getOne']);
});

$app->group('/products', function (RouteCollectorProxy $group) {
    $group->get('', [ProductController::class, 'getAll']);
    $group->get('/{id}', [ProductController::class, 'getOne']);
    $group->post('', [ProductController::class, 'insertOne'])
        ->add(new InsertBodyProductMiddleware());
    $group->put('/{id}', [ProductController::class, 'updateOne'])
        ->add(new InsertBodyProductMiddleware());
    $group->delete('/remove/{id}', [ProductController::class, 'deleteOne']);
    // $group->delete('/delete/{id}', [ProductController::class, 'delete']);
});

$app->group('/categories', function (RouteCollectorProxy $group) {
    $group->get('', [CategoryController::class, 'getAll']);
    $group->get('/{id}', [CategoryController::class, 'getOne']);
    $group->post('', [CategoryController::class, 'insertOne'])
        ->add(new InsertBodyCategoryMiddleware());
    $group->put('/{id}', [CategoryController::class, 'updateOne'])
        ->add(new InsertBodyCategoryMiddleware());
    $group->delete('/{id}', [CategoryController::class, 'deleteOne']);
});

$app->group('/comments', function (RouteCollectorProxy $group) {
    $group->get('/product/{id}', [CommentsController::class, 'getOne']);
    $group->get('/likes/{id}', [CommentsController::class, 'getAllLike']);
    $group->post('/product/{id}', [CommentsController::class, 'insertOne'])
        ->add(new InsertBodyComments());
    $group->post('/reply/{commentId}', [CommentsController::class, 'insertReply'])
        ->add(new InsertBodyCommentsReplay());
    $group->post('/like/{commentId}', [CommentsController::class, 'insertLike']);
    $group->delete('/{commentId}', [CommentsController::class, 'deleteOne']);
});

$app->get('/report', [ReportController::class, 'generate']);
