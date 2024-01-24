<?php

require_once __DIR__ . '/AppController.php';
require_once __DIR__ . '/../models/Reward.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/RewardRepository.php';
require_once __DIR__ . '/../repository/WeightLossRecordRepository.php';

class DefaultController extends AppController
{

    private RewardRepository $rewardRepository;
    private WeightLossRecordRepository $weightLossRecordRepository;

    public function __construct()
    {
        parent::__construct();
        $this->rewardRepository = new RewardRepository();
        $this->weightLossRecordRepository = new WeightLossRecordRepository();
    }


    public function myDay()
    {
        $cssNames = [
            'menu',
            'myDay',
        ];
        $jsNames = [
            'myDay'
        ];
        $this->layout('myDay', $cssNames, $jsNames);
    }


    public function statistics()
    {

        $user = User::getUserFromCookie();

        if ($this->isPost()) {
            $weight = $_POST['new_weight'];
            $this->weightLossRecordRepository->addRecord($user->getId(), $weight);
            $user->setWeight($weight);
            User::saveUserToCookie($user);
        }
        $cssNames = [
            'menu',
            'form',
            'stats',
        ];
        $jsNames = [
            'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js',
            'module.stats',
            'module.validationFunctions',
            'module.statsValidation'
        ];
        $rewards = $this->rewardRepository->getRewards();
        $records = $this->weightLossRecordRepository->getRecords($user->getId());
        $this->layout('statistics', $cssNames, $jsNames, ["rewards" => $rewards, "records" => $records]);
    }
}