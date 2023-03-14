<?php

use Yyk\Eqbao\PersonalTemplate\PersonaltemplateCreate;


require '../vendor/autoload.php';
spl_autoload_register(function ($class_name) {
    echo $class_name . "\n";
    require_once $class_name . '.php';
});

$appid = '7438953390';
$secret = '00d8dcaa04dcd876aa9e76168ea5b70d';
$host = 'https://smlopenapi.esign.cn';
$accountid = 'a517e5813b614ba082617075451197f8';

$person = new PersonaltemplateCreate($accountid);
$person->setType('RECTANGLE');
$result = $person->setHeight(30)->setWidth(50)->setColor(RED)->create($host, $appid, $secret);
var_dump("------------ 开始创建个人印章 ---------------", $result, "------------ 结束创建个人印章 ---------------");

