<?php

require_once __DIR__.'/AppController.php';
require_once __DIR__.'/../models/Product.php';
require_once __DIR__.'/../repository/ProductRepository.php';


class SearchController extends AppController
{

    private ProductRepository $productRepository;

    public function __construct()
    {
        parent::__construct();
        $this->productRepository = new ProductRepository();
    }

    public function search(){
        if(isset($_COOKIE['meal_name'])) {
            $cssNames = [
                'menu',
                'search'
            ];
            $jsNames = [
                'search'
            ];
            $variables = [
              $_COOKIE['meal_name']
            ];
            $this->layout('search', $cssNames, $jsNames, $variables);
        }
        else
        {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/myDay");
        }

    }

    public function searchProduct(){
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->productRepository->getProductsByName($decoded['search']));
        }
    }



}