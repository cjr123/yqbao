<?php

namespace Yyk\Eqbao\PersonalTemplate;

use GuzzleHttp\Client;
use Yyk\Eqbao\Common\UtilHelper;
use Yyk\Eqbao\HeaderManage;

//use Yyk\Eqbao\BORDERLESS;

/**
 * 个人模板印章管理
 */
class PersonaltemplateCreate
{
    private $createUrl = '/v1/accounts/{accountId}/seals/personaltemplate';
    private $params = [
        'color' => 'BLACK',
        'type' => 'BORDERLESS'
    ];
    private $method = 'POST';
    private $client;
    private $host;
    private $appid;
    private $secret;

    public function __construct($host, $appid, $secret)
    {
        $this->host = $host;
        $this->appid = $appid;
        $this->secret = $secret;
        $this->client = new Client();
    }

    /**
     * 设置印章颜色
     * @param $color
     * @return $this
     */
    public function setColor($color = BLACK)
    {
        $this->params['color'] = $color;
        return $this;
    }

    /**
     * 设置别名
     * @param $alias
     * @return $this
     */
    public function setAlias($alias)
    {
        $this->params['alias'] = $alias;
        return $this;
    }

    /**
     * 设置高度
     * @param int $height
     * @return $this
     */
    public function setHeight(int $height)
    {
        $this->params['height'] = $height;
        return $this;
    }

    /**
     * 设置宽度
     * @param int $width
     * @return $this
     */
    public function setWidth(int $width)
    {
        $this->params['width'] = $width;
        return $this;
    }

    /**
     * 设置模板类型
     * @param $type BORDERLESS(无边框矩形印章),RECTANGLE(带边框矩形印章),SQUARE(正方形印章)
     * @return $this
     */
    public function setType($type)
    {
        $this->params['type'] = $type;
        return $this;
    }

    /**
     * 创建个人模板印章
     * @param $accountId
     * @return array|null
     */
    public function create($accountId)
    {
        $this->params['accountId'] = $accountId;
        $this->createUrl = str_replace("{accountId}", $accountId, $this->createUrl);
        $jsonParam = json_encode($this->params, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
//        var_dump($jsonParam);
        //对body体做md5摘要
        $contentMd5 = UtilHelper::getContentMd5($jsonParam);
        $reqSignature = UtilHelper::getSignature($this->method, "*/*", "application/json; charset=UTF-8", $contentMd5, "", "", $this->createUrl, $this->secret);
        try {
            $response = $this->client
                ->request($this->method, $this->host . $this->createUrl, ['headers' => HeaderManage::headers($this->appid, $reqSignature, $contentMd5), 'body' => $jsonParam])
                ->getBody()
                ->getContents();
            $resultObj = json_decode($response);
            if ($resultObj->code) {
                echo sprintf("个人模板印章创建出错：%s\n", $resultObj->message);
                return null;
            }
            return [
                'sealId' => $resultObj->data->sealId,
                'fileKey' => $resultObj->data->fileKey,
                'url' => $resultObj->data->url,
                'width' => $resultObj->data->width,
                'height' => $resultObj->data->height,
            ];
        } catch (\Exception $e) {
            echo sprintf("个人模板印章创建异常：%s\n", $e->getMessage());
            return null;
        }
    }


}