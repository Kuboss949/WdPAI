<?php

require_once __DIR__.'/AppController.php';
require_once __DIR__.'/../models/Dog.php';

class DefaultController extends AppController{

    public function myDay(){
        $cssNames = [ 
            'menu',
            'myDay',
            ];
        $this->layout('myDay', $cssNames);
    }

    public function search(){
        $cssNames = [ 
            'menu',
            'search',
            ];
        $this->layout('search', $cssNames);
    }

    public function profile(){
        $cssNames = [ 
            'menu',
            'profile',
            ];
        $this->layout('profile', $cssNames);
    }
    

    public function statistics(){
        $cssNames = [ 
            'menu',
            'statistics',
            ];
        $this->layout('statistics', $cssNames);
    }
}