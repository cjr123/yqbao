<?php

namespace Yyk\Eqbao\PersonalTemplate;

use Yyk\Eqbao\Common\PrintService;
use Yyk\Eqbao\Common\Upload;

class DefaultPersonalTemplate extends PersonalTemplate
{
    protected $url = '/v1/accounts/{accountId}/seals/{sealId}/setDefault';

    public function setDefault(string $accountId, string $sealId): bool
    {
        $this->url = str_replace("{accountId}", $accountId, $this->url);
        $this->url = str_replace("{sealId}", $sealId, $this->url);
        $params = [];
        $resultObj = Upload::uploadData($this->host, $this->appid, $this->secret, $params, 'PUT', $this->url);
        if (is_null($resultObj)) {
            PrintService::err(__METHOD__, sprintf("设置签名失败，accountId：%s，sealId：%s", $accountId, $sealId));
            return false;
        }
        return true;
    }
}