<?php
use Cake\Routing\Router;

Router::plugin('BuiBaker', function ($routes) {
    $routes->fallbacks('DashedRoute');
});
