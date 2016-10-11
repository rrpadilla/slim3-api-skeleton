<?php

namespace App\Handlers;

use Slim\Handlers\AbstractHandler;
use App\Renders\ApiView;

abstract class ApiAbstractHandler extends AbstractHandler
{
    protected $view;

    public function __construct(ApiView $view)
    {
        $this->view = $view;
    }
}