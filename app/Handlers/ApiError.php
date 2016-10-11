<?php

namespace App\Handlers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * API default error handler
 *
 * It outputs the error message and diagnostic information in either JSON or XML.
 */
final class ApiError extends ApiAbstractError
{
    /**
     * Invoke error handler
     *
     * @param ServerRequestInterface $request   The most recent Request object
     * @param ResponseInterface      $response  The most recent Response object
     * @param \Exception             $exception The caught Exception object
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, \Exception $exception)
    {
        // Log errors.
        $this->writeToErrorLog($exception);

        $data = [
            'message' => 'Application error. Something went wrong!',
        ];
        if ($this->displayErrorDetails) {
            $data['exception'] = [];
            do {
                $data['exception'][] = [
                    'type' => get_class($exception),
                    'code' => $exception->getCode(),
                    'message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => explode("\n", $exception->getTraceAsString()),
                ];
            } while ($exception = $exception->getPrevious());
        }

        return $this->view->render($request, $response, $data, 500);
    }
}
