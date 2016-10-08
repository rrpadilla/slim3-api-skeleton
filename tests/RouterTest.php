<?php

namespace App\Tests;

use Slim\Router;

class RouterTest extends BaseTest
{
    protected $router;

    public function testMap()
    {
        $this->router = new Router;
        $methods = ['GET'];
        $pattern = '/hello';
        $callable = function ($request, $response, $args) {
            //echo sprintf('Hello %s %s', $args['first'], $args['last']);
            echo sprintf('Hello');
        };
        $route = $this->router->map($methods, $pattern, $callable);
        //$this->assertInstanceOf('\Slim\Interfaces\RouteInterface', $route);
        $this->assertAttributeContains($route, 'routes', $this->router);
    }
}