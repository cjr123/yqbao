<?php
declare(strict_types = 1);
require_once dirname(__DIR__) . '/vendor/autoload.php';


$appId = "7438952021";                           //应用id
$secret = "fdc915b00a9f3388e52c0930fd45d3af";    //应用密钥
$baseUrl = "https://smlopenapi.esign.cn";            // 沙箱环境

/**
 * 生成13位时间戳 毫秒 字符串签名用
 */
function getMillisecond() {
    list($t1, $t2) = explode(' ', microtime());
    return (float)sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
}

/**
 * 将body数据md5加密
 * @param $data json字符串
 */
function changeMd5($data){
    return base64_encode(md5($data, true));
}

$params = array(
    "psnAuthConfig" => array(
        "psnAccount" => "13126880126",
        "psnInfo" => array(
            "psnName" => "",
            "psnIDCardNum" => "",
            "psnIDCardType" => "CRED_PSN_CH_IDCARD",
            "psnMobile" => ""
        ),
        "psnAuthPageConfig" => array(
            "psnDefaultauthMode" => "PSN_FACE",
            "psnAvailableauthModes" => array(
                "PSN_BANKCARD4",
                "PSN_MOBILE3",
                "PSN_FACE"
            ),
            "psnEditableFields" => array(
                "IDCardNum"
            )
        )
    ),
    "authorizeConfig" => array(
        "authorizedScopes" => array(
            "get_psn_identity_info",
            "psn_initiate_sign",
            "manage_psn_resource"
        )
    ),
    "redirectConfig" => array(
        "redirectUrl" => "https://www.esign.cn/"
    ),
    "notifyUrl" => "http://www.yunyikang.cn/notify",
    "clientType" => "ALL"
);

/*
$fileId = "93ed79b712474a959a67bc7c027750bd";
$params = array(
    "fileId" => $fileId
); */

$data = json_encode($params, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
$contentMd5 = changeMd5($data);

$httpMethod = 'POST';
// $httpMethod = 'GET';
$accept = '*/*';
$contentType = 'application/json; charset=UTF-8';
$date = '';
$headers = '';
$url = '/v3/psn-auth-url';
// $url = '/v3/files/' . $fileId;

$stringToSign = $httpMethod . "\n" . $accept . "\n"  . $contentMd5 . "\n" . $contentType . "\n"  . $date . "\n" .$headers  ;
if($headers != ''){
    $stringToSign .= "\n" . $url;
}else{
    $stringToSign .= $url;
}

$signature = hash_hmac("sha256", $stringToSign, $secret, true);
$signature = base64_encode($signature);

$headers = array(
    'X-Tsign-Open-App-Id' => $appId,
    'Content-Type' => $contentType,
    'X-Tsign-Open-Ca-Timestamp' => getMillisecond(),
    'Accept' => '*/*',
    'X-Tsign-Open-Ca-Signature' => $signature,
    'Content-MD5' => $contentMd5,
    'X-Tsign-Open-Auth-Mode' => 'Signature'
);

$client = new \GuzzleHttp\Client([
  'verify' => false,
  'base_uri' => $baseUrl,
  // 'headers' => $headers    // 同步时设置
]);

/*
// 同步
$response = $client->request($httpMethod, $url, [
    'body' => $data
]);
$result = $response->getBody()->read(1024);
echo $response->getStatusCode();
$result = $response->getBody()->getContents();

$body = json_decode($result, true);
var_dump($body); */


var_dump($headers,$data);

// 异步
$request = new \GuzzleHttp\Psr7\Request($httpMethod, $baseUrl . $url, $headers, $data);
// echo $request->getUri();
// var_dump($request->getHeaders());
// $response = $client->sendAsync($request)->wait();
$promise = $client->sendAsync($request)->then(function($response) {
  // echo $response->getStatusCode();
  echo $response->getBody()->getContents();
  // var_dump($response->getHeaders());
});
echo 'a';
$promise->wait();
