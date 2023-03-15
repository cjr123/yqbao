<?php

use Yyk\Eqbao\FileManage;
use Yyk\Eqbao\Common\PrintService;

require '../vendor/autoload.php';
spl_autoload_register(function ($class_name) {
    echo $class_name . "\n";
    require_once $class_name . '.php';
});

$appid = '7438953390';
$secret = '00d8dcaa04dcd876aa9e76168ea5b70d';
$host = 'https://smlopenapi.esign.cn';
$fileName = '/work/data/环信充值发票.pdf';
$fileId = '519f5ee932f34af295f1f66837a25e34';

$upload = new FileManage($host, $appid, $secret);
//上传文件
//$fileId = $upload->uploadFile($fileName);
//PrintService::info(sprintf("FileId：%s", $fileId));

//获取文件上传状态
//$beUploaded = $upload->status($fileId);
//var_dump("********* 开始 文件上传状态 **********", (int)$beUploaded, "********* 结束 文件上传状态 **********");


//获取文件详情
$result = $upload->detail($fileId);
var_dump($result);


