<?php
require '../vendor/autoload.php';
spl_autoload_register(function ($class_name) {
    echo $class_name . "\n";
    require_once $class_name . '.php';
});

$appid = '7438953390';
$secret = '00d8dcaa04dcd876aa9e76168ea5b70d';
$host = 'https://smlopenapi.esign.cn';

//崔
$accountId = 'a517e5813b614ba082617075451197f8';

//首
$s_accountId = '4f3a549c97524af4bd445af1f1b4fce5';

$sign=new \Yyk\Eqbao\AutoSignManage($host,$appid,$secret);
$sign->setAutoSign($s_accountId);