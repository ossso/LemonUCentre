<?php

namespace LemonUCentre\Social;

use LemonUCentre\Utils as Utils;

/**
 * QQ互联
 */

class QQConnect
{
    /**
     * @var appid
     */
    private $appid = null;

    /**
     * @var appkey
     */
    private $appkey = null;

    /**
     * @var state
     */
    private $state = null;

    /**
     * @var 获取Code的地址
     */
    private $getCodeURI = null;

    /**
     * @var 获取AccessToken的地址
     */
    private $getAccessTokenURI = null;

    /**
     * @var 获取OpenID的地址
     */
    private $getOpenIDURI = null;

    /**
     * @var 获取UserInfo的地址
     */
    private $getUserInfoURI = null;

    /**
     * @var accessToken
     */
    public $accessToken = null;

    /**
     * @var redirectUri
     */
    public $redirectUri = null;

    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->getCodeURI = 'https://graph.qq.com/oauth2.0/authorize';
        $this->getAccessTokenURI = 'https://graph.qq.com/oauth2.0/token';
        $this->getOpenIDURI = 'https://graph.qq.com/oauth2.0/me';
        $this->getUserInfoURI = 'https://graph.qq.com/user/get_user_info';
    }

    /**
     * 初始化
     * @param string $appid APPID
     * @param string $appkey APPKEY
     * @param string $redirectUri 回调地址
     * @param string $accessToken AccessToken
     * @param string $state State
     */
    public function init($appid, $appkey, $redirectUri, $accessToken = null, $state = null)
    {
        $this->appid = $appid;
        $this->appkey = $appkey;
        $this->redirectUri = $redirectUri;
        if (isset($accessToken)) {
            $this->accessToken = $accessToken;
        }
        if (isset($state)) {
            $this->state = $state;
        }
    }

    /**
     * 校验appid与appkey是否设置
     */
    public function vaildate()
    {
        if (empty($this->appid)) {
            $error = '请设置AppID';
            throw new Exception($error);
        }
        if (empty($this->appkey)) {
            $error = '请设置AppKey';
            throw new Exception($error);
        }
        if (empty($this->redirectUri)) {
            $error = '请设置回调地址';
            throw new Exception($error);
        }
    }

    /**
     * 验证state
     */
    public function checkState($state)
    {
        return isset($state) && $this->state == $state;
    }

    /**
     * 验证accessToken
     */
    public function checkAccessToken()
    {
        if (empty($this->accessToken)) {
            $error = 'accessToken不存在';
            throw new Exception($error);
        }
    }

    /**
     * 创建请求生成Code的URL
     * @param string $state
     * @param boolean $to 是否主动前往
     */
    public function getCodeUrl($state = null, $to = false)
    {
        $this->vaildate();
        if (isset($state)) {
            $this->state = $state;
        } else {
            $this->state = substr(md5(uniqid()), 8, 16);
        }
        $params = array();
        $params[] = 'response_type=code';
        $params[] = 'client_id=' . $this->appid;
        $params[] = 'redirect_uri=' . urlencode($this->redirectUri);
        $params[] = 'state=' . $this->state;
        $url = $this->getAccessTokenURI . '?' . implode('&', $params);

        if ($to) {
            header('HTTP/1.1 302 Found');
            header('Location: ' . $url);
            die();
        }

        return array(
            'state' => $state,
            'url'   => $url,
        );
    }

    /**
     * 获取AccessToken
     * @param string $state State值
     * @param string $code 登录Code
     * @param Object $ret 响应内容 - debug
     *
     * @return String
     */
    public function getAccessToken($state, $code, &$ret = null)
    {

        $this->vaildate();

        if (!$this->checkState($state)) {
            return false;
        }

        $params = array();
        $params[] = 'grant_type=authorization_code';
        $params[] = 'client_id=' . $this->appid;
        $params[] = 'client_secret=' . $this->appkey;
        $params[] = 'code=' .  $code;
        $params[] = 'redirect_uri=' . urlencode($this->redirectUri);
        $url = $this->getAccessTokenURI . '?' . implode('&', $params);

        $response = Utils\network($url);
        if (!$response['code'] == '200') {
            $ret = array(
                'code'  => $response['code'],
                'msg'   => 'Netword Error Code' . $response['code'],
            );
            return null;
        }

        $regexp = '/access\_token=([a-zA-Z0-9]*)/';
        $content = array();
        preg_match_all($regexp, $response['result'], $content);
        if (count($content[0]) < 1) {
            $ret = array(
                'code'  => '-1',
                'msg'   => '未返回正确内容',
            );
            return null;
        }
        $accessToken = $content[0];

        $this->accessToken = $accessToken;

        return $accessToken;
    }

    /**
     * 获取OpenID
     */
    public function getOpenID(&$ret = null)
    {
        $this->checkAccessToken();

        $url = $this->getOpenIDURI . '?access_token=' . $this->accessToken;

        $response = Utils\network($url);

        if (!$response['code'] == '200') {
            $ret = array(
                'code'  => $response['code'],
                'msg'   => 'Netword Error Code' . $response['code'],
            );
            return null;
        }
        $regexp = '/callback\((.*)\)/';
        $content = array();
        preg_match_all($regexp, $response['result'], $content);
        if (count($content[0]) < 1) {
            $ret = array(
                'code'  => '-1',
                'msg'   => '未返回正确内容',
            );
            return null;
        }
        $result = $content[0];
        $result = json_decode($result, true);

        if (!array_key_exists('openid', $result)) {
            $ret = $result;
            return null;
        }
        $ret = $result;

        $appid = $result['client_id'];
        if ($this->appid != $appid) {
            return null;
        }
        $openid = $result['openid'];

        return $openid;
    }

    /**
     * 获取用户信息
     * @param string $openid OPENID
     */
    public function getUserInfo($openid, &$ret)
    {
        $this->checkAccessToken();

        $params = array();
        $params[] = 'access_token=' . $this->accessToken;
        $params[] = 'oauth_consumer_key=' . $this->appid;
        $params[] = 'openid=' .  $openid;
        $url = $this->getUserInfoURI . '?' . implode('&', $params);

        $response = Utils\network($url);

        if (!$response['code'] == '200') {
            $ret = array(
                'code'  => $response['code'],
                'msg'   => 'Netword Error Code' . $response['code'],
            );
            return null;
        }

        $result = $response['result'];
        $result = json_decode($result, true);
        if ($result['ret'] > 0) {
            $ret = array(
                'code'  => $result['ret'],
                'msg'   => $result['msg'],
            );
            return null;
        }
        $ret = $result;

        return $result;
    }
}
