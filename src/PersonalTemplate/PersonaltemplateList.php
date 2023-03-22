<?php

namespace Yyk\Eqbao\PersonalTemplate;

use GuzzleHttp\Client;
use Yyk\Eqbao\Common\PrintService;
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
    private $setDefaultUrl = '/v1/accounts/{accountId}/seals/{sealId}/setDefault';
    /**
     * @var Client
     */
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

    /**
     * 查看印章列表
     * @param $accountId
     * @return void
     */
    public function search($accountId)
    {
        $data = [];
        $method = 'GET';
        $this->searchUrl = str_replace('{accountId}', $accountId, $this->searchUrl);
        $this->params['accountId'] = $accountId;
        $resultObj = Upload::uploadData($this->host, $this->appid, $this->secret, $this->params, $method, $this->searchUrl);
        if (is_null($resultObj)) {
            PrintService::err(__METHOD__, "获取印章列表出错，accountid：" . $accountId);
            return $data;
        }

        foreach ($resultObj->data->seals as $item) {
            $data[] = [
                'sealId' => $item->sealId,
                'fileKey' => $item->fileKey,
                'defaultFlag' => $item->defaultFlag,
                'url' => $item->url,
                'status' => $item->status,
                'createDate' => $item->createDate,
                'width' => $item->width,
                'height' => $item->height
            ];

        }
        return $data;
    }


    /**
     * 设置默认印章
     * @param $accountId
     * @param $sealId
     * @return void
     */
    public function setDefault($accountId, $sealId)
    {
        $method = 'PUT';
        $this->setDefaultUrl = str_replace('{accountId}', $accountId, $this->setDefaultUrl);
        $this->setDefaultUrl = str_replace('{sealId}', $sealId, $this->setDefaultUrl);
        $params = [
            'accountId' => $accountId,
            'sealId' => $sealId
        ];
        $resultObj = Upload::uploadData($this->host, $this->appid, $this->secret, $params, $method, $this->setDefaultUrl);
        if(is_null($resultObj))
        {
            PrintService::err(__METHOD__,sprintf("设置默认印章异常,accountId:%s,sealId:%s",$accountId,$sealId));
            return false;
        }
        if(!$resultObj->code)
        {
            PrintService::err(__METHOD__,sprintf("设置默认印章出错,accountId:%s,sealId:%s",$accountId,$sealId));
            return false;
        }
        return true;

    }


}