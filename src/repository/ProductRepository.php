<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Product.php';

class ProductRepository extends Repository
{    
    public function getProductsByName($name): array
    {
        $products = [];
        try{
            $stmt = $this->database->connect()->prepare('
                SELECT
                    p.name AS product_name,
                    u.unit_name,
                    pu.calories_per_unit
                FROM
                    products p
                JOIN
                    product_units pu ON p.product_id = pu.product_id
                JOIN
                    units u ON pu.unit_id = u.unit_id
                where p.name LIKE :name;
                        ');
            $str = "%" . $name . "%";
            $stmt->bindParam(':name', $str, PDO::PARAM_STR);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $productName = $row['product_name'];
                $unitName = $row['unit_name'];
                $calories = $row['calories_per_unit'];

                if (!isset($products[$productName])) {
                    $products[$productName] = new Product($productName);
                }

                $products[$productName]->addUnit($unitName, $calories);
            }
    } catch (PDOException $e) {
            echo "Application error, please try again later";
        }
        return $products;
    }




}