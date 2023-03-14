<?php

namespace Yyk\Eqbao;

use Yyk\Eqbao\Common\UtilHelper;

class HeaderManage
{
    /**
     * 获取header信息
     * @param $appid 后台应用ID
     * @param $reqSignature 签名
     * @param $contentMD5   参数MD5
     * @param $wechatAppid 小程序appid
     * @return array
     */
    public static function headers($appid, $reqSignature, $contentMD5, $wechatAppid = '')
    {
        $headers['X-Tsign-Open-App-Id'] = $appid;
        $headers['X-Tsign-Open-Ca-Timestamp'] = UtilHelper::getMillisecond();
        $headers['Accept'] = '*/*';
        $headers['X-Tsign-Open-Ca-Signature'] = $reqSignature;
        $headers['Content-MD5'] = $contentMD5;
        $headers['Content-Type'] = 'application/json; charset=UTF-8';
        $headers['X-Tsign-Open-Auth-Mode'] = 'Signature';
        if (!empty($wechatAppid)) {
            $headers['X-Tsign-Dns-App-Id'] = $wechatAppid;
        }
        return $headers;
    }


}