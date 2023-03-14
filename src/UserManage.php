<?php

namespace Yyk\Eqbao;

use GuzzleHttp\Client;
use Yyk\Eqbao\Common\UtilHelper;

class UserManage
{
    private $thirdPartyUserId;  //用户唯一标识
    private $name;  //姓名
    private $idType;  //证件类型
    private $idNumber;  //证件号码
    private $mobile;    //手机号
    private $email; //邮箱地址
    private $appid; //应用ID
    private $createUrl = '/v1/accounts/createByThirdPartyUserId';

    /**
     * @var Client
     */
    protected $client;


    public function __construct(string $thirdPartyUserId, string $name, string $idNumber = '', string $mobile = '', string $idType = CRED_PSN_CH_IDCARD, string $email = '')
    {
        $this->thirdPartyUserId = $thirdPartyUserId;
        $this->name = $name;
        $this->idType = $idType;
        $this->idNumber = $idNumber;
        $this->mobile = $mobile;
        $this->email = $email;
        $this->client = new Client();
    }

    /**
     * 创建用户
     * @param $host 访问域名
     * @param $appid    appid
     * @param $secret  secret
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create($host, $appid, $secret)
    {
        $this->appid = $appid;
        $params = [
            'thirdPartyUserId' => $this->thirdPartyUserId,
            'name' => $this->name,
            'idType' => $this->idType,
            'idNumber' => $this->idNumber,
            'mobile' => $this->mobile,
            'email' => $this->email
        ];
        if (empty($params['email'])) {
            unset($params['email']);
        }
        $jsonParam = json_encode($params, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        //对body体做md5摘要
        $contentMd5 = UtilHelper::getContentMd5($jsonParam);
        $reqSignature = UtilHelper::getSignature("POST", "*/*", "application/json; charset=UTF-8", $contentMd5, "", "", $this->createUrl, $secret);
        try {
            $response = $this->client->request('POST', $host . $this->createUrl, ['headers' => HeaderManage::headers($this->appid, $reqSignature, $contentMd5), 'body' => $jsonParam])->getBody()->getContents();
            $resultObj = json_decode($response);
            return $resultObj->data->accountId ?? null;
        } catch (\Exception $e) {
            echo sprintf("创建用户发生异常：%s", $e->getMessage());
            return null;
        }
    }
}