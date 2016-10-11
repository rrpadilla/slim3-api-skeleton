<?php

namespace App\Handlers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Renders\ApiView;
use Slim\Http\Body;

/**
 * Api not allowed handler
 *
 * It outputs a simple message in either JSON or XML.
 */
class ApiNotAllowed extends ApiAbstractHandler
{
    protected $textPlain;

    public function __construct(ApiView $view, $textPlain = false)
    {
        parent::__construct($view);
        $this->textPlain = $textPlain;
    }

    /**
     * Invoke error handler
     *
     * @param  ServerRequestInterface $request  The most recent Request object
     * @param  ResponseInterface      $response The most recent Response object
     * @param  string[]               $methods  Allowed HTTP methods
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $methods)
    {
        $allow = implode(', ', $methods);

        if ($request->getMethod() === 'OPTIONS') {
            $status = 200;
            $message = 'Allowed methods: ' . $allow;
            // Return Plain Text.
            if ($this->textPlain) {
                $body = new Body(fopen('php://temp', 'r+'));
                $body->write($message);
                return $response
                        ->withStatus($status)
                        ->withHeader('Content-type', 'text/plain')
                        ->withHeader('Allow', $allow)
                        ->withBody($body);
            }
        } else {
            $status = 405;
            $message = 'Method not allowed. Must be one of: ' . $allow;
        }

        $data = [
            'message' => $message,
        ];
        $addHeaders = [
            'Allow' => implode(', ', $methods),
        ];

        return $this->view->render($request, $response, $data, $status, $addHeaders);
    }
}
