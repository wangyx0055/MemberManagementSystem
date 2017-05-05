/*
Navicat MySQL Data Transfer

Source Server         : ppp
Source Server Version : 50553
Source Host           : 127.0.0.1:3306
Source Database       : meifa

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-04-24 16:03:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '活动id',
  `title` varchar(20) NOT NULL COMMENT '活动标题',
  `content` varchar(255) NOT NULL COMMENT '活动内容',
  `start` int(11) DEFAULT NULL COMMENT '开始时间',
  `end` int(11) DEFAULT NULL COMMENT '结束时间',
  `time` int(11) NOT NULL COMMENT '发布时间',
  PRIMARY KEY (`article_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES ('1', '开业大酬宾', '充100送钥匙扣', '20170420', '20170515', '20170420');
INSERT INTO `article` VALUES ('2', '新春大酬宾', '<p>充500送T恤</p>', '1491753600', '1493395200', '1493014824');

-- ----------------------------
-- Table structure for codes
-- ----------------------------
DROP TABLE IF EXISTS `codes`;
CREATE TABLE `codes` (
  `code_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '代金劵id',
  `code` varchar(20) NOT NULL COMMENT '代金券代码',
  `user_id` int(100) NOT NULL COMMENT '所属会员id',
  `money` int(255) DEFAULT NULL COMMENT '金额',
  `status` int(1) DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`code_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of codes
-- ----------------------------
INSERT INTO `codes` VALUES ('2', 'ENJPLZWYDUC', '10', '0', '1');
INSERT INTO `codes` VALUES ('4', 'LRDBOFJWNMT', '13', '0', '1');

-- ----------------------------
-- Table structure for group
-- ----------------------------
DROP TABLE IF EXISTS `group`;
CREATE TABLE `group` (
  `group_id` int(20) NOT NULL AUTO_INCREMENT COMMENT '组ID',
  `name` varchar(255) NOT NULL COMMENT '组名称',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of group
-- ----------------------------
INSERT INTO `group` VALUES ('1', '管理部门');
INSERT INTO `group` VALUES ('11', '美发部');

-- ----------------------------
-- Table structure for histories
-- ----------------------------
DROP TABLE IF EXISTS `histories`;
CREATE TABLE `histories` (
  `history_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '历史id',
  `users_id` int(100) NOT NULL COMMENT '会员ID',
  `member_id` int(100) NOT NULL COMMENT '员工id',
  `type` int(1) NOT NULL COMMENT '操作类型',
  `amount` int(255) DEFAULT '0' COMMENT '金额',
  `content` varchar(100) DEFAULT NULL COMMENT '消费内容',
  `time` int(11) DEFAULT NULL COMMENT '消费时间',
  `remainder` varchar(255) DEFAULT NULL COMMENT '余额',
  PRIMARY KEY (`history_id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of histories
-- ----------------------------
INSERT INTO `histories` VALUES ('49', '13', '0', '1', '100000', null, '1493003662', null);
INSERT INTO `histories` VALUES ('50', '14', '0', '1', '500', null, '1493010922', null);
INSERT INTO `histories` VALUES ('51', '13', '0', '1', '80', null, '1493013570', null);
INSERT INTO `histories` VALUES ('52', '14', '19', '0', '50', null, '1493014378', '350');
INSERT INTO `histories` VALUES ('53', '13', '19', '0', '33', null, '1493014394', '109693.5');
INSERT INTO `histories` VALUES ('54', '13', '21', '0', '130', null, '1493014413', '109564');
INSERT INTO `histories` VALUES ('55', '15', '0', '1', '1000000', null, '1493019643', null);
INSERT INTO `histories` VALUES ('56', '15', '21', '0', '130', null, '1493019672', '1009870');

-- ----------------------------
-- Table structure for indent
-- ----------------------------
DROP TABLE IF EXISTS `indent`;
CREATE TABLE `indent` (
  `ind_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `num` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `tel` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `statu` int(1) NOT NULL,
  PRIMARY KEY (`ind_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of indent
-- ----------------------------
INSERT INTO `indent` VALUES ('5', '10', '159286', '小米手机', '123456', '成都', '1492929751', '1');
INSERT INTO `indent` VALUES ('11', '13', 'YML4NTJCE', '小米手机', '1111111', '江苏', '1493010451', '1');
INSERT INTO `indent` VALUES ('10', '11', 'R57NGB2XH', '小米手机', '987', '南京', '1493009921', '1');
INSERT INTO `indent` VALUES ('12', '13', 'K75RXQPSV', '小米手机', '132465', '成都', '1493010500', '0');
INSERT INTO `indent` VALUES ('13', '14', 'J6FQV3T8C', '小米手机', '132456', '测试', '1493011282', '0');

-- ----------------------------
-- Table structure for jie
-- ----------------------------
DROP TABLE IF EXISTS `jie`;
CREATE TABLE `jie` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `cj` varchar(255) NOT NULL COMMENT '充值',
  `zj` varchar(255) NOT NULL COMMENT '赠送',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jie
-- ----------------------------
INSERT INTO `jie` VALUES ('10', '10000', '10000');

-- ----------------------------
-- Table structure for markchangeshop
-- ----------------------------
DROP TABLE IF EXISTS `markchangeshop`;
CREATE TABLE `markchangeshop` (
  `product_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_name` varchar(50) NOT NULL,
  `product_detail` varchar(255) NOT NULL,
  `needed_mark` int(30) NOT NULL,
  `is_change` tinyint(5) unsigned NOT NULL DEFAULT '0',
  `store_amount` int(255) NOT NULL DEFAULT '0',
  `photo` varchar(255) NOT NULL,
  `thumb_photo` varchar(255) NOT NULL,
  `has_changed_amount` int(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of markchangeshop
-- ----------------------------
INSERT INTO `markchangeshop` VALUES ('11', '台灯', '台灯', '30', '0', '50', 'Admin/MarkChangeShopImgs/20170424/IT_58fd75cca4574.jpg', 'Admin/MarkChangeShopImgs/20170424/IT_58fd75cca4574_80x80.jpg', '0');

-- ----------------------------
-- Table structure for members
-- ----------------------------
DROP TABLE IF EXISTS `members`;
CREATE TABLE `members` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '员工ID',
  `username` varchar(20) NOT NULL COMMENT '员工名称',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `realname` varchar(20) NOT NULL COMMENT '真实姓名',
  `sex` varchar(30) DEFAULT '男',
  `telephone` int(20) NOT NULL COMMENT '电话',
  `last_login` int(11) NOT NULL COMMENT '最后登录时间',
  `last_loginip` varchar(20) NOT NULL COMMENT '最后登录ip',
  `group_id` int(20) DEFAULT NULL COMMENT '组ID',
  `is_admin` varchar(30) DEFAULT 'Y',
  `photo` varchar(255) NOT NULL COMMENT '头像',
  `thumb_photo` varchar(255) NOT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of members
-- ----------------------------
INSERT INTO `members` VALUES ('19', 'admin', '21232f297a57a5a743894a0e4a801fc3', '老板', '男', '2147483647', '1492912307', '::1', '1', 'Y', 'Admin/MembersImgs/20170423/IT_58fc08b35c4f9.jpg', 'Admin/MembersImgs/20170423/IT_58fc08b35c4f9_80x80.jpg');
INSERT INTO `members` VALUES ('21', '小张', 'e10adc3949ba59abbe56e057f20f883e', '张飞', '男', '123456', '1493004190', '127.0.0.1', '11', 'Y', 'Admin/MembersImgs/20170424/IT_58fd6f9e7da56.jpg', 'Admin/MembersImgs/20170424/IT_58fd6f9e7da56_80x80.jpg');

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '预约id',
  `phone` int(15) NOT NULL COMMENT '电话',
  `realname` varchar(5) NOT NULL COMMENT '姓名',
  `barber` int(100) NOT NULL COMMENT '预约美发师id',
  `content` varchar(255) DEFAULT NULL COMMENT '备注',
  `date` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '预约状态',
  `reply` varchar(255) NOT NULL COMMENT '回复信息',
  `user_id` int(10) NOT NULL COMMENT '会员id',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order
-- ----------------------------
INSERT INTO `order` VALUES ('1', '123456', '张三', '1', '染发', '0', '1', '预约成功', '0');
INSERT INTO `order` VALUES ('6', '123456', '12345', '21', '<p>烫发</p>', '1493395200', '1', '', '11');
INSERT INTO `order` VALUES ('7', '123', '李四', '21', '<p>&nbsp; &nbsp; &nbsp; &nbsp;这里写你需要的服务\r\n &nbsp; &nbsp;</p>', '1493136000', '1', '', '14');
INSERT INTO `order` VALUES ('8', '123', '李四', '19', '<p>&nbsp; &nbsp; &nbsp; &nbsp;这里写你需要的服务\r\n &nbsp; &nbsp;</p>', '1492531200', '1', '', '14');
INSERT INTO `order` VALUES ('9', '132', '测试账户', '21', '<p>&nbsp; &nbsp; &nbsp; &nbsp;这里写你需要的服务\r\n &nbsp; &nbsp;</p>', '1491926400', '0', '', '16');

-- ----------------------------
-- Table structure for plans
-- ----------------------------
DROP TABLE IF EXISTS `plans`;
CREATE TABLE `plans` (
  `plan_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '套餐id',
  `name` varchar(20) NOT NULL COMMENT '套餐名称',
  `des` varchar(255) NOT NULL COMMENT '套餐描述',
  `money` int(255) NOT NULL COMMENT '套餐金额',
  `status` int(1) DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`plan_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of plans
-- ----------------------------
INSERT INTO `plans` VALUES ('1', '洗剪吹', '洗头+箭头+吹', '50', '1');
INSERT INTO `plans` VALUES ('2', '烫发', '烫发', '100', '1');
INSERT INTO `plans` VALUES ('3', '焗油', '焗油让发质更好', '100', '1');
INSERT INTO `plans` VALUES ('4', '染发', '染发', '200', '1');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `users_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '会员ID',
  `username` varchar(20) NOT NULL COMMENT '会员名称',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `realname` varchar(20) NOT NULL COMMENT '真实姓名',
  `sex` varchar(30) DEFAULT '男',
  `telephone` int(20) NOT NULL COMMENT '电话',
  `remark` tinytext NOT NULL COMMENT '备注',
  `money` int(255) NOT NULL DEFAULT '0' COMMENT '余额',
  `is_vip` int(2) NOT NULL DEFAULT '0',
  `photo` varchar(255) NOT NULL COMMENT '头像',
  `thumb_photo` varchar(255) NOT NULL,
  `acc` int(50) NOT NULL DEFAULT '0' COMMENT '积分',
  PRIMARY KEY (`users_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('15', '测试2', 'e10adc3949ba59abbe56e057f20f883e', '测试2', '男', '123', '', '1009870', '5', 'Admin/UsersImgs/20170424/IT_58fda32d3cafa.jpg', 'Admin/UsersImgs/20170424/IT_58fda32d3cafa_80x80.jpg', '1000000');
INSERT INTO `users` VALUES ('14', '李四', '250cf8b51c773f3f8dc8b4be867a9a02', '李四', '男', '123', '', '350', '0', 'Admin/UsersImgs/20170424/IT_58fd89dfe3129.JPEG', 'Admin/UsersImgs/20170424/IT_58fd89dfe3129_80x80.JPEG', '500');
INSERT INTO `users` VALUES ('13', '测试', 'c56d0e9a7ccec67b4ea131655038d604', '测试', '男', '13465', '测试', '109564', '5', 'Admin/UsersImgs/20170424/IT_58fda2c717dc0.jpg', 'Admin/UsersImgs/20170424/IT_58fda2c717dc0_80x80.jpg', '100080');
INSERT INTO `users` VALUES ('16', '测试账户', '202cb962ac59075b964b07152d234b70', '测试账户', '男', '132', '', '0', '0', 'Admin/UsersImgs/20170424/IT_58fdaa9acf1d0.jpg', 'Admin/UsersImgs/20170424/IT_58fdaa9acf1d0_80x80.jpg', '0');

-- ----------------------------
-- Table structure for vip
-- ----------------------------
DROP TABLE IF EXISTS `vip`;
CREATE TABLE `vip` (
  `vip_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `zhekou` varchar(20) NOT NULL,
  `InMoney` varchar(50) NOT NULL,
  `rank` varchar(10) NOT NULL,
  PRIMARY KEY (`vip_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of vip
-- ----------------------------
INSERT INTO `vip` VALUES ('1', '0.9', '5000', '1');
INSERT INTO `vip` VALUES ('2', '0.8', '10000', '2');
INSERT INTO `vip` VALUES ('3', '0.75', '20000', '3');
INSERT INTO `vip` VALUES ('4', '0.7', '25000', '4');
INSERT INTO `vip` VALUES ('5', '0.65', '30000', '5');
