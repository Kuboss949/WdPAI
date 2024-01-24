<?php

require_once __DIR__ . '/AppController.php';
require_once __DIR__ . '/../models/MealEntry.php';
require_once __DIR__ . '/../repository/MealRepository.php';

class MealController extends AppController
{
    private MealRepository $mealRepository;

    public function __construct()
    {
        parent::__construct();
        $this->mealRepository = new MealRepository();
    }

    public function deleteEntry()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $id = $decoded['id'];
            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->mealRepository->deleteEntry($id));
        }
    }

    function addProductToMeal()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $id = $decoded['productData']['userID'];
            $productName = $decoded['productData']['name'];
            $amount = $decoded['productData']['amount'];
            $unit = $decoded['productData']['unit'];
            $meal = $decoded['productData']['meal'];
            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->mealRepository->addProductToMeal($id, $productName, $amount, $unit, $meal));
        }
    }

}