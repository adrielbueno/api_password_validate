<?php

require_once 'vendor/autoload.php';

define('ABSOLUTE_MAIN_DIR', dirname(__FILE__));

require_once 'app/core/globals/functions.php';
require_once 'app/core/config/server.php';

register_shutdown_function('catch_fatal_error');

require_once 'app/core/handlers/middlewares/Filter.php';

requireRouteFiles();

try {
    (new App\Core\Handlers\Router\Runner())->run();
} catch (\Throwable $th) {
    (new App\Core\Handlers\Exceptions\ExceptionHandler($th))->print();
}
