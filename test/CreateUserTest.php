<?php

use Yyk\Eqbao\UserManage;

require '../vendor/autoload.php';
spl_autoload_register(function ($class_name) {
    echo $class_name . "\n";
    require_once $class_name . '.php';
});

$appid = '7438953390';
$secret = '00d8dcaa04dcd876aa9e76168ea5b70d';
$host = 'https://smlopenapi.esign.cn';
$thirdPartyUserId = '123213s221sd';
$name = '张首宾';
$idNumber = '370923199307122810';
$mobile = '13693064196';

$createUser = new UserManage($thirdPartyUserId, $name, $idNumber, $mobile);
$result = $createUser->create($host, $appid, $secret);
var_dump("开始创建用户",$result,"用户创建完成");

