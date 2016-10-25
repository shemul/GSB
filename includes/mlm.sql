/*
Navicat MySQL Data Transfer

Source Server         : INDOWEB EMPTY
Source Server Version : 50546
Source Host           : indowebdeveloper.com:3306
Source Database       : indoweb_empty

Target Server Type    : MYSQL
Target Server Version : 50546
File Encoding         : 65001

Date: 2016-01-04 12:08:57
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for bonus_date_logs
-- ----------------------------
DROP TABLE IF EXISTS `bonus_date_logs`;
CREATE TABLE `bonus_date_logs` (
  `date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of bonus_date_logs
-- ----------------------------

-- ----------------------------
-- Table structure for devident_log
-- ----------------------------
DROP TABLE IF EXISTS `devident_log`;
CREATE TABLE `devident_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `nominal` float(255,0) DEFAULT NULL,
  `opendate` datetime DEFAULT NULL,
  `closedate` datetime DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of devident_log
-- ----------------------------

-- ----------------------------
-- Table structure for devident_timeline
-- ----------------------------
DROP TABLE IF EXISTS `devident_timeline`;
CREATE TABLE `devident_timeline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `devident_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `percentage` float(10,3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of devident_timeline
-- ----------------------------

-- ----------------------------
-- Table structure for fund_transaction
-- ----------------------------
DROP TABLE IF EXISTS `fund_transaction`;
CREATE TABLE `fund_transaction` (
  `date` datetime DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `nominal` float(255,3) DEFAULT NULL,
  `from_id` int(255) DEFAULT NULL COMMENT 'From User ID',
  `details` text,
  `to_id` int(255) DEFAULT NULL COMMENT 'To User ID',
  `trans_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`trans_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of fund_transaction
-- ----------------------------

-- ----------------------------
-- Table structure for genealogy
-- ----------------------------
DROP TABLE IF EXISTS `genealogy`;
CREATE TABLE `genealogy` (
  `uid` int(11) DEFAULT NULL,
  `parentid` int(11) DEFAULT NULL,
  `sponsorid` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of genealogy
-- ----------------------------

-- ----------------------------
-- Table structure for holiday
-- ----------------------------
DROP TABLE IF EXISTS `holiday`;
CREATE TABLE `holiday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of holiday
-- ----------------------------
INSERT INTO `holiday` VALUES ('1', '2015-02-19', 'Imlek');
INSERT INTO `holiday` VALUES ('2', '2015-03-21', 'Hari Raya Nyepi');
INSERT INTO `holiday` VALUES ('3', '2015-04-03', 'Wafatnya Yesus Kristus ( Jumat Agung )');
INSERT INTO `holiday` VALUES ('4', '2015-05-01', 'Hari Buruh International');
INSERT INTO `holiday` VALUES ('5', '2015-05-14', 'Kenaikan Yesus Kristus');
INSERT INTO `holiday` VALUES ('6', '2015-05-16', 'Israj Miraj');
INSERT INTO `holiday` VALUES ('7', '2015-06-02', 'Hari Raya Waisak');
INSERT INTO `holiday` VALUES ('8', '2015-07-17', 'Idul Fitri');
INSERT INTO `holiday` VALUES ('9', '2015-07-18', 'Idul Fitri');
INSERT INTO `holiday` VALUES ('10', '2015-08-17', 'Hari Kemerdekaan Indonesia');
INSERT INTO `holiday` VALUES ('11', '2015-09-24', 'Idul Adha');
INSERT INTO `holiday` VALUES ('12', '2015-10-14', 'Tahun Baru Islam 1437 Hijriyah');
INSERT INTO `holiday` VALUES ('13', '2015-12-25', 'Hari Raya Natal');

-- ----------------------------
-- Table structure for invoice
-- ----------------------------
DROP TABLE IF EXISTS `invoice`;
CREATE TABLE `invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` varchar(200) NOT NULL,
  `status` int(11) NOT NULL COMMENT '1 COMPLETED 0 PENDING',
  `date` datetime NOT NULL,
  `buyer` int(11) NOT NULL,
  `gateway` varchar(11) NOT NULL,
  `amount` float(255,3) NOT NULL,
  `notes` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of invoice
-- ----------------------------

-- ----------------------------
-- Table structure for login_log
-- ----------------------------
DROP TABLE IF EXISTS `login_log`;
CREATE TABLE `login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of login_log
-- ----------------------------

-- ----------------------------
-- Table structure for pairing_log
-- ----------------------------
DROP TABLE IF EXISTS `pairing_log`;
CREATE TABLE `pairing_log` (
  `idUser` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `left` float(255,0) DEFAULT NULL,
  `right` float(255,0) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pairing_log
-- ----------------------------

-- ----------------------------
-- Table structure for product
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) DEFAULT NULL,
  `value` float DEFAULT NULL,
  `devident_rate` varchar(255) DEFAULT NULL,
  `max_pairing` float(255,0) DEFAULT NULL,
  `reward` int(11) DEFAULT NULL,
  `referral_rate` int(255) DEFAULT NULL,
  `disable` int(255) DEFAULT '0',
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES ('1', 'METAL', '0', '1.25/0.50', '100', '0', '8', '1');

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(2550) DEFAULT NULL,
  `value` varchar(2550) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of settings
-- ----------------------------

-- ----------------------------
-- Table structure for type_transaction
-- ----------------------------
DROP TABLE IF EXISTS `type_transaction`;
CREATE TABLE `type_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of type_transaction
-- ----------------------------
INSERT INTO `type_transaction` VALUES ('1', 'TRANSFER');
INSERT INTO `type_transaction` VALUES ('2', 'FUND TO REGISTER FUND  CONVERSION');
INSERT INTO `type_transaction` VALUES ('3', 'REGISTER DEVIDENT');
INSERT INTO `type_transaction` VALUES ('4', 'PAIRING BONUS');
INSERT INTO `type_transaction` VALUES ('5', 'DEVIDENT BONUS');
INSERT INTO `type_transaction` VALUES ('6', 'SPONSOR BONUS');
INSERT INTO `type_transaction` VALUES ('7', 'DEVIDENT CLOSING');
INSERT INTO `type_transaction` VALUES ('8', 'WITHDRAWAL DEDUCTION ( FUNDS )');
INSERT INTO `type_transaction` VALUES ('9', 'NEW MEMBER FEE ( DEDUCT FROM REGISTER FUND )');
INSERT INTO `type_transaction` VALUES ('10', 'TRANSFER REGISTER FUND');

-- ----------------------------
-- Table structure for user_bank
-- ----------------------------
DROP TABLE IF EXISTS `user_bank`;
CREATE TABLE `user_bank` (
  `uid` int(11) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `branch_name` varchar(255) NOT NULL,
  `acnumber` varchar(255) NOT NULL,
  `bankholder` varchar(255) DEFAULT NULL,
  `swiftcode` varchar(255) DEFAULT NULL,
  `bank_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`bank_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_bank
-- ----------------------------

-- ----------------------------
-- Table structure for user_detail
-- ----------------------------
DROP TABLE IF EXISTS `user_detail`;
CREATE TABLE `user_detail` (
  `uid` int(30) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `email` varchar(40) NOT NULL,
  `mobile` text NOT NULL,
  `phone` text NOT NULL,
  `state` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `zip` text NOT NULL,
  `address` text NOT NULL,
  `relation` varchar(255) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `beneficiary` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_detail
-- ----------------------------

-- ----------------------------
-- Table structure for user_id
-- ----------------------------
DROP TABLE IF EXISTS `user_id`;
CREATE TABLE `user_id` (
  `uname` varchar(25) NOT NULL,
  `password` varchar(60) NOT NULL,
  `pin` varchar(60) NOT NULL,
  `register_date` date NOT NULL,
  `role` int(255) NOT NULL,
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `product` int(255) DEFAULT NULL,
  `banned` int(11) DEFAULT '0',
  `paired` int(255) DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user_id
-- ----------------------------

-- ----------------------------
-- Table structure for withdrawal
-- ----------------------------
DROP TABLE IF EXISTS `withdrawal`;
CREATE TABLE `withdrawal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `nominal` varchar(255) DEFAULT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `paid_date` datetime DEFAULT NULL,
  `pendregs` float(255,3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;