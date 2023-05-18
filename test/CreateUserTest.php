<?php

use Yyk\Eqbao\UserManage;
use Yyk\Eqbao\Conf;

require '../vendor/autoload.php';
spl_autoload_register(function ($class_name) {
    echo $class_name . "\n";
    require_once $class_name . '.php';
});

$thirdPartyUserId = 'aa12123';
$createUser = new UserManage($thirdPartyUserId, Conf::$s_name, Conf::$s_idNumber, Conf::$s_mobile);
$result = $createUser->create(Conf::$host, Conf::$appid, Conf::$secret);
var_dump("开始创建用户",$result,"用户创建完成");

