<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;

class BaseTestCase extends TestCase
{
    protected $app;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp()
    {
        $this->createApplication();
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    protected function tearDown()
    {
        $this->app = null;
    }

    /**
     * Creates the application.
     */
    public function createApplication()
    {
        $this->app = require __DIR__ . '/../bootstrap/test.php';
        return $this->app;
    }

    /**
     * Process the application given a request method and URI.
     *
     * @see http://www.slimframework.com/docs/cookbook/environment.html
     *
     * @param string $requestMethod the request method (e.g. GET, POST, PUT, DELETE, HEAD, PATCH, OPTIONS, etc.)
     * @param string $requestUri the request URI
     * @param string $queryString the params (e.g. 'abc=123&foo=bar')
     * @param array $envData Array of custom environment keys and values
     * @param array|object|null $requestData the request data
     * @return \Slim\Http\Response
     */
    public function runApp($requestMethod, $requestUri, $queryString, $envData = [], $requestData = null)
    {
        $mock = array_merge([
            'REQUEST_METHOD' => $requestMethod,
            'REQUEST_URI' => $requestUri,
            'QUERY_STRING' => $queryString,
            'CONTENT_TYPE' => 'application/json;charset=utf8'
        ], $envData);

        // Create a mock environment for testing with.
        $environment = Environment::mock($mock);

        // Set up a request object based on the environment.
        $request = Request::createFromEnvironment($environment);

        // Add request data, if it exists
        if (isset($requestData)) {
            $request = $request->withParsedBody($requestData);
        }

        // Create application.
        $app = $this->app;
        if (!$app instanceof App) {
            $app = $this->createApplication();
        }

        // Set up a response object.
        $response = new Response();

        // Process the application
        $response = $app->process($request, $response);

        // Return the response
        return $response;
    }
}
