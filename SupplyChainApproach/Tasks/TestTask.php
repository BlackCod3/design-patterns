<?php

require_once __DIR__ . '/../../vendor/autoload.php';


require_once __DIR__ . '/AbstractTask.php';
require_once __DIR__ . '/FirstTask.php';
require_once __DIR__ . '/SecondTask.php';

$f1 = new \SupplyChainApproach\Tasks\FirstTask();


$faker = Faker\Factory::create('FR_fr');
