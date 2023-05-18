<?php

namespace Yyk\Eqbao\DocTemplates;

use Yyk\Eqbao\Common\PrintService;
use Yyk\Eqbao\Common\Upload;

/**
 * 填充模板内容
 */
class TemplateFill extends BaseTemplate
{
    protected $url = '/v1/files/createByTemplate';

    public function fill(string $fileName, string $templateId, TemplateContent $content, bool $strictCheck = false)
    {
        $params = [
            'name' => $fileName,
            'templateId' => $templateId,
            'simpleFormFields' => $content,
            'strictCheck' => $strictCheck
        ];
        var_dump("---------",$params,"------------");
        $resultObj = Upload::uploadData($this->host, $this->appid, $this->secret, $params, 'POST', $this->url);
        if (is_null($resultObj)) {
            PrintService::err(__METHOD__, sprintf("填充模板文件失败，fileName：%s，templateId：%s，content：%s", $fileName, $templateId, json_encode(json_encode($content))));
            return [];
        }
        return json_decode(json_encode($resultObj->data), true);
    }
}