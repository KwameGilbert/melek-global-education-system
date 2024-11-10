<?php

use App\Routes\StudentRoute;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->group('/api', function (RouteCollectorProxy $group) {
        (new StudentRoute())->register($group);
    });
};
