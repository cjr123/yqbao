<?php
require '../vendor/autoload.php';

use Yyk\Eqbao\PersonalTemplate\PersonaltemplateList;
use Yyk\Eqbao\Conf;

spl_autoload_register(function ($class_name) {
    echo $class_name . "\n";
    require_once $class_name . '.php';
});

$person = new PersonaltemplateList(Conf::$host, Conf::$appid, Conf::$secret);
$result = $person->search(Conf::$c_accountId);
var_dump($result);


/**
 * 设置默认印章
 */
//$sealId = '755dbe41-3527-419f-b867-be5bd4bf5ccc';
//$person->setDefault($accountid, $sealId);
//var_dump("------------ 开始创建个人印章 ---------------", $result, "------------ 结束创建个人印章 ---------------");