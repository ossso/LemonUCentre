<?php

namespace LemonUCentre\Service;

use LemonUCentre\Utils;

/**
 * 腾讯云短信服务
 *
 * API 2.0版本
 */

class QCloudSMS
{
    /**
     * @var smsSdkAppid
     */
    private $sdkappid = null;

    /**
     * @var smsSdkAppkey
     */
    private $appkey = null;

    /**
     * @var 随机数
     */
    public $random = null;

    /**
     * @var 请求主机
     */
    public $host = null;

    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->host = 'https://yun.tim.qq.com/v5/tlssmssvr/sendsms';
    }

    /**
     * 初始化
     *
     * @param stirng $secretId
     * @param stirng $secretKey
     * @param stirng $smsSdkAppid
     */
    public function init($sdkappid, $appkey)
    {
        $this->sdkappid = $sdkappid;
        $this->appkey = $appkey;
        return $this;
    }

    /**
     * 获取QueryString参数
     *
     * @param array $data 要被组装成字符串的数组
     * @return string
     */
    public function getQueryString($data)
    {
        $params = array();
        foreach ($data as $val) {
            $params[] = urlencode($val[0]) . '=' . urlencode($val[1]);
        }
        $res = implode('&', $params);
        return $res;
    }

    /**
     * 拼接待签名字符串
     *
     * @param array $params 请求参数
     */
    public function str2Sign($params)
    {
        $stringToSign = $this->getQueryString($params);
        return $stringToSign;
    }

    /**
     * 签名
     *
     * @param string $stringToSign 签名内容
     * @return string 签名值
     */
    public function signature($stringToSign)
    {
        $signature = hash('SHA256', $stringToSign);
        return $signature;
    }

    /**
     * 发送短信
     *
     * @param string $phone 接收手机号码
     * @param string $sign 短信签名
     * @param string $tplID 短信模板
     * @param array $tplParams 短信替换参数
     */
    public function Send($phone, $sign, $tplID, $tplParams)
    {
        $this->random = mt_rand();
        $timestamp = time();

        $params = array();
        $params[] = array('appkey', $this->appkey);
        $params[] = array('random', $this->random);
        $params[] = array('time', $timestamp);
        $params[] = array('mobile', $phone);

        $stringToSign = $this->str2Sign($params);
        $signature = $this->signature($stringToSign);

        $data = array();
        $data['params'] = $tplParams;
        $data['sig'] = $signature;
        $data['sign'] = $sign;
        $data['tel'] = array(
            'mobile'        => $phone,
            'nationcode'    => '86',
        );
        $data['time'] = $timestamp;
        $data['tpl_id'] = (int)$tplID;

        // 发送请求
        $url = $this->host . '?sdkappid=' . $this->sdkappid . '&random=' . $this->random;
        $result = Utils\network($url, $data, true, 30);

        if ($result['code'] != '200') {
            return array(
                'code'      => -1,
                'message'   => '发送短信请求失败',
            );
        }
        $res = json_decode($result['result']);
        if ($res->result != '0') {
            return array(
                'code'      => -1,
                'message'   => '短信发送失败: ' . $res->errmsg,
                'errCode'   => $res->result,
            );
        }
        return array(
            'code'      => 0,
            'message'   => '发送成功',
        );
    }
}
