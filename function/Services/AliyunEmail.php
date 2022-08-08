<?php

namespace LemonUCentre\Service;

use LemonUCentre\Utils;

/**
 * 阿里云短信服务
 */

class AliyunEmail
{
    /**
     * @var AccessKeyId
     */
    private $accessKeyId = null;

    /**
     * @var AccessKeySecret
     */
    private $accessKeySecret = null;

    /**
     * @var RegionId
     */
    public $regionId = null;

    /**
     * @var 服务域名
     */
    public $domain = null;

    /**
     * @var Action
     */
    public $action = null;

    /**
     * @var Version
     */
    public $version = null;

    /**
     * @var Timestamp
     */
    public $timestamp = null;

    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->action = 'SingleSendMail';
        $this->domain = 'dm.aliyuncs.com';
        $this->regionId = 'cn-hangzhou';
        $this->version = '2015-11-23';
        $this->timestamp = gmdate('Y-m-d\TH:i:s\Z');
    }

    /**
     * 初始化
     *
     * @param stirng $accessKeyId
     * @param stirng $accessKeySecret
     * @param stirng $regionId
     */
    public function init($accessKeyId, $accessKeySecret, $regionId = null)
    {
        $this->accessKeyId = $accessKeyId;
        $this->accessKeySecret = $accessKeySecret;
        if (isset($regionId)) {
            $this->regionId = $regionId;
            switch ($regionId) {
                default:
                case 'cn-hangzhou':
                    $this->domain = 'dm.aliyuncs.com';
                    $this->version = '2015-11-23';
                break;
                case 'ap-southeast-1':
                    $this->domain = 'dm.ap-southeast-1.aliyuncs.com';
                    $this->version = '2017-06-22';
                break;
                case 'ap-southeast-2':
                    $this->domain = 'dm.ap-southeast-2.aliyuncs.com';
                    $this->version = '2017-06-22';
                break;
            }
        }
        return $this;
    }

    /**
     * 阿里API要求参数转码
     *
     * @param string $str 转码内容
     * @return string 被转码内容
     */
    public function encode($str)
    {
        $res = urlencode($str);
        $res = preg_replace("/\+/", "%20", $res);
        $res = preg_replace("/\*/", "%2A", $res);
        $res = preg_replace("/%7E/", "~", $res);
        return $res;
    }

    /**
     * 合并请求参数
     * 转为一维并排序
     *
     * @param array $data 要被合并的数组
     * @return array 排序完成后的一维数组
     */
    public function paramsMergeSort($data)
    {
        $params = array();
        $params[] = array('AccessKeyId', $this->accessKeyId);
        $params[] = array('Action', $this->action);
        $params[] = array('Format', 'JSON');
        $params[] = array('RegionId', $this->regionId);
        $params[] = array('SignatureMethod', 'HMAC-SHA1');
        $params[] = array('SignatureVersion', '1.0');
        $params[] = array('SignatureNonce', uniqid(mt_rand(0, 0xffff), true));
        $params[] = array('Timestamp', $this->timestamp);
        $params[] = array('Version', $this->version);
        $params = array_merge($params, $data);
        $arr = array();
        foreach ($params as $val) {
            $arr[$val[0]] = $val[1];
        }
        ksort($arr);
        return $arr;
    }

    /**
     * 组装请求字符串
     *
     * @param array $data 要被组装成字符串的数组
     * @return string 组装完成的数组
     */
    public function getParamString($data)
    {
        $params = array();
        foreach ($data as $key => $val) {
            if ($key == 'ReplyToAddress') {
                $params[] = $this->encode($key) . '=' . $this->encode($val ? 'true' : 'false');
            } else {
                $params[] = $this->encode($key) . '=' . $this->encode($val);
            }
        }
        $res = implode('&', $params);
        return $res;
    }

    /**
     * 获取签名
     *
     * @param string $stringToSign 签名内容
     * @return string 未被转码的签名
     */
    public function signature($stringToSign)
    {
        $signature = base64_encode(hash_hmac('sha1', $stringToSign, $this->accessKeySecret . '&', true));
        return $signature;
    }

    /**
     * 发送邮件
     */
    public function send($fromEmail, $fromEmailName, $toEmail, $subject, $content, $type = 'html')
    {
        $this->timestamp = gmdate('Y-m-d\TH:i:s\Z');

        $params = array();
        $params[] = array('AccountName', $fromEmail);
        $params[] = array('FromAlias', $fromEmailName);
        $params[] = array('ToAddress', $toEmail);
        $params[] = array('AddressType', 1);
        $params[] = array('ReplyToAddress', false);
        $params[] = array('Subject', $subject);
        if ($type == 'html') {
            $params[] = array('HtmlBody', $content);
        } else {
            $params[] = array('TextBody', $content);
        }
        // 降维并排序
        $paramArray = $this->paramsMergeSort($params);
        // 组装参数字符串
        $sortedQueryString = $this->getParamString($paramArray);
        $stringToSign = 'GET&' . $this->encode('/') . '&' . $this->encode($sortedQueryString);
        // 签名
        $sign = $this->signature($stringToSign);
        $signature = $this->encode($sign);
        // 组装请求地址
        $sortQueryString = '&' . $sortedQueryString;
        $pamamString = 'Signature=' . $signature . $sortQueryString;
        $url = 'https://' . $this->domain . '/?'. $pamamString;

        // 发起请求
        $result = Utils\network($url);

        if ($result['code'] != '200') {
            return array(
                'code'      => -1,
                'message'   => '发送邮件请求失败',
            );
        }
        $res = json_decode($result['result']);
        if ($res->Code != 'OK') {
            return array(
                'code'      => -1,
                'message'   => '邮件发送失败: ' . $res->Message,
            );
        }
        return array(
            'code'      => 0,
            'message'   => '发送成功',
        );
    }
}
