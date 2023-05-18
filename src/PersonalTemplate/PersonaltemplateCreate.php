<?php

namespace Yyk\Eqbao\PersonalTemplate;

use Yyk\Eqbao\Common\Upload;

/**
 * 个人模板印章管理
 */
class PersonaltemplateCreate extends PersonalTemplate
{
    private $createUrl = '/v1/accounts/{accountId}/seals/personaltemplate';
    private $params = [
        'color' => 'BLACK',
        'type' => 'BORDERLESS'
    ];
    private $method = 'POST';


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
     * @param string $accountId
     * @return array|null
     */
    public function create(string $accountId): ?array
    {
        $this->params['accountId'] = $accountId;
        $this->createUrl = str_replace("{accountId}", $accountId, $this->createUrl);
        $resultObj = Upload::uploadData($this->host, $this->appid, $this->secret, $this->params, $this->method, $this->createUrl);
        if (is_null($resultObj)) {
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
    }


}