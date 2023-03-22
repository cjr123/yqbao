<?php

use Yyk\Eqbao\UserManage;

require '../vendor/autoload.php';
spl_autoload_register(function ($class_name) {
    echo $class_name . "\n";
    require_once $class_name . '.php';
});

$appid = 'appid';
$secret = 'secret';
$host = 'https://smlopenapi.esign.cn';
$thirdPartyUserId = '用户唯一标识';
$name = '姓名';
$idNumber = '签证号';
$mobile = '手机号';

$createUser = new UserManage($thirdPartyUserId, $name, $idNumber, $mobile);
$result = $createUser->create($host, $appid, $secret);
var_dump("开始创建用户",$result,"用户创建完成");

