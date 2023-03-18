<?php
/**
 * 核心服务类
 * 主要方法与zblogphp.php风格统计
 */

namespace LemonUCentre\Services;

// use LemonUCentre\Models\LoginRecord;
// use LemonUCentre\Models\RedeemCode;
// use LemonUCentre\Models\RedeemCodeProduct;
use LemonUCentre\Models\User;

/**
 * 用户中心
 */
class UCenter
{
    /**
     * @var User 用户
     */
    public $user = null;

    // /**
    //  * @var string 当前访问的域名主机
    //  */
    // public $host = null;

    // /**
    //  * @var array 数据库表
    //  */
    // public $table = array();

    // /**
    //  * @var array 数据库数据结构
    //  */
    // public $tableInfo = array();

    // /**
    //  * @var array 转换数据结构
    //  */
    // public $datainfo = array();

    // /**
    //  * @var array 页面数组
    //  */
    // public $pages = array();

    // /**
    //  * @var array API数组
    //  */
    // public $apis = array();

    /**
     * @var User[] 用户数组
     */
    public $users = array();

    // /**
    //  * @var UserByUID[] 用户数组
    //  */
    // public $userListByUID = array();

    // /**
    //  * @var Articles[] 文章数组
    //  */
    // public $articles = array();

    // /**
    //  * @var Articles[] 文章数组
    //  */
    // public $articleListByLogID = array();

    // /**
    //  * @var CheckIn[] 签到数组
    //  */
    // public $checkins = array();

    // /**
    //  * @var LoginRecord[] 登录记录数组
    //  */
    // public $loginRecords = array();

    // /**
    //  * @var PointRecord[] 积分记录数组
    //  */
    // public $ponitRecords = array();

    // /**
    //  * @var Collect[] 文章收藏数组
    //  */
    // public $collects = array();

    // /**
    //  * @var Like[] 文章点赞数组
    //  */
    // public $likes = array();

    // /**
    //  * @var Follow[] 关注数组
    //  */
    // public $follows = array();

    // /**
    //  * @var Third[] 第三方登录记录数组
    //  */
    // public $thirds = array();

    // /**
    //  * @var MSGList[] 站内信消息列表
    //  */
    // public $msglist = array();

    // /**
    //  * @var MSGContent[] 站内信消息内容
    //  */
    // public $msgcontents = array();

    // /**
    //  * @var RedeemType[] 兑换码类型
    //  */
    // public $redeemTypes = array();

    // /**
    //  * @var RedeemCode[] 兑换码
    //  */
    // public $redeemCodes = array();

    // /**
    //  * @var RedeemCode[] 兑换码
    //  */
    // public $redeemCodesByCode = array();

    /**
     * 构造函数
     * 加载基本配置到$lemon_uc.
     */
    public function __construct()
    {}

    /**
     * 初始化
     */
    public function init()
    {
        global $zbp;

        $this->user = new User();

        // $PointsName = '积分';
        // if ($zbp->Config('LemonUCentre')->HasKey('pointsName') && $zbp->Config('LemonUCentre')->pointsName) {
        //     $PointsName = $zbp->Config('LemonUCentre')->pointsName;
        // }
        // $this->PointsName = $PointsName;

        // $VIPName = 'VIP';
        // if ($zbp->Config('LemonUCentre')->HasKey('VIPName') && $zbp->Config('LemonUCentre')->VIPName) {
        //     $VIPName = $zbp->Config('LemonUCentre')->VIPName;
        // }
        // $this->VIPName = $VIPName;

        // $static = $zbp->Config('LemonUCentre')->staticPath;
        // if ($zbp->Config('LemonUCentre')->disenableStaticPath == '1' || empty($static)) {
        //     $static = $zbp->host . 'zb_users/plugin/LemonUCentre/static/';
        // }
        // $this->static = $static;

        // $jspath = $static . 'js/';
        // if ($zbp->option['ZC_DEBUG_MODE']) {
        //     $jspath = $zbp->host . 'zb_users/plugin/LemonUCentre/src/js/';
        // }
        // $this->jspath = $jspath;
        
        // $this->host = $_SERVER['HTTP_HOST'];
    }

