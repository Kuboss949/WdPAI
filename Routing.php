<?php

require_once __DIR__ . '/src/controllers/DefaultController.php';
require_once __DIR__ . '/src/controllers/SecurityController.php';
require_once __DIR__ . '/src/controllers/SearchController.php';
require_once __DIR__ . '/src/controllers/MealController.php';
require_once __DIR__ . '/src/controllers/ProfileController.php';
require_once __DIR__ . '/src/controllers/AdministrationController.php';

class Routing{
    public static $routes = [];

    public static function get($url, $controller){
        self::$routes[$url] = $controller;
    }

    public static function run($url){
        $action = explode("/", $url)[0];

        if(!array_key_exists($action, self::$routes)){
                die("Wrong url!");
        }

        $controller = self::$routes[$action];
        $object = new $controller;
        $object->$action();

    }

}