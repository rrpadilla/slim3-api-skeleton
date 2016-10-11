<?php

namespace App\Handlers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Api error handler for PHP 7+ Throwables
 *
 * It outputs the error message and diagnostic information in either JSON, XML,
 * or HTML based on the Accept header.
 */
final class ApiPhpError extends ApiAbstractError
{
    /**
     * Invoke error handler
     *
     * @param ServerRequestInterface $request   The most recent Request object
     * @param ResponseInterface      $response  The most recent Response object
     * @param \Throwable             $error     The caught Throwable object
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, \Throwable $error)
    {
        // Log errors.
        $this->writeToErrorLog($error);

        $data = [
            'message' => 'Application error. Something went wrong!',
        ];
        if ($this->displayErrorDetails) {
            $data['error'] = [];
            do {
                $data['error'][] = [
                    'type' => get_class($error),
                    'code' => $error->getCode(),
                    'message' => $error->getMessage(),
                    'file' => $error->getFile(),
                    'line' => $error->getLine(),
                    'trace' => explode("\n", $error->getTraceAsString()),
                ];
            } while ($error = $error->getPrevious());
        }

        return $this->view->render($request, $response, $data, 500);
    }
}