    /**
     * 根据ID获取User
     * @param number $id 用户ID
     */
    public function getUserByID($ID)
    {
        if (isset($this->users[$ID])) {
            return $this->users[$ID];
        }

        $user = new User();
        $user->LoadInfoByID($ID);
        $this->users[$ID] = $user;
        return $user;
    }

    // /**
    //  * 根据ID获取LemonUCentreArticle
    //  */
    // public function GetArticleByID($ID)
    // {
    //     if (isset($this->articles[$ID])) {
    //         return $this->articles[$ID];
    //     } else {
    //         $article = new Article();
    //         $article->LoadInfoByID($ID);
    //         $this->articles[$ID] = $article;
    //         return $article;
    //     }
    // }

    // /**
    //  * 根据LogID获取LemonUCentreArticle
    //  */
    // public function GetArticleByLogID($ID)
    // {
    //     if (isset($this->articleListByLogID[$ID])) {
    //         return $this->articleListByLogID[$ID];
    //     } else {
    //         $article = new Article();
    //         $article->LoadInfoByLogID($ID);
    //         $this->articleListByLogID[$ID] = $article;
    //         return $article;
    //     }
    // }

    // /**
    //  * 根据ID获取 CheckIn
    //  */
    // public function getCheckInByID($ID)
    // {
    //     if (isset($this->checkins[$ID])) {
    //         return $this->checkins[$ID];
    //     } else {
    //         $checkin = new CheckIn();
    //         $checkin->LoadInfoByID($ID);
    //         $this->checkins[$ID] = $checkin;
    //         return $checkin;
    //     }
    // }

    // /**
    //  * 根据ID获取LemonUCentreLoginRecord
    //  */
    // public function GetLoginRecordByID($ID)
    // {
    //     if (isset($this->loginRecords[$ID])) {
    //         return $this->loginRecords[$ID];
    //     } else {
    //         $record = new LoginRecord();
    //         $record->LoadInfoByID($ID);
    //         $this->loginRecords[$ID] = $record;
    //         return $record;
    //     }
    // }

    // /**
    //  * 根据ID获取LemonUCentrePointsRecord
    //  */
    // public function GetPointsRecordByID($ID)
    // {
    //     if (isset($this->pointsRecords[$ID])) {
    //         return $this->pointsRecords[$ID];
    //     } else {
    //         $record = new PointsRecord();
    //         $record->LoadInfoByID($ID);
    //         $this->pointsRecords[$ID] = $record;
    //         return $record;
    //     }
    // }

    // /**
    //  * 根据ID获取LemonUCentreCollect
    //  */
    // public function GetCollectByID($ID)
    // {
    //     if (isset($this->collects[$ID])) {
    //         return $this->collects[$ID];
    //     } else {
    //         $collect = new Collect();
    //         $collect->LoadInfoByID($ID);
    //         $this->collects[$ID] = $collect;
    //         return $collect;
    //     }
    // }

    // /**
    //  * 根据ID获取LemonUCentreLike
    //  */
    // public function GetLikeByID($ID)
    // {
    //     if (isset($this->likes[$ID])) {
    //         return $this->likes[$ID];
    //     } else {
    //         $like = new Like();
    //         $like->LoadInfoByID($ID);
    //         $this->likes[$ID] = $like;
    //         return $like;
    //     }
    // }

    // /**
    //  * 根据ID获取LemonUCentreFollow
    //  */
    // public function GetFollowByID($ID)
    // {
    //     if (isset($this->follows[$ID])) {
    //         return $this->follows[$ID];
    //     } else {
    //         $follow = new Follow();
    //         $follow->LoadInfoByID($ID);
    //         $this->follows[$ID] = $follow;
    //         return $follow;
    //     }
    // }

