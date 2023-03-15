<?php

namespace LemonUCentre\Utils;

/**
 * 发起http请求
 * @param string $url 访问路径
 * @param array $params 参数，该数组多于1个，表示为POST
 * @param array $json 是否json
 * @param int $expire 请求超时时间
 * @param array $extend 请求伪造包头参数
 * @param string $hostIp HOST的地址
 * @return array    返回的为一个请求状态，一个内容
 */
function network($url, $params = array(), $json = false, $expire = 0, $headers = array(), $extend = array(), $hostIp = '')
{
    global $zbp;
    if (empty($url)) {
        return array('code' => '100');
    }

    $_curl = curl_init();
    $_header = array(
        'Accept-Language: zh-CN',
        'Connection: Keep-Alive',
        'Cache-Control: no-cache',
    );
    // 方便直接访问要设置host的地址
    if (!empty($hostIp)) {
        $urlInfo = parse_url($url);
        if (empty($urlInfo['host'])) {
            $urlInfo['host'] = substr(DOMAIN, 7, -1);
            $url = "http://{$hostIp}{$url}";
        } else {
            $url = str_replace($urlInfo['host'], $hostIp, $url);
        }
        $_header[] = "Host: {$urlInfo['host']}";
    }

    foreach ($headers as $val) {
        $_header[] = $val;
    }

    // 只要第二个参数传了值之后，就是POST的
    if (!empty($params)) {
        curl_setopt($_curl, CURLOPT_POST, true);
        if ($json) {
            $data = json_encode($params);
            $_header[] = 'Content-Type: application/json; charset=utf-8';
            $_header[] = 'Content-Length:' . strlen($data);
            curl_setopt($_curl, CURLOPT_HEADER, 0);
            curl_setopt($_curl, CURLOPT_POSTFIELDS, $data);
        } else {
            curl_setopt($_curl, CURLOPT_POSTFIELDS, http_build_query($params));
        }
    }

    if (substr($url, 0, 8) == 'https://') {
        curl_setopt($_curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($_curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    }
    curl_setopt($_curl, CURLOPT_URL, $url);
    curl_setopt($_curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($_curl, CURLOPT_USERAGENT, 'API PHP CURL');
    curl_setopt($_curl, CURLOPT_HTTPHEADER, $_header);

    if ($expire > 0) {
        curl_setopt($_curl, CURLOPT_TIMEOUT, $expire); // 处理超时时间
        curl_setopt($_curl, CURLOPT_CONNECTTIMEOUT, $expire); // 建立连接超时时间
    }

    // 额外的配置
    if (!empty($extend)) {
        curl_setopt_array($_curl, $extend);
    }

    $result['result'] = curl_exec($_curl);
    $result['code'] = curl_getinfo($_curl, CURLINFO_HTTP_CODE);
    $result['info'] = curl_getinfo($_curl);
    if ($result['result'] === false) {
        $result['result'] = curl_error($_curl);
        $result['code'] = curl_errno($_curl);
    }

    curl_close($_curl);

    // $content = '';
    // $content .= 'URL:' . $url . "\r\n";
    // $content .= $result['result'];

    return $result;
}
