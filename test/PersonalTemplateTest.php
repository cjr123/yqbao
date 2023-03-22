<?php

use Yyk\Eqbao\PersonalTemplate\PersonaltemplateCreate;


require '../vendor/autoload.php';
spl_autoload_register(function ($class_name) {
    echo $class_name . "\n";
    require_once $class_name . '.php';
});

$appid = 'appid';
$secret = 'secret';
$host = 'https://smlopenapi.esign.cn';
$accountid = 'accountid';

$person = new PersonaltemplateCreate($host, $appid, $secret);
$person->setType('BORDERLESS');
$result = $person->setHeight(60)->setWidth(70)->setColor(BLACK)->create($accountid);
var_dump("------------ 开始创建个人印章 ---------------", $result, "------------ 结束创建个人印章 ---------------");

