<?php
require __DIR__.'/Routing.php';

$path = trim($_SERVER["REQUEST_URI"],"/");

$path = parse_url($path, PHP_URL_PATH);

Routing::get('login', 'DefaultController');
Routing::get('myDay', 'DefaultController');

Routing::run($path);


