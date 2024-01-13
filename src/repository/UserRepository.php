<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{
    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM user_merged WHERE email=:email OR login=:email
        ');

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user === false) {
            return null;
        }

        if (!$user['enabled']) {
            return null;
        }

        return new User(
            $user['user_id'],
            $user['login'],
            $user['email'],
            $user['password'],
            $user['salt'],
            $user['level'],
            $user['exp'],
            $user['profile_image_name'],
            $user['role_name'],
            $user['height'],
            $user['current_weight'],
            $user['weight_loss'],
            $user['activity_level'],
            $user['sex'],
            $user['age']
        );
    }

    public function addUser(User $user)
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO users (login, email, password, enabled, role_id, salt)
            VALUES (?, ?, ?, ?, ?, ?)
        ');

        $stmt->execute([
            $user->getLogin(),
            $user->getEmail(),
            $user->getPassword(),
            true,
            2,
            $user->getSalt()
        ]);

        $userId = $this->getUserId($user);

        $stmt = $this->database->connect()->prepare('
            INSERT INTO user_details (user_id, level, exp, profile_image_name, height, current_weight, activity_level, weight_loss)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ');

        $stmt->execute([
            $userId,
            $user->getLevel(),
            $user->getExp(),
            $user->getImage(),
            $user->getHeight(),
            $user->getWeight(),
            $user->getActivity(),
            $user->getWeightLoss()
        ]);
    }

    public function getUserId(User $user): int
    {
        $stmt = $this->database->connect()->prepare('
            SELECT user_id FROM users WHERE email = :email
        ');

        $email = $user->getEmail();
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data['user_id'];
    }
}
