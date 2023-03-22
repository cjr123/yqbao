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
$accountId = 'a517e5813b614ba082617075451197f8';

//B
$s_accountId = '4f3a549c97524af4bd445af1f1b4fce5';

$sign=new \Yyk\Eqbao\AutoSignManage($host,$appid,$secret);
$sign->setAutoSign($s_accountId);