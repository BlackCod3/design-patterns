<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/Tasks/AbstractTask.php';
require_once __DIR__ . '/Tasks/FirstTask.php';
require_once __DIR__ . '/Tasks/SecondTask.php';
require_once __DIR__ . '/Tasks/ThirdTask.php';

use SupplyChainApproach\Tasks\FirstTask;
use SupplyChainApproach\Tasks\SecondTask;
use SupplyChainApproach\Tasks\ThirdTask;





$task1 = new FirstTask();
$task2 = new SecondTask();
$task3 = new ThirdTask();

$launch     = (array_key_exists(1, $argv) && $argv[1] === 'launch') ? true : false;
$taskNumber = (array_key_exists(2, $argv) && in_array($argv[2], [1, 2, 3])) ? $argv[2] : 0;

if ($launch && $taskNumber) {

    $taskToLaunch = 'task'.$taskNumber;
    $$taskToLaunch->process();

}
