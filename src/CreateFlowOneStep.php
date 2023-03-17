<?php

namespace Yyk\Eqbao;

use Yyk\Eqbao\Common\PrintService;
use Yyk\Eqbao\Common\Upload;

class CreateFlowOneStep
{
    private $appid;
    private $secret;
    private $host;
    private $url = '/api/v2/signflows/createFlowOneStep';
    private $getSignUrl = '/v1/signflows/{flowId}/executeUrl';
    private $params = [];
    private $sealType = '';
    private $fileId;
    private $businessScene;
    private $signers = [];

    public function __construct(string $host, string $appid, string $secret)
    {
        $this->host = $host;
        $this->appid = $appid;
        $this->secret = $secret;
    }

    /**
     * 获取签署地址
     * @param $accountId
     * @param $flowId
     * @return void
     */
    public function getSignUrl($accountId, $flowId)
    {
        $this->getSignUrl = str_replace("{flowId}", $flowId, $this->getSignUrl);
        $this->getSignUrl = $this->getSignUrl . "?accountId=" . $accountId;
        $params = [
        ];
        $resultObj = Upload::uploadData($this->host, $this->appid, $this->secret, $params, 'GET', $this->getSignUrl);
        var_dump($resultObj);
        if (is_null($resultObj)) {
            PrintService::err(__METHOD__, sprintf("获取签署链接出错，flowId：%s", $flowId));
            return;
        }
        return [
            'url' => $resultObj->data->url,
            'shortUrl' => $resultObj->data->shortUrl
        ];
    }

    /**
     * @param string $fileId 要签署的文件ID
     * @param string $businessScene 本次签署流程的文件主题名称
     * @return void
     */
    public function sign(string $fileId, string $businessScene)
    {
        $this->fileId = $fileId;
        $this->businessScene = $businessScene;
        if (count($this->signers) === 0) {
            PrintService::err(__METHOD__, '请先使用 addSigners 方法添加签名用户');
            return;
        }
        $this->build();
        $method = 'POST';
        $resultObj = Upload::uploadData($this->host, $this->appid, $this->secret, $this->params, $method, $this->url);
        if (is_null($resultObj)) {
            PrintService::err(__METHOD__, sprintf("签署文件出错，fileId：%s", $fileId));
            return;
        }
        var_dump($resultObj);
    }

    /**
     * 添加签名用户
     * @param string $signerAccountId
     * @param int $posX
     * @param int $posY
     * @param string $sealId
     * @return $this
     */
    public function addSigners(string $signerAccountId, int $posX, int $posY, string $sealId = '')
    {
        $this->signers[] = [
            'signerAccountId' => $signerAccountId,
            'posX' => $posX,
            'posY' => $posY,
            'sealId' => $sealId
        ];
        return $this;
    }

    protected function build()
    {
        $this->params = [
            'flowInfo' => [
                'autoArchive' => true,
                'autoInitiate' => true,
                'businessScene' => $this->businessScene
            ],
            'docs' => [
                [
                    'fileId' => $this->fileId
                ]
            ]
        ];
        foreach ($this->signers as $index => $signer) {

            $item = [
                'signOrder' => $index + 1,
                'signfields' => [
                    [
                        'fileId' => $this->fileId,
                        'sealType' => $this->sealType,
                        'posBean' => [
                            'posPage' => '1',
                            'posX' => $signer['posX'],
                            'posY' => $signer['posY']
                        ],
                        'autoExecute' => true,
//                        'width' => 50
                    ]
                ],
                'signerAccount' => [
                    'signerAccountId' => $signer['signerAccountId'],
                    'noticeType' => '1'
                ]
            ];
            if (!empty($signer['sealId'])) {
                $item['signfields'][0]['sealId'] = $signer['sealId'];
            }
            $this->params['signers'][] = $item;
        }


    }

    /**
     * 设置本次签署流程的文件主题名称
     * @param string $businessScene 主题名称
     * @return $this
     */
//    public function setBusinessScene(string $businessScene)
//    {
//        $this->params['flowInfo']['businessScene'] = $businessScene;
//        return $this;
//    }

    /**
     * 要签署的文件ID
     * @param string $fileId
     * @return $this
     */
//    public function setFileId(string $fileId)
//    {
//        $this->params['signers']['signfields']['fileId'] = $fileId;
//        return $this;
//    }

    /**
     * 签名方式
     * @param int $sealType 0-手绘签名，1-模板印章签名，多种类型时逗号分割，为空不限制
     * @return $this
     */
    public function setSealType(int $sealType)
    {
        $this->sealType = $sealType;
        return $this;
    }
}