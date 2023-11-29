<?php
require __DIR__.'/Routing.php';

$path = trim($_SERVER["REQUEST_URI"],"/");

$path = parse_url($path, PHP_URL_PATH);

Routing::get('login', 'SecurityController');
Routing::get('register', 'SecurityController');
Routing::get('myDay', 'DefaultController');
Routing::get('profile', 'DefaultController');
Routing::get('search', 'DefaultController');
Routing::get('statistics', 'DefaultController');


Routing::run($path);


