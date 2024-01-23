<?php
require_once __DIR__.'/AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../repository/RewardRepository.php';

class ProfileController extends AppController{

    private UserRepository $userRepository;
    private RewardRepository $rewardRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->rewardRepository = new RewardRepository();
    }

    public function profile()
    {
        $userObject = User::getUserFromCookie();
        $cssNames = [
            'menu',
            'form',
            'profile'
        ];
        $jsNames = [
            'profile',
            'module.validationFunctions',
            'module.profileValidation'
        ];
        $images = $this->rewardRepository->getImages($userObject->getLevel());

        if (isset($_POST['updateProfile'])) {
            $newLogin = isset($_POST['login']) ? htmlspecialchars($_POST['login']) : '';
            $newEmail = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
            if($newLogin != $userObject->getLogin() && $this->userRepository->userWithLoginExists($newLogin)){
                return $this->layout('profile', $cssNames, $jsNames,  ['messages' => ['User with such login already exists!'], 'images' => $images]);
            }
            elseif($newEmail != $userObject->getEmail() && $this->userRepository->userWithEmailExists($newEmail)){
                return $this->layout('profile', $cssNames, $jsNames,  ['messages' => ['User with such email already exists!', 'images' => $images]]);
            }

            $this->updateUserProfile($newLogin, $newEmail, $userObject);
        } else if (isset($_POST['updateGoals'])) {
            $image = isset($_POST['profilePictures']) ? htmlspecialchars($_POST['profilePictures']) : '';
            $height = isset($_POST['height']) ? intval($_POST['height']) : 0;
            $weight = isset($_POST['weight']) ? floatval($_POST['weight']) : 0.0;
            $age = isset($_POST['age']) ? intval($_POST['age']) : 0;
            $sex = isset($_POST['sex']) ? htmlspecialchars($_POST['sex']) : '';
            $activity = isset($_POST['weekly-activity']) ? htmlspecialchars($_POST['weekly-activity']) : '';
            $weightLoss = isset($_POST['weight-loss']) ? floatval($_POST['weight-loss']) : 0.0;

            $this->updateUserGoals($image, $height, $weight, $age, $sex, $weightLoss, $activity, $userObject);
        }

        User::saveUserToCookie($userObject);

        return $this->layout('profile', $cssNames, $jsNames, ['images' => $images]);
    }

    private function updateUserProfile(string $newLogin, string $newEmail, User $userObject)
    {
        $this->userRepository->updateProfile($newLogin, $newEmail);
        $userObject->setEmail($newEmail);
        $userObject->setLogin($newLogin);
    }

    private function updateUserGoals(string $image, int $height, float $weight, int $age, string $sex, float $weightLoss, string $activity, User $userObject)
    {
        $this->userRepository->updateGoals($image, $height, $weight, $age, $sex, $weightLoss, $activity);

        $userObject->setImage($image);
        $userObject->setHeight($height);
        $userObject->setWeight($weight);
        $userObject->setAge($age);
        $userObject->setSex($sex);
        $userObject->setActivity($activity);
        $userObject->setWeightLoss($weightLoss);
    }
}