<?php

require '../vendor/autoload.php';
spl_autoload_register(function ($class_name) {
    echo $class_name . "\n";
    require_once $class_name . '.php';
});

$appid = 'appid';
$secret = 'secret';
$host = 'https://smlopenapi.esign.cn';
//$fileName = '/work/data/环信充值发票.pdf';
$fileId = '';

//崔
$accountId = '';
$cposX = 436;
$cposY = 60;
$sealId = '';
//首
$s_accountId = '';
$s_posX = 101;
$s_posY = 163;


$createObj = new \Yyk\Eqbao\CreateFlowOneStep($host, $appid, $secret);
//$createObj->setSealType(1)
//    ->addSigners($accountId, $cposX, $cposY, $sealId)
//    ->addSigners($s_accountId, $s_posX, $s_posY)
//    ->sign($fileId, "环信发票11");

$flowId = 'flowId';
////获取签名地址
$createObj->getSignUrl($accountId, $flowId);


