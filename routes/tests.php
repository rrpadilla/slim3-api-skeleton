<?php

// API
$app->group('/v1', function () use ($app) {

    $app->get('/hello', function ($request, $response, $args) {
        $data = ['message' => 'Hello'];
        return $this->view->render($request, $response, $data, 200);
    })->setName('hello');

    $app->get('/example', App\Controllers\ExampleAction::class)
        ->setName('example');
});
