<?php

namespace LemonUCentre\Controllers;

/**
 * 基础数据控制类
 */
class BaseController
{
    /**
     * VO
     * @var object
     */
    public $vo = null;

    /**
     * 类型
     * @var string
     */
    public $type = null;

    /**
     * 响应数据
     * @var array
     */
    public $response = array();

    /**
     * 忽略登录的白名单
     * @var array
     */
    private $whites = array();

    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->vo = new VO();
        $this->whites = array('login');
    }

    /**
     * set方法
     */
    public function __set($name, $value)
    {
        switch ($name) {
            /**
             * 添加白名单
             */
            case 'whites':
                $this->whites[] = $value;
            break;
            default:
        }
    }

    /**
     * 初始化方法
     */
    public function init($type = null, $output = true)
    {

        $this->type = $type;
        if (empty($type)) {
            $this->type = \GetVars('HTTP_REQUEST_API_TYPE', 'SERVER');
        }

        if (!$this->checkLogin()) {
            $this->output();
            return false;
        }

        $this->watch();
        if (count($this->response) == 0 && $output) {
            $this->response = array(
                'code'      => -1,
                'message'   => '未定义接口',
            );
        }
        if ($output) {
            $this->output();
        }
    }

    /**
     * 确认是否登录
     */
    public function checkLogin()
    {
        global $zbp, $lemon_uc;
        $whites = array('login');
        if (!in_array($this->type, $this->whites)) {
            if ($zbp->user->ID == 0) {
                $this->response['code'] = -9;
                $this->response['message'] = '未登录或登录已超时';
                return false;
            }
        }
        return true;
    }

    /**
     * 监听
     */
    public function watch()
    {
        return true;
    }

    /**
     * 输出数据
     */
    public function output()
    {
        header('Content-Type: application/json');
        echo json_encode($this->response);
    }
}
