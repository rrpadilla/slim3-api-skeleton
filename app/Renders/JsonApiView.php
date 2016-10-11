<?php

namespace App\Renders;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Body;

/**
 * JsonApiView - view wrapper for json responses (with error code).
 *
 * This class is a view helper for simple JSON API's.
 */
class JsonApiView implements ApiViewInterface {

    /**
     * Bitmask consisting of <b>JSON_HEX_QUOT</b>,
     * <b>JSON_HEX_TAG</b>,
     * <b>JSON_HEX_AMP</b>,
     * <b>JSON_HEX_APOS</b>,
     * <b>JSON_NUMERIC_CHECK</b>,
     * <b>JSON_PRETTY_PRINT</b>,
     * <b>JSON_UNESCAPED_SLASHES</b>,
     * <b>JSON_FORCE_OBJECT</b>,
     * <b>JSON_UNESCAPED_UNICODE</b>.
     * The behaviour of these constants is described on
     * the JSON constants page.
     * @var int
     */
    public $encodingOptions = JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES;

    /**
     * Output rendered template
     *
     * @param  ResponseInterface $response
     * @param  array $data Associative array of data to be returned
     * @param  int $status HTTP status code
     * @param  array $addHeaders Associative array of header to be added
     * @return ResponseInterface
     */
    public function render(ResponseInterface $response, array $data = [], $status = 200, $addHeaders = [])
    {
        $status = intval($status);
        $output = [
            'meta' => ['error' => true, 'status' => $status],
            'data' => $data,
        ];
        $output['meta']['error'] = ($status < 400) ? false : true;

        $json = json_encode($output, $this->encodingOptions);

        // Ensure that the json encoding passed successfully
        if ($json === false) {
            throw new \RuntimeException(json_last_error_msg(), json_last_error());
        }

        $body = new Body(fopen('php://temp', 'r+'));
        $body->write($json);
        $newResponse = $response->withBody($body);

        $newResponse = $newResponse->withStatus($status)
            ->withHeader('Content-Type', 'application/json;charset=utf-8');

        if (count($addHeaders)) {
            foreach ($addHeaders as $headerKey => $headerValue) {
                if (strtolower($headerKey) != 'content-type') {
                    $newResponse->withHeader($headerKey, $headerValue);
                }
            }
        }

        return $newResponse;
    }
}