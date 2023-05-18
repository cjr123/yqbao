<?php

namespace Yyk\Eqbao\DocTemplates;

use Yyk\Eqbao\Common\PrintService;
use Yyk\Eqbao\Common\Upload;

class TemplateDetail extends BaseTemplate
{
    protected $url = '/v1/docTemplates/{templateId}';

    public function detail(string $templateId): array
    {
        $this->url = str_replace("{templateId}", $templateId, $this->url);
        $resultObj = Upload::uploadData($this->host, $this->appid, $this->secret, [], 'GET', $this->url);
//        var_dump($resultObj);
        if (is_null($resultObj)) {
            PrintService::err(__METHOD__, sprintf("获取【模板详情】出错，accountId：%s", $templateId));
            return [];
        }
        return json_decode(json_encode($resultObj->data), true);
    }

}