    // /**
    //  * 根据ID获取LemonUCentreThird
    //  */
    // public function GetThirdByID($ID)
    // {
    //     if (isset($this->thirds[$ID])) {
    //         return $this->thirds[$ID];
    //     } else {
    //         $third = new Third();
    //         $third->LoadInfoByID($ID);
    //         $this->thirds[$ID] = $third;
    //         return $third;
    //     }
    // }

    // /**
    //  * 根据ID获取LemonUCentreMSGList
    //  */
    // public function GetMSGByID($ID)
    // {
    //     if (isset($this->msgs[$ID])) {
    //         return $this->msgs[$ID];
    //     } else {
    //         $msg = new MSGList();
    //         $msg->LoadInfoByID($ID);
    //         $this->msgs[$ID] = $msg;
    //         return $msg;
    //     }
    // }

    // /**
    //  * 根据ID获取LemonUCentreMSGContent
    //  */
    // public function GetMSGContentByID($ID)
    // {
    //     if (isset($this->msgcontents[$ID])) {
    //         return $this->msgcontents[$ID];
    //     } else {
    //         $mc = new MSGContent();
    //         $mc->LoadInfoByID($ID);
    //         $this->msgcontents[$ID] = $mc;
    //         return $mc;
    //     }
    // }

    // /**
    //  * 根据ID获取LemonUCentreInvitationCode
    //  */
    // public function GetLemonUCentreInvitationCodeByID($ID)
    // {
    //     $code = new InvitationCode();
    //     $code->LoadInfoByID($ID);
    //     return $code;
    // }

    // /**
    //  * 根据ID获取 RedeemCode
    //  */
    // public function getRedeemCodeByID($ID)
    // {
    //     if (isset($this->redeemCodes[$ID])) {
    //         return $this->redeemCodes[$ID];
    //     } else {
    //         $code = new RedeemCode();
    //         $code->LoadInfoByID($ID);
    //         $this->redeemCodes[$ID] = $code;
    //         return $code;
    //     }
    // }

    // /**
    //  * 根据Code获取 RedeemCode
    //  */
    // public function getRedeemCodeByCode($code)
    // {
    //     if (isset($this->redeemCodesByCode[$code])) {
    //         return $this->redeemCodesByCode[$code];
    //     } else {
    //         $redeemCode = new RedeemCode();
    //         $redeemCode->LoadInfoByCode($code);
    //         $this->redeemCodesByCode[$code] = $redeemCode;
    //         return $redeemCode;
    //     }
    // }

    // /**
    //  * 根据ID获取 RedeemType
    //  */
    // public function getRedeemTypeByID($ID)
    // {
    //     if (isset($this->redeemTypes[$ID])) {
    //         return $this->redeemTypes[$ID];
    //     } else {
    //         $type = new RedeemType();
    //         $type->LoadInfoByID($ID);
    //         $this->redeemTypes[$ID] = $type;
    //         return $type;
    //     }
    // }

    /**
     * 获取用户列表
     * @param mixed $select
     * @param mixed $where
     * @param mixed $order
     * @param mixed $limit
     * @param mixed $option
     * 
     * @return LemonUCentreUser[]
     */
    public function getUserList($select = null, $w = null, $order = null, $limit = null, $option = null)
    {
        global $zbp;

        if (empty($select)) {
            $select = array('*');
        }
        if (empty($w)) {
            $w = array();
        }

        $sql = $zbp->db->sql->Select(
            $this->table['LemonUCentreUser'],
            $select,
            $w,
            $order,
            $limit,
            $option
        );
        $result = $zbp->GetListType('LemonUCentre\Models\User', $sql);

        foreach ($result as $item) {
            $this->users[$item->ID] = $item;
        }

        return $result;
    }

