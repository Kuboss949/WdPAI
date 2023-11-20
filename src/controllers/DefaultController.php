<?php

require_once __DIR__.'/AppController.php';
require_once __DIR__.'/../models/Dog.php';

class DefaultController extends AppController{

    public function login(){
        $this->render('login');
    }

    public function myDay(){
        $names = [ 
            'menu',
            'myDay',
            ];
        $this->render('myDay', $names);
    }
}