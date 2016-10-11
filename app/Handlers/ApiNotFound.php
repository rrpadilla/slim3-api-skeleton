<?php

namespace App\Handlers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Api not found handler.
 *
 * It outputs a simple message in either JSON or XML.
 */
final class ApiNotFound extends ApiAbstractHandler
{
    /**
     * Invoke not found handler
     *
     * @param  ServerRequestInterface $request  The most recent Request object
     * @param  ResponseInterface      $response The most recent Response object
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $data = [
            'message' => 'Not found',
        ];

        return $this->view->render($request, $response, $data, 404);
    }
}
