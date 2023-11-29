<?php
require_once __DIR__.'/AppController.php';

class SecurityController extends AppController{
    public function login(){
        $this->render('login');
    }

    public function register(){
        $this->render('register');
    }
}