<?php
require '../vendor/autoload.php';

use Yyk\Eqbao\PersonalCertification;
use Yyk\Eqbao\Conf;


spl_autoload_register(function ($class_name) {
    echo $class_name . "\n";
    require_once $class_name . '.php';
});

$redirectUrl = '跳转地址';

$person = new PersonalCertification(Conf::$c_accountId);
$result = $person->setRedirectUrl($redirectUrl)->setShowResultPage(false)->build(Conf::$host, Conf::$appid, Conf::$secret);
var_dump($result);