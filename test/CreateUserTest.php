<?php

use Yyk\Eqbao\UserManage;

require '../vendor/autoload.php';
spl_autoload_register(function ($class_name) {
    echo $class_name . "\n";
    require_once $class_name . '.php';
});

$appid = '';
$secret = '';
$host = 'https://smlopenapi.esign.cn';
$thirdPartyUserId = '1112312';
$name = '';
$idNumber = '';
$mobile = '';

$createUser = new UserManage($thirdPartyUserId, $name, $idNumber, $mobile);
$result = $createUser->create($host, $appid, $secret);
var_dump("开始创建用户",$result,"用户创建完成");

