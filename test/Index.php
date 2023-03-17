<?php

require '../vendor/autoload.php';
spl_autoload_register(function ($class_name) {
    echo $class_name . "\n";
    require_once $class_name . '.php';
});


//use Yyk\Eqbao\Test;
//
//
//$i = new Test();
//$i->show();
//
//var_dump(CRED_PSN_CH_IDCARD);

//$filePath='/work/file/发票.pdf';
//var_dump(basename($filePath));

$obj=new stdClass();
$obj->name='小明';
$obj->age=21;

$a[]=$obj;

var_dump(json_encode($a));