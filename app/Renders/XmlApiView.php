<?php

namespace App\Renders;

use Psr\Http\Message\ResponseInterface;
use App\Helpers\ArrayToXml;

/**
 * XmlApiView - view wrapper for xml responses (with error code).
 *
 * This class is a view helper for simple XML API's.
 */
class XmlApiView implements ApiViewInterface {

    /**
     * Output rendered template
     *
     * @param  ResponseInterface $response
     * @param  array $data Associative array of data to be returned
     * @param  int $status HTTP status code
     * @param  array $addHeaders Associative array of header to be added
     * @return ResponseInterface
     * @throws \Exception
     */
    public function render(ResponseInterface $response, $data = [], $status = 200, $addHeaders = [])
    {
        $status = intval($status);
        $output = [
            'meta' => ['error' => true, 'status' => $status],
            'data' => [$data],
        ];
        $output['meta']['error'] = ($status < 400) ? false : true;

        try {
            $xmlBody = ArrayToXml::convert($output);
            if ($xmlBody === false) {
                throw new \RuntimeException("Error Generating XML.");
            }
        } catch (\Exception $e) {
            throw $e;
        }

        $r = $response->withStatus($status)
            ->withHeader('Content-Type', 'application/xml; charset=UTF-8');

        if (count($addHeaders)) {
            foreach ($addHeaders as $headerKey => $headerValue) {
                if (strtolower($headerKey) != 'content-type') {
                    $r->withHeader($headerKey, $headerValue);
                }
            }
        }

        $r->getBody()->write($xmlBody);
        return $r;
    }
}