    // /**
    //  * 获取文章列表
    //  */
    // public function GetArticleList($select = null, $w = null, $order = null, $limit = null, $option = null)
    // {
    //     global $zbp;
    //     if (empty($select)) {
    //         $select = array('*');
    //     }
    //     if (empty($w)) {
    //         $w = array();
    //     }

    //     $sql = $zbp->db->sql->Select(
    //         $zbp->table['LemonUCentreArticle'],
    //         $select,
    //         $w,
    //         $order,
    //         $limit,
    //         $option
    //     );
    //     $result = $zbp->GetListType('LemonUCentre\Article', $sql);

    //     foreach ($result as $item) {
    //         $this->articles[$item->ID] = $item;
    //     }

    //     return $result;
    // }

    // /**
    //  * 获取签到记录
    //  */
    // public function getCheckInList($select = null, $w = null, $order = null, $limit = null, $option = null)
    // {
    //     global $zbp;
    //     if (empty($select)) {
    //         $select = array('*');
    //     }
    //     if (empty($w)) {
    //         $w = array();
    //     }

    //     $sql = $zbp->db->sql->Select(
    //         $this->table['CheckIn'],
    //         $select,
    //         $w,
    //         $order,
    //         $limit,
    //         $option
    //     );
    //     $result = $zbp->GetListType('LemonUCentre\Models\CheckIn', $sql);

    //     foreach ($result as $item) {
    //         $this->checkins[$item->ID] = $item;
    //     }

    //     return $result;
    // }

    // /**
    //  * 获取签到记录
    //  */
    // public function getCheckInRerocdList($select = null, $w = null, $order = null, $limit = null, $option = null)
    // {
    //     global $zbp;
    //     if (empty($select)) {
    //         $select = array('*');
    //     }
    //     if (empty($w)) {
    //         $w = array();
    //     }

    //     $sql = $zbp->db->sql->Select(
    //         $this->table['CheckInRerocd'],
    //         $select,
    //         $w,
    //         $order,
    //         $limit,
    //         $option
    //     );
    //     $result = $zbp->GetListType('LemonUCentre\Models\CheckInRerocd', $sql);

    //     return $result;
    // }

    // /**
    //  * 获取登录记录
    //  */
    // public function getLoginRecordList($select = null, $w = null, $order = null, $limit = null, $option = null)
    // {
    //     global $zbp;

    //     if (empty($select)) {
    //         $select = array('*');
    //     }
    //     if (empty($w)) {
    //         $w = array();
    //     }

    //     $sql = $zbp->db->sql->Select(
    //         $this->table['LoginRecord'],
    //         $select,
    //         $w,
    //         $order,
    //         $limit,
    //         $option
    //     );
    //     $result = $zbp->GetListType('LemonUCentre\Models\LoginRecord', $sql);

    //     foreach ($result as $item) {
    //         $this->loginRecords[$item->ID] = $item;
    //     }

    //     return $result;
    // }

    // /**
    //  * 获取积分记录
    //  */
    // public function GetPointsRecordList($select = null, $w = null, $order = null, $limit = null, $option = null)
    // {
    //     global $zbp;
    //     if (empty($select)) {
    //         $select = array('*');
    //     }
    //     if (empty($w)) {
    //         $w = array();
    //     }

    //     $sql = $zbp->db->sql->Select(
    //         $zbp->table['LemonUCentrePointsRecord'],
    //         $select,
    //         $w,
    //         $order,
    //         $limit,
    //         $option
    //     );
    //     $result = $zbp->GetListType('LemonUCentre\PointsRecord', $sql);

    //     foreach ($result as $item) {
    //         $this->pointsRecords[$item->ID] = $item;
    //     }

    //     return $result;
    // }

    // /**
    //  * 获取VIP记录
    //  */
    // public function GetVIPRecordList($select = null, $w = null, $order = null, $limit = null, $option = null)
    // {
    //     global $zbp;
    //     if (empty($select)) {
    //         $select = array('*');
    //     }
    //     if (empty($w)) {
    //         $w = array();
    //     }

