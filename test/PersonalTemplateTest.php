<?php
require '../vendor/autoload.php';

use Yyk\Eqbao\PersonalTemplate\PersonaltemplateCreate;
use Yyk\Eqbao\Conf;


spl_autoload_register(function ($class_name) {
    echo $class_name . "\n";
    require_once $class_name . '.php';
});

$person = new PersonaltemplateCreate(Conf::$host, Conf::$appid, Conf::$secret);
$person->setType('BORDERLESS');
$result = $person->setHeight(60)->setWidth(70)->setColor(BLACK)->create(Conf::$c_accountId);
var_dump("------------ 开始创建个人印章 ---------------", $result, "------------ 结束创建个人印章 ---------------");

