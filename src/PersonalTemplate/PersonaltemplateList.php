<?php

namespace Yyk\Eqbao\PersonalTemplate;

use GuzzleHttp\Client;
use Yyk\Eqbao\Common\PrintService;
use Yyk\Eqbao\Common\Upload;
use Yyk\Eqbao\Common\UtilHelper;
use Yyk\Eqbao\HeaderManage;

class PersonaltemplateList extends PersonalTemplate
{
    private $params = [
        'offset' => 1,
        'size' => 20
    ];
    private $searchUrl = '/v1/accounts/{accountId}/seals';

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


}