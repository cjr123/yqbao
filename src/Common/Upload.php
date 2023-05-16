<?php

namespace Yyk\Eqbao\Common;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Utils;
use Yyk\Eqbao\HeaderManage;

class Upload
{

    public static function uploadData($host, $appid, $secret, $params, $method, $url)
    {
        $client = new Client();
        $jsonParam = json_encode($params, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
//        var_dump($jsonParam);
        //对body体做md5摘要
        $contentMd5 = UtilHelper::getContentMd5($jsonParam);
        $reqSignature = UtilHelper::getSignature($method, "*/*", "application/json; charset=UTF-8", $contentMd5, "", "", $url, $secret);
        try {
            $response = $client->request($method, $host . $url, ['headers' => HeaderManage::headers($appid, $reqSignature, $contentMd5), 'body' => $jsonParam])
                ->getBody()
                ->getContents();
            $resultObj = json_decode($response);
            if ($resultObj->code) {
                PrintService::err(__METHOD__, sprintf("上传信息出错：%s", $resultObj->message));
                return null;
            }
            return $resultObj;
        } catch (\Exception $e) {
            PrintService::err(__METHOD__, sprintf("上传信息出异常：%s", $e->getMessage()));
            return null;
        }
    }

    /**
     * 上传文件
     * @param string $localFile
     * @param string $contentMd5
     * @param string $contentType
     * @param string $uploadUrl
     * @param string $method
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function uploadFile(string $localFile, string $contentMd5, string $contentType, string $uploadUrl, string $method)
    {
        $client = new Client();
        try {
            $bodyResource = Utils::tryFopen($localFile, 'r');
//            $body = Utils::streamFor($bodyResource);
            $response = $client->request($method, $uploadUrl, ['headers' => HeaderManage::headersForUploadFile($contentMd5, $contentType), 'body' => $bodyResource])
                ->getBody()
                ->getContents();
            $resultObj = json_decode($response);
            if ($resultObj->errCode) {
                PrintService::err(__METHOD__, sprintf("上传文件出错：%s", $resultObj->message));
                return false;
            }
            return true;
        } catch (\Exception $e) {
            PrintService::err(__METHOD__, sprintf("上传文件出异常：%s", $e->getMessage()));
            return false;
        }
    }

}