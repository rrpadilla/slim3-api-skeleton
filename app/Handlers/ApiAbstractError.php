<?php

namespace App\Handlers;

use Slim\Handlers\AbstractError;
use App\Renders\ApiViewInterface;
use Psr\Log\LoggerInterface;

abstract class ApiAbstractError extends AbstractError
{
    protected $view;
    protected $logger;

    /**
     * @param ApiViewInterface $view
     * @param LoggerInterface $logger
     * @param bool $displayErrorDetails
     */
    public function __construct(ApiViewInterface $view, LoggerInterface $logger, $displayErrorDetails = false)
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
