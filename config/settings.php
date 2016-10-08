<?php

return [
    'settings' => [
        // Slim Settings.
        // 'httpVersion' => '1.1',
        // 'responseChunkSize' => 4096,
        // 'outputBuffering' => 'append',
        // 'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails' => $envSettings->get('APP_DEBUG', false),
        // 'addContentLengthHeader' => true,
        'routerCacheFile' => $envSettings->get('APP_ROUTER_CACHE_FILE', BASE_PATH . '/cache/routes/routes.cache'),

        // DB settings.
        'db' => [
            'driver' => $envSettings->get('DB_DRIVER', 'mysql'),
            'host' => $envSettings->get('DB_HOST', 'localhost'),
            'port' => $envSettings->get('DB_PORT', 3306),
            'database' => $envSettings->get('DB_DATABASE', ''),
            'username' => $envSettings->get('DB_USERNAME', ''),
            'password' => $envSettings->get('DB_PASSWORD', ''),
            'charset' => $envSettings->get('DB_CHARSET', 'utf8'),
            'collation' => $envSettings->get('DB_COLLATION', 'utf8_unicode_ci'),
            'prefix' => $envSettings->get('DB_PREFIX', ''),
        ],

        // Monolog settings
        'logger' => [
            'name' => 'api-logger',
            'path' => BASE_PATH . '/logs/app.log',
        ],
    ],
];