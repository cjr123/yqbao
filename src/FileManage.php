<?php

namespace Yyk\Eqbao;

use Yyk\Eqbao\Common\PrintService;
use Yyk\Eqbao\Common\Upload;
use Yyk\Eqbao\Common\UtilHelper;

class FileManage
{
    private $getUploadUrl = '/v1/files/getUploadUrl';
    private $fileStatusUrl = '/v1/files/{fileId}/status';
    private $detailUrl = '/v1/files/{fileId}';
    private $contentType = 'application/octet-stream';
    private $fileName;
    private $convert2Pdf = false;
    private $uploadUrl = '';
    private $appid;
    private $secret;
    private $host;
    private $fileId = '';

    private $contentMd5;

    public function __construct(string $host, string $appid, string $secret)
    {
        $this->host = $host;
        $this->appid = $appid;
        $this->secret = $secret;
    }


    /**
     * 设置文件的MIME类型
     * @param string $contentType application/octet-stream 或 application/pdf
     * @return $this
     */
    public function setContentType(string $contentType)
    {
        $this->contentType = $contentType;
        return $this;
    }

    /**
     * 是否转换成pdf文档，默认false
     * @param bool $convert2Pdf
     * @return $this
     */
    public function setConvert2Pdf(bool $convert2Pdf)
    {
        $this->convert2Pdf = $convert2Pdf;
        return $this;
    }

    /**
     * 上传文件，返回fileId
     * @param string $fileName 本地文件绝对路径
     * @return void
     */
    public function uploadFile(string $fileName)
    {
        if (!file_exists($fileName)) {
            PrintService::err(__METHOD__, sprintf("本地文件不存在，无法进行上传操作，%s", $fileName));
//            echo sprintf("本地文件不存在，无法进行上传操作，%s\n", $fileName);
            return;
        }
        $this->fileName = $fileName;
        //获取上传文件地址
        $this->getUploadUrl();
        if (empty($this->uploadUrl)) {
            return;
        }
        //上传文件
        $beUploaded = Upload::uploadFile($this->fileName, $this->contentMd5, $this->contentType, $this->uploadUrl, 'PUT');
        if ($beUploaded) {
            PrintService::info("文件上传成功");
        }
        return $this->fileId;
    }


    /**
     * 查询文件上传状态
     * @param string $fileId
     * @return bool
     */
    public function status(string $fileId): bool
    {
        $params['fileId'] = $fileId;
        $this->fileStatusUrl = str_replace("{fileId}", $fileId, $this->fileStatusUrl);
        $resultObj = Upload::uploadData($this->host, $this->appid, $this->secret, $params, 'GET', $this->fileStatusUrl);
//        var_dump($resultObj);
        if (is_null($resultObj)) {
            PrintService::err(__METHOD__, sprintf("获取文件状态出错，fileId：%s", $fileId));
            return false;
        }
        if (in_array($resultObj->data->status, [2, 5])) {
            return true;
        }
        return false;

    }

    /**
     * 获取文件详情
     * @param string $fileId 文件ID
     * @param bool $pageSize 是否返回文件首页的长宽值，默认值 false
     * @return false|void
     */
    public function detail(string $fileId, bool $pageSize = false)
    {
        $params['fileId'] = $fileId;
        $params['pageSize'] = $pageSize;
        $this->detailUrl = str_replace("{fileId}", $fileId, $this->detailUrl);
        $resultObj = Upload::uploadData($this->host, $this->appid, $this->secret, $params, 'GET', $this->detailUrl);
//        var_dump($resultObj);
        if (is_null($resultObj)) {
            PrintService::err(__METHOD__, sprintf("获取文件详情出错，fileId：%s", $fileId));
            return null;
        }
//        var_dump($resultObj);
        return [
            'filedId' => $resultObj->data->fileId,
            'name' => $resultObj->data->name,
            'downloadUrl' => $resultObj->data->downloadUrl,
            'status' => $resultObj->data->status,
            'pdfTotalPages' => $resultObj->data->pdfTotalPages,
            'pageWidth' => $resultObj->data->pageWidth,
            'pageHeight' => $resultObj->data->pageHeight
        ];

    }


    /**
     * 获取上传文件地址
     * @return void
     */
    protected function getUploadUrl()
    {
        $params['contentMd5'] = $this->contentMd5 = UtilHelper::getContentBase64Md5($this->fileName);
        $params['contentType'] = $this->contentType;
        $params['fileName'] = basename($this->fileName);
        $params['fileSize'] = filesize($this->fileName);
        $params['convert2Pdf'] = $this->convert2Pdf;
        $method = 'POST';
        $resultObj = Upload::uploadData($this->host, $this->appid, $this->secret, $params, $method, $this->getUploadUrl);
        if (is_null($resultObj)) {
            PrintService::err(__METHOD__, sprintf("获取上传文件地址出错，无法进行上传操作，file：%s", $this->fileName));
            return;
        }
//        var_dump($resultObj);
        $this->fileId = $resultObj->data->fileId;
        $this->uploadUrl = $resultObj->data->uploadUrl;

    }


}