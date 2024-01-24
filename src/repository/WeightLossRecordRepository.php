<?php

require_once 'Repository.php';
class WeightLossRecordRepository extends Repository
{
    public function getRecords(int $id)
    {
        $records = [];
        try{
            $stmt = $this->database->connect()->prepare('
                SELECT change_date, new_weight FROM public.weight_changes where user_id = :id
                ORDER BY change_date ASC 
                        ');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $records[] = array(
                        $row['change_date'] => (float)$row['new_weight'],
                    );
            }

        } catch (PDOException $e) {
            echo "Application error, please try again later";
        }

        return $records;

    }

    public function addRecord(int $id, float $weight)
    {
        try{
            $date = date('Y-m-d');

            $stmt = $this->database->connect()->prepare('
                INSERT INTO weight_changes (user_id, change_date, new_weight)
                VALUES (?, ?, ?)
                ON CONFLICT (user_id, change_date)
                DO UPDATE SET new_weight = EXCLUDED.new_weight;
                        ');
            $stmt->execute([
                $id,
                $date,
                $weight
            ]);
            $stmt = $this->database->connect()->prepare('
            UPDATE user_details
            SET
                current_weight = :weight
            WHERE 
                user_id = :id
                        ');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':weight', $weight, PDO::PARAM_STR);
            $stmt->execute();

        } catch (PDOException $e) {
            echo "Application error, please try again later";
        }

    }



}