<?php

use Yyk\Eqbao\PersonalTemplate\PersonaltemplateList;

require '../vendor/autoload.php';
spl_autoload_register(function ($class_name) {
    echo $class_name . "\n";
    require_once $class_name . '.php';
});

$appid = '7438953390';
$secret = '00d8dcaa04dcd876aa9e76168ea5b70d';
$host = 'https://smlopenapi.esign.cn';
$accountid = 'a517e5813b614ba082617075451197f8';

$person = new PersonaltemplateList($host, $appid, $secret);
$result = $person->search($accountid);
var_dump($result);


/**
 * 设置默认印章
 */
//$sealId = '755dbe41-3527-419f-b867-be5bd4bf5ccc';
//$person->setDefault($accountid, $sealId);
//var_dump("------------ 开始创建个人印章 ---------------", $result, "------------ 结束创建个人印章 ---------------");