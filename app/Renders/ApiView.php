<?php

namespace App\Renders;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;

/**
 * Class ApiView
 * @package App\Renders
 */
class ApiView
{
    protected $defaultMediaType = 'application/json';
    protected $knownMediaTypes = ['application/json', 'application/xml', 'text/xml'];
    protected $outputParam = 'output';
    protected $checkHeader = true;

    /**
     * ApiView constructor.
     * @param string $defaultMediaType
     * @param string $outputParam
     * @param bool $checkHeader
     */
    public function __construct($defaultMediaType = 'application/json', $outputParam = 'output', $checkHeader = true)
    {
        $this->defaultMediaType = $defaultMediaType;
        $this->outputParam = $outputParam;
        $this->checkHeader = $checkHeader;
    }

    /**
     * @param Request $request
     * @param ResponseInterface $response
     * @param array $data Associative array of data to be returned
     * @param int $status HTTP status code
     * @param array $addHeaders Associative array of header to be added
     * @return ResponseInterface
     */
    public function render(Request $request, ResponseInterface $response, $data = [], $status = 200, $addHeaders = [])
    {
        $mediaType = $this->determineMediaType($request);

        $renderer = $this->getRenderer($mediaType);
        $response = $renderer->render($response, $data, $status, $addHeaders);

        return $response;
    }

    /**
     * @param $mediaType
     * @return ApiViewInterface
     */
    private function getRenderer($mediaType)
    {
        switch ($mediaType) {
            case 'application/xml':
            case 'text/xml':
                return new XmlApiView();

            case 'application/json':
                return new JsonApiView();

            default:
                throw new \RuntimeException("Unknown media type $mediaType");
        }

        return $output;
    }

    /**
     * Read the output parameter or accept header and determine which media type we know about
     * is wanted.
     *
     * @param Request $request
     * @return string
     */
    public function determineMediaType(Request $request)
    {
        $output = $request->getQueryParam($this->outputParam);
        if ($output !== null) {
            if (mb_strtolower($output) == 'xml') {
                return 'application/xml';
            }
            return 'application/json';
        }

        if ($this->checkHeader) {
            $acceptHeader = $request->getHeaderLine('Accept');
            if (!empty($acceptHeader)) {
                $selectedMediaTypes = array_intersect(explode(',', $acceptHeader), $this->knownMediaTypes);

                if (count($selectedMediaTypes)) {
                    return current($selectedMediaTypes);
                }

                // handle +json and +xml specially
                if (preg_match('/\+(json|xml)/', $acceptHeader, $matches)) {
                    $mediaType = 'application/' . $matches[1];
                    if (in_array($mediaType, $this->knownMediaTypes)) {
                        return $mediaType;
                    }
                }
            }
        }

        return $this->getDefaultMediaType();
    }

    /**
     * Getter for defaultMediaType
     *
     * @return string
     */
    public function getDefaultMediaType()
    {
        return $this->defaultMediaType;
    }

    /**
     * Setter for defaultMediaType
     *
     * @param string $defaultMediaType Value to set
     * @return self
     */
    public function setDefaultMediaType($defaultMediaType)
    {
        $this->defaultMediaType = $defaultMediaType;
        return $this;
    }
}