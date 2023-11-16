<?php

require_once __DIR__.'/AppController.php';
require_once __DIR__.'/../models/Dog.php';

class DefaultController extends AppController{

    public function login(){
        $this->render('login');
    }

    public function myDay(){
        $dogs = [ 

            new Dog("Buddy", "Golden Retriever", "Friendly and energetic", "Golden", "https://zooart.com.pl/blog/wp-content/uploads/2021/08/GOLDEN-RETRIEVER-1000x667-1.jpg"), 
            
            new Dog("Charlie", "Labrador Retriever", "Loyal and playful", "Chocolate", "https://upload.wikimedia.org/wikipedia/commons/thumb/2/26/YellowLabradorLooking_new.jpg/640px-YellowLabradorLooking_new.jpg"), 
            
            new Dog("Max", "German Shepherd", "Intelligent and protective", "Black and Tan", "https://example.com/max.jpg"), 
            
            new Dog("Lucy", "Beagle", "Curious and friendly", "Tri-color", "https://example.com/lucy.jpg"), 
            
            new Dog("Sadie", "Dachshund", "Clever and lively", "Red", "https://example.com/sadie.jpg") 
            
            ]; 
        $this->render('myDay', ['title' => 'Hello on my day page', 'dogs' => $dogs]);
    }
}