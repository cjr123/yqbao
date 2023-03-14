<?php

namespace Yyk\Eqbao;
class Test
{
    protected $host='https://smlopenapi.esign.cn';




    public function show()
    {
        echo sprintf("host is %s \n",$this->host);
    }
}

$url='http://www.php.cn/index.php?name=wxp&id=2#abc';
var_dump(parse_url($url,PHP_URL_PATH));