<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Reward.php';
class RewardRepository extends Repository
{
    public function getRewards()
    {
        $rewards = [];
        try{
            $stmt = $this->database->connect()->prepare('
                SELECT reward_types.type_name, rewards.*
                FROM rewards
                JOIN reward_types ON reward_types.reward_type_id = rewards.reward_type_id
                ORDER BY rewards.required_level ASC;
                        ');
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $reward = new Reward($row['required_level'], $row['type_name'], $row['content']);
                array_push($rewards, $reward);
            }



        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        return $rewards;

    }

    public function getImages($level)
    {
        $images = [];
        try{
            $stmt = $this->database->connect()->prepare("
                SELECT rewards.content
                FROM rewards
                JOIN reward_types ON reward_types.reward_type_id = rewards.reward_type_id
                WHERE reward_types.type_name='profile picture' AND rewards.required_level <= :level;
                        ");
            $stmt->bindParam(':level', $level, PDO::PARAM_INT);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($images, $row['content']);
            }


        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        return $images;

    }


}