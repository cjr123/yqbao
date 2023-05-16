<?php

namespace Yyk\Eqbao\PersonalTemplate;

use Yyk\Eqbao\Common\PrintService;
use Yyk\Eqbao\Common\Upload;

class PersonalTemplateImg
{
    private $appid;
    private $secret;
    private $host;
    private $url = '/v1/accounts/{accountId}/seals/image';
    private $type = 'BASE64';
    private $width = 95;
    private $height = 95;
    private $transparentFlag = false;

    public function __construct(string $host, string $appid, string $secret)
    {
        $this->host = $host;
        $this->appid = $appid;
        $this->secret = $secret;
    }

    public function setWidth(int $width)
    {
        $this->width = $width;
        return $this;
    }

    public function setHeight(int $height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * 是否对图片进行透明化处理，默认false,对于有背景颜色的图片，建议进行透明化处理，否则可能会遮挡文字
     * @param bool $flag
     * @return $this
     */
    public function setTransparentFlag(bool $flag)
    {
        $this->transparentFlag = $flag;
        return $this;
    }

    /**
     * 上传个人图片签名
     * @param string $accountId
     * @param string $pngBaseCode 签名图片 base64值
     * @return array
     */
    public function create(string $accountId, string $pngBaseCode): array
    {
        $this->url = str_replace("{accountId}", $accountId, $this->url);
        $params = [
            'accountId' => $accountId,
            'height' => $this->height,
            'width' => $this->width,
            'type' => $this->type,
            'data' => $pngBaseCode,
            'transparentFlag' => $this->transparentFlag
        ];
        $resultObj = Upload::uploadData($this->host, $this->appid, $this->secret, $params, 'POST', $this->url);
//        var_dump($resultObj);
        if (is_null($resultObj)) {
            PrintService::err(__METHOD__, sprintf("上传用户图片签名失败，accountId：%s", $accountId));
            return [];
        }
        return json_decode(json_encode($resultObj->data), true);

    }


}