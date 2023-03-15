<?php
/**
 * 常量
 */

namespace LemonUCentre\Constant;

/**
 * ----- 通用值 ----- 
 */
// 通用的状态值
const STATUS = array(
  0 => '停用',
  1 => '启用',
);

/**
 * ----- 奖励规则 ----- 
 */
// 奖励规则的适用分类
const AWARD_RULE_CATE_NAME = array(
  0 => '签到',
  1 => '注册',
  2 => '兑换码',
  3 => '积分',
);

// 奖励规则的奖励类型
const AWARD_RULE_TYPE_NAME = array(
  0 => '积分',
  1 => '会员',
  2 => '兑换码',
  3 => '邀请码',
  4 => '文章阅读权限',
);
