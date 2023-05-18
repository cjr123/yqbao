<?php
require '../vendor/autoload.php';

use Yyk\Eqbao\Conf;


spl_autoload_register(function ($class_name) {
    echo $class_name . "\n";
    require_once $class_name . '.php';
});

$sign = new \Yyk\Eqbao\AutoSignManage(Conf::$host, Conf::$appid, Conf::$secret);
//$CBesign = $sign->setAutoSign(Conf::$c_accountId);
$SBesign = $sign->setAutoSign(Conf::$s_accountId);
//var_dump('---------',(int)$CBesign,'-------------');
var_dump('************', (int)$SBesign, '************');