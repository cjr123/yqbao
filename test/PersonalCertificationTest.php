<?php

use Yyk\Eqbao\PersonalCertification;

require '../vendor/autoload.php';
spl_autoload_register(function ($class_name) {
    echo $class_name . "\n";
    require_once $class_name . '.php';
});

$appid = 'APPID';
$secret = 'SECRET';
$host = 'https://smlopenapi.esign.cn';
$accountid = 'accountId';
$redirectUrl = '跳转地址';

$person = new PersonalCertification($accountid);
$result = $person->setRedirectUrl($redirectUrl)->setShowResultPage(false)->build($host, $appid, $secret);
var_dump($result);