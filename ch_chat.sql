/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : 127.0.0.1:3306
Source Database       : ch_chat

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2017-02-26 02:09:53
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ch_collect
-- ----------------------------
DROP TABLE IF EXISTS `ch_collect`;
CREATE TABLE `ch_collect` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `moodID` int(11) NOT NULL DEFAULT '0',
  `createtime` int(1) DEFAULT '0',
  `display` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ch_collect
-- ----------------------------
INSERT INTO `ch_collect` VALUES ('1', '11', '3', '1486463717', '0');
INSERT INTO `ch_collect` VALUES ('2', '11', '3', '1486463720', '0');
INSERT INTO `ch_collect` VALUES ('3', '11', '3', '1486463809', '0');
INSERT INTO `ch_collect` VALUES ('4', '11', '3', '1486463863', '0');
INSERT INTO `ch_collect` VALUES ('5', '11', '3', '1486463888', '0');
INSERT INTO `ch_collect` VALUES ('6', '11', '3', '1486464015', '0');
INSERT INTO `ch_collect` VALUES ('7', '11', '4', '1486464201', '0');
INSERT INTO `ch_collect` VALUES ('8', '11', '4', '1486646979', '1');
INSERT INTO `ch_collect` VALUES ('9', '11', '3', '1486646981', '1');

-- ----------------------------
-- Table structure for ch_comment
-- ----------------------------
DROP TABLE IF EXISTS `ch_comment`;
CREATE TABLE `ch_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `moodID` int(11) NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `createtime` int(11) DEFAULT '0',
  `display` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ch_comment
-- ----------------------------
INSERT INTO `ch_comment` VALUES ('1', '11', '3', '那你很棒哦', '1484720835', '0');
INSERT INTO `ch_comment` VALUES ('3', '11', '3', '哦哦哦', '1486647755', '0');
INSERT INTO `ch_comment` VALUES ('4', '11', '4', '你好啊', '1486647762', '0');

-- ----------------------------
-- Table structure for ch_favorite
-- ----------------------------
DROP TABLE IF EXISTS `ch_favorite`;
CREATE TABLE `ch_favorite` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `moodID` int(11) NOT NULL DEFAULT '0',
  `createtime` int(1) DEFAULT '0',
  `display` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ch_favorite
-- ----------------------------
INSERT INTO `ch_favorite` VALUES ('12', '11', '4', '1486653175', '0');
INSERT INTO `ch_favorite` VALUES ('13', '11', '5', '1487995516', '0');
INSERT INTO `ch_favorite` VALUES ('3', '11', '1', '1484742614', '0');
INSERT INTO `ch_favorite` VALUES ('4', '11', '1', '1484742619', '0');
INSERT INTO `ch_favorite` VALUES ('5', '11', '1', '1484742621', '0');
INSERT INTO `ch_favorite` VALUES ('6', '11', '1', '1484742630', '0');
INSERT INTO `ch_favorite` VALUES ('7', '11', '2', '1484743145', '1');
INSERT INTO `ch_favorite` VALUES ('8', '11', '1', '1484743159', '1');
INSERT INTO `ch_favorite` VALUES ('9', '11', '3', '1486401662', '0');
INSERT INTO `ch_favorite` VALUES ('10', '11', '4', '1486401664', '0');
INSERT INTO `ch_favorite` VALUES ('11', '11', '3', '1486463069', '0');
INSERT INTO `ch_favorite` VALUES ('14', '11', '4', '1488039014', '1');

-- ----------------------------
-- Table structure for ch_friend
-- ----------------------------
DROP TABLE IF EXISTS `ch_friend`;
CREATE TABLE `ch_friend` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `fid` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(4) DEFAULT '1',
  `createtime` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
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
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `createtime` int(1) DEFAULT '0',
  `display` tinyint(4) DEFAULT '0',
  `link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ch_link
-- ----------------------------
INSERT INTO `ch_link` VALUES ('6', 'TP官网', '1486481314', '1', 'http://www.thinkphp.cn/');
INSERT INTO `ch_link` VALUES ('5', '百度一下', '1486479913', '1', 'http://www.baidu.com');

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
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '',
  `createtime` int(1) DEFAULT '0',
  `logo` varchar(255) DEFAULT '',
  `display` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ch_sysinfo
-- ----------------------------
INSERT INTO `ch_sysinfo` VALUES ('1', '龙岩学院交流社区', '1486792614', '2017-02-11/589ebd4dca9e5.jpg', '1');

-- ----------------------------
-- Table structure for ch_user
-- ----------------------------
DROP TABLE IF EXISTS `ch_user`;
CREATE TABLE `ch_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` char(32) NOT NULL,
  `sex` enum('2','1','0') NOT NULL DEFAULT '0',
  `age` int(10) unsigned NOT NULL DEFAULT '0',
  `icon` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `identity` tinyint(4) DEFAULT '1' COMMENT '1学生2老师',
  `department` varchar(20) NOT NULL DEFAULT '信息工程学院',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ch_user
-- ----------------------------
INSERT INTO `ch_user` VALUES ('1', 'admin', '4297f44b13955235245b2497399d7a93', '2', '0', null, '3', '1', '化学与材料学院');
INSERT INTO `ch_user` VALUES ('11', 'user', '4297f44b13955235245b2497399d7a93', '1', '6', '2017-02-11/589eb7ec718f8.gif', '1', '1', '文学与传媒学院');
INSERT INTO `ch_user` VALUES ('12', 'first', 'e10adc3949ba59abbe56e057f20f883e', '1', '16', null, '1', '1', '信息工程学院');
INSERT INTO `ch_user` VALUES ('13', '管理员', 'e10adc3949ba59abbe56e057f20f883e', '1', '19', null, '2', '1', '信息工程学院');
INSERT INTO `ch_user` VALUES ('15', '第二个', 'e10adc3949ba59abbe56e057f20f883e', '1', '12', null, '1', '1', '信息工程学院');
INSERT INTO `ch_user` VALUES ('16', '第三个', 'e10adc3949ba59abbe56e057f20f883e', '1', '13', null, '1', '1', '信息工程学院');
INSERT INTO `ch_user` VALUES ('17', '第四个', 'e10adc3949ba59abbe56e057f20f883e', '1', '0', null, '1', '1', '信息工程学院');
INSERT INTO `ch_user` VALUES ('18', '第五个', 'e10adc3949ba59abbe56e057f20f883e', '2', '0', null, '1', '1', '信息工程学院');
INSERT INTO `ch_user` VALUES ('19', '第六个', 'e10adc3949ba59abbe56e057f20f883e', '1', '19', null, '1', '1', '信息工程学院');
INSERT INTO `ch_user` VALUES ('20', '第七个', 'e10adc3949ba59abbe56e057f20f883e', '1', '0', null, '1', '1', '信息工程学院');
INSERT INTO `ch_user` VALUES ('21', '第八个', 'e10adc3949ba59abbe56e057f20f883e', '1', '0', null, '1', '1', '信息工程学院');
INSERT INTO `ch_user` VALUES ('22', '瞅你咋滴', 'e10adc3949ba59abbe56e057f20f883e', '1', '13', null, '1', '1', '信息工程学院');
INSERT INTO `ch_user` VALUES ('23', 'boom', 'e10adc3949ba59abbe56e057f20f883e', '2', '0', null, '1', '1', '信息工程学院');
