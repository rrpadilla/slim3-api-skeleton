<?php

namespace App\Handlers;

use Slim\Handlers\AbstractHandler;
use App\Renders\ApiViewInterface;

abstract class ApiAbstractHandler extends AbstractHandler
{
    protected $view;

    public function __construct(ApiViewInterface $view)
    {
        $this->view = $view;
    }
}