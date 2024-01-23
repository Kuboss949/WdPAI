<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../models/SimplifiedUser.php';

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

    function updateProfile(string $login, string $email): void
    {
        $userObject = User::getUserFromCookie();

        $stmt = $this->database->connect()->prepare('
            UPDATE users SET login = :newLogin, email = :newEmail WHERE user_id = :id;
        ');
        $stmt->bindParam(':newLogin', $login, PDO::PARAM_STR);
        $stmt->bindParam(':newEmail', $email, PDO::PARAM_STR);
        $id = $userObject->getId();
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    function updateGoals(string $image, int $height, float $weight, int $age, string $sex, float $weightLoss, string $activity): void
    {
        $userObject = User::getUserFromCookie();
        $stmt = $this->database->connect()->prepare('
        UPDATE user_details
            SET
                profile_image_name = :image,
                height = :height,
                current_weight = :weight,
                age = :age,
                sex = :sex,
                weight_loss = :weightLoss,
                activity_level = :activity
            WHERE user_id = :id
        ');
        // Wiązanie parametrów
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);
        $stmt->bindParam(':height', $height, PDO::PARAM_INT);
        $stmt->bindParam(':weight', $weight, PDO::PARAM_INT);
        $stmt->bindParam(':age', $age, PDO::PARAM_INT);
        $stmt->bindParam(':sex', $sex, PDO::PARAM_STR);
        $stmt->bindParam(':weightLoss', $weightLoss, PDO::PARAM_STR);
        $stmt->bindParam(':activity', $activity, PDO::PARAM_STR);
        $id = $userObject->getId();
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function userWithEmailExists($email): bool
    {
        $stmt = $this->database->connect()->prepare('
        SELECT * from users where email = :email
        ');

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function userWithLoginExists($login): bool
    {
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM users WHERE login = :login
    ');

        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function isAdmin($id): bool
    {
        $stmt = $this->database->connect()->prepare('
        SELECT role_id FROM users WHERE user_id = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data['role_id'] == 1;
    }


    public function getUsers(){
        $users = [];
        $stmt = $this->database->connect()->prepare('
        SELECT users.user_id, users.login, users.email, users.enabled, roles.role_name 
        FROM users 
        JOIN roles ON roles.role_id = users.role_id
        ORDER BY users.user_id ASC;
        ');
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = new SimplifiedUser($row['user_id'], $row['login'], $row['email'], $row['enabled'], $row['role_name']);
            array_push($users, $user);
        }

        return $users;
    }


    public function deleteUser($id)
    {
        $stmt = $this->database->connect()->prepare('
        DELETE FROM meal_entries WHERE user_id = :id;
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt = $this->database->connect()->prepare('
        DELETE FROM user_details WHERE user_id = :id;
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt = $this->database->connect()->prepare('
        DELETE FROM weight_changes WHERE user_id = :id;
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt = $this->database->connect()->prepare('
        DELETE FROM users WHERE user_id = :id;
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result){
            return array('status' => 'success', 'message' => 'Wpis został usunięty.');
        }else{
            return array('error' => 'Nie udało się usunąć wpisu');
        }
    }
}
