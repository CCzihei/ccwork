/*
Navicat MySQL Data Transfer

Source Server         : wamp3.1
Source Server Version : 50719
Source Host           : localhost:3306
Source Database       : ch_chat

Target Server Type    : MYSQL
Target Server Version : 50719
File Encoding         : 65001

Date: 2018-02-02 02:42:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ch_admin
-- ----------------------------
DROP TABLE IF EXISTS `ch_admin`;
CREATE TABLE `ch_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员名称',
  `password` char(35) NOT NULL DEFAULT '' COMMENT '密码',
  `operator` varchar(50) NOT NULL DEFAULT '' COMMENT '操作人',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modified_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后修改时间',
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `uni_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ch_admin
-- ----------------------------
INSERT INTO `ch_admin` VALUES ('1', 'admin', 'bde3c7679b99822a4a6f52a553b79125|B@', '陈作海', '0', '0');

-- ----------------------------
-- Table structure for ch_collect
-- ----------------------------
DROP TABLE IF EXISTS `ch_collect`;
CREATE TABLE `ch_collect` (
  `collect_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `mood_id` int(11) NOT NULL DEFAULT '0' COMMENT '动态ID',
  `display` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否展示1：是0：否',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`collect_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ch_collect
-- ----------------------------
INSERT INTO `ch_collect` VALUES ('1', '11', '3', '0', '1486463717');
INSERT INTO `ch_collect` VALUES ('2', '11', '3', '0', '1486463720');
INSERT INTO `ch_collect` VALUES ('3', '11', '3', '0', '1486463809');
INSERT INTO `ch_collect` VALUES ('4', '11', '3', '0', '1486463863');
INSERT INTO `ch_collect` VALUES ('5', '11', '3', '0', '1486463888');
INSERT INTO `ch_collect` VALUES ('6', '11', '3', '0', '1486464015');
INSERT INTO `ch_collect` VALUES ('7', '11', '4', '0', '1486464201');
INSERT INTO `ch_collect` VALUES ('8', '11', '4', '1', '1486646979');
INSERT INTO `ch_collect` VALUES ('9', '11', '3', '1', '1486646981');

-- ----------------------------
-- Table structure for ch_comment
-- ----------------------------
DROP TABLE IF EXISTS `ch_comment`;
CREATE TABLE `ch_comment` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `mood_id` int(11) NOT NULL DEFAULT '0' COMMENT '动态ID',
  `content` varchar(500) NOT NULL DEFAULT '' COMMENT '评论内容',
  `display` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否展示1：是0：否',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ch_comment
-- ----------------------------
INSERT INTO `ch_comment` VALUES ('1', '11', '3', '那你很棒哦', '0', '1484720835');
INSERT INTO `ch_comment` VALUES ('3', '11', '3', '哦哦哦', '0', '1486647755');
INSERT INTO `ch_comment` VALUES ('4', '11', '4', '你好啊', '0', '1486647762');

-- ----------------------------
-- Table structure for ch_favorite
-- ----------------------------
DROP TABLE IF EXISTS `ch_favorite`;
CREATE TABLE `ch_favorite` (
  `favorite_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `mood_id` int(11) NOT NULL DEFAULT '0' COMMENT '动态id',
  `display` tinyint(1) DEFAULT '1' COMMENT '是否展示1：是0：否',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`favorite_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ch_favorite
-- ----------------------------
INSERT INTO `ch_favorite` VALUES ('12', '11', '4', '0', '1486653175');
INSERT INTO `ch_favorite` VALUES ('13', '11', '5', '0', '1487995516');
INSERT INTO `ch_favorite` VALUES ('3', '11', '1', '0', '1484742614');
INSERT INTO `ch_favorite` VALUES ('4', '11', '1', '0', '1484742619');
INSERT INTO `ch_favorite` VALUES ('5', '11', '1', '0', '1484742621');
INSERT INTO `ch_favorite` VALUES ('6', '11', '1', '0', '1484742630');
INSERT INTO `ch_favorite` VALUES ('7', '11', '2', '1', '1484743145');
INSERT INTO `ch_favorite` VALUES ('8', '11', '1', '1', '1484743159');
INSERT INTO `ch_favorite` VALUES ('9', '11', '3', '0', '1486401662');
INSERT INTO `ch_favorite` VALUES ('10', '11', '4', '0', '1486401664');
INSERT INTO `ch_favorite` VALUES ('11', '11', '3', '0', '1486463069');
INSERT INTO `ch_favorite` VALUES ('14', '11', '4', '1', '1488039014');

-- ----------------------------
-- Table structure for ch_friend
-- ----------------------------
DROP TABLE IF EXISTS `ch_friend`;
CREATE TABLE `ch_friend` (
  `friend_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `friend_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '好友用户id',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`friend_id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ch_friend
-- ----------------------------
INSERT INTO `ch_friend` VALUES ('44', '23', '23', '2', '1486708317');
INSERT INTO `ch_friend` VALUES ('45', '12', '11', '2', '1487591016');
INSERT INTO `ch_friend` VALUES ('42', '11', '11', '2', '0');
INSERT INTO `ch_friend` VALUES ('43', '22', '22', '2', '1486708246');
INSERT INTO `ch_friend` VALUES ('41', '15', '11', '2', '0');
INSERT INTO `ch_friend` VALUES ('40', '11', '15', '2', '1486660787');
INSERT INTO `ch_friend` VALUES ('46', '11', '12', '2', '0');

-- ----------------------------
-- Table structure for ch_link
-- ----------------------------
DROP TABLE IF EXISTS `ch_link`;
CREATE TABLE `ch_link` (
  `link_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '地址名称',
  `status` tinyint(4) DEFAULT '0' COMMENT '状态1：可使用0：不可使用',
  `link` varchar(1000) DEFAULT '' COMMENT '链接地址',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `modified_time` int(11) DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ch_link
-- ----------------------------
INSERT INTO `ch_link` VALUES ('6', 'TP官网', '1', 'http://www.thinkphp.cn/', '1486481314', null);
INSERT INTO `ch_link` VALUES ('5', '百度一下', '1', 'http://www.baidu.com', '1486479913', null);

-- ----------------------------
-- Table structure for ch_mood
-- ----------------------------
DROP TABLE IF EXISTS `ch_mood`;
CREATE TABLE `ch_mood` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `content` text NOT NULL,
  `createtime` int(11) DEFAULT '0',
  `display` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ch_mood
-- ----------------------------
INSERT INTO `ch_mood` VALUES ('5', '15', '哦哦哦哦', '1486655751', '1');
INSERT INTO `ch_mood` VALUES ('4', '11', '很是开心哦\r\n', '1486276918', '1');
INSERT INTO `ch_mood` VALUES ('3', '12', '这是开心的日子 ', '1484720380', '1');
INSERT INTO `ch_mood` VALUES ('6', '16', '你好 啊你好啊你好啊', '1486707523', '1');
INSERT INTO `ch_mood` VALUES ('7', '23', '事实上', '1486708381', '1');

-- ----------------------------
-- Table structure for ch_sysinfo
-- ----------------------------
DROP TABLE IF EXISTS `ch_sysinfo`;
CREATE TABLE `ch_sysinfo` (
  `sysinfo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '配置键',
  `value` varchar(255) NOT NULL DEFAULT '' COMMENT '配置值',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modified_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后修改时间',
  PRIMARY KEY (`sysinfo_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ch_sysinfo
-- ----------------------------
INSERT INTO `ch_sysinfo` VALUES ('1', 'name', 'Vchat', '0', '0');
INSERT INTO `ch_sysinfo` VALUES ('3', 'logo', '0', '0', '0');

-- ----------------------------
-- Table structure for ch_user
-- ----------------------------
DROP TABLE IF EXISTS `ch_user`;
CREATE TABLE `ch_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '姓名',
  `password` char(35) NOT NULL COMMENT '密码',
  `sex` tinyint(4) NOT NULL DEFAULT '0' COMMENT '性别',
  `age` int(10) unsigned NOT NULL DEFAULT '0',
  `icon` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  `identity` tinyint(4) NOT NULL DEFAULT '1' COMMENT '身份1学生2老师',
  `department` varchar(20) NOT NULL DEFAULT '信息工程学院' COMMENT '院系',
  `operator` varchar(50) NOT NULL DEFAULT '' COMMENT '操作人',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `modified_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后修改时间',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ch_user
-- ----------------------------
INSERT INTO `ch_user` VALUES ('1', 'admin', '4297f44b13955235245b2497399d7a93', '1', '0', '1', '3', '1', '化学与材料学院', '', '0', '0');
INSERT INTO `ch_user` VALUES ('11', 'user', '4297f44b13955235245b2497399d7a93', '2', '6', '1', '1', '1', '文学与传媒学院', '', '0', '0');
INSERT INTO `ch_user` VALUES ('12', 'first', 'e10adc3949ba59abbe56e057f20f883e', '2', '16', '1', '0', '1', '信息工程学院', '', '0', '0');
INSERT INTO `ch_user` VALUES ('13', '管理员', 'e10adc3949ba59abbe56e057f20f883e', '2', '19', '1', '2', '1', '信息工程学院', '', '0', '0');
INSERT INTO `ch_user` VALUES ('15', '第二个', 'e10adc3949ba59abbe56e057f20f883e', '2', '12', '1', '1', '1', '信息工程学院', '', '0', '0');
INSERT INTO `ch_user` VALUES ('16', '第三个', 'e10adc3949ba59abbe56e057f20f883e', '2', '13', '1', '1', '1', '信息工程学院', '', '0', '0');
INSERT INTO `ch_user` VALUES ('17', '第四个', 'e10adc3949ba59abbe56e057f20f883e', '2', '0', '1', '1', '1', '信息工程学院', '', '0', '0');
INSERT INTO `ch_user` VALUES ('18', '第五个', 'e10adc3949ba59abbe56e057f20f883e', '1', '0', '1', '1', '1', '信息工程学院', '', '0', '0');
INSERT INTO `ch_user` VALUES ('19', '第六个', 'e10adc3949ba59abbe56e057f20f883e', '2', '19', '1', '1', '1', '信息工程学院', '', '0', '0');
INSERT INTO `ch_user` VALUES ('20', '第七个', 'e10adc3949ba59abbe56e057f20f883e', '2', '0', '1', '1', '1', '信息工程学院', '', '0', '0');
INSERT INTO `ch_user` VALUES ('21', '第八个', 'e10adc3949ba59abbe56e057f20f883e', '2', '0', '1', '1', '1', '信息工程学院', '', '0', '0');
INSERT INTO `ch_user` VALUES ('22', '瞅你咋滴', 'e10adc3949ba59abbe56e057f20f883e', '2', '13', '1', '1', '1', '信息工程学院', '', '0', '0');
INSERT INTO `ch_user` VALUES ('23', 'boom', 'e10adc3949ba59abbe56e057f20f883e', '1', '0', '1', '1', '1', '信息工程学院', '', '0', '0');
