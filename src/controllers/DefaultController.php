<?php

require_once __DIR__.'/AppController.php';
require_once __DIR__.'/../models/Dog.php';
require_once __DIR__.'/../repository/ProductRepository.php';

class DefaultController extends AppController{

    private $productRepository;

    public function __construct()
    {
        // parent::__construct();
        $this->productRepository = new ProductRepository();
    }


    public function myDay(){
        $cssNames = [ 
            'menu',
            'myDay',
        ];
        $products = $this->productRepository->getProducts(); // Corrected syntax
        $this->layout('myDay', $cssNames, $products);
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