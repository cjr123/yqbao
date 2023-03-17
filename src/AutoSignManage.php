<?php

namespace Yyk\Eqbao;

use Yyk\Eqbao\Common\PrintService;
use Yyk\Eqbao\Common\Upload;

class AutoSignManage
{
    private $autoSignUrl = '/v1/signAuth/{accountId}';
    private $cancelSignUrl = '/v1/signAuth/{accountId}';
    private $appid;
    private $secret;
    private $host;

    public function __construct(string $host, string $appid, string $secret)
    {
        $this->host = $host;
        $this->appid = $appid;
        $this->secret = $secret;
    }


    /**
     * 设置静默签名
     * @param string $accountId
     * @param string $deadline 结束时间：年-月-日 时:分:秒
     * @return bool
     */
    public function setAutoSign(string $accountId, string $deadline = ''): bool
    {
        $this->autoSignUrl = str_replace("{accountId}", $accountId, $this->autoSignUrl);
        $params = [
            'accountId' => $accountId
        ];
        if (!empty($deadline)) {
            $params['deadline'] = $deadline;
        }
        $resultObj = Upload::uploadData($this->host, $this->appid, $this->secret, $params, 'POST', $this->autoSignUrl);
//        var_dump($resultObj);
        if (is_null($resultObj)) {
            PrintService::err(__METHOD__, sprintf("设置静默签署出错，accountId：%s", $accountId));
            return false;
        }
        return true;

    }

    /**
     * 取消静默签名
     * @param string $accountId
     * @return bool
     */
    public function cancelAutoSign(string $accountId): bool
    {
        $this->cancelSignUrl = str_replace("{accountId}", $accountId, $this->cancelSignUrl);
        $params = [
            'accountId' => $accountId
        ];
        $resultObj = Upload::uploadData($this->host, $this->appid, $this->secret, $params, 'DELETE', $this->cancelSignUrl);
//        var_dump($resultObj);
        if (is_null($resultObj)) {
            PrintService::err(__METHOD__, sprintf("取消静默签署出错，accountId：%s", $accountId));
            return false;
        }
        return true;
    }

}