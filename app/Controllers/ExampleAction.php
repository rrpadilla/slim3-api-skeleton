<?php
namespace App\Controllers;

use App\Renders\ApiView;
use Slim\Http\Request;
use Slim\Http\Response;
use Psr\Log\LoggerInterface;

final class ExampleAction
{
    private $view;
    private $logger;

    public function __construct(ApiView $view, LoggerInterface $logger)
    {
        $this->view = $view;
        $this->logger = $logger;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $message = "Example action dispatched";
        $this->logger->info($message);
        $data = ['message' => $message];
        return $this->view->render($request, $response, $data, 200);
    }
}
