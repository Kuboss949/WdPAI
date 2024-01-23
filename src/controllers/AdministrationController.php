<?php

require_once __DIR__.'/AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class AdministrationController extends AppController
{
    private UserRepository $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function administrationPanel(){
        $user = User::getUserFromCookie();
        if($this->userRepository->isAdmin($user->getId())){
            $cssNames = [
                'menu',
                'administrationPanel'
            ];
            $jsNames = [
                'administrationPanel'
            ];
            $users = $this->userRepository->getUsers();
            return $this->layout('administrationPanel', $cssNames, $jsNames, ['users' => $users]);
        }else{
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/myDay");
        }
    }

    public function deleteUser()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $id = $decoded['id'];
            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->userRepository->deleteUser($id));
        }
    }





}