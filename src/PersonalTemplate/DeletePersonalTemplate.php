<?php

namespace Yyk\Eqbao\PersonalTemplate;

use Yyk\Eqbao\Common\PrintService;
use Yyk\Eqbao\Common\Upload;

class DeletePersonalTemplate extends PersonalTemplate
{
    protected $url = '/v1/accounts/{accountId}/seals/{sealId}';

    public function del(string $accountId, string $sealId): bool
    {
        $this->url = str_replace("{accountId}", $accountId, $this->url);
        $this->url = str_replace("{sealId}", $sealId, $this->url);
        $params = [];
        $resultObj = Upload::uploadData($this->host, $this->appid, $this->secret, $params, 'DELETE', $this->url);
        if (is_null($resultObj)) {
            PrintService::err(__METHOD__, sprintf("【删除签名】失败，accountId：%s，sealId：%s", $accountId, $sealId));
            return false;
        }
        return true;
    }
}