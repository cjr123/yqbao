<?php

use Yyk\Eqbao\PersonalCertification;

require '../vendor/autoload.php';
spl_autoload_register(function ($class_name) {
    echo $class_name . "\n";
    require_once $class_name . '.php';
});

$appid = '7438953390';
$secret = '00d8dcaa04dcd876aa9e76168ea5b70d';
$host = 'https://smlopenapi.esign.cn';
$accountid = 'a517e5813b614ba082617075451197f8';
$redirectUrl = 'https://www.baidu.com';

$person = new PersonalCertification($accountid);
$result = $person->setRedirectUrl($redirectUrl)->setShowResultPage(false)->build($host, $appid, $secret);
var_dump($result);