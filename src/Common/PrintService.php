<?php

namespace Yyk\Eqbao\Common;

class PrintService
{
    public static function err(string $from, string $msg)
    {
        echo sprintf("%s ------------------- err -------------------------\n", date('Y-m-d H:i:s', time()));
        echo sprintf("%s, from：%s, msg：%s\n", date('Y-m-d H:i:s', time()), $from, $msg);
        echo sprintf("%s ----------------- err end -------------------------\n", date('Y-m-d H:i:s', time()));
    }

    public static function info(string $msg)
    {
        echo sprintf("%s ****************** info *****************************\n", date('Y-m-d H:i:s', time()));
        echo sprintf("%s %s\n", date('Y-m-d H:i:s', time()), $msg);
        echo sprintf("%s ****************** info end *************************\n", date('Y-m-d H:i:s', time()));

    }

}