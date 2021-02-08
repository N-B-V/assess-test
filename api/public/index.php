<?php

require '../vendor/autoload.php';

// Bootstrap Slim Framework
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true, // you would want this false in production
    ],
]);

require '../src/dependencies.php';
require '../src/routes.php';

$app->run();