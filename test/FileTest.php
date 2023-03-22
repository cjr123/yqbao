<?php

use Yyk\Eqbao\FileManage;
use Yyk\Eqbao\Common\PrintService;

require '../vendor/autoload.php';
spl_autoload_register(function ($class_name) {
    echo $class_name . "\n";
    require_once $class_name . '.php';
});

$appid = 'appid';
$secret = 'secret';
$host = 'https://smlopenapi.esign.cn';
$fileName = 'pdf文件路径';
$fileId = 'fileId';

$upload = new FileManage($host, $appid, $secret);
//上传文件
$fileId = $upload->uploadFile($fileName);
PrintService::info(sprintf("FileId：%s", $fileId));

//获取文件上传状态
//$beUploaded = $upload->status($fileId);
//var_dump("********* 开始 文件上传状态 **********", (int)$beUploaded, "********* 结束 文件上传状态 **********");


//获取文件详情
//$result = $upload->detail($fileId);
//var_dump($result);


