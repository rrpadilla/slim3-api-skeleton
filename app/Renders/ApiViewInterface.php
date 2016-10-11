<?php

namespace App\Renders;

use Psr\Http\Message\ResponseInterface;

interface ApiViewInterface
{
    /**
     * Json or Xml.
     *
     * This method prepares the response object to return an HTTP Json or Xml
     * response to the client.
     *
     * @param  ResponseInterface $response
     * @param  array $data Associative array of data to be returned
     * @param  int $status HTTP status code
     * @param  array $addHeaders Associative array of header to be added
     * @return ResponseInterface
     */
    public function render(ResponseInterface $response, array $data = [], $status = 200, $addHeaders = []);
}