<?php

namespace App\Tests;

class DefaultRoutesTest extends BaseTestCase
{
    /**
     * Test that the hello route returns the message "Hello".
     */
    public function testGetHello()
    {
        $envData = ['CONTENT_TYPE' => 'application/json;charset=utf8'];
        $response = $this->runApp('GET', '/v1/hello', 'output=json', $envData);
        $output = $response->getBody();
        $output = json_decode($output, true);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(200, $output['meta']['status']);
        $this->assertEquals('Hello', $output['data']['message']);
        $this->assertContains('application/json', $response->getHeaderLine('Content-type'));
        $this->assertNotContains('application/xml', $response->getHeaderLine('Content-type'));
    }

    /**
     * Test that the hello route won't accept a post request
     */
    public function testPostHellopageNotAllowed()
    {
        $response = $this->runApp('POST', '/v1/hello', 'output=json');
        $this->assertEquals(405, $response->getStatusCode());
        $this->assertContains('Method not allowed', (string)$response->getBody());
    }
}