    //     $sql = $zbp->db->sql->Select(
    //         $zbp->table['LemonUCentreVIPRecord'],
    //         $select,
    //         $w,
    //         $order,
    //         $limit,
    //         $option
    //     );
    //     $result = $zbp->GetListType('LemonUCentre\VIPRecord', $sql);

    //     return $result;
    // }

    // /**
    //  * 获取收藏列表
    //  */
    // public function GetCollectList($select = null, $w = null, $order = null, $limit = null, $option = null)
    // {
    //     global $zbp;
    //     if (empty($select)) {
    //         $select = array('*');
    //     }
    //     if (empty($w)) {
    //         $w = array();
    //     }

    //     $sql = $zbp->db->sql->Select(
    //         $zbp->table['LemonUCentreCollect'],
    //         $select,
    //         $w,
    //         $order,
    //         $limit,
    //         $option
    //     );
    //     $result = $zbp->GetListType('LemonUCentre\Collect', $sql);

    //     foreach ($result as $item) {
    //         $this->collects[$item->ID] = $item;
    //     }

    //     return $result;
    // }

    // /**
    //  * 获取第三方绑定列表
    //  */
    // public function GetThirdList($select = null, $w = null, $order = null, $limit = null, $option = null)
    // {
    //     global $zbp;
    //     if (empty($select)) {
    //         $select = array('*');
    //     }
    //     if (empty($w)) {
    //         $w = array();
    //     }

    //     $sql = $zbp->db->sql->Select(
    //         $zbp->table['LemonUCentreThird'],
    //         $select,
    //         $w,
    //         $order,
    //         $limit,
    //         $option
    //     );
    //     $result = $zbp->GetListType('LemonUCentre\Third', $sql);

    //     foreach ($result as $item) {
    //         $this->thirds[$item->ID] = $item;
    //     }

    //     return $result;
    // }

    // /**
    //  * 获取站内信列表
    //  */
    // public function GetMSGList($select = null, $w = null, $order = null, $limit = null, $option = null)
    // {
    //     global $zbp;
    //     if (empty($select)) {
    //         $select = array('*');
    //     }
    //     if (empty($w)) {
    //         $w = array();
    //     }

    //     $sql = $zbp->db->sql->Select(
    //         $zbp->table['LemonUCentreMSGList'],
    //         $select,
    //         $w,
    //         $order,
    //         $limit,
    //         $option
    //     );
    //     $result = $zbp->GetListType('LemonUCentre\MSGList', $sql);

    //     foreach ($result as $item) {
    //         $this->msgs[$item->ID] = $item;
    //     }

    //     return $result;
    // }

    // /**
    //  * 获取站内信内容列表
    //  */
    // public function GetMSGContentList($select = null, $w = null, $order = null, $limit = null, $option = null)
    // {
    //     global $zbp;
    //     if (empty($select)) {
    //         $select = array('*');
    //     }
    //     if (empty($w)) {
    //         $w = array();
    //     }

    //     $sql = $zbp->db->sql->Select(
    //         $zbp->table['LemonUCentreMSGContent'],
    //         $select,
    //         $w,
    //         $order,
    //         $limit,
    //         $option
    //     );
    //     $result = $zbp->GetListType('LemonUCentre\MSGContent', $sql);

    //     foreach ($result as $item) {
    //         $this->msgcontents[$item->ID] = $item;
    //     }

    //     return $result;
    // }

    // /**
    //  * 获取VerifyCode的列表
    //  */
    // public function GetVerifyCodeList($select = null, $w = null, $order = null, $limit = null, $option = null)
    // {
    //     global $zbp;
    //     if (empty($select)) {
    //         $select = array('*');
    //     }
    //     if (empty($w)) {
    //         $w = array();
    //     }

