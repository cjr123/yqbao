<?php

namespace Yyk\Eqbao;

use GuzzleHttp\Client;
use Yyk\Eqbao\Common\UtilHelper;

class PersonalCertification
{
    private $verifyUrl = '/v2/identity/auth/web/{accountId}/indivIdentityUrl';
    protected $params = [];
    /**
     * @var Client
     */
    private $client;
    private $method = "POST";

    public function __construct($accountid)
    {
        $this->params['accountId'] = $accountid;
        $this->verifyUrl = str_replace("{accountId}", $accountid, $this->verifyUrl);
//        var_dump("verifyUrl：".$this->verifyUrl);
        $this->client = new Client();
    }

    public function setContexId(string $tag)
    {
        $this->params['contextInfo']['contextId'] = $tag;
        return $this;
    }

    public function setRedirectUrl(string $redirectUrl)
    {
        $this->params['contextInfo']['redirectUrl'] = $redirectUrl;
        return $this;
    }

    /**
     * 接收实名认证状态变更通知的地址
     * @param string $notifyUrl
     * @return $this
     */
    public function setNotifyUrl(string $notifyUrl)
    {
        $this->params['contextInfo']['notifyUrl'] = $notifyUrl;
        return $this;
    }

    public function setShowResultPage(bool $isShow)
    {
        $this->params['contextInfo']['showResultPage'] = $isShow;
        return $this;
    }

    public function build($host, $appid, $secret, $wechatAppid = '')
    {
        $jsonParam = json_encode($this->params, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        //对body体做md5摘要
        $contentMd5 = UtilHelper::getContentMd5($jsonParam);
        $reqSignature = UtilHelper::getSignature($this->method, "*/*", "application/json; charset=UTF-8", $contentMd5, "", "", $this->verifyUrl, $secret);
        try {
            $response = $this->client->request($this->method, $host . $this->verifyUrl, ['headers' => HeaderManage::headers($appid, $reqSignature, $contentMd5, $wechatAppid), 'body' => $jsonParam])->getBody()->getContents();
            $resultObj = json_decode($response);
            if ($resultObj->code) {
                return null;
            }
            return [
                'url' => $resultObj->data->url,
                'shortUrl' => $resultObj->data->shortLink,
                'flowId' => $resultObj->data->flowId
            ];
//            return $resultObj->data->accountId ?? null;
        } catch (\Exception $e) {
            echo sprintf("个人认证发生异常：%s", $e->getMessage());
            return null;
        }

    }


}