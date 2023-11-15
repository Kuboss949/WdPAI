<?php

require_once __DIR__.'/AppController.php';

class DefaultController extends AppController{

    public function login(){
        //include __DIR__."/src/views/login.html";
        $this->render('login');
    }

    public function myDay(){
        //include __DIR__."/src/views/myDay.html";
        $this->render('myDay');
    }
}