    //     $sql = $zbp->db->sql->Select(
    //         $zbp->table['LemonUCentreVerifyCode'],
    //         $select,
    //         $w,
    //         $order,
    //         $limit,
    //         $option
    //     );
    //     $result = $zbp->GetListType('LemonUCentre\VerifyCode', $sql);

    //     return $result;
    // }

    // /**
    //  * 获取InvitationCode的列表
    //  */
    // public function getInviteCodeList($select = null, $w = null, $order = null, $limit = null, $option = null)
    // {
    //     global $zbp;

    //     if (empty($select)) {
    //         $select = array('*');
    //     }
    //     if (empty($w)) {
    //         $w = array();
    //     }

    //     $sql = $zbp->db->sql->Select(
    //         $this->table['InviteCode'],
    //         $select,
    //         $w,
    //         $order,
    //         $limit,
    //         $option
    //     );
    //     $result = $zbp->GetListType('LemonUCentre\Models\InviteCode', $sql);

    //     return $result;
    // }

    // /**
    //  * 获取RedemptionCode的列表
    //  */
    // public function getRedeemTypeList($select = null, $w = null, $order = null, $limit = null, $option = null)
    // {
    //     global $zbp;

    //     if (empty($select)) {
    //         $select = array('*');
    //     }
    //     if (empty($w)) {
    //         $w = array();
    //     }

    //     $sql = $zbp->db->sql->Select(
    //         $this->table['RedeemType'],
    //         $select,
    //         $w,
    //         $order,
    //         $limit,
    //         $option
    //     );
    //     $result = $zbp->GetListType('LemonUCentre\Models\RedeemType', $sql);

    //     foreach ($result as $item) {
    //         $this->redeemTypes[$item->ID] = $item;
    //         $this->redeemCodesByCode[$item->Code] = $item;
    //     }

    //     return $result;
    // }

    // /**
    //  * 获取RedemptionCode的列表
    //  */
    // public function getRedeemCodeList($select = null, $w = null, $order = null, $limit = null, $option = null)
    // {
    //     global $zbp;

    //     if (empty($select)) {
    //         $select = array('*');
    //     }
    //     if (empty($w)) {
    //         $w = array();
    //     }

    //     $sql = $zbp->db->sql->Select(
    //         $this->table['RedeemCode'],
    //         $select,
    //         $w,
    //         $order,
    //         $limit,
    //         $option
    //     );
    //     $result = $zbp->GetListType('LemonUCentre\Models\RedeemCode', $sql);

    //     return $result;
    // }

    // /**
    //  * 验证手机短信验证码
    //  *
    //  * @param string $phone 手机号码
    //  * @param string $code 验证码
    //  *
    //  * @return boolean
    //  */
    // public function VerifyCodeByPhone($phone, $code)
    // {
    //     global $zbp;

    //     $w = array();
    //     $w[] = array('=', 'vc_Type', '0');
    //     $w[] = array('=', 'vc_Status', '0');
    //     $w[] = array('=', 'vc_Account', $phone);
    //     $w[] = array('=', 'vc_Code', $code);
    //     $minTime = time() - (15 * 60);
    //     $w[] = array('>', 'vc_CreateTime', $minTime);
    //     $result = $this->GetVerifyCodeList(array('*'), $w);

    //     if ($result && count($result) > 0) {
    //         $result[0]->Status = 1;
    //         $result[0]->VerifyTime = time();
    //         $result[0]->Save();
    //         return true;
    //     }

    //     return false;
    // }

    // /**
    //  * 验证邮件验证码
    //  *
    //  * @param string $email 手机号码
    //  * @param string $code 验证码
    //  *
    //  * @return boolean
    //  */
    // public function VerifyCodeByEmail($email, $code)
    // {
    //     global $zbp;

    //     $w = array();
    //     $w[] = array('=', 'vc_Type', '1');
    //     $w[] = array('=', 'vc_Status', '0');
    //     $w[] = array('=', 'vc_Account', $email);
    //     $w[] = array('=', 'vc_Code', $code);
    //     $minTime = time() - (15 * 60);
    //     $w[] = array('>', 'vc_CreateTime', $minTime);
    //     $result = $this->GetVerifyCodeList(array('*'), $w);

    //     if ($result && count($result) > 0) {
    //         $result[0]->Status = 1;
    //         $result[0]->VerifyTime = time();
    //         $result[0]->Save();
    //         return true;
    //     }

    //     return false;
    // }

    // /**
    //  * 获取唯一邀请码
    //  *
    //  * @param boolean $indb 入库
    //  * @return string
    //  */
    // public function getUniqueInviteCode($indb = false)
    // {
    //     global $zbp;

    //     $code = substr(md5($zbp->host . uniqid() . mt_rand()), 2, 6);
    //     $code = strtoupper($code);
    //     $w = array();
    //     $w[] = array('=', 'ic_Code', $code);
    //     $result = $this->getInviteCodeList(array('*'), $w);
        
    //     $w2 = array();
    //     $w2[] = array('=', 'u_Code', $code);
    //     $result2 = $this->getUserList(array('*'), $w2);

    //     /**
    //      * 递归查询邀请码是否重复
    //      */
    //     if (count($result) > 0 || count($result2) > 0) {
    //         $code = $this->getUniqueInviteCode($indb);
    //     }

    //     if ($indb) {
    //         $inviteCode = new InviteCode();
    //         $inviteCode->Code = $code;
    //         $inviteCode->Save();
    //     }

    //     return $code;
    // }

    // /**
    //  * 用户昨日是否签到
    //  */
    // public function checkInYesterday($lemonUser = null)
    // {
    //     if (empty($lemonUser)) {
    //         $lemonUser = $this->user;
    //     }

    //     $yesterday = date('Y/m/d 00:00:00', strtotime('-1 day'));
    //     $timestamp = strtotime($yesterday);
    //     $w = array();
    //     $w[] = array('=', 'ckr_UID', $lemonUser->UID);
    //     $w[] = array('>=', 'ckr_CreateTime', $timestamp);
    //     $result = $this->getCheckInRerocdList(array('*'), $w, null, array(1));

    //     return count($result) > 0;
    // }

    // /**
    //  * 用户当日是否签到
    //  */
    // public function checkInToday($lemonUser = null)
    // {
    //     if (empty($lemonUser)) {
    //         $lemonUser = $this->user;
    //     }

    //     $today = date('Y/m/d 00:00:00');
    //     $timestamp = strtotime($today);
    //     $w = array();
    //     $w[] = array('=', 'ckr_UID', $lemonUser->UID);
    //     $w[] = array('>=', 'ckr_CreateTime', $timestamp);
    //     $result = $this->getCheckInRerocdList(array('*'), $w, null, array(1));

    //     return count($result) > 0;
    // }

    // /**
    //  * 获取用户的连签时间
    //  */
    // public function checkInCount($lemonUser = null)
    // {
    //     if (empty($lemonUser)) {
    //         $lemonUser = $this->user;
    //     }

    //     $yesterday = date('Y/m/d 00:00:00', strtotime('-1 day'));
    //     $timestamp = strtotime($yesterday);

    //     if ($lemonUser->CheckIn->CheckTime > $timestamp) {
    //         return $lemonUser->CheckIn->Count;
    //     }

    //     return 0;
    // }

    // /**
    //  * 生成兑换码
    //  */
    // public function createRedeemCodeItem($typeId, $value)
    // {
    //     global $zbp;

    //     $code = new RedeemCode();
    //     $code->TypeID = $typeId;
    //     $code->UID = $zbp->user->LemonUser->ID;
    //     $code->Value = $value;
    //     $code->Code = RedeemCode::getCode();
    //     $code->Save();

    //     return $code;
    // }
}
