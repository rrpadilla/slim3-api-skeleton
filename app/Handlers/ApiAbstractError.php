<?php

namespace App\Handlers;

use Slim\Handlers\AbstractError;
use App\Renders\ApiView;
use Psr\Log\LoggerInterface;

abstract class ApiAbstractError extends AbstractError
{
    protected $view;
    protected $logger;

    /**
     * @param ApiView $view
     * @param LoggerInterface $logger
     * @param bool $displayErrorDetails
     */
    public function __construct(ApiView $view, LoggerInterface $logger, $displayErrorDetails = false)
    {
        parent::__construct($displayErrorDetails);
        $this->view = $view;
        $this->logger = $logger;
    }

    /**
     * @param $message
     */
    protected function logError($message)
    {
        parent::logError($message);
        $this->logger->critical($message);
    }
}
