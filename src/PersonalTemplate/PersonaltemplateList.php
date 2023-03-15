<?php

namespace Yyk\Eqbao\PersonalTemplate;

use GuzzleHttp\Client;
use Yyk\Eqbao\Common\Upload;
use Yyk\Eqbao\Common\UtilHelper;
use Yyk\Eqbao\HeaderManage;

class PersonaltemplateList
{
    private $params = [
        'offset' => 1,
        'size' => 20
    ];
    private $searchUrl = '/v1/accounts/{accountId}/seals';
    private $method = 'GET';
    /**
     * @var Client
     */
    private $client;


    public function __construct($accountId)
    {
        $this->searchUrl = str_replace('{accountId}', $accountId, $this->searchUrl);
        $this->params['accountId'] = $accountId;
        $this->client = new Client();
    }

    public function setPage(int $page)
    {
        $this->params['offset'] = $page;
        return $this;
    }

    public function setPageSize(int $pageSize)
    {
        $this->params['size'] = $pageSize;
        return $this;
    }

    public function search($host, $appid, $secret)
    {

        $resultObj = Upload::uploadData($host, $appid, $secret, $this->params, $this->method, $this->searchUrl);
        var_dump($resultObj);

//        $jsonParam = json_encode($this->params, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
////        var_dump($jsonParam);
//        //对body体做md5摘要
//        $contentMd5 = UtilHelper::getContentMd5($jsonParam);
//        $reqSignature = UtilHelper::getSignature($this->method, "*/*", "application/json; charset=UTF-8", $contentMd5, "", "", $this->searchUrl, $secret);
//        try {
//            $response = $this->client
//                ->request($this->method, $host . $this->searchUrl, ['headers' => HeaderManage::headers($appid, $reqSignature, $contentMd5), 'body' => $jsonParam])
//                ->getBody()
//                ->getContents();
//            $resultObj = json_decode($response);
//            if ($resultObj->code) {
//                echo sprintf("获取个人模板印章列表出错：%s\n", $resultObj->message);
//                return null;
//            }
//            var_dump($resultObj);
//        } catch (\Exception $e) {
//            echo sprintf("获取个人模板印章列表异常：%s\n", $e->getMessage());
//            return null;
//        }
    }


}