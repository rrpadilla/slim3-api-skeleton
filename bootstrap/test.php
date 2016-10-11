<?php

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

require BASE_PATH . '/vendor/autoload.php';

// Load "Environments" files.
if (file_exists(BASE_PATH . '/env.php')) {
    $envSettings = \Noodlehaus\Config::load(BASE_PATH . '/env.php');
} else {
    $envSettings = \Noodlehaus\Config::load(BASE_PATH . '/env.php.dist');
}

// Timezone.
date_default_timezone_set($envSettings->get('TIMEZONE', 'UTC'));
// Encoding.
mb_internal_encoding('UTF-8');

// Instantiate the app.
$settings = require BASE_PATH . '/config/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies.
require BASE_PATH . '/config/dependencies.php';

// Register middleware.
require BASE_PATH . '/config/middleware.php';

// Register routes.
require BASE_PATH . '/routes/tests.php';
//require BASE_PATH . '/routes/routes.php';

return $app;
