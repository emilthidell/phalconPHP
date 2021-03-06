<?php
/*
 * Define custom routes. File gets included in the router service definition.
 */
$router = new Phalcon\Mvc\Router();

$router->add('/confirm/{code}/{email}', array(
    'controller' => 'user_control',
    'action' => 'confirmEmail'
));

$router->add('/reset-password/{code}/{email}', array(
    'controller' => 'user_control',
    'action' => 'resetPassword'
));

$router->add('/worldmap', array(
    'controller' => 'Cities',
    'action' => 'worldMap'
));

$router->add('/cities/{cityDd}', array(
    'controller' => 'cities',
    'action' => 'map'
));

$router->add('/cities/{cityId}/building/{buildingId}', array(
    'controller' => 'cities',
    'action' => 'building'
));

return $router;
