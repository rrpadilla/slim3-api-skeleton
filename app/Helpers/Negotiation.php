<?php

namespace App\Helpers;

use Slim\Http\Request;

final class Negotiation
{
    /**
     * Known handled content types
     *
     * @return array
     */
    public static function getKnownContentTypes()
    {
        return [
            'application/json',
            'application/xml',
        ];
    }

    /**
     * Determine which content type we know about is wanted using Accept header
     *
     * @param Request $request
     * @return string
     */
    public static function determineContentType(Request $request)
    {
        $acceptHeader = $request->getHeaderLine('Accept');
        if (!empty($acceptHeader)) {
            $selectedContentTypes = array_intersect(explode(',', $acceptHeader), self::getKnownContentTypes());

            if (count($selectedContentTypes)) {
                return current($selectedContentTypes);
            }

            // handle +json and +xml specially
            if (preg_match('/\+(json|xml)/', $acceptHeader, $matches)) {
                $contentType = 'application/' . $matches[1];
                if (in_array($contentType, self::getKnownContentTypes())) {
                    return $contentType;
                }
            }
        }

        return 'application/json';
    }

    /**
     * @param Request $request
     * @param string $param
     * @param bool $checkHeader
     * @return string
     */
    public static function negotiate(Request $request, $param = 'output', $checkHeader = true)
    {
        $output = $request->getQueryParam($param);
        if ($output !== null) {
            if (mb_strtolower($output) == 'xml') {
                return 'application/xml';
            }
            return 'application/json';
        }
        if ($checkHeader) {
            return self::determineContentType($request);
        }

        return 'application/json';
    }
}
