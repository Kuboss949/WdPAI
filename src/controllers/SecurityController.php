<?php
require_once __DIR__.'/AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController{

    private UserRepository $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }
    public function login()
    {
        if (!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST['email'];

        $user = $this->userRepository->getUser($email);

        if (!$user) {
            return $this->render('login', ['messages' => ['User not found!']]);
        }

        $enteredPassword = $user->getSalt().$_POST['password'];
        $hashedPassword = $user->getPassword(); // Assuming getPassword() returns the hashed password directly

        if (!password_verify($enteredPassword, $hashedPassword)) {
            return $this->render('login', ['messages' => ['Wrong password!']]);
        }

        $userJson = json_encode($user);
        $userBase64 = base64_encode($userJson);

        setcookie('user_data', $userBase64, time() + (86400 * 30), "/");
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/myDay");
    }

    public function register(){
        if (!$this->isPost()) {
            return $this->render('register');
        }

        $email = $_POST['email'];
        $login = $_POST['login'];
        $password = $_POST['password'];
        $randomSalt = bin2hex(random_bytes(16));
        $hashedPassword = password_hash($randomSalt.$password, PASSWORD_BCRYPT);

        $user = new User(0, $login, $email, $hashedPassword, $randomSalt, 1,  "knight", 2);

        $this->userRepository->addUser($user);

        return $this->render('login', ['messages' => ['You\'ve been succesfully registrated!']]);
    }
}