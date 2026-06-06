<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$routes = app('router')->getRoutes();
foreach ($routes as $route) {
    if (strpos($route->getName(), 'matchs.') !== false) {
        echo $route->methods()[0] . " " . $route->uri() . " -> " . $route->getName() . "\n";
    }
}
