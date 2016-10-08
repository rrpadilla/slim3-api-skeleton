<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
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
     * Creates the application.
     */
    public function createApplication()
    {
        $app = null;

        require __DIR__ . '/../bootstrap/app.php';

        $app->run();
    }
}