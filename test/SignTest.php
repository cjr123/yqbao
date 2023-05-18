<?php
require '../vendor/autoload.php';

use Yyk\Eqbao\Conf;

spl_autoload_register(function ($class_name) {
    echo $class_name . "\n";
    require_once $class_name . '.php';
});


//C
$cposX = 192.48;
$cposY = 324.94;

//S
$s_posX = 451.38;
$s_posY = 323.6;
$posPage = 7;


$createObj = new \Yyk\Eqbao\CreateFlowOneStep(Conf::$host, Conf::$appid, Conf::$secret);
$createObj->setSealType(1)
    ->addSigners(Conf::$c_accountId, $cposX, $cposY, $posPage, Conf::$c_sealId)
    ->addSigners(Conf::$s_accountId, $s_posX, $s_posY, $posPage)
    ->sign(Conf::$fileId, "劳动合同004");

$flowId = 'flowId';
////获取签名地址
//$createObj->getSignUrl($accountId, $flowId);


