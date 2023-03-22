<?php

require '../vendor/autoload.php';
spl_autoload_register(function ($class_name) {
    echo $class_name . "\n";
    require_once $class_name . '.php';
});

$appid = '7438953390';
$secret = '00d8dcaa04dcd876aa9e76168ea5b70d';
$host = 'https://smlopenapi.esign.cn';
//$fileName = '/work/data/环信充值发票.pdf';
$fileId = 'a5f9152384564a1c8a4edbed47902f56';

//崔
$accountId = 'a517e5813b614ba082617075451197f8';
$cposX = 436;
$cposY = 60;
$sealId = '755dbe41-3527-419f-b867-be5bd4bf5ccc';
//首
$s_accountId = '4f3a549c97524af4bd445af1f1b4fce5';
$s_posX = 101;
$s_posY = 163;


$createObj = new \Yyk\Eqbao\CreateFlowOneStep($host, $appid, $secret);
//$createObj->setSealType(1)
//    ->addSigners($accountId, $cposX, $cposY, $sealId)
//    ->addSigners($s_accountId, $s_posX, $s_posY)
//    ->sign($fileId, "环信发票11");

$flowId = 'b7d6278c42a74a53b2dc347cfadd0fe2';
////获取签名地址
$createObj->getSignUrl($accountId, $flowId);


