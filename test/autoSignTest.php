<?php
require '../vendor/autoload.php';
spl_autoload_register(function ($class_name) {
    echo $class_name . "\n";
    require_once $class_name . '.php';
});

$appid = 'appid';
$secret = 'secret';
$host = 'https://smlopenapi.esign.cn';

//A
$accountId = '';

//B
$s_accountId = '';

$sign=new \Yyk\Eqbao\AutoSignManage($host,$appid,$secret);
$sign->setAutoSign($s_accountId);