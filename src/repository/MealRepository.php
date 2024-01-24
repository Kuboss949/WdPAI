<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/MealEntry.php';

class MealRepository extends Repository
{
    public function getMealsForUser($userId): array{
        $meals = [];
        try{
            $stmt = $this->database->connect()->prepare('
                SELECT
                    me.entry_id AS id,
                    mt.meal_type_name AS meal_name,
                    p.name AS product_name,
                    me.amount,
                    u.unit_name,
                    pu.calories_per_unit
                FROM
                    meal_entries me
                JOIN
                    meal_types mt ON me.meal_type_id = mt.meal_type_id
                JOIN
                    products p ON me.product_id = p.product_id
                JOIN
                    product_units pu ON me.product_id = pu.product_id AND me.unit_id = pu.unit_id
                JOIN
                    units u ON me.unit_id = u.unit_id
                WHERE
                    me.user_id = :id; 
                        ');
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $meal = new MealEntry(
                    $row['id'],
                    $row['meal_name'],
                    $row['product_name'],
                    $row['amount'],
                    $row['unit_name'],
                    $row['calories_per_unit']
                );
                $meals[] = $meal;
            }
        } catch (PDOException $e) {
            echo "Application error, please try again later";
        }
        return $meals;
    }

    public function addProductToMeal($id, $productName, $amount, $unit, $meal) :array
    {
        try{
            $stmt = $this->database->connect()->prepare('
                SELECT product_id 
                FROM products  
                WHERE LOWER(name) = LOWER(:productName)');
            $stmt->bindParam(':productName', $productName, PDO::PARAM_STR);
            $stmt->execute();
            $productResult = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt = $this->database->connect()->prepare('
                SELECT unit_id 
                FROM units 
                WHERE LOWER(unit_name) = LOWER(:unitName)');
            $stmt->bindParam(':unitName', $unit, PDO::PARAM_STR);
            $stmt->execute();
            $unitResult = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt = $this->database->connect()->prepare('
                SELECT meal_type_id
                FROM meal_types
                WHERE LOWER(meal_type_name) = LOWER(:mealName);');
            $stmt->bindParam(':mealName', $meal, PDO::PARAM_STR);
            $stmt->execute();
            $mealResult = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($productResult && $unitResult && $mealResult) {
                $stmt = $this->database->connect()->prepare('
                INSERT INTO meal_entries (user_id, meal_type_id, product_id, amount, unit_id)
                VALUES (:user_id, :meal_type_id, :product_id, :amount, :unit_id)');
                $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);
                $stmt->bindParam(':meal_type_id', $mealResult['meal_type_id'], PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $productResult['product_id'], PDO::PARAM_INT);
                $stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
                $stmt->bindParam(':unit_id', $unitResult['unit_id'], PDO::PARAM_INT);
                $stmt->execute();

                return array('status' => 'success', 'message' => 'Produkt został dodany do posiłku.');
            } else {
                return array('error' => 'Nie udało się uzyskać informacji o produkcie, jednostce lub typie posiłku.');
            }

        } catch (PDOException $e) {
            return array('error' => 'Błąd podczas komunikacji z bazą danych: ' . $e->getMessage());
        }

    }

    function deleteEntry($id)
    {
        try{
            $stmt = $this->database->connect()->prepare('
                    DELETE
                    FROM meal_entries 
                    WHERE entry_id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            $rowCount = $stmt->rowCount();
            if($rowCount > 0){
                return array('status' => 'success', 'message' => 'Wpis został usunięty.');
            }else{
                return array('error' => 'Nie udało się usunąć wpisu');
            }
        } catch (PDOException $e) {
            return array('error' => 'Błąd podczas komunikacji z bazą danych: ' . $e->getMessage());
        }

    }


}