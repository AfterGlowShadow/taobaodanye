/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : tb_fangtaobao

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-11-19 20:36:36
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `wp_app_attribute_classify`
-- ----------------------------
DROP TABLE IF EXISTS `wp_app_attribute_classify`;
CREATE TABLE `wp_app_attribute_classify` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(50) DEFAULT NULL COMMENT '产品分类名称',
  `pga` int(11) DEFAULT '0' COMMENT '父亲分类id',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT '0',
  `level` int(3) DEFAULT NULL COMMENT '层级(表明第几层)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COMMENT='商品分类\r\n@name 分类\r\n@is_api 1\r\n@is_show 1\r\n@is_auth 1';

-- ----------------------------
-- Records of wp_app_attribute_classify
-- ----------------------------
INSERT INTO `wp_app_attribute_classify` VALUES ('1', '3232', '0', '1574159753', '1574163659', '1574163659', '2');
INSERT INTO `wp_app_attribute_classify` VALUES ('2', 'admin', '0', '1574159806', '1574166862', '0', '2');
INSERT INTO `wp_app_attribute_classify` VALUES ('3', 'admin', '1', '1574160105', '1574160105', '0', null);
INSERT INTO `wp_app_attribute_classify` VALUES ('4', 'test', '1', '1574162382', '1574162382', '0', null);
INSERT INTO `wp_app_attribute_classify` VALUES ('5', 'test', '1', '1574162545', '1574162545', '0', '1');
INSERT INTO `wp_app_attribute_classify` VALUES ('6', 'test', '1', '1574162923', '1574162923', '0', '1');
INSERT INTO `wp_app_attribute_classify` VALUES ('9', '3232', '1', '1574166624', '1574166624', '0', '0');
INSERT INTO `wp_app_attribute_classify` VALUES ('10', 'test1', '1', '1574166783', '1574166783', '0', '1');

-- ----------------------------
-- Table structure for `wp_app_attribute_goodspecis`
-- ----------------------------
DROP TABLE IF EXISTS `wp_app_attribute_goodspecis`;
CREATE TABLE `wp_app_attribute_goodspecis` (
  `id` int(11) NOT NULL DEFAULT '0',
  `goodsid` int(11) DEFAULT NULL COMMENT '商品id',
  `specsidl` varchar(50) DEFAULT NULL COMMENT '规格id列表',
  `price` int(11) DEFAULT NULL COMMENT '真实价格',
  `zprice` int(11) DEFAULT NULL COMMENT '折扣价格',
  `img` varchar(255) DEFAULT NULL COMMENT '图片地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='货物规格中间表\r\n@name 货物规格\r\n@is_api 1\r\n@is_show 1\r\n@is_auth 1';

-- ----------------------------
-- Records of wp_app_attribute_goodspecis
-- ----------------------------

-- ----------------------------
-- Table structure for `wp_app_attribute_specs`
-- ----------------------------
DROP TABLE IF EXISTS `wp_app_attribute_specs`;
CREATE TABLE `wp_app_attribute_specs` (
  `id` int(11) NOT NULL DEFAULT '0',
  `name` char(50) DEFAULT NULL COMMENT '规格名称',
  `classifyid` int(11) DEFAULT NULL COMMENT '所属分类id',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT '0',
  `classify` int(11) DEFAULT NULL COMMENT '所属分类',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='商品规格\r\n@name 规格\r\n@is_api 1\r\n@is_show 1\r\n@is_auth 1';

-- ----------------------------
-- Records of wp_app_attribute_specs
-- ----------------------------

-- ----------------------------
-- Table structure for `wp_app_tb`
-- ----------------------------
DROP TABLE IF EXISTS `wp_app_tb`;
CREATE TABLE `wp_app_tb` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(255) NOT NULL COMMENT '编号',
  `user_id` int(11) NOT NULL COMMENT '出售人id',
  `user_name` varchar(255) NOT NULL COMMENT '出售人名称',
  `product_name` varchar(255) NOT NULL COMMENT '商品名',
  `company_type` int(10) NOT NULL COMMENT '企业类型',
  `company_type_name` varchar(255) NOT NULL COMMENT '企业类型名称',
  `company_name` varchar(255) NOT NULL COMMENT '企业名称',
  `city` varchar(255) NOT NULL COMMENT '市',
  `county` varchar(255) NOT NULL COMMENT '县',
  `phone` varchar(255) NOT NULL COMMENT '手机',
  `credit_code` varchar(255) NOT NULL COMMENT '注册号/统一社会信用代码',
  `pay_taxes` varchar(255) NOT NULL COMMENT '纳税类型',
  `pay_taxes_type` int(11) NOT NULL COMMENT '纳税类型id',
  `declare_tax` varchar(255) NOT NULL COMMENT '报税情况',
  `declare_tax_type` int(11) NOT NULL COMMENT '报税情况id',
  `recive_invoice` int(11) NOT NULL COMMENT '是否申领过发票 1否 2是',
  `internetbank` int(11) NOT NULL COMMENT '有无网银 1有 2否',
  `bank_account` varchar(255) NOT NULL COMMENT '银行账户',
  `bank_account_type` int(11) NOT NULL COMMENT '银行账户 1已开基本户 2未开基本户',
  `sell_price` decimal(10,2) NOT NULL COMMENT '出售金额 元',
  `qq` varchar(255) NOT NULL COMMENT '联系qq',
  `status` int(10) NOT NULL DEFAULT '1' COMMENT '状态 1待审核 2在售中的企业 3交接中的企业 4已售出的企业 5拒绝',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '修改时间',
  `delete_time` int(11) NOT NULL COMMENT '删除时间',
  `industry_type` int(11) NOT NULL COMMENT '所属行业id',
  `industry_name` varchar(255) NOT NULL COMMENT '所属行业名',
  `industry_second_type` int(11) NOT NULL COMMENT '所属行业二级id',
  `industry_second_name` varchar(255) NOT NULL COMMENT '求购行业名二级',
  `establishment` varchar(255) NOT NULL COMMENT '成立日期',
  `registered_capital` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '注册资本',
  `contributed_capital` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实缴资本',
  `business_license` varchar(255) NOT NULL COMMENT '营业执照图片',
  `legal_person` varchar(255) NOT NULL COMMENT '法人姓名',
  `business_scope` text NOT NULL COMMENT '经营范围',
  `other_infomation` text NOT NULL COMMENT '其他信息',
  `view_num` int(11) NOT NULL COMMENT '浏览量',
  `celection_num` int(11) NOT NULL COMMENT '收藏量',
  `publish_time` int(11) NOT NULL COMMENT '发布时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='宣传页\r\n@name 宣传页\r\n@is_api 1\r\n@is_show 1\r\n@is_auth 1';

-- ----------------------------
-- Records of wp_app_tb
-- ----------------------------
INSERT INTO `wp_app_tb` VALUES ('1', 'dxbgfhfgchjn4', '6', '垂死病中惊坐起', '的股份的时代', '3', '打广告', '河北伟湃网络科技有限公司', 'jjj ', 'sdfgs', '13612341234', '21212534153214235', '1212', '0', '12', '1', '1', '1', '1', '1', '1.00', '111111111', '2', '1', '1573811485', '0', '1', '1212', '1', '1', '1', '1.00', '1.00', '/uploads/b6/fe0d485e186b58cad217ea6704f239.png', '1', '1', '1', '1', '0', '0');
INSERT INTO `wp_app_tb` VALUES ('3', '', '0', '', '', '0', '', '', '', '', '', '', '', '0', '', '0', '0', '0', '', '0', '0.00', '', '1', '0', '1573811390', '1573811390', '0', '', '0', '', '', '0.00', '0.00', '', '', '', '', '0', '0', '0');

-- ----------------------------
-- Table structure for `wp_app_tb_banner`
-- ----------------------------
DROP TABLE IF EXISTS `wp_app_tb_banner`;
CREATE TABLE `wp_app_tb_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL COMMENT '轮播图地址(外网)',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT '0',
  `goodsid` int(11) DEFAULT NULL COMMENT '商品id',
  `img` varchar(255) DEFAULT NULL COMMENT '图片地址',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `status` tinyint(3) DEFAULT '1' COMMENT '状态（0-未知 1-启用 2-禁用）',
  `intro` varchar(255) DEFAULT NULL COMMENT '简介',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='轮播图\r\n@name 轮播图\r\n@is_api 1\r\n@is_show 1\r\n@is_auth 1';

-- ----------------------------
-- Records of wp_app_tb_banner
-- ----------------------------

-- ----------------------------
-- Table structure for `wp_app_tb_goods`
-- ----------------------------
DROP TABLE IF EXISTS `wp_app_tb_goods`;
CREATE TABLE `wp_app_tb_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goodsname` varchar(50) DEFAULT NULL COMMENT '商品名称',
  `price` int(10) DEFAULT NULL COMMENT '价格',
  `title` varchar(50) DEFAULT NULL COMMENT '标题',
  `description` varchar(100) DEFAULT NULL COMMENT '描述',
  `content` text COMMENT '详情',
  `modelid` varchar(255) DEFAULT NULL COMMENT '宣传模型id',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT '0',
  `classify` int(11) DEFAULT NULL COMMENT '商品分类id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='商品\r\n@name 商品\r\n@is_api 1\r\n@is_show 1\r\n@is_auth 1';

-- ----------------------------
-- Records of wp_app_tb_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `wp_app_tb_model`
-- ----------------------------
DROP TABLE IF EXISTS `wp_app_tb_model`;
CREATE TABLE `wp_app_tb_model` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='宣传页模型\r\n@name 宣传页模板\r\n@is_api 1\r\n@is_show 1\r\n@is_auth 1';

-- ----------------------------
-- Records of wp_app_tb_model
-- ----------------------------

-- ----------------------------
-- Table structure for `wp_app_tb_order`
-- ----------------------------
DROP TABLE IF EXISTS `wp_app_tb_order`;
CREATE TABLE `wp_app_tb_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` int(11) DEFAULT NULL COMMENT '收件人手机号',
  `address` varchar(255) DEFAULT NULL COMMENT '寄货地址',
  `productid` int(11) DEFAULT NULL COMMENT '商品id',
  `price` int(11) DEFAULT '0' COMMENT '价格',
  `create_time` varchar(14) DEFAULT NULL COMMENT '创建时间',
  `pay_time` varchar(14) DEFAULT NULL COMMENT '支付时间',
  `status` int(1) DEFAULT '0' COMMENT '支付状态0未支付 1支付成功 2支付中 3待审核 4支付失败',
  `ordersn` varchar(50) DEFAULT NULL COMMENT '订单编号',
  `orderoutsn` varchar(50) DEFAULT NULL COMMENT '外部订单编号',
  `number` int(50) DEFAULT '0' COMMENT '购买产品数量',
  `typeid` int(11) DEFAULT '0' COMMENT '产品类型id',
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='订单\r\n@name 订单\r\n@is_api 1\r\n@is_show 1\r\n@is_auth 1';

-- ----------------------------
-- Records of wp_app_tb_order
-- ----------------------------

-- ----------------------------
-- Table structure for `wp_sys_code_sms`
-- ----------------------------
DROP TABLE IF EXISTS `wp_sys_code_sms`;
CREATE TABLE `wp_sys_code_sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(20) CHARACTER SET utf8 NOT NULL COMMENT '手机',
  `code` varchar(20) CHARACTER SET utf8 NOT NULL COMMENT '短信验证码',
  `code_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '验证码类型（0-未知 1-注册 2-忘记密码 3-登录）',
  `code_expire_in` int(11) NOT NULL COMMENT '验证码过期时间戳',
  `content` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '发送内容',
  `send_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '发送状态（0-未知 1-等待发送 2-发送中 3-成功 4-失败）',
  `send_errmsg` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '发送失败信息',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态（0-未知 1-启用 2-禁用）',
  `type` tinyint(4) NOT NULL DEFAULT '2' COMMENT '类型（0-未知 1-短信验证码）',
  `sms_type` tinyint(4) NOT NULL COMMENT '短信类型（0-未知 1-阿里大鱼 2-114）',
  `remark` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '备注',
  `response_message` varchar(255) NOT NULL COMMENT '返回消息',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  `delete_time` int(11) NOT NULL COMMENT '软删除标记',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='短信验证码表\r\n@name 短信验证码\r\n@is_api 1\r\n@is_show 1\r\n@is_auth 1';

-- ----------------------------
-- Records of wp_sys_code_sms
-- ----------------------------
INSERT INTO `wp_sys_code_sms` VALUES ('1', '17367919507', '534716', '3', '0', '', '4', '发送失败', '1', '1', '2', '', '', '1571020365', '1571020365', '0');
INSERT INTO `wp_sys_code_sms` VALUES ('2', '17367919507', '475131', '3', '0', '【旅游】您的验证码为：475131，请在5分钟内使用。', '4', '企业id只能是数字', '1', '1', '2', '', '{\"returnstatus\":\"Faild\",\"message\":\"企业id只能是数字\",\"remainpoint\":\"0\",\"taskID\":\"0\",\"successCounts\":\"0\"}', '1571021224', '1571021224', '0');
INSERT INTO `wp_sys_code_sms` VALUES ('3', '17367919507', '198021', '3', '0', '【旅游】您的验证码为：198021，请在5分钟内使用。', '4', '发送失败', '1', '1', '2', '', '{\"returnstatus\":\"Faild\",\"message\":\"用户名或密码错误\",\"remainpoint\":\"0\",\"taskID\":\"0\",\"successCounts\":\"0\"}', '1571024035', '1571024035', '0');
INSERT INTO `wp_sys_code_sms` VALUES ('4', '17367919507', '309244', '1', '0', '【旅游】您的验证码为：309244，请在5分钟内使用。', '4', '用户名或密码错误', '1', '1', '2', '', '{\"returnstatus\":\"Faild\",\"message\":\"用户名或密码错误\",\"remainpoint\":\"0\",\"taskID\":\"0\",\"successCounts\":\"0\"}', '1571024988', '1571024988', '0');
INSERT INTO `wp_sys_code_sms` VALUES ('5', '17367919507', '229963', '1', '0', '【旅游】您的验证码为：229963，请在5分钟内使用。', '3', 'ok', '1', '1', '2', '', '{\"returnstatus\":\"Success\",\"message\":\"ok\",\"remainpoint\":\"24999\",\"taskID\":\"669539\",\"successCounts\":\"1\"}', '1571024999', '1571024999', '0');
INSERT INTO `wp_sys_code_sms` VALUES ('6', '18532045821', '837660', '1', '0', '【旅游】您的验证码为：837660，请在5分钟内使用。', '3', 'ok', '1', '1', '2', '', '{\"returnstatus\":\"Success\",\"message\":\"ok\",\"remainpoint\":\"24998\",\"taskID\":\"670200\",\"successCounts\":\"1\"}', '1571036023', '1571036023', '0');
INSERT INTO `wp_sys_code_sms` VALUES ('7', '13612341234', '328760', '3', '0', '【旅游】您的验证码为：328760，请在5分钟内使用。', '3', 'ok', '1', '1', '2', '', '{\"returnstatus\":\"Success\",\"message\":\"ok\",\"remainpoint\":\"24997\",\"taskID\":\"699725\",\"successCounts\":\"1\"}', '1571216744', '1571216744', '0');
INSERT INTO `wp_sys_code_sms` VALUES ('8', '15512062275', '183110', '3', '0', '【旅游】您的验证码为：183110，请在5分钟内使用。', '3', 'ok', '1', '1', '2', '', '{\"returnstatus\":\"Success\",\"message\":\"ok\",\"remainpoint\":\"24996\",\"taskID\":\"706023\",\"successCounts\":\"1\"}', '1571315834', '1571315834', '0');
INSERT INTO `wp_sys_code_sms` VALUES ('9', '18532045821', '420622', '3', '0', '【旅游】您的验证码为：420622，请在5分钟内使用。', '3', 'ok', '1', '1', '2', '', '{\"returnstatus\":\"Success\",\"message\":\"ok\",\"remainpoint\":\"24995\",\"taskID\":\"706155\",\"successCounts\":\"1\"}', '1571363625', '1571363625', '0');
INSERT INTO `wp_sys_code_sms` VALUES ('10', '18337137693', '222822', '2', '0', '【旅游】您的验证码为：222822，请在5分钟内使用。', '3', 'ok', '1', '1', '2', '', '{\"returnstatus\":\"Success\",\"message\":\"ok\",\"remainpoint\":\"24994\",\"taskID\":\"706803\",\"successCounts\":\"1\"}', '1571377413', '1571377413', '0');
INSERT INTO `wp_sys_code_sms` VALUES ('11', '18337137693', '765423', '2', '0', '【旅游】您的验证码为：765423，请在5分钟内使用。', '3', 'ok', '1', '1', '2', '', '{\"returnstatus\":\"Success\",\"message\":\"ok\",\"remainpoint\":\"24993\",\"taskID\":\"706806\",\"successCounts\":\"1\"}', '1571377443', '1571377443', '0');
INSERT INTO `wp_sys_code_sms` VALUES ('12', '15512062275', '155578', '1', '0', '【旅游】您的验证码为：155578，请在5分钟内使用。', '3', 'ok', '1', '1', '2', '', '{\"returnstatus\":\"Success\",\"message\":\"ok\",\"remainpoint\":\"24992\",\"taskID\":\"714864\",\"successCounts\":\"1\"}', '1571385687', '1571385687', '0');
INSERT INTO `wp_sys_code_sms` VALUES ('13', '15512062272', '819390', '1', '0', '【旅游】您的验证码为：819390，请在5分钟内使用。', '3', 'ok', '1', '1', '2', '', '{\"returnstatus\":\"Success\",\"message\":\"ok\",\"remainpoint\":\"24991\",\"taskID\":\"714949\",\"successCounts\":\"1\"}', '1571385904', '1571385904', '0');
INSERT INTO `wp_sys_code_sms` VALUES ('14', '18134118023', '950533', '3', '1572577397', '【旅游】您的验证码为：950533，请在5分钟内使用。', '3', 'ok', '2', '1', '2', '', '{\"returnstatus\":\"Success\",\"message\":\"ok\",\"remainpoint\":\"24957\",\"taskID\":\"988590\",\"successCounts\":\"1\"}', '1572577097', '1572577127', '0');
INSERT INTO `wp_sys_code_sms` VALUES ('15', '18134118023', '435752', '3', '1572612575', '【旅游】您的验证码为：435752，请在5分钟内使用。', '3', 'ok', '2', '1', '2', '', '{\"returnstatus\":\"Success\",\"message\":\"ok\",\"remainpoint\":\"24956\",\"taskID\":\"989479\",\"successCounts\":\"1\"}', '1572612275', '1572612298', '0');

-- ----------------------------
-- Table structure for `wp_sys_msg_send`
-- ----------------------------
DROP TABLE IF EXISTS `wp_sys_msg_send`;
CREATE TABLE `wp_sys_msg_send` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `send_id` int(11) NOT NULL COMMENT '发送者id',
  `receiver_id` int(11) NOT NULL COMMENT '接收者id',
  `send_param` text CHARACTER SET utf8 NOT NULL COMMENT '附件参数 推送相关参数',
  `send_time` int(11) NOT NULL COMMENT '发送时间（保留定时发送）',
  `read_flag` tinyint(4) NOT NULL DEFAULT '0' COMMENT '已读标志（0-未读 1-已读）',
  `msg_text_id` int(11) NOT NULL COMMENT '消息内容id',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态（0-等待发送 1-发送中 2-成功 3-失败）',
  `addon_name` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '应用名称',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  `delete_time` int(11) NOT NULL COMMENT '软删除标记',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=132 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='站内消息发送表\r\n@name 站内消息发送\r\n@is_menu 0\r\n@is_api 1\r\n@is_show 1\r\n@is_auth 1';

-- ----------------------------
-- Records of wp_sys_msg_send
-- ----------------------------
INSERT INTO `wp_sys_msg_send` VALUES ('72', '1', '1', '{\"openid\":\"oop0M0ec4XsFe6Gdq05fycRT2zx0\"}', '0', '1', '26', '2', 'wpVehicle', '1567504829', '1567504829', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('73', '1', '2', '{\"openid\":\"oop0M0YFBLg8sUBaOFoQhwZ0e6PQ\"}', '0', '0', '26', '2', 'wpVehicle', '1567504829', '1567504829', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('74', '1', '3', '{\"openid\":\"oQA6q5QPBgT_ncvv60wIJurtDAiM\"}', '0', '0', '26', '2', 'wpVehicle', '1567504829', '1567504829', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('75', '1', '1', '{\"openid\":\"oop0M0ec4XsFe6Gdq05fycRT2zx0\"}', '0', '1', '27', '2', 'wpVehicle', '1567588952', '1567666674', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('76', '1', '2', '{\"openid\":\"oop0M0YFBLg8sUBaOFoQhwZ0e6PQ\"}', '0', '1', '27', '2', 'wpVehicle', '1567588952', '1567666846', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('77', '1', '3', '{\"openid\":\"oQA6q5QPBgT_ncvv60wIJurtDAiM\"}', '0', '0', '27', '2', 'wpVehicle', '1567588952', '1567588952', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('78', '1', '4', '{\"openid\":\"oQA6q5QQkYnw9jo5PlWIc2-YgsSQ\"}', '0', '0', '27', '2', 'wpVehicle', '1567588952', '1567588952', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('79', '1', '1', '{\"openid\":\"oop0M0ec4XsFe6Gdq05fycRT2zx0\"}', '0', '0', '28', '2', 'wpVehicle', '1567588959', '1567588959', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('80', '1', '2', '{\"openid\":\"oop0M0YFBLg8sUBaOFoQhwZ0e6PQ\"}', '0', '0', '28', '2', 'wpVehicle', '1567588959', '1567588959', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('81', '1', '3', '{\"openid\":\"oQA6q5QPBgT_ncvv60wIJurtDAiM\"}', '0', '0', '28', '2', 'wpVehicle', '1567588959', '1567588959', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('82', '1', '4', '{\"openid\":\"oQA6q5QQkYnw9jo5PlWIc2-YgsSQ\"}', '0', '0', '28', '2', 'wpVehicle', '1567588959', '1567588959', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('83', '1', '1', '{\"openid\":\"oop0M0ec4XsFe6Gdq05fycRT2zx0\"}', '0', '0', '29', '2', 'wpVehicle', '1567589006', '1567589006', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('84', '1', '2', '{\"openid\":\"oop0M0YFBLg8sUBaOFoQhwZ0e6PQ\"}', '0', '0', '29', '2', 'wpVehicle', '1567589006', '1567589006', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('85', '1', '3', '{\"openid\":\"oQA6q5QPBgT_ncvv60wIJurtDAiM\"}', '0', '0', '29', '2', 'wpVehicle', '1567589006', '1567589006', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('86', '1', '4', '{\"openid\":\"oQA6q5QQkYnw9jo5PlWIc2-YgsSQ\"}', '0', '0', '29', '2', 'wpVehicle', '1567589006', '1567589006', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('87', '1', '1', '{\"openid\":\"oop0M0ec4XsFe6Gdq05fycRT2zx0\"}', '0', '0', '30', '2', 'wpVehicle', '1567590485', '1567590485', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('88', '1', '2', '{\"openid\":\"oop0M0YFBLg8sUBaOFoQhwZ0e6PQ\"}', '0', '0', '30', '2', 'wpVehicle', '1567590485', '1567590485', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('89', '1', '3', '{\"openid\":\"oQA6q5QPBgT_ncvv60wIJurtDAiM\"}', '0', '0', '30', '2', 'wpVehicle', '1567590485', '1567590485', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('90', '1', '4', '{\"openid\":\"oQA6q5QQkYnw9jo5PlWIc2-YgsSQ\"}', '0', '0', '30', '2', 'wpVehicle', '1567590485', '1567590485', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('91', '1', '1', '', '0', '0', '32', '2', 'wpVehicle', '1567590759', '1567590759', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('92', '1', '2', '', '0', '0', '32', '2', 'wpVehicle', '1567590759', '1567590759', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('93', '1', '3', '', '0', '0', '32', '2', 'wpVehicle', '1567590759', '1567590759', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('94', '1', '1', '', '0', '0', '33', '2', 'wpVehicle', '1567590770', '1567590770', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('95', '1', '2', '', '0', '0', '33', '2', 'wpVehicle', '1567590770', '1567590770', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('96', '1', '3', '', '0', '0', '33', '2', 'wpVehicle', '1567590770', '1567590770', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('97', '1', '1', '', '0', '0', '34', '2', 'wpVehicle', '1567590775', '1567590775', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('98', '1', '2', '', '0', '0', '34', '2', 'wpVehicle', '1567590775', '1567590775', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('99', '1', '3', '', '0', '0', '34', '2', 'wpVehicle', '1567590775', '1567590775', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('100', '1', '2', '', '0', '0', '35', '2', 'wpVehicle', '1567590786', '1567590786', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('101', '1', '3', '', '0', '0', '35', '2', 'wpVehicle', '1567590786', '1567590786', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('102', '1', '6', '', '0', '0', '36', '2', 'wpVehicle', '1567590839', '1567590839', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('103', '1', '5', '', '0', '1', '36', '2', 'wpVehicle', '1567590839', '1567667049', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('104', '1', '4', '', '0', '0', '36', '2', 'wpVehicle', '1567590839', '1567590839', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('105', '1', '1', '', '0', '0', '36', '2', 'wpVehicle', '1567590839', '1567590839', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('106', '1', '2', '', '0', '0', '36', '2', 'wpVehicle', '1567590839', '1567590839', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('107', '1', '5', '', '0', '1', '37', '2', 'wpVehicle', '1567647635', '1567667045', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('108', '1', '5', '', '0', '1', '38', '2', 'wpVehicle', '1567649258', '1567666910', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('109', '1', '5', '', '0', '1', '39', '2', 'wpVehicle', '1567667354', '1567667947', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('110', '1', '5', '', '0', '1', '40', '2', 'wpVehicle', '1567667811', '1567667945', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('111', '1', '5', '', '0', '1', '41', '2', 'wpVehicle', '1567667991', '1567668070', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('112', '1', '5', '', '0', '1', '42', '2', 'wpVehicle', '1567668051', '1567668067', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('113', '1', '5', '', '0', '1', '43', '2', 'wpVehicle', '1567668218', '1567668228', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('114', '1', '5', '', '0', '1', '44', '2', 'wpVehicle', '1567668783', '1567678645', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('115', '1', '8', '', '0', '1', '45', '2', 'wpVehicle', '1567733032', '1567741145', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('116', '1', '1', '', '0', '0', '46', '2', 'wpVehicle', '1567750310', '1567750310', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('117', '1', '2', '', '0', '0', '46', '2', 'wpVehicle', '1567750310', '1567750310', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('118', '1', '3', '', '0', '0', '46', '2', 'wpVehicle', '1567750310', '1567750310', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('119', '1', '4', '', '0', '0', '46', '2', 'wpVehicle', '1567750310', '1567750310', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('120', '1', '1', '', '0', '0', '47', '2', 'wpVehicle', '1567839426', '1567839426', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('121', '1', '2', '', '0', '0', '47', '2', 'wpVehicle', '1567839427', '1567839427', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('122', '1', '3', '', '0', '0', '47', '2', 'wpVehicle', '1567839427', '1567839427', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('123', '1', '4', '', '0', '0', '47', '2', 'wpVehicle', '1567839427', '1567839427', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('124', '1', '1', '', '0', '0', '48', '2', 'wpVehicle', '1567839554', '1567839554', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('125', '1', '2', '', '0', '0', '48', '2', 'wpVehicle', '1567839555', '1567839555', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('126', '1', '3', '', '0', '0', '48', '2', 'wpVehicle', '1567839555', '1567839555', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('127', '1', '4', '', '0', '0', '48', '2', 'wpVehicle', '1567839555', '1567839555', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('128', '1', '1', '', '0', '0', '49', '2', 'wpVehicle', '1567839676', '1567839678', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('129', '1', '2', '', '0', '0', '49', '2', 'wpVehicle', '1567839676', '1567839678', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('130', '1', '3', '', '0', '0', '49', '2', 'wpVehicle', '1567839676', '1567839678', '0');
INSERT INTO `wp_sys_msg_send` VALUES ('131', '1', '4', '', '0', '0', '49', '2', 'wpVehicle', '1567839676', '1567839678', '0');

-- ----------------------------
-- Table structure for `wp_sys_msg_text`
-- ----------------------------
DROP TABLE IF EXISTS `wp_sys_msg_text`;
CREATE TABLE `wp_sys_msg_text` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '标题',
  `content` text CHARACTER SET utf8 NOT NULL COMMENT '内容',
  `send_param` text CHARACTER SET utf8 NOT NULL COMMENT '附件参数 推送相关参数',
  `type` int(4) NOT NULL DEFAULT '1' COMMENT '类型（0-未知 1-公众号推送 2-小程序推送 3-短信 4-邮箱 5-其他 大于100为自定义）',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态（0-未知 1-待发送 2-发送中 3-已发送）',
  `remark` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '备注',
  `addon_name` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '应用名称',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  `delete_time` int(11) NOT NULL COMMENT '软删除标记',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='站内消息内容表\r\n@name 站内消息内容\r\n@is_menu 0\r\n@is_api 1\r\n@is_show 1\r\n@is_auth 1';

-- ----------------------------
-- Records of wp_sys_msg_text
-- ----------------------------
INSERT INTO `wp_sys_msg_text` VALUES ('26', '测试', '', '', '0', '1', '', 'wpVehicle', '1567504829', '1567504829', '0');
INSERT INTO `wp_sys_msg_text` VALUES ('27', '测试发送标题', '内容', '', '0', '1', '备注', 'wpVehicle', '1567588952', '1567588952', '0');
INSERT INTO `wp_sys_msg_text` VALUES ('28', '测试发送标题', '内容', '', '0', '1', '备注', 'wpVehicle', '1567588959', '1567588959', '0');
INSERT INTO `wp_sys_msg_text` VALUES ('29', '测试发送标题', '内容', '', '0', '1', '备注', 'wpVehicle', '1567589006', '1567589006', '0');
INSERT INTO `wp_sys_msg_text` VALUES ('30', '测试', '', '', '0', '1', '', 'wpVehicle', '1567590485', '1567590485', '0');
INSERT INTO `wp_sys_msg_text` VALUES ('32', '测试', '', '', '0', '1', '', 'wpVehicle', '1567590759', '1567590759', '0');
INSERT INTO `wp_sys_msg_text` VALUES ('33', '测试', '', '', '0', '1', '', 'wpVehicle', '1567590770', '1567590770', '0');
INSERT INTO `wp_sys_msg_text` VALUES ('34', '测试', '', '', '0', '1', '', 'wpVehicle', '1567590775', '1567590775', '0');
INSERT INTO `wp_sys_msg_text` VALUES ('35', '测试', '', '', '0', '1', '', 'wpVehicle', '1567590786', '1567590786', '0');
INSERT INTO `wp_sys_msg_text` VALUES ('36', '测试发送标题', '内容', '', '0', '1', '备注', 'wpVehicle', '1567590839', '1567590839', '0');
INSERT INTO `wp_sys_msg_text` VALUES ('37', '测试发送标题', '内容', '', '0', '1', '备注', 'wpVehicle', '1567647635', '1567647635', '0');
INSERT INTO `wp_sys_msg_text` VALUES ('38', '询价询价', '宝马', '', '0', '1', '', 'wpVehicle', '1567649258', '1567649258', '0');
INSERT INTO `wp_sys_msg_text` VALUES ('39', '测试未读', '未读消息', '', '0', '1', '', 'wpVehicle', '1567667354', '1567667354', '0');
INSERT INTO `wp_sys_msg_text` VALUES ('40', '测试未读', '未读消息', '', '0', '1', '123', 'wpVehicle', '1567667811', '1567667811', '0');
INSERT INTO `wp_sys_msg_text` VALUES ('41', '测试未读2', '未读消息', '', '0', '1', '123', 'wpVehicle', '1567667991', '1567667991', '0');
INSERT INTO `wp_sys_msg_text` VALUES ('42', '测试未读3', '未读消息', '', '0', '1', '123', 'wpVehicle', '1567668051', '1567668051', '0');
INSERT INTO `wp_sys_msg_text` VALUES ('43', '测试未读4', '未读消息', '', '0', '1', '123', 'wpVehicle', '1567668218', '1567668218', '0');
INSERT INTO `wp_sys_msg_text` VALUES ('44', '测试未读5', '未读消息', '', '0', '1', '123', 'wpVehicle', '1567668783', '1567668783', '0');
INSERT INTO `wp_sys_msg_text` VALUES ('45', '宾利新车型发布啦！！', '宾利2019新款车型发布啦！平台新增3款宾利品牌车！！宾利2019新款车型发布啦！平台新增3款宾利品牌车！！宾利2019新款车型发布啦！平台新增3款宾利品牌车！！宾利2019新款车型发布啦！平台新增3款宾利品牌车！！宾利2019新款车型发布啦！平台新增3款宾利品牌车！！', '', '0', '1', '', 'wpVehicle', '1567733032', '1567733032', '0');
INSERT INTO `wp_sys_msg_text` VALUES ('46', '测试', '', '', '0', '1', '', 'wpVehicle', '1567750309', '1567750309', '0');
INSERT INTO `wp_sys_msg_text` VALUES ('47', '测试', '', '', '0', '1', '', 'wpVehicle', '1567839426', '1567839426', '0');
INSERT INTO `wp_sys_msg_text` VALUES ('48', '测试', '', '', '0', '1', '', 'wpVehicle', '1567839554', '1567839554', '0');
INSERT INTO `wp_sys_msg_text` VALUES ('49', '测试', '', '', '0', '1', '', 'wpVehicle', '1567839676', '1567839676', '0');

-- ----------------------------
-- Table structure for `wp_sys_pay_payment`
-- ----------------------------
DROP TABLE IF EXISTS `wp_sys_pay_payment`;
CREATE TABLE `wp_sys_pay_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '标题（body subject）',
  `order_number` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '订单号',
  `out_trade_no` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '外部订单号',
  `realname` varchar(50) NOT NULL COMMENT '姓名',
  `identity_number` varchar(20) NOT NULL COMMENT '身份证号',
  `money` decimal(12,2) NOT NULL COMMENT '金额（total_amount total_fee）',
  `openid` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '微信openid 支付宝用不到',
  `pay_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '支付类型（0-未知 1-支付宝 2-微信 3-银行卡）',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态（0-未知 1-支付中 2-支付完成 3-支付失败 4-支付取消 5-退款中 6-退款完成 7-退款失败 8-退款取消）',
  `remark` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '备注',
  `tag` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '应用标记（区分不同支付）',
  `attach` text CHARACTER SET utf8 NOT NULL COMMENT '附加数据json',
  `notify_info` text CHARACTER SET utf8 NOT NULL COMMENT '回调返回内容信息',
  `pay_time` int(11) NOT NULL COMMENT '回调支付成功时间',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  `delete_time` int(11) NOT NULL COMMENT '软删除标记',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='支付表\r\n@name 支付记录\r\n@is_api 1\r\n@is_show 1\r\n@is_auth 1';

-- ----------------------------
-- Records of wp_sys_pay_payment
-- ----------------------------
INSERT INTO `wp_sys_pay_payment` VALUES ('1', '缴费', '20191015095918507536', '20191018150545154780773709', '', '', '0.01', '', '1', '4', '', '', '{}', '', '0', '1571382345', '1571382634', '0');
INSERT INTO `wp_sys_pay_payment` VALUES ('2', '缴费', '20191015095918507536', '20191018151034626075714125', '', '', '0.01', '', '1', '4', '', '', '{}', '', '0', '1571382634', '1571383007', '0');
INSERT INTO `wp_sys_pay_payment` VALUES ('3', '缴费', '20191015095918507536', '20191018151647242538207813', '', '', '0.01', '', '1', '1', '', '', '{}', '', '0', '1571383007', '1571383007', '0');

-- ----------------------------
-- Table structure for `wp_sys_pay_refund`
-- ----------------------------
DROP TABLE IF EXISTS `wp_sys_pay_refund`;
CREATE TABLE `wp_sys_pay_refund` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_number` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '订单号',
  `out_trade_no` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '外部订单号',
  `realname` varchar(50) NOT NULL COMMENT '姓名',
  `money` decimal(12,2) NOT NULL COMMENT '金额（total_amount total_fee）',
  `identity_number` varchar(20) NOT NULL COMMENT '身份证号',
  `openid` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '微信openid 支付宝用不到',
  `pay_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '支付类型（0-未知 1-支付宝 2-微信 3-银行卡）',
  `reason` varchar(255) NOT NULL COMMENT '退款原因',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态（0-未知 1-支付中 2-支付完成 3-支付失败 4-支付取消 5-退款中 6-退款完成 7-退款失败 8-退款取消）',
  `remark` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '备注',
  `tag` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '应用标记（区分不同支付）',
  `attach` text CHARACTER SET utf8 NOT NULL COMMENT '附加数据json',
  `notify_info` text CHARACTER SET utf8 NOT NULL COMMENT '回调返回内容信息',
  `refund_time` int(11) NOT NULL COMMENT '退款成功时间',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  `delete_time` int(11) NOT NULL COMMENT '软删除标记',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='退款表\r\n@name 退款记录\r\n@is_api 1\r\n@is_show 1\r\n@is_auth 1';

-- ----------------------------
-- Records of wp_sys_pay_refund
-- ----------------------------

-- ----------------------------
-- Table structure for `wp_sys_rbac_role`
-- ----------------------------
DROP TABLE IF EXISTS `wp_sys_rbac_role`;
CREATE TABLE `wp_sys_rbac_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '用户名',
  `intro` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '简介',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '类型（0-未知 1-通用）',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态,1启用 0禁用',
  `remark` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '备注',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  `delete_time` int(11) NOT NULL COMMENT '软删除标记',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='权限角色表\r\n@name 角色\r\n@is_menu 0\r\n@is_api 1\r\n@is_show 1\r\n@is_auth 1';

-- ----------------------------
-- Records of wp_sys_rbac_role
-- ----------------------------
INSERT INTO `wp_sys_rbac_role` VALUES ('7', '超级管理员', '后台管理平台的最高权限用户', '1', '1', '454353', '1567654316', '1572847953', '0');
INSERT INTO `wp_sys_rbac_role` VALUES ('8', '管理员', '管理员', '1', '1', '346456', '1567664282', '1572850582', '0');
INSERT INTO `wp_sys_rbac_role` VALUES ('9', '管理员', '管理员', '1', '1', '2342', '1572847561', '1572847650', '1572847650');
INSERT INTO `wp_sys_rbac_role` VALUES ('10', '管理员', '管理员', '1', '1', '5555 ', '1572847719', '1572847763', '1572847763');

-- ----------------------------
-- Table structure for `wp_sys_rbac_role_rule`
-- ----------------------------
DROP TABLE IF EXISTS `wp_sys_rbac_role_rule`;
CREATE TABLE `wp_sys_rbac_role_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL COMMENT '角色id',
  `rule_id` int(11) NOT NULL COMMENT '权限规则id',
  `rule_url` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '权限规则url',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `index_role_rule_url` (`rule_url`) USING BTREE COMMENT '角色关联规则url索引',
  KEY `index_role_role_id` (`role_id`) USING BTREE COMMENT '角色关联规则中角色id索引'
) ENGINE=InnoDB AUTO_INCREMENT=1835 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='角色规则关联表\r\n@name 角色规则关联\r\n@is_menu 0\r\n@is_api 1\r\n@is_show 1\r\n@is_auth 1';

-- ----------------------------
-- Records of wp_sys_rbac_role_rule
-- ----------------------------
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('273', '7', '200', '', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('274', '7', '1800', '', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('275', '7', '1801', '/sys/{{$mid}}/admin/slide.v1.slides.getList', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('276', '7', '1802', '/sys/{{$mid}}/admin/slide.v1.slides.getItemById', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('277', '7', '1803', '/sys/{{$mid}}/admin/slide.v1.slides.edit', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('278', '7', '1804', '/sys/{{$mid}}/admin/slide.v1.slides.delete', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('279', '7', '1300', '', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('280', '7', '1302', '/sys/{{$mid}}/admin/rbac.v1.rules.getTree', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('281', '7', '2100', '', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('282', '7', '2102', '/wpVehicle/{{$mid}}/admin/vehicle.v1.publishs.getListLite', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('283', '7', '2103', '/wpVehicle/{{$mid}}/admin/vehicle.v1.publishs.getMyListLite', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('284', '7', '2104', '/wpVehicle/{{$mid}}/admin/vehicle.v1.publishs.getItemById', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('285', '7', '2105', '/wpVehicle/{{$mid}}/admin/vehicle.v1.publishs.getItemOfOutBoundPrice', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('286', '7', '2106', '/wpVehicle/{{$mid}}/admin/vehicle.v1.publishs.getItemOfSalePrice', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('287', '7', '2107', '/wpVehicle/{{$mid}}/admin/vehicle.v1.publishs.getItemOfSalePolicy', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('288', '7', '2108', '/wpVehicle/{{$mid}}/admin/vehicle.v1.publishs.getItemOfOutboundCondition', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('289', '7', '2109', '/wpVehicle/{{$mid}}/admin/vehicle.v1.publishs.getItemOfAddress', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('290', '7', '2110', '/wpVehicle/{{$mid}}/admin/vehicle.v1.publishs.add', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('291', '7', '2111', '/wpVehicle/{{$mid}}/admin/vehicle.v1.publishs.setStatus', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('292', '7', '2112', '/wpVehicle/{{$mid}}/admin/vehicle.v1.publishs.setStatus', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('293', '7', '2113', '/wpVehicle/{{$mid}}/admin/vehicle.v1.publishs.edit', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('294', '7', '2114', '/wpVehicle/{{$mid}}/admin/vehicle.v1.publishs.delete', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('295', '7', '1600', '', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('296', '7', '1601', '/sys/{{$mid}}/admin/rbac.v1.userroles.getRoleIDsList', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('297', '7', '1602', '/sys/{{$mid}}/admin/rbac.v1.userroles.getRoleList', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('298', '7', '1603', '/sys/{{$mid}}/admin/rbac.v1.userroles.getUserRoleRuleList', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('299', '7', '1604', '/sys/{{$mid}}/admin/rbac.v1.userroles.getUserRoleRuleRejectList', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('300', '7', '1605', '/sys/{{$mid}}/admin/rbac.v1.userroles.getUserRoleRuleMenuList', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('301', '7', '1606', '/sys/{{$mid}}/admin/rbac.v1.userroles.setRoles', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('302', '7', '1607', '/sys/{{$mid}}/admin/rbac.v1.userroles.getList', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('303', '7', '1608', '/sys/{{$mid}}/admin/rbac.v1.userroles.getItemById', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('304', '7', '1609', '/sys/{{$mid}}/admin/rbac.v1.userroles.add', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('305', '7', '1610', '/sys/{{$mid}}/admin/rbac.v1.userroles.edit', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('306', '7', '1611', '/sys/{{$mid}}/admin/rbac.v1.userroles.delete', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('307', '7', '1100', '', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('308', '7', '1101', '/sys/{{$mid}}/admin/rbac.v1.roles.getList', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('309', '7', '1102', '/sys/{{$mid}}/admin/rbac.v1.roles.getItemById', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('310', '7', '1103', '/sys/{{$mid}}/admin/rbac.v1.roles.add', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('311', '7', '1104', '/sys/{{$mid}}/admin/rbac.v1.roles.edit', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('312', '7', '1105', '/sys/{{$mid}}/admin/rbac.v1.roles.delete', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('313', '7', '1900', '', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('314', '7', '1901', '/wpVehicle/{{$mid}}/admin/vehicle.v1.brands.getList', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('315', '7', '1902', '/wpVehicle/{{$mid}}/admin/vehicle.v1.brands.add', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('316', '7', '1903', '/wpVehicle/{{$mid}}/admin/vehicle.v1.brands.edit', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('317', '7', '1904', '/wpVehicle/{{$mid}}/admin/vehicle.v1.brands.getItemById', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('318', '7', '1905', '/wpVehicle/{{$mid}}/admin/vehicle.v1.brands.delete', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('319', '7', '1400', '', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('320', '7', '1401', '/sys/{{$mid}}/admin/rbac.v1.stores.getList', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('321', '7', '1402', '/sys/{{$mid}}/admin/rbac.v1.stores.getItemById', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('322', '7', '1403', '/sys/{{$mid}}/admin/rbac.v1.stores.add', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('323', '7', '1404', '/sys/{{$mid}}/admin/rbac.v1.stores.edit', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('324', '7', '1405', '/sys/{{$mid}}/admin/rbac.v1.stores.delete', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('325', '7', '2200', '', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('326', '7', '2201', '/wpVehicle/{{$mid}}/admin/vehicle.v1.seriess.getList', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('327', '7', '2202', '/wpVehicle/{{$mid}}/admin/vehicle.v1.seriess.getItemById', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('328', '7', '2203', '/wpVehicle/{{$mid}}/admin/vehicle.v1.seriess.add', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('329', '7', '2204', '/wpVehicle/{{$mid}}/admin/vehicle.v1.seriess.edit', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('330', '7', '2205', '/wpVehicle/{{$mid}}/admin/vehicle.v1.seriess.delete', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('331', '7', '1700', '', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('332', '7', '1701', '/sys/{{$mid}}/admin/rbac.v1.userstores.getStoreIDsList', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('333', '7', '1702', '/sys/{{$mid}}/admin/rbac.v1.userstores.getStoreList', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('334', '7', '1703', '/sys/{{$mid}}/admin/rbac.v1.userstores.setStores', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('335', '7', '1704', '/sys/{{$mid}}/admin/rbac.v1.userstores.getStoreManager', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('336', '7', '1705', '/sys/{{$mid}}/admin/rbac.v1.userstores.getStoreClerk', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('337', '7', '1706', '/sys/{{$mid}}/admin/rbac.v1.userstores.getList', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('338', '7', '1707', '/sys/{{$mid}}/admin/rbac.v1.userstores.getItemById', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('339', '7', '1708', '/sys/{{$mid}}/admin/rbac.v1.userstores.add', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('340', '7', '1709', '/sys/{{$mid}}/admin/rbac.v1.userstores.edit', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('341', '7', '1710', '/sys/{{$mid}}/admin/rbac.v1.userstores.delete', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('342', '7', '1200', '', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('343', '7', '1201', '/sys/{{$mid}}/admin/rbac.v1.rolerules.getRuleIDsList', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('344', '7', '1202', '/sys/{{$mid}}/admin/rbac.v1.rolerules.getRuleList', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('345', '7', '1203', '/sys/{{$mid}}/admin/rbac.v1.rolerules.setRules', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('346', '7', '1204', '/sys/{{$mid}}/admin/rbac.v1.rolerules.getList', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('347', '7', '1205', '/sys/{{$mid}}/admin/rbac.v1.rolerules.getItemById', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('348', '7', '1206', '/sys/{{$mid}}/admin/rbac.v1.rolerules.add', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('349', '7', '1207', '/sys/{{$mid}}/admin/rbac.v1.rolerules.edit', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('350', '7', '1208', '/sys/{{$mid}}/admin/rbac.v1.rolerules.delete', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('351', '7', '2000', '', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('352', '7', '2001', '/wpVehicle/{{$mid}}/admin/vehicle.v1.inquirys.getList', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('353', '7', '2002', '/wpVehicle/{{$mid}}/admin/vehicle.v1.inquirys.getMyList', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('354', '7', '2003', '/wpVehicle/{{$mid}}/admin/vehicle.v1.inquirys.getItemById', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('355', '7', '2004', '/wpVehicle/{{$mid}}/admin/vehicle.v1.inquirys.add', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('356', '7', '2005', '/wpVehicle/{{$mid}}/admin/vehicle.v1.inquirys.setStatus', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('357', '7', '2006', '/wpVehicle/{{$mid}}/admin/vehicle.v1.inquirys.edit', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('358', '7', '2007', '/wpVehicle/{{$mid}}/admin/vehicle.v1.inquirys.delete', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('359', '7', '1500', '', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('360', '7', '1501', '/sys/{{$mid}}/admin/rbac.v1.users.getList', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('361', '7', '1502', '/sys/{{$mid}}/admin/rbac.v1.users.getItemById', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('362', '7', '1503', '/sys/{{$mid}}/admin/rbac.v1.users.login', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('363', '7', '1504', '/sys/{{$mid}}/admin/rbac.v1.users.logout', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('364', '7', '1505', '/sys/{{$mid}}/admin/rbac.v1.users.changePasswd', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('365', '7', '1506', '/sys/{{$mid}}/admin/rbac.v1.users.resetPasswd', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('366', '7', '1507', '/sys/{{$mid}}/admin/rbac.v1.users.setStatus', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('367', '7', '1508', '/sys/{{$mid}}/admin/rbac.v1.users.add', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('368', '7', '1509', '/sys/{{$mid}}/admin/rbac.v1.users.edit', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('369', '7', '1510', '/sys/{{$mid}}/admin/rbac.v1.users.delete', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('370', '7', '1000', '', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('371', '7', '1001', '/sys/{{$mid}}/admin/msg.v1.sends.getList', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('372', '7', '1002', '/sys/{{$mid}}/admin/msg.v1.sends.getListNotRead', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('373', '7', '1003', '/sys/{{$mid}}/admin/msg.v1.sends.getItemById', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('374', '7', '1006', '/sys/{{$mid}}/admin/msg.v1.sends.send', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('375', '7', '1007', '/sys/{{$mid}}/admin/msg.v1.sends.edit', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('376', '7', '1008', '/sys/{{$mid}}/admin/msg.v1.sends.delete', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('377', '7', '2300', '', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('378', '7', '2304', '/wpVehicle/{{$mid}}/admin/vehicle.v1.seriesmodels.add', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('379', '7', '2305', '/wpVehicle/{{$mid}}/admin/vehicle.v1.seriesmodels.edit', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('380', '7', '2306', '/wpVehicle/{{$mid}}/admin/vehicle.v1.seriesmodels.delete', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('381', '7', '2301', '/wpVehicle/{{$mid}}/admin/vehicle.v1.seriesmodels.getList', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('382', '7', '2302', '/wpVehicle/{{$mid}}/admin/vehicle.v1.seriesmodels.getItemById', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('383', '7', '2303', '/wpVehicle/{{$mid}}/admin/vehicle.v1.seriesmodels.getItemDisplay', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('384', '7', '500', '', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('385', '7', '501', 'admin', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('386', '7', '502', 'user', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('387', '7', '503', 'role', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('388', '7', '504', 'Storefront', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('389', '7', '505', 'brand', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('390', '7', '506', 'price', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('391', '7', '507', 'release', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('392', '7', '508', 'bannar', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('393', '7', '509', 'msgS', '1567654342', '1567654342');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1681', '8', '1800', '', '1572851365', '1572851365');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1682', '8', '1801', '/app/admin/Trip.v1.Orders.setStatusAffirm', '1572851365', '1572851365');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1683', '8', '1802', '/app/admin/Trip.v1.Orders.setStatusCancel', '1572851365', '1572851365');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1684', '8', '1803', '/app/admin/Trip.v1.Orders.setStatusRefundReject', '1572851365', '1572851365');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1685', '8', '1804', '/app/admin/Trip.v1.Orders.setStatusRefundOK', '1572851365', '1572851365');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1686', '8', '1805', '/app/admin/Trip.v1.Orders.getList', '1572851365', '1572851365');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1687', '8', '1806', '/app/admin/Trip.v1.Orders.getItemById', '1572851365', '1572851365');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1688', '8', '1807', '/app/admin/Trip.v1.Orders.add', '1572851365', '1572851365');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1689', '8', '1808', '/app/admin/Trip.v1.Orders.edit', '1572851365', '1572851365');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1690', '8', '1809', '/app/admin/Trip.v1.Orders.delete', '1572851365', '1572851365');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1691', '8', '1810', '/app/admin/Trip.v1.Orders.setStatus', '1572851365', '1572851365');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1692', '8', '3600', '', '1572851365', '1572851365');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1693', '8', '3601', '/sys/admin/User.v1.Users.getList', '1572851365', '1572851365');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1694', '8', '3602', '/sys/admin/User.v1.Users.getItemById', '1572851365', '1572851365');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1695', '8', '3603', '/sys/admin/User.v1.Users.changePasswd', '1572851365', '1572851365');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1696', '8', '3604', '/sys/admin/User.v1.Users.resetPasswd', '1572851366', '1572851366');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1697', '8', '3605', '/sys/admin/User.v1.Users.setStatus', '1572851366', '1572851366');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1698', '8', '3606', '/sys/admin/User.v1.Users.add', '1572851366', '1572851366');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1699', '8', '3607', '/sys/admin/User.v1.Users.edit', '1572851366', '1572851366');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1700', '8', '3608', '/sys/admin/User.v1.Users.delete', '1572851366', '1572851366');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1701', '8', '1300', '', '1572851366', '1572851366');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1702', '8', '1301', '/app/admin/Sns.v1.LikeRecords.getList', '1572851366', '1572851366');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1703', '8', '1302', '/app/admin/Sns.v1.LikeRecords.getItemById', '1572851366', '1572851366');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1704', '8', '1303', '/app/admin/Sns.v1.LikeRecords.add', '1572851366', '1572851366');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1705', '8', '1304', '/app/admin/Sns.v1.LikeRecords.edit', '1572851366', '1572851366');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1706', '8', '1305', '/app/admin/Sns.v1.LikeRecords.delete', '1572851366', '1572851366');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1707', '8', '1306', '/app/admin/Sns.v1.LikeRecords.setStatus', '1572851366', '1572851366');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1708', '8', '3101', '/sys/admin/Rbac.v1.Users.getList', '1572851366', '1572851366');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1709', '8', '3103', '/sys/admin/Rbac.v1.Users.login', '1572851366', '1572851366');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1710', '8', '3104', '/sys/admin/Rbac.v1.Users.logout', '1572851366', '1572851366');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1711', '8', '2602', '/sys/admin/Pay.v1.Refunds.getList', '1572851366', '1572851366');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1712', '8', '2603', '/sys/admin/Pay.v1.Refunds.getItemById', '1572851366', '1572851366');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1713', '8', '2100', '', '1572851366', '1572851366');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1714', '8', '2101', '/app/admin/Trip.v1.UserCustomizations.getList', '1572851366', '1572851366');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1715', '8', '2102', '/app/admin/Trip.v1.UserCustomizations.getItemById', '1572851366', '1572851366');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1716', '8', '2103', '/app/admin/Trip.v1.UserCustomizations.add', '1572851366', '1572851366');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1717', '8', '2104', '/app/admin/Trip.v1.UserCustomizations.edit', '1572851366', '1572851366');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1718', '8', '2105', '/app/admin/Trip.v1.UserCustomizations.delete', '1572851366', '1572851366');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1719', '8', '2106', '/app/admin/Trip.v1.UserCustomizations.setStatus', '1572851366', '1572851366');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1720', '8', '1600', '', '1572851366', '1572851366');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1721', '8', '1601', '/app/admin/Trip.v1.Classifys.getList', '1572851366', '1572851366');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1722', '8', '1602', '/app/admin/Trip.v1.Classifys.getItemById', '1572851367', '1572851367');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1723', '8', '1603', '/app/admin/Trip.v1.Classifys.add', '1572851367', '1572851367');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1724', '8', '1604', '/app/admin/Trip.v1.Classifys.edit', '1572851367', '1572851367');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1725', '8', '1605', '/app/admin/Trip.v1.Classifys.delete', '1572851367', '1572851367');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1726', '8', '3400', '', '1572851367', '1572851367');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1727', '8', '3401', '/sys/admin/Slide.v1.Slides.getList', '1572851367', '1572851367');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1728', '8', '3402', '/sys/admin/Slide.v1.Slides.getItemById', '1572851367', '1572851367');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1729', '8', '3403', '/sys/admin/Slide.v1.Slides.edit', '1572851367', '1572851367');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1730', '8', '3404', '/sys/admin/Slide.v1.Slides.delete', '1572851367', '1572851367');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1731', '8', '3405', '/sys/admin/Slide.v1.Slides.setStatus', '1572851367', '1572851367');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1732', '8', '1100', '', '1572851367', '1572851367');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1733', '8', '1101', '/app/admin/Sns.v1.Comments.getList', '1572851367', '1572851367');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1734', '8', '1102', '/app/admin/Sns.v1.Comments.getItemById', '1572851367', '1572851367');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1735', '8', '1103', '/app/admin/Sns.v1.Comments.add', '1572851367', '1572851367');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1736', '8', '1104', '/app/admin/Sns.v1.Comments.edit', '1572851367', '1572851367');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1737', '8', '1105', '/app/admin/Sns.v1.Comments.delete', '1572851367', '1572851367');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1738', '8', '1106', '/app/admin/Sns.v1.Comments.setStatus', '1572851367', '1572851367');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1739', '8', '2400', '', '1572851367', '1572851367');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1740', '8', '2401', '/sys/admin/Msg.v1.Sends.getList', '1572851367', '1572851367');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1741', '8', '2402', '/sys/admin/Msg.v1.Sends.getListNotRead', '1572851367', '1572851367');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1742', '8', '2403', '/sys/admin/Msg.v1.Sends.getItemById', '1572851367', '1572851367');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1743', '8', '2406', '/sys/admin/Msg.v1.Sends.send', '1572851367', '1572851367');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1744', '8', '2407', '/sys/admin/Msg.v1.Sends.edit', '1572851367', '1572851367');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1745', '8', '2408', '/sys/admin/Msg.v1.Sends.delete', '1572851367', '1572851367');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1746', '8', '2409', '/sys/admin/Msg.v1.Sends.setStatus', '1572851367', '1572851367');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1747', '8', '1900', '', '1572851367', '1572851367');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1748', '8', '1901', '/app/admin/Trip.v1.SearchRecords.getList', '1572851367', '1572851367');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1749', '8', '1902', '/app/admin/Trip.v1.SearchRecords.getItemById', '1572851368', '1572851368');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1750', '8', '1903', '/app/admin/Trip.v1.SearchRecords.add', '1572851368', '1572851368');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1751', '8', '1904', '/app/admin/Trip.v1.SearchRecords.edit', '1572851368', '1572851368');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1752', '8', '1905', '/app/admin/Trip.v1.SearchRecords.delete', '1572851368', '1572851368');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1753', '8', '3700', '', '1572851368', '1572851368');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1754', '8', '3701', '/sys/admin/User.v1.ShareRecords.getList', '1572851368', '1572851368');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1755', '8', '3702', '/sys/admin/User.v1.ShareRecords.getItemById', '1572851368', '1572851368');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1756', '8', '3703', '/sys/admin/User.v1.ShareRecords.add', '1572851368', '1572851368');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1757', '8', '3704', '/sys/admin/User.v1.ShareRecords.edit', '1572851368', '1572851368');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1758', '8', '3705', '/sys/admin/User.v1.ShareRecords.delete', '1572851368', '1572851368');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1759', '8', '3706', '/sys/admin/User.v1.ShareRecords.setStatus', '1572851368', '1572851368');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1760', '8', '1400', '', '1572851368', '1572851368');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1761', '8', '1401', '/app/admin/Sns.v1.SearchRecords.getList', '1572851368', '1572851368');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1762', '8', '1402', '/app/admin/Sns.v1.SearchRecords.getItemById', '1572851368', '1572851368');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1763', '8', '1403', '/app/admin/Sns.v1.SearchRecords.add', '1572851368', '1572851368');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1764', '8', '1404', '/app/admin/Sns.v1.SearchRecords.edit', '1572851368', '1572851368');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1765', '8', '1405', '/app/admin/Sns.v1.SearchRecords.delete', '1572851368', '1572851368');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1766', '8', '2200', '', '1572851368', '1572851368');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1767', '8', '2201', '/app/admin/Trip.v1.UserInvoices.getList', '1572851368', '1572851368');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1768', '8', '2202', '/app/admin/Trip.v1.UserInvoices.getItemById', '1572851368', '1572851368');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1769', '8', '2203', '/app/admin/Trip.v1.UserInvoices.add', '1572851368', '1572851368');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1770', '8', '2204', '/app/admin/Trip.v1.UserInvoices.edit', '1572851368', '1572851368');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1771', '8', '2205', '/app/admin/Trip.v1.UserInvoices.delete', '1572851368', '1572851368');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1772', '8', '1700', '', '1572851368', '1572851368');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1773', '8', '1701', '/app/admin/Trip.v1.CouponPools.getList', '1572851368', '1572851368');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1774', '8', '1702', '/app/admin/Trip.v1.CouponPools.createCoupon', '1572851368', '1572851368');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1775', '8', '1703', '/app/admin/Trip.v1.CouponPools.getItemById', '1572851368', '1572851368');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1776', '8', '1704', '/app/admin/Trip.v1.CouponPools.add', '1572851369', '1572851369');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1777', '8', '1705', '/app/admin/Trip.v1.CouponPools.edit', '1572851369', '1572851369');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1778', '8', '1706', '/app/admin/Trip.v1.CouponPools.delete', '1572851369', '1572851369');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1779', '8', '1707', '/app/admin/Trip.v1.CouponPools.setStatus', '1572851369', '1572851369');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1780', '8', '3500', '', '1572851369', '1572851369');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1781', '8', '3501', '/sys/admin/Update.v1.Medias.getList', '1572851369', '1572851369');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1782', '8', '3502', '/sys/admin/Update.v1.Medias.getItemById', '1572851369', '1572851369');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1783', '8', '3503', '/sys/admin/Update.v1.Medias.add', '1572851369', '1572851369');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1784', '8', '3504', '/sys/admin/Update.v1.Medias.edit', '1572851369', '1572851369');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1785', '8', '3505', '/sys/admin/Update.v1.Medias.delete', '1572851369', '1572851369');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1786', '8', '1200', '', '1572851369', '1572851369');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1787', '8', '1201', '/app/admin/Sns.v1.LikeLogs.getList', '1572851369', '1572851369');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1788', '8', '1202', '/app/admin/Sns.v1.LikeLogs.getItemById', '1572851369', '1572851369');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1789', '8', '1203', '/app/admin/Sns.v1.LikeLogs.add', '1572851369', '1572851369');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1790', '8', '1204', '/app/admin/Sns.v1.LikeLogs.edit', '1572851369', '1572851369');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1791', '8', '1205', '/app/admin/Sns.v1.LikeLogs.delete', '1572851369', '1572851369');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1792', '8', '1206', '/app/admin/Sns.v1.LikeLogs.setStatus', '1572851369', '1572851369');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1793', '8', '2500', '', '1572851369', '1572851369');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1794', '8', '2501', '/sys/admin/Pay.v1.Payments.getList', '1572851369', '1572851369');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1795', '8', '2502', '/sys/admin/Pay.v1.Payments.getItemById', '1572851369', '1572851369');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1796', '8', '2503', '/sys/admin/Pay.v1.Payments.add', '1572851369', '1572851369');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1797', '8', '2504', '/sys/admin/Pay.v1.Payments.edit', '1572851369', '1572851369');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1798', '8', '2505', '/sys/admin/Pay.v1.Payments.delete', '1572851369', '1572851369');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1799', '8', '2506', '/sys/admin/Pay.v1.Payments.setStatus', '1572851369', '1572851369');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1800', '8', '2000', '', '1572851369', '1572851369');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1801', '8', '2001', '/app/admin/Trip.v1.UserCoupons.getList', '1572851369', '1572851369');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1802', '8', '2002', '/app/admin/Trip.v1.UserCoupons.getItemById', '1572851369', '1572851369');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1803', '8', '2003', '/app/admin/Trip.v1.UserCoupons.add', '1572851370', '1572851370');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1804', '8', '2004', '/app/admin/Trip.v1.UserCoupons.edit', '1572851370', '1572851370');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1805', '8', '2005', '/app/admin/Trip.v1.UserCoupons.delete', '1572851370', '1572851370');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1806', '8', '2006', '/app/admin/Trip.v1.UserCoupons.setStatus', '1572851370', '1572851370');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1807', '8', '3800', '', '1572851370', '1572851370');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1808', '8', '3801', '/sys/admin/User.v1.Thirds.getList', '1572851370', '1572851370');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1809', '8', '3802', '/sys/admin/User.v1.Thirds.getItemById', '1572851370', '1572851370');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1810', '8', '3803', '/sys/admin/User.v1.Thirds.add', '1572851370', '1572851370');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1811', '8', '3804', '/sys/admin/User.v1.Thirds.edit', '1572851370', '1572851370');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1812', '8', '3805', '/sys/admin/User.v1.Thirds.delete', '1572851370', '1572851370');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1813', '8', '3806', '/sys/admin/User.v1.Thirds.setStatus', '1572851370', '1572851370');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1814', '8', '1500', '', '1572851370', '1572851370');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1815', '8', '1501', '/app/admin/Trip.v1.Trips.add', '1572851370', '1572851370');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1816', '8', '1502', '/app/admin/Trip.v1.Trips.getList', '1572851370', '1572851370');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1817', '8', '1503', '/app/admin/Trip.v1.Trips.getItemById', '1572851370', '1572851370');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1818', '8', '1504', '/app/admin/Trip.v1.Trips.edit', '1572851370', '1572851370');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1819', '8', '1505', '/app/admin/Trip.v1.Trips.delete', '1572851370', '1572851370');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1820', '8', '1506', '/app/admin/Trip.v1.Trips.setStatus', '1572851370', '1572851370');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1821', '8', '1000', '', '1572851370', '1572851370');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1822', '8', '1001', '/app/admin/Sns.v1.Snss.getList', '1572851370', '1572851370');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1823', '8', '1002', '/app/admin/Sns.v1.Snss.getItemById', '1572851370', '1572851370');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1824', '8', '1003', '/app/admin/Sns.v1.Snss.add', '1572851370', '1572851370');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1825', '8', '1004', '/app/admin/Sns.v1.Snss.edit', '1572851370', '1572851370');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1826', '8', '1005', '/app/admin/Sns.v1.Snss.delete', '1572851370', '1572851370');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1827', '8', '1006', '/app/admin/Sns.v1.Snss.setStatus', '1572851370', '1572851370');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1828', '8', '2300', '', '1572851370', '1572851370');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1829', '8', '2304', '/sys/admin/Code.v1.Smss.edit', '1572851370', '1572851370');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1830', '8', '2305', '/sys/admin/Code.v1.Smss.delete', '1572851371', '1572851371');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1831', '8', '2306', '/sys/admin/Code.v1.Smss.setStatus', '1572851371', '1572851371');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1832', '8', '2301', '/sys/admin/Code.v1.Smss.getList', '1572851371', '1572851371');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1833', '8', '2302', '/sys/admin/Code.v1.Smss.getItemById', '1572851371', '1572851371');
INSERT INTO `wp_sys_rbac_role_rule` VALUES ('1834', '8', '2303', '/sys/admin/Code.v1.Smss.add', '1572851371', '1572851371');

-- ----------------------------
-- Table structure for `wp_sys_rbac_rule`
-- ----------------------------
DROP TABLE IF EXISTS `wp_sys_rbac_rule`;
CREATE TABLE `wp_sys_rbac_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL COMMENT '父级id',
  `name` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '用户名',
  `title` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '标题（用于菜单显示）',
  `icon` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '图标（用于菜单显示）',
  `intro` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '简介',
  `url` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '链接',
  `type` tinyint(4) NOT NULL DEFAULT '2' COMMENT '类型（0-未知 1-通用 2-后台 3-前端）',
  `is_auth` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否校验权限（0-不校验 1-校验）',
  `is_menu` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否菜单（0-否 1-是）',
  `is_api` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否输出接口文档（0-否 1-是）',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示在权限列表或菜单中（0-否 1-是）',
  `is_maker` tinyint(4) NOT NULL COMMENT '是否为生成器生成（0-否 1-是）',
  `tag` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '标签（生成器用来识别）',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态,1启用 0禁用',
  `sort` int(11) NOT NULL COMMENT '排序',
  `remark` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '备注',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  `delete_time` int(11) NOT NULL COMMENT '软删除标记',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `index_rule_url` (`url`) USING BTREE COMMENT '规则url'
) ENGINE=InnoDB AUTO_INCREMENT=3807 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='权限规则表\r\n@name 权限规则\r\n@is_menu 0\r\n@is_api 1\r\n@is_show 0\r\n@is_auth 1';

-- ----------------------------
-- Records of wp_sys_rbac_rule
-- ----------------------------
INSERT INTO `wp_sys_rbac_rule` VALUES ('200', '0', '后台系统管理', '后台系统管理', '', '后台系统管理', '', '2', '0', '1', '1', '1', '1', '', '1', '0', '', '1572850503', '1572850503', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('500', '0', '菜单管理', '菜单管理', '', '', '', '2', '1', '1', '1', '1', '0', '', '1', '0', '', '1567597087', '1567597087', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('501', '500', '管理员列表', '管理员列表', 'el-icon-s-custom', '', 'admin', '2', '1', '1', '1', '1', '0', '', '1', '0', '', '1567597087', '1567597087', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('502', '500', '用户列表', '用户列表', 'el-icon-lx-people', '', 'user', '2', '1', '1', '1', '1', '0', '', '1', '0', '', '1567597087', '1567597087', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('503', '500', '角色管理', '角色管理', 'el-icon-user-solid', '', 'role', '2', '1', '1', '1', '1', '0', '', '1', '0', '', '1567597087', '1567597087', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('504', '500', '门店管理', '门店管理', 'el-icon-s-shop', '', 'Storefront', '2', '1', '1', '1', '1', '0', '', '1', '0', '', '1567597087', '1567597087', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('505', '500', '车辆信息', '车辆信息', 'el-icon-s-order', '', 'brand', '2', '1', '1', '1', '1', '0', '', '1', '0', '', '1567597087', '1567597087', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('506', '500', '询价管理', '询价管理', 'el-icon-lx-apps', '', 'price', '2', '1', '1', '1', '1', '0', '', '1', '0', '', '1567597087', '1567597087', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('507', '500', '发布管理', '发布管理', 'el-icon-s-claim', '', 'release', '2', '1', '1', '1', '1', '0', '', '1', '0', '', '1567597087', '1567597087', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('508', '500', '轮播图', '轮播图', 'el-icon-lx-cascades', '', 'bannar', '2', '1', '1', '1', '1', '0', '', '1', '0', '', '1567597087', '1567597087', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('509', '500', '消息列表', '消息列表', 'el-icon-message-solid', '', 'msgS', '2', '1', '1', '1', '1', '0', '', '1', '0', '', '1567597087', '1567597087', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1000', '200', '社区文章', '社区文章', '', '', '', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\Snss', '1', '0', '', '1572850503', '1572850503', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1001', '1000', '获取社区文章列表', '获取社区文章列表', '', '', '/app/admin/Sns.v1.Snss.getList', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\Snss@getList', '1', '0', '', '1572850504', '1572850504', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1002', '1000', '获取社区文章详情', '获取社区文章详情', '', '', '/app/admin/Sns.v1.Snss.getItemById', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\Snss@getItemById', '1', '0', '', '1572850504', '1572850504', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1003', '1000', '添加社区文章', '添加社区文章', '', '', '/app/admin/Sns.v1.Snss.add', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\Snss@add', '1', '0', '', '1572850504', '1572850504', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1004', '1000', '更改社区文章', '更改社区文章', '', '', '/app/admin/Sns.v1.Snss.edit', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\Snss@edit', '1', '0', '', '1572850504', '1572850504', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1005', '1000', '删除社区文章', '删除社区文章', '', '', '/app/admin/Sns.v1.Snss.delete', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\Snss@delete', '1', '0', '', '1572850504', '1572850504', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1006', '1000', '更改社区文章状态', '更改社区文章状态', '', '', '/app/admin/Sns.v1.Snss.setStatus', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\Snss@setStatus', '1', '0', '', '1572850504', '1572850504', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1100', '200', '社区评论', '社区评论', '', '', '', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\Comments', '1', '0', '', '1572850504', '1572850504', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1101', '1100', '获取社区评论列表', '获取社区评论列表', '', '', '/app/admin/Sns.v1.Comments.getList', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\Comments@getList', '1', '0', '', '1572850504', '1572850504', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1102', '1100', '获取社区评论详情', '获取社区评论详情', '', '', '/app/admin/Sns.v1.Comments.getItemById', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\Comments@getItemById', '1', '0', '', '1572850504', '1572850504', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1103', '1100', '添加社区评论', '添加社区评论', '', '', '/app/admin/Sns.v1.Comments.add', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\Comments@add', '1', '0', '', '1572850504', '1572850504', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1104', '1100', '更改社区评论', '更改社区评论', '', '', '/app/admin/Sns.v1.Comments.edit', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\Comments@edit', '1', '0', '', '1572850504', '1572850504', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1105', '1100', '删除社区评论', '删除社区评论', '', '', '/app/admin/Sns.v1.Comments.delete', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\Comments@delete', '1', '0', '', '1572850504', '1572850504', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1106', '1100', '更改社区评论状态', '更改社区评论状态', '', '', '/app/admin/Sns.v1.Comments.setStatus', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\Comments@setStatus', '1', '0', '', '1572850504', '1572850504', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1200', '200', '社区点赞记录', '社区点赞记录', '', '', '', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\LikeLogs', '1', '0', '', '1572850505', '1572850505', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1201', '1200', '获取社区点赞记录列表', '获取社区点赞记录列表', '', '', '/app/admin/Sns.v1.LikeLogs.getList', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\LikeLogs@getList', '1', '0', '', '1572850505', '1572850505', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1202', '1200', '获取社区点赞记录详情', '获取社区点赞记录详情', '', '', '/app/admin/Sns.v1.LikeLogs.getItemById', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\LikeLogs@getItemById', '1', '0', '', '1572850505', '1572850505', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1203', '1200', '添加社区点赞记录', '添加社区点赞记录', '', '', '/app/admin/Sns.v1.LikeLogs.add', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\LikeLogs@add', '1', '0', '', '1572850505', '1572850505', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1204', '1200', '更改社区点赞记录', '更改社区点赞记录', '', '', '/app/admin/Sns.v1.LikeLogs.edit', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\LikeLogs@edit', '1', '0', '', '1572850505', '1572850505', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1205', '1200', '删除社区点赞记录', '删除社区点赞记录', '', '', '/app/admin/Sns.v1.LikeLogs.delete', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\LikeLogs@delete', '1', '0', '', '1572850505', '1572850505', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1206', '1200', '更改社区点赞记录状态', '更改社区点赞记录状态', '', '', '/app/admin/Sns.v1.LikeLogs.setStatus', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\LikeLogs@setStatus', '1', '0', '', '1572850505', '1572850505', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1300', '200', '社区点赞记录', '社区点赞记录', '', '', '', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\LikeRecords', '1', '0', '', '1572850505', '1572850505', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1301', '1300', '获取社区点赞记录列表', '获取社区点赞记录列表', '', '', '/app/admin/Sns.v1.LikeRecords.getList', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\LikeRecords@getList', '1', '0', '', '1572850505', '1572850505', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1302', '1300', '获取社区点赞记录详情', '获取社区点赞记录详情', '', '', '/app/admin/Sns.v1.LikeRecords.getItemById', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\LikeRecords@getItemById', '1', '0', '', '1572850505', '1572850505', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1303', '1300', '添加社区点赞记录', '添加社区点赞记录', '', '', '/app/admin/Sns.v1.LikeRecords.add', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\LikeRecords@add', '1', '0', '', '1572850505', '1572850505', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1304', '1300', '更改社区点赞记录', '更改社区点赞记录', '', '', '/app/admin/Sns.v1.LikeRecords.edit', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\LikeRecords@edit', '1', '0', '', '1572850506', '1572850506', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1305', '1300', '删除社区点赞记录', '删除社区点赞记录', '', '', '/app/admin/Sns.v1.LikeRecords.delete', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\LikeRecords@delete', '1', '0', '', '1572850506', '1572850506', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1306', '1300', '更改社区点赞记录状态', '更改社区点赞记录状态', '', '', '/app/admin/Sns.v1.LikeRecords.setStatus', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\LikeRecords@setStatus', '1', '0', '', '1572850506', '1572850506', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1400', '200', '社区搜索记录', '社区搜索记录', '', '', '', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\SearchRecords', '1', '0', '', '1572850506', '1572850506', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1401', '1400', '获取社区搜索记录列表', '获取社区搜索记录列表', '', '', '/app/admin/Sns.v1.SearchRecords.getList', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\SearchRecords@getList', '1', '0', '', '1572850506', '1572850506', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1402', '1400', '获取社区搜索记录详情', '获取社区搜索记录详情', '', '', '/app/admin/Sns.v1.SearchRecords.getItemById', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\SearchRecords@getItemById', '1', '0', '', '1572850506', '1572850506', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1403', '1400', '添加社区搜索记录', '添加社区搜索记录', '', '', '/app/admin/Sns.v1.SearchRecords.add', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\SearchRecords@add', '1', '0', '', '1572850506', '1572850506', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1404', '1400', '更改社区搜索记录', '更改社区搜索记录', '', '', '/app/admin/Sns.v1.SearchRecords.edit', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\SearchRecords@edit', '1', '0', '', '1572850506', '1572850506', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1405', '1400', '删除社区搜索记录', '删除社区搜索记录', '', '', '/app/admin/Sns.v1.SearchRecords.delete', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Sns\\admin\\controller\\SearchRecords@delete', '1', '0', '', '1572850507', '1572850507', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1500', '200', '旅游产品', '旅游产品', '', '', '', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\Trips', '1', '0', '', '1572850507', '1572850507', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1501', '1500', '添加旅游产品', '添加旅游产品', '', '', '/app/admin/Trip.v1.Trips.add', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\Trips@add', '1', '0', '', '1572850507', '1572850507', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1502', '1500', '获取旅游产品列表', '获取旅游产品列表', '', '', '/app/admin/Trip.v1.Trips.getList', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\Trips@getList', '1', '0', '', '1572850507', '1572850507', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1503', '1500', '获取旅游产品详情', '获取旅游产品详情', '', '', '/app/admin/Trip.v1.Trips.getItemById', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\Trips@getItemById', '1', '0', '', '1572850507', '1572850507', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1504', '1500', '更改旅游产品', '更改旅游产品', '', '', '/app/admin/Trip.v1.Trips.edit', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\Trips@edit', '1', '0', '', '1572850507', '1572850507', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1505', '1500', '删除旅游产品', '删除旅游产品', '', '', '/app/admin/Trip.v1.Trips.delete', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\Trips@delete', '1', '0', '', '1572850508', '1572850508', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1506', '1500', '更改旅游产品状态', '更改旅游产品状态', '', '', '/app/admin/Trip.v1.Trips.setStatus', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\Trips@setStatus', '1', '0', '', '1572850508', '1572850508', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1600', '200', '分类', '分类', '', '', '', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\Classifys', '1', '0', '', '1572850508', '1572850508', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1601', '1600', '获取分类列表', '获取分类列表', '', '', '/app/admin/Trip.v1.Classifys.getList', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\Classifys@getList', '1', '0', '', '1572850508', '1572850508', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1602', '1600', '获取分类详情', '获取分类详情', '', '', '/app/admin/Trip.v1.Classifys.getItemById', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\Classifys@getItemById', '1', '0', '', '1572850508', '1572850508', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1603', '1600', '添加分类', '添加分类', '', '', '/app/admin/Trip.v1.Classifys.add', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\Classifys@add', '1', '0', '', '1572850508', '1572850508', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1604', '1600', '更改分类', '更改分类', '', '', '/app/admin/Trip.v1.Classifys.edit', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\Classifys@edit', '1', '0', '', '1572850508', '1572850508', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1605', '1600', '删除分类', '删除分类', '', '', '/app/admin/Trip.v1.Classifys.delete', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\Classifys@delete', '1', '0', '', '1572850508', '1572850508', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1700', '200', '优惠券', '优惠券', '', '', '', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\CouponPools', '1', '0', '', '1572850508', '1572850508', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1701', '1700', '获取优惠券列表', '获取优惠券列表', '', '', '/app/admin/Trip.v1.CouponPools.getList', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\CouponPools@getList', '1', '0', '', '1572850508', '1572850508', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1702', '1700', '创建优惠券', '创建优惠券', '', '', '/app/admin/Trip.v1.CouponPools.createCoupon', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\CouponPools@createCoupon', '1', '0', '', '1572850508', '1572850508', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1703', '1700', '获取优惠券详情', '获取优惠券详情', '', '', '/app/admin/Trip.v1.CouponPools.getItemById', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\CouponPools@getItemById', '1', '0', '', '1572850508', '1572850508', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1704', '1700', '添加优惠券', '添加优惠券', '', '', '/app/admin/Trip.v1.CouponPools.add', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\CouponPools@add', '1', '0', '', '1572850509', '1572850509', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1705', '1700', '更改优惠券', '更改优惠券', '', '', '/app/admin/Trip.v1.CouponPools.edit', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\CouponPools@edit', '1', '0', '', '1572850509', '1572850509', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1706', '1700', '删除优惠券', '删除优惠券', '', '', '/app/admin/Trip.v1.CouponPools.delete', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\CouponPools@delete', '1', '0', '', '1572850509', '1572850509', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1707', '1700', '更改优惠券状态', '更改优惠券状态', '', '', '/app/admin/Trip.v1.CouponPools.setStatus', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\CouponPools@setStatus', '1', '0', '', '1572850509', '1572850509', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1800', '200', '旅游订单', '旅游订单', '', '', '', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\Orders', '1', '0', '', '1572850509', '1572850509', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1801', '1800', '订单确认', '订单确认', '', '', '/app/admin/Trip.v1.Orders.setStatusAffirm', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\Orders@setStatusAffirm', '1', '0', '', '1572850509', '1572850509', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1802', '1800', '取消订单', '取消订单', '', '', '/app/admin/Trip.v1.Orders.setStatusCancel', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\Orders@setStatusCancel', '1', '0', '', '1572850509', '1572850509', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1803', '1800', '退款驳回', '退款驳回', '', '', '/app/admin/Trip.v1.Orders.setStatusRefundReject', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\Orders@setStatusRefundReject', '1', '0', '', '1572850509', '1572850509', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1804', '1800', '同意退款', '同意退款', '', '', '/app/admin/Trip.v1.Orders.setStatusRefundOK', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\Orders@setStatusRefundOK', '1', '0', '', '1572850509', '1572850509', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1805', '1800', '获取旅游订单列表', '获取旅游订单列表', '', '', '/app/admin/Trip.v1.Orders.getList', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\Orders@getList', '1', '0', '', '1572850509', '1572850509', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1806', '1800', '获取旅游订单详情', '获取旅游订单详情', '', '', '/app/admin/Trip.v1.Orders.getItemById', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\Orders@getItemById', '1', '0', '', '1572850510', '1572850510', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1807', '1800', '添加旅游订单', '添加旅游订单', '', '', '/app/admin/Trip.v1.Orders.add', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\Orders@add', '1', '0', '', '1572850510', '1572850510', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1808', '1800', '更改旅游订单', '更改旅游订单', '', '', '/app/admin/Trip.v1.Orders.edit', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\Orders@edit', '1', '0', '', '1572850510', '1572850510', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1809', '1800', '删除旅游订单', '删除旅游订单', '', '', '/app/admin/Trip.v1.Orders.delete', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\Orders@delete', '1', '0', '', '1572850510', '1572850510', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1810', '1800', '更改旅游订单状态', '更改旅游订单状态', '', '', '/app/admin/Trip.v1.Orders.setStatus', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\Orders@setStatus', '1', '0', '', '1572850510', '1572850510', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1900', '200', '社区搜索记录', '社区搜索记录', '', '', '', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\SearchRecords', '1', '0', '', '1572850510', '1572850510', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1901', '1900', '获取旅游产品搜索记录列表', '获取旅游产品搜索记录列表', '', '', '/app/admin/Trip.v1.SearchRecords.getList', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\SearchRecords@getList', '1', '0', '', '1572850510', '1572850510', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1902', '1900', '获取旅游产品搜索记录详情', '获取旅游产品搜索记录详情', '', '', '/app/admin/Trip.v1.SearchRecords.getItemById', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\SearchRecords@getItemById', '1', '0', '', '1572850510', '1572850510', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1903', '1900', '添加旅游产品搜索记录', '添加旅游产品搜索记录', '', '', '/app/admin/Trip.v1.SearchRecords.add', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\SearchRecords@add', '1', '0', '', '1572850510', '1572850510', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1904', '1900', '更改旅游产品搜索记录', '更改旅游产品搜索记录', '', '', '/app/admin/Trip.v1.SearchRecords.edit', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\SearchRecords@edit', '1', '0', '', '1572850510', '1572850510', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('1905', '1900', '删除旅游产品搜索记录', '删除旅游产品搜索记录', '', '', '/app/admin/Trip.v1.SearchRecords.delete', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\SearchRecords@delete', '1', '0', '', '1572850510', '1572850510', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2000', '200', '用户优惠券', '用户优惠券', '', '', '', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\UserCoupons', '1', '0', '', '1572850511', '1572850511', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2001', '2000', '获取用户优惠券列表', '获取用户优惠券列表', '', '', '/app/admin/Trip.v1.UserCoupons.getList', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\UserCoupons@getList', '1', '0', '', '1572850511', '1572850511', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2002', '2000', '获取用户优惠券详情', '获取用户优惠券详情', '', '', '/app/admin/Trip.v1.UserCoupons.getItemById', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\UserCoupons@getItemById', '1', '0', '', '1572850511', '1572850511', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2003', '2000', '添加用户优惠券', '添加用户优惠券', '', '', '/app/admin/Trip.v1.UserCoupons.add', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\UserCoupons@add', '1', '0', '', '1572850511', '1572850511', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2004', '2000', '更改用户优惠券', '更改用户优惠券', '', '', '/app/admin/Trip.v1.UserCoupons.edit', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\UserCoupons@edit', '1', '0', '', '1572850511', '1572850511', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2005', '2000', '删除用户优惠券', '删除用户优惠券', '', '', '/app/admin/Trip.v1.UserCoupons.delete', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\UserCoupons@delete', '1', '0', '', '1572850511', '1572850511', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2006', '2000', '更改用户优惠券状态', '更改用户优惠券状态', '', '', '/app/admin/Trip.v1.UserCoupons.setStatus', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\UserCoupons@setStatus', '1', '0', '', '1572850511', '1572850511', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2100', '200', '定制游', '定制游', '', '', '', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\UserCustomizations', '1', '0', '', '1572850511', '1572850511', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2101', '2100', '获取定制游列表', '获取定制游列表', '', '', '/app/admin/Trip.v1.UserCustomizations.getList', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\UserCustomizations@getList', '1', '0', '', '1572850511', '1572850511', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2102', '2100', '获取定制游详情', '获取定制游详情', '', '', '/app/admin/Trip.v1.UserCustomizations.getItemById', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\UserCustomizations@getItemById', '1', '0', '', '1572850511', '1572850511', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2103', '2100', '添加定制游', '添加定制游', '', '', '/app/admin/Trip.v1.UserCustomizations.add', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\UserCustomizations@add', '1', '0', '', '1572850511', '1572850511', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2104', '2100', '更改定制游', '更改定制游', '', '', '/app/admin/Trip.v1.UserCustomizations.edit', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\UserCustomizations@edit', '1', '0', '', '1572850511', '1572850511', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2105', '2100', '删除定制游', '删除定制游', '', '', '/app/admin/Trip.v1.UserCustomizations.delete', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\UserCustomizations@delete', '1', '0', '', '1572850512', '1572850512', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2106', '2100', '更改定制游状态', '更改定制游状态', '', '', '/app/admin/Trip.v1.UserCustomizations.setStatus', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\UserCustomizations@setStatus', '1', '0', '', '1572850512', '1572850512', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2200', '200', '发票信息', '发票信息', '', '', '', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\UserInvoices', '1', '0', '', '1572850512', '1572850512', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2201', '2200', '获取发票信息列表', '获取发票信息列表', '', '', '/app/admin/Trip.v1.UserInvoices.getList', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\UserInvoices@getList', '1', '0', '', '1572850512', '1572850512', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2202', '2200', '获取发票信息详情', '获取发票信息详情', '', '', '/app/admin/Trip.v1.UserInvoices.getItemById', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\UserInvoices@getItemById', '1', '0', '', '1572850512', '1572850512', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2203', '2200', '添加发票信息', '添加发票信息', '', '', '/app/admin/Trip.v1.UserInvoices.add', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\UserInvoices@add', '1', '0', '', '1572850512', '1572850512', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2204', '2200', '更改发票信息', '更改发票信息', '', '', '/app/admin/Trip.v1.UserInvoices.edit', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\UserInvoices@edit', '1', '0', '', '1572850512', '1572850512', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2205', '2200', '删除发票信息', '删除发票信息', '', '', '/app/admin/Trip.v1.UserInvoices.delete', '2', '1', '0', '1', '1', '1', 'app\\app\\trip\\Trip\\admin\\controller\\UserInvoices@delete', '1', '0', '', '1572850512', '1572850512', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2300', '200', '轮播图', '轮播图', '', '', '', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Code\\admin\\controller\\Smss', '1', '0', '', '1572850512', '1572850512', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2301', '2300', '获取短信验证码列表', '获取短信验证码列表', '', '', '/sys/admin/Code.v1.Smss.getList', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Code\\admin\\controller\\Smss@getList', '1', '0', '', '1572850512', '1572850512', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2302', '2300', '获取短信验证码详情', '获取短信验证码详情', '', '', '/sys/admin/Code.v1.Smss.getItemById', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Code\\admin\\controller\\Smss@getItemById', '1', '0', '', '1572850512', '1572850512', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2303', '2300', '添加短信验证码', '添加短信验证码', '', '', '/sys/admin/Code.v1.Smss.add', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Code\\admin\\controller\\Smss@add', '1', '0', '', '1572850513', '1572850513', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2304', '2300', '更改短信验证码', '更改短信验证码', '', '', '/sys/admin/Code.v1.Smss.edit', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Code\\admin\\controller\\Smss@edit', '1', '0', '', '1572850513', '1572850513', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2305', '2300', '删除短信验证码', '删除短信验证码', '', '', '/sys/admin/Code.v1.Smss.delete', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Code\\admin\\controller\\Smss@delete', '1', '0', '', '1572850513', '1572850513', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2306', '2300', '更改短信验证码状态', '更改短信验证码状态', '', '', '/sys/admin/Code.v1.Smss.setStatus', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Code\\admin\\controller\\Smss@setStatus', '1', '0', '', '1572850513', '1572850513', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2400', '200', '站内消息发送', '站内消息发送', '', '', '', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Msg\\admin\\controller\\Sends', '1', '0', '', '1572850513', '1572850513', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2401', '2400', '获取站内消息发送列表', '获取站内消息发送列表', '', '', '/sys/admin/Msg.v1.Sends.getList', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Msg\\admin\\controller\\Sends@getList', '1', '0', '', '1572850513', '1572850513', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2402', '2400', '获取未读消息列表', '获取未读消息列表', '', '', '/sys/admin/Msg.v1.Sends.getListNotRead', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Msg\\admin\\controller\\Sends@getListUnread', '1', '0', '', '1572850513', '1572850513', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2403', '2400', '获取消息详情', '获取消息详情', '', '', '/sys/admin/Msg.v1.Sends.getItemById', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Msg\\admin\\controller\\Sends@getItemById', '1', '0', '', '1572850513', '1572850513', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2406', '2400', '发送消息', '发送消息', '', '', '/sys/admin/Msg.v1.Sends.send', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Msg\\admin\\controller\\Sends@send', '1', '0', '', '1572850513', '1572850513', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2407', '2400', '更改站内消息发送', '更改站内消息发送', '', '', '/sys/admin/Msg.v1.Sends.edit', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Msg\\admin\\controller\\Sends@edit', '1', '0', '', '1572850514', '1572850514', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2408', '2400', '删除站内消息发送', '删除站内消息发送', '', '', '/sys/admin/Msg.v1.Sends.delete', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Msg\\admin\\controller\\Sends@delete', '1', '0', '', '1572850514', '1572850514', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2409', '2400', '更改站内消息发送状态', '更改站内消息发送状态', '', '', '/sys/admin/Msg.v1.Sends.setStatus', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Msg\\admin\\controller\\Sends@setStatus', '1', '0', '', '1572850514', '1572850514', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2500', '200', '支付记录', '支付记录', '', '', '', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Pay\\admin\\controller\\Payments', '1', '0', '', '1572850514', '1572850514', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2501', '2500', '获取支付记录列表', '获取支付记录列表', '', '', '/sys/admin/Pay.v1.Payments.getList', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Pay\\admin\\controller\\Payments@getList', '1', '0', '', '1572850514', '1572850514', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2502', '2500', '获取支付记录详情', '获取支付记录详情', '', '', '/sys/admin/Pay.v1.Payments.getItemById', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Pay\\admin\\controller\\Payments@getItemById', '1', '0', '', '1572850514', '1572850514', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2503', '2500', '添加支付记录', '添加支付记录', '', '', '/sys/admin/Pay.v1.Payments.add', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Pay\\admin\\controller\\Payments@add', '1', '0', '', '1572850514', '1572850514', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2504', '2500', '更改支付记录', '更改支付记录', '', '', '/sys/admin/Pay.v1.Payments.edit', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Pay\\admin\\controller\\Payments@edit', '1', '0', '', '1572850514', '1572850514', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2505', '2500', '删除支付记录', '删除支付记录', '', '', '/sys/admin/Pay.v1.Payments.delete', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Pay\\admin\\controller\\Payments@delete', '1', '0', '', '1572850514', '1572850514', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2506', '2500', '更改支付记录状态', '更改支付记录状态', '', '', '/sys/admin/Pay.v1.Payments.setStatus', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Pay\\admin\\controller\\Payments@setStatus', '1', '0', '', '1572850514', '1572850514', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2600', '200', '退款记录', '退款记录', '', '', '', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Pay\\admin\\controller\\Refunds', '1', '0', '', '1572850514', '1572850514', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2601', '2600', '退款', '退款', '', '', '/sys/admin/Pay.v1.Refunds.refund', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Pay\\admin\\controller\\Refunds@refund', '1', '0', '', '1572850515', '1572850515', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2602', '2600', '获取退款记录列表', '获取退款记录列表', '', '', '/sys/admin/Pay.v1.Refunds.getList', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Pay\\admin\\controller\\Refunds@getList', '1', '0', '', '1572850515', '1572850515', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2603', '2600', '获取退款记录详情', '获取退款记录详情', '', '', '/sys/admin/Pay.v1.Refunds.getItemById', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Pay\\admin\\controller\\Refunds@getItemById', '1', '0', '', '1572850515', '1572850515', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2604', '2600', '添加退款记录', '添加退款记录', '', '', '/sys/admin/Pay.v1.Refunds.add', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Pay\\admin\\controller\\Refunds@add', '1', '0', '', '1572850515', '1572850515', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2605', '2600', '更改退款记录', '更改退款记录', '', '', '/sys/admin/Pay.v1.Refunds.edit', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Pay\\admin\\controller\\Refunds@edit', '1', '0', '', '1572850515', '1572850515', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2606', '2600', '删除退款记录', '删除退款记录', '', '', '/sys/admin/Pay.v1.Refunds.delete', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Pay\\admin\\controller\\Refunds@delete', '1', '0', '', '1572850515', '1572850515', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2607', '2600', '更改退款记录状态', '更改退款记录状态', '', '', '/sys/admin/Pay.v1.Refunds.setStatus', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Pay\\admin\\controller\\Refunds@setStatus', '1', '0', '', '1572850515', '1572850515', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2700', '200', '角色管理', '角色管理', '', '', '', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\Roles', '1', '0', '', '1572850515', '1572850515', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2701', '2700', '获取角色列表', '获取角色列表', '', '', '/sys/admin/Rbac.v1.Roles.getList', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\Roles@getList', '1', '0', '', '1572850515', '1572850515', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2702', '2700', '获取角色详情', '获取角色详情', '', '', '/sys/admin/Rbac.v1.Roles.getItemById', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\Roles@getItemById', '1', '0', '', '1572850515', '1572850515', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2703', '2700', '添加角色', '添加角色', '', '', '/sys/admin/Rbac.v1.Roles.add', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\Roles@add', '1', '0', '', '1572850515', '1572850515', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2704', '2700', '更改角色', '更改角色', '', '', '/sys/admin/Rbac.v1.Roles.edit', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\Roles@edit', '1', '0', '', '1572850516', '1572850516', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2705', '2700', '删除角色', '删除角色', '', '', '/sys/admin/Rbac.v1.Roles.delete', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\Roles@delete', '1', '0', '', '1572850516', '1572850516', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2706', '2700', '更改角色状态', '更改角色状态', '', '', '/sys/admin/Rbac.v1.Roles.setStatus', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\Roles@setStatus', '1', '0', '', '1572850516', '1572850516', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2800', '200', '角色规则关联管理', '角色规则关联管理', '', '', '', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\RoleRules', '1', '0', '', '1572850516', '1572850516', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2801', '2800', '获取管理员关联的角色ID列表', '获取管理员关联的角色ID列表', '', '', '/sys/admin/Rbac.v1.Rolerules.getRuleIDsList', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\RoleRules@getRuleIDsList', '1', '0', '', '1572850516', '1572850516', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2802', '2800', '获取管理员关联的角色列表', '获取管理员关联的角色列表', '', '', '/sys/admin/Rbac.v1.Rolerules.getRuleList', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\RoleRules@getRuleList', '1', '0', '', '1572850516', '1572850516', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2803', '2800', '添加更改角色对应权限规则列表（批量）', '添加更改角色对应权限规则列表（批量）', '', '', '/sys/admin/Rbac.v1.Rolerules.setRules', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\RoleRules@setRules', '1', '0', '', '1572850516', '1572850516', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2804', '2800', '获取角色规则关联列表', '获取角色规则关联列表', '', '', '/sys/admin/Rbac.v1.RoleRules.getList', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\RoleRules@getList', '1', '0', '', '1572850516', '1572850516', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2805', '2800', '获取角色规则关联详情', '获取角色规则关联详情', '', '', '/sys/admin/Rbac.v1.RoleRules.getItemById', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\RoleRules@getItemById', '1', '0', '', '1572850517', '1572850517', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2806', '2800', '添加角色规则关联', '添加角色规则关联', '', '', '/sys/admin/Rbac.v1.RoleRules.add', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\RoleRules@add', '1', '0', '', '1572850517', '1572850517', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2807', '2800', '更改角色规则关联', '更改角色规则关联', '', '', '/sys/admin/Rbac.v1.RoleRules.edit', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\RoleRules@edit', '1', '0', '', '1572850517', '1572850517', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2808', '2800', '删除角色规则关联', '删除角色规则关联', '', '', '/sys/admin/Rbac.v1.RoleRules.delete', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\RoleRules@delete', '1', '0', '', '1572850517', '1572850517', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2900', '200', '权限规则', '权限规则', '', '', '', '2', '1', '0', '1', '0', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\Rules', '1', '0', '', '1572850517', '1572850517', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2902', '2900', '获取权限规则树', '获取权限规则树', '', '', '/sys/admin/Rbac.v1.Rules.getTree', '2', '1', '0', '1', '0', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\Rules@getTree', '1', '0', '', '1572850517', '1572850517', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('2908', '2900', '更改权限规则状态', '更改权限规则状态', '', '', '/sys/admin/Rbac.v1.Rules.setStatus', '2', '1', '0', '1', '0', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\Rules@setStatus', '1', '0', '', '1572850517', '1572850517', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3000', '200', '店面管理', '店面管理', '', '', '', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\Stores', '1', '0', '', '1572850517', '1572850517', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3001', '3000', '获取店面列表', '获取店面列表', '', '', '/sys/admin/Rbac.v1.Stores.getList', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\Stores@getList', '1', '0', '', '1572850517', '1572850517', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3002', '3000', '获取店面详情', '获取店面详情', '', '', '/sys/admin/Rbac.v1.Stores.getItemById', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\Stores@getItemById', '1', '0', '', '1572850517', '1572850517', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3003', '3000', '添加店面', '添加店面', '', '', '/sys/admin/Rbac.v1.Stores.add', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\Stores@add', '1', '0', '', '1572850517', '1572850517', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3004', '3000', '更改店面', '更改店面', '', '', '/sys/admin/Rbac.v1.Stores.edit', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\Stores@edit', '1', '0', '', '1572850517', '1572850517', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3005', '3000', '删除店面', '删除店面', '', '', '/sys/admin/Rbac.v1.Stores.delete', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\Stores@delete', '1', '0', '', '1572850517', '1572850517', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3100', '200', '管理员管理', '管理员管理', '', '', '', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\Users', '1', '0', '', '1572850518', '1572850518', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3101', '3100', '获取管理员列表', '获取管理员列表', '', '', '/sys/admin/Rbac.v1.Users.getList', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\Users@getList', '1', '0', '', '1572850518', '1572850518', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3102', '3100', '获取管理员详情', '获取管理员详情', '', '', '/sys/admin/Rbac.v1.Users.getItemById', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\Users@getItemById', '1', '0', '', '1572850518', '1572850518', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3103', '3100', '管理员登录', '管理员登录', '', '', '/sys/admin/Rbac.v1.Users.login', '2', '0', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\Users@login', '1', '0', '', '1572850518', '1572850518', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3104', '3100', '管理员注销', '管理员注销', '', '', '/sys/admin/Rbac.v1.Users.logout', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\Users@logout', '1', '0', '', '1572850518', '1572850518', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3105', '3100', '更改密码', '更改密码', '', '', '/sys/admin/Rbac.v1.Users.changePasswd', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\Users@changePasswd', '1', '0', '', '1572850518', '1572850518', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3106', '3100', '重置密码', '重置密码', '', '', '/sys/admin/Rbac.v1.Users.resetPasswd', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\Users@resetPasswd', '1', '0', '', '1572850518', '1572850518', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3107', '3100', '设置管理员状态', '设置管理员状态', '', '', '/sys/admin/Rbac.v1.Users.setStatus', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\Users@setStatus', '1', '0', '', '1572850518', '1572850518', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3108', '3100', '添加管理员', '添加管理员', '', '', '/sys/admin/Rbac.v1.Users.add', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\Users@add', '1', '0', '', '1572850518', '1572850518', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3109', '3100', '更改管理员', '更改管理员', '', '', '/sys/admin/Rbac.v1.Users.edit', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\Users@edit', '1', '0', '', '1572850518', '1572850518', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3110', '3100', '删除管理员', '删除管理员', '', '', '/sys/admin/Rbac.v1.Users.delete', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\Users@delete', '1', '0', '', '1572850518', '1572850518', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3200', '200', '管理员角色关联', '管理员角色关联', '', '', '', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\UserRoles', '1', '0', '', '1572850518', '1572850518', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3201', '3200', '获取管理员关联的角色ID列表', '获取管理员关联的角色ID列表', '', '', '/sys/admin/Rbac.v1.Userroles.getRoleIDsList', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\UserRoles@getRoleIDsList', '1', '0', '', '1572850519', '1572850519', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3202', '3200', '获取管理员关联的角色列表', '获取管理员关联的角色列表', '', '', '/sys/admin/Rbac.v1.Userroles.getRoleList', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\UserRoles@getRoleList', '1', '0', '', '1572850519', '1572850519', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3203', '3200', '获取用户角色对应规则列表', '获取用户角色对应规则列表', '', '', '/sys/admin/Rbac.v1.Userroles.getUserRoleRuleList', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\UserRoles@getUserRoleRuleList', '1', '0', '', '1572850519', '1572850519', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3204', '3200', '获取管理员角色对应拒绝访问的规则列表', '获取管理员角色对应拒绝访问的规则列表', '', '', '/sys/admin/Rbac.v1.Userroles.getUserRoleRuleRejectList', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\UserRoles@getUserRoleRuleRejectList', '1', '0', '', '1572850519', '1572850519', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3205', '3200', '获取管理员角色对应菜单列表', '获取管理员角色对应菜单列表', '', '', '/sys/admin/Rbac.v1.Userroles.getUserRoleRuleMenuList', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\UserRoles@getUserRoleRuleMenuList', '1', '0', '', '1572850519', '1572850519', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3206', '3200', '添加更改管理员对应角色列表（批量）', '添加更改管理员对应角色列表（批量）', '', '', '/sys/admin/Rbac.v1.Userroles.setRoles', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\UserRoles@setRoles', '1', '0', '', '1572850519', '1572850519', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3207', '3200', '获取管理员角色关联列表', '获取管理员角色关联列表', '', '', '/sys/admin/Rbac.v1.UserRoles.getList', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\UserRoles@getList', '1', '0', '', '1572850519', '1572850519', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3208', '3200', '获取管理员角色关联详情', '获取管理员角色关联详情', '', '', '/sys/admin/Rbac.v1.UserRoles.getItemById', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\UserRoles@getItemById', '1', '0', '', '1572850519', '1572850519', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3209', '3200', '添加管理员角色关联', '添加管理员角色关联', '', '', '/sys/admin/Rbac.v1.UserRoles.add', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\UserRoles@add', '1', '0', '', '1572850519', '1572850519', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3210', '3200', '更改管理员角色关联', '更改管理员角色关联', '', '', '/sys/admin/Rbac.v1.UserRoles.edit', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\UserRoles@edit', '1', '0', '', '1572850519', '1572850519', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3211', '3200', '删除管理员角色关联', '删除管理员角色关联', '', '', '/sys/admin/Rbac.v1.UserRoles.delete', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\UserRoles@delete', '1', '0', '', '1572850519', '1572850519', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3300', '200', '管理员店面关联', '管理员店面关联', '', '', '', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\UserStores', '1', '0', '', '1572850519', '1572850519', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3301', '3300', '获取管理员店面关联列表', '获取管理员店面关联列表', '', '', '/sys/admin/Rbac.v1.Userstores.getStoreIDsList', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\UserStores@getStoreIDsList', '1', '0', '', '1572850520', '1572850520', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3302', '3300', '获取管理员关联的店面列表', '获取管理员关联的店面列表', '', '', '/sys/admin/Rbac.v1.Userstores.getStoreList', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\UserStores@getStoreList', '1', '0', '', '1572850520', '1572850520', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3303', '3300', '添加更改管理员对应店面列表（批量）', '添加更改管理员对应店面列表（批量）', '', '', '/sys/admin/Rbac.v1.Userstores.setStores', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\UserStores@setStores', '1', '0', '', '1572850520', '1572850520', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3304', '3300', '获取店长列表', '获取店长列表', '', '', '/sys/admin/Rbac.v1.Userstores.getStoreManager', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\UserStores@getStoreManager', '1', '0', '', '1572850520', '1572850520', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3305', '3300', '获取店员列表', '获取店员列表', '', '', '/sys/admin/Rbac.v1.Userstores.getStoreClerk', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\UserStores@getStoreClerk', '1', '0', '', '1572850520', '1572850520', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3306', '3300', '获取管理员店面关联列表', '获取管理员店面关联列表', '', '', '/sys/admin/Rbac.v1.UserStores.getList', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\UserStores@getList', '1', '0', '', '1572850520', '1572850520', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3307', '3300', '获取管理员店面关联详情', '获取管理员店面关联详情', '', '', '/sys/admin/Rbac.v1.UserStores.getItemById', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\UserStores@getItemById', '1', '0', '', '1572850520', '1572850520', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3308', '3300', '添加管理员店面关联', '添加管理员店面关联', '', '', '/sys/admin/Rbac.v1.UserStores.add', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\UserStores@add', '1', '0', '', '1572850520', '1572850520', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3309', '3300', '更改管理员店面关联', '更改管理员店面关联', '', '', '/sys/admin/Rbac.v1.UserStores.edit', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\UserStores@edit', '1', '0', '', '1572850520', '1572850520', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3310', '3300', '删除管理员店面关联', '删除管理员店面关联', '', '', '/sys/admin/Rbac.v1.UserStores.delete', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Rbac\\admin\\controller\\UserStores@delete', '1', '0', '', '1572850520', '1572850520', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3400', '200', '轮播图', '轮播图', '', '', '', '2', '1', '1', '1', '0', '1', 'app\\sys\\com\\Slide\\admin\\controller\\Slides', '1', '0', '', '1572850520', '1572850520', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3401', '3400', '获取轮播图列表', '获取轮播图列表', '', '', '/sys/admin/Slide.v1.Slides.getList', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Slide\\admin\\controller\\Slides@getList', '1', '0', '', '1572850520', '1572850520', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3402', '3400', '获取轮播图详情', '获取轮播图详情', '', '', '/sys/admin/Slide.v1.Slides.getItemById', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Slide\\admin\\controller\\Slides@getItemById', '1', '0', '', '1572850521', '1572850521', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3403', '3400', '更改轮播图', '更改轮播图', '', '', '/sys/admin/Slide.v1.Slides.edit', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Slide\\admin\\controller\\Slides@edit', '1', '0', '', '1572850521', '1572850521', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3404', '3400', '删除轮播图', '删除轮播图', '', '', '/sys/admin/Slide.v1.Slides.delete', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Slide\\admin\\controller\\Slides@delete', '1', '0', '', '1572850521', '1572850521', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3405', '3400', '更改轮播图状态', '更改轮播图状态', '', '', '/sys/admin/Slide.v1.Slides.setStatus', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\Slide\\admin\\controller\\Slides@setStatus', '1', '0', '', '1572850521', '1572850521', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3500', '200', '上传视频', '上传视频', '', '', '', '2', '1', '0', '1', '0', '1', 'app\\sys\\com\\Update\\admin\\controller\\Medias', '1', '0', '', '1572850521', '1572850521', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3501', '3500', '获取上传视频列表', '获取上传视频列表', '', '', '/sys/admin/Update.v1.Medias.getList', '2', '1', '0', '1', '0', '1', 'app\\sys\\com\\Update\\admin\\controller\\Medias@getList', '1', '0', '', '1572850521', '1572850521', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3502', '3500', '获取上传视频详情', '获取上传视频详情', '', '', '/sys/admin/Update.v1.Medias.getItemById', '2', '1', '0', '1', '0', '1', 'app\\sys\\com\\Update\\admin\\controller\\Medias@getItemById', '1', '0', '', '1572850521', '1572850521', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3503', '3500', '添加上传视频', '添加上传视频', '', '', '/sys/admin/Update.v1.Medias.add', '2', '1', '0', '1', '0', '1', 'app\\sys\\com\\Update\\admin\\controller\\Medias@add', '1', '0', '', '1572850521', '1572850521', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3504', '3500', '更改上传视频', '更改上传视频', '', '', '/sys/admin/Update.v1.Medias.edit', '2', '1', '0', '1', '0', '1', 'app\\sys\\com\\Update\\admin\\controller\\Medias@edit', '1', '0', '', '1572850521', '1572850521', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3505', '3500', '删除上传视频', '删除上传视频', '', '', '/sys/admin/Update.v1.Medias.delete', '2', '1', '0', '1', '0', '1', 'app\\sys\\com\\Update\\admin\\controller\\Medias@delete', '1', '0', '', '1572850522', '1572850522', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3600', '200', '用户管理', '用户管理', '', '', '', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\User\\admin\\controller\\Users', '1', '0', '', '1572850522', '1572850522', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3601', '3600', '获取用户列表', '获取用户列表', '', '', '/sys/admin/User.v1.Users.getList', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\User\\admin\\controller\\Users@getList', '1', '0', '', '1572850522', '1572850522', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3602', '3600', '获取用户详情', '获取用户详情', '', '', '/sys/admin/User.v1.Users.getItemById', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\User\\admin\\controller\\Users@getItemById', '1', '0', '', '1572850522', '1572850522', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3603', '3600', '更改密码', '更改密码', '', '', '/sys/admin/User.v1.Users.changePasswd', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\User\\admin\\controller\\Users@changePasswd', '1', '0', '', '1572850522', '1572850522', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3604', '3600', '重置密码', '重置密码', '', '', '/sys/admin/User.v1.Users.resetPasswd', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\User\\admin\\controller\\Users@resetPasswd', '1', '0', '', '1572850522', '1572850522', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3605', '3600', '设置用户状态', '设置用户状态', '', '', '/sys/admin/User.v1.Users.setStatus', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\User\\admin\\controller\\Users@setStatus', '1', '0', '', '1572850522', '1572850522', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3606', '3600', '添加用户', '添加用户', '', '', '/sys/admin/User.v1.Users.add', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\User\\admin\\controller\\Users@add', '1', '0', '', '1572850522', '1572850522', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3607', '3600', '更改用户', '更改用户', '', '', '/sys/admin/User.v1.Users.edit', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\User\\admin\\controller\\Users@edit', '1', '0', '', '1572850522', '1572850522', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3608', '3600', '删除用户', '删除用户', '', '', '/sys/admin/User.v1.Users.delete', '2', '1', '0', '1', '1', '1', 'app\\sys\\com\\User\\admin\\controller\\Users@delete', '1', '0', '', '1572850523', '1572850523', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3700', '200', '用户分享记录', '用户分享记录', '', '', '', '2', '1', '0', '1', '0', '1', 'app\\sys\\com\\User\\admin\\controller\\ShareRecords', '1', '0', '', '1572850523', '1572850523', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3701', '3700', '获取用户分享记录', '获取用户分享记录', '', '', '/sys/admin/User.v1.ShareRecords.getList', '2', '1', '0', '1', '0', '1', 'app\\sys\\com\\User\\admin\\controller\\ShareRecords@getList', '1', '0', '', '1572850523', '1572850523', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3702', '3700', '获取用户分享记录', '获取用户分享记录', '', '', '/sys/admin/User.v1.ShareRecords.getItemById', '2', '1', '0', '1', '0', '1', 'app\\sys\\com\\User\\admin\\controller\\ShareRecords@getItemById', '1', '0', '', '1572850523', '1572850523', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3703', '3700', '添加用户分享记录', '添加用户分享记录', '', '', '/sys/admin/User.v1.ShareRecords.add', '2', '1', '0', '1', '0', '1', 'app\\sys\\com\\User\\admin\\controller\\ShareRecords@add', '1', '0', '', '1572850523', '1572850523', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3704', '3700', '更改用户分享记录', '更改用户分享记录', '', '', '/sys/admin/User.v1.ShareRecords.edit', '2', '1', '0', '1', '0', '1', 'app\\sys\\com\\User\\admin\\controller\\ShareRecords@edit', '1', '0', '', '1572850523', '1572850523', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3705', '3700', '删除用户分享记录', '删除用户分享记录', '', '', '/sys/admin/User.v1.ShareRecords.delete', '2', '1', '0', '1', '0', '1', 'app\\sys\\com\\User\\admin\\controller\\ShareRecords@delete', '1', '0', '', '1572850523', '1572850523', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3706', '3700', '更改用户分享记录', '更改用户分享记录', '', '', '/sys/admin/User.v1.ShareRecords.setStatus', '2', '1', '0', '1', '0', '1', 'app\\sys\\com\\User\\admin\\controller\\ShareRecords@setStatus', '1', '0', '', '1572850523', '1572850523', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3800', '200', '第三方登录记录', '第三方登录记录', '', '', '', '2', '1', '0', '1', '0', '1', 'app\\sys\\com\\User\\admin\\controller\\Thirds', '1', '0', '', '1572850523', '1572850523', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3801', '3800', '获取第三方登录记录列表', '获取第三方登录记录列表', '', '', '/sys/admin/User.v1.Thirds.getList', '2', '1', '0', '1', '0', '1', 'app\\sys\\com\\User\\admin\\controller\\Thirds@getList', '1', '0', '', '1572850524', '1572850524', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3802', '3800', '获取第三方登录记录详情', '获取第三方登录记录详情', '', '', '/sys/admin/User.v1.Thirds.getItemById', '2', '1', '0', '1', '0', '1', 'app\\sys\\com\\User\\admin\\controller\\Thirds@getItemById', '1', '0', '', '1572850524', '1572850524', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3803', '3800', '添加第三方登录记录', '添加第三方登录记录', '', '', '/sys/admin/User.v1.Thirds.add', '2', '1', '0', '1', '0', '1', 'app\\sys\\com\\User\\admin\\controller\\Thirds@add', '1', '0', '', '1572850524', '1572850524', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3804', '3800', '更改第三方登录记录', '更改第三方登录记录', '', '', '/sys/admin/User.v1.Thirds.edit', '2', '1', '0', '1', '0', '1', 'app\\sys\\com\\User\\admin\\controller\\Thirds@edit', '1', '0', '', '1572850524', '1572850524', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3805', '3800', '删除第三方登录记录', '删除第三方登录记录', '', '', '/sys/admin/User.v1.Thirds.delete', '2', '1', '0', '1', '0', '1', 'app\\sys\\com\\User\\admin\\controller\\Thirds@delete', '1', '0', '', '1572850525', '1572850525', '0');
INSERT INTO `wp_sys_rbac_rule` VALUES ('3806', '3800', '更改第三方登录记录状态', '更改第三方登录记录状态', '', '', '/sys/admin/User.v1.Thirds.setStatus', '2', '1', '0', '1', '0', '1', 'app\\sys\\com\\User\\admin\\controller\\Thirds@setStatus', '1', '0', '', '1572850525', '1572850525', '0');

-- ----------------------------
-- Table structure for `wp_sys_rbac_store`
-- ----------------------------
DROP TABLE IF EXISTS `wp_sys_rbac_store`;
CREATE TABLE `wp_sys_rbac_store` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '店面名称',
  `province` varchar(20) CHARACTER SET utf8 NOT NULL COMMENT '省',
  `city` varchar(20) CHARACTER SET utf8 NOT NULL COMMENT '市',
  `area` varchar(20) CHARACTER SET utf8 NOT NULL COMMENT '区',
  `address` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '详细地址',
  `storekeeper_name` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT '店主',
  `mobile` varchar(20) CHARACTER SET utf8 NOT NULL COMMENT '电话',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  `delete_time` int(11) NOT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='店面表\r\n@name 店面\r\n@is_menu 0\r\n@is_api 1\r\n@is_show 1\r\n@is_auth 1';

-- ----------------------------
-- Records of wp_sys_rbac_store
-- ----------------------------
INSERT INTO `wp_sys_rbac_store` VALUES ('1', '奥迪专卖店3', '北京市', '市辖区', '东城区', '东城区xx街', '张亮', '18712345678', '1566900688', '1566901808', '0');
INSERT INTO `wp_sys_rbac_store` VALUES ('2', '奥迪专卖店2', '北京市', '市辖区', '东城区', '东城区xx街', '张亮', '18712345678', '1566901670', '1566901670', '0');
INSERT INTO `wp_sys_rbac_store` VALUES ('3', '奥迪专卖店1', '北京市', '市辖区', '东城区', '和平区奥迪', '王', '18712345678', '1567158920', '1567158920', '0');
INSERT INTO `wp_sys_rbac_store` VALUES ('4', '123', '', '', '', '', '', '', '1567420369', '1567587652', '1567587652');
INSERT INTO `wp_sys_rbac_store` VALUES ('5', '123', '天津市', '市辖区', '南开区', '南开', '周', '18712345678', '1567420413', '1567587655', '1567587655');
INSERT INTO `wp_sys_rbac_store` VALUES ('6', '123++++', '北京市', '市辖区', '东城区', '南开', '周', '18712345678', '1567508547', '1567508562', '1567508562');
INSERT INTO `wp_sys_rbac_store` VALUES ('7', '123+', '北京市', '市辖区', '东城区', '南开', '周', '18712345678', '1567508554', '1567587657', '1567587657');
INSERT INTO `wp_sys_rbac_store` VALUES ('8', '123++', '北京市', '市辖区', '东城区', '南开', '周', '18712345678', '1567508567', '1567508588', '1567508588');
INSERT INTO `wp_sys_rbac_store` VALUES ('9', '新飞汽车销售服务公司', '北京市', '市辖区', '房山区', '通达大街111号', '张飞', '15699998888', '1567666642', '1567666642', '0');

-- ----------------------------
-- Table structure for `wp_sys_rbac_user`
-- ----------------------------
DROP TABLE IF EXISTS `wp_sys_rbac_user`;
CREATE TABLE `wp_sys_rbac_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '用户名',
  `passwd` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '密码',
  `nickname` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '昵称',
  `avatar` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '头像',
  `mobile` varchar(20) CHARACTER SET utf8 NOT NULL COMMENT '电话',
  `is_root` tinyint(3) NOT NULL DEFAULT '1' COMMENT '是否超级管理员（0-否 1-是）',
  `status` tinyint(3) NOT NULL COMMENT '状态（1启用 0禁用）',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  `delete_time` int(11) NOT NULL COMMENT '软删除标记',
  `pid` int(11) DEFAULT NULL COMMENT '所属的超管的id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='管理员表\r\n@name 管理员\r\n@is_menu 0\r\n@is_api 1\r\n@is_show 1\r\n@is_auth 1';

-- ----------------------------
-- Records of wp_sys_rbac_user
-- ----------------------------
INSERT INTO `wp_sys_rbac_user` VALUES ('1', 'admin', '14e1b600b1fd579f47433b88e8d85291', '超级管理员', '', '', '1', '1', '0', '1570765109', '0', '0');
INSERT INTO `wp_sys_rbac_user` VALUES ('2', 'user', '14e1b600b1fd579f47433b88e8d85291', '普通用户', '', '', '1', '1', '0', '0', '0', '0');
INSERT INTO `wp_sys_rbac_user` VALUES ('3', 'user1', '14e1b600b1fd579f47433b88e8d85291', 'nick', '', '', '0', '1', '1567161408', '1567161408', '0', '1');
INSERT INTO `wp_sys_rbac_user` VALUES ('4', 'admin2', '14e1b600b1fd579f47433b88e8d85291', 'nicke', '', '', '0', '1', '1567161433', '1567161433', '0', '2');
INSERT INTO `wp_sys_rbac_user` VALUES ('19', '324234', 'e10adc3949ba59abbe56e057f20f883e', '32424', '', '32343242', '0', '1', '1572852554', '1572852631', '1572852631', '1');
INSERT INTO `wp_sys_rbac_user` VALUES ('20', '123456', '14e1b600b1fd579f47433b88e8d85291', '32424', '', '32343242', '0', '1', '1572852599', '1572852663', '0', '1');

-- ----------------------------
-- Table structure for `wp_sys_rbac_user_role`
-- ----------------------------
DROP TABLE IF EXISTS `wp_sys_rbac_user_role`;
CREATE TABLE `wp_sys_rbac_user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `role_id` int(11) NOT NULL COMMENT '角色id',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='管理员角色关联表\r\n@name 管理员角色关联\r\n@is_menu 0\r\n@is_api 1\r\n@is_show 1\r\n@is_auth 1';

-- ----------------------------
-- Records of wp_sys_rbac_user_role
-- ----------------------------
INSERT INTO `wp_sys_rbac_user_role` VALUES ('34', '1', '7', '1567664070', '1567664070');
INSERT INTO `wp_sys_rbac_user_role` VALUES ('35', '4', '8', '1567665041', '1567665041');
INSERT INTO `wp_sys_rbac_user_role` VALUES ('37', '2', '7', '0', '0');
INSERT INTO `wp_sys_rbac_user_role` VALUES ('38', '3', '8', '0', '0');
INSERT INTO `wp_sys_rbac_user_role` VALUES ('39', '20', '8', '1572852601', '1572852601');

-- ----------------------------
-- Table structure for `wp_sys_rbac_user_store`
-- ----------------------------
DROP TABLE IF EXISTS `wp_sys_rbac_user_store`;
CREATE TABLE `wp_sys_rbac_user_store` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `store_id` int(11) NOT NULL COMMENT '店面id',
  `identity_type` tinyint(4) NOT NULL DEFAULT '2' COMMENT '身份类型（0-未知 1-店长 2-店员）',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='管理员店面关联表\r\n@name 管理员店面关联\r\n@is_menu 0\r\n@is_api 1\r\n@is_show 1\r\n@is_auth 1';

-- ----------------------------
-- Records of wp_sys_rbac_user_store
-- ----------------------------
INSERT INTO `wp_sys_rbac_user_store` VALUES ('7', '4', '2', '2', '1567165513', '1567165513');
INSERT INTO `wp_sys_rbac_user_store` VALUES ('11', '1', '3', '1', '1567497015', '1567497015');
INSERT INTO `wp_sys_rbac_user_store` VALUES ('40', '5', '3', '1', '1567587684', '1567587684');
INSERT INTO `wp_sys_rbac_user_store` VALUES ('41', '8', '9', '1', '1567666832', '1567666832');
INSERT INTO `wp_sys_rbac_user_store` VALUES ('42', '9', '9', '2', '1567669392', '1567669392');
INSERT INTO `wp_sys_rbac_user_store` VALUES ('43', '10', '9', '2', '1567669508', '1567669508');

-- ----------------------------
-- Table structure for `wp_sys_slide`
-- ----------------------------
DROP TABLE IF EXISTS `wp_sys_slide`;
CREATE TABLE `wp_sys_slide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '标题',
  `intro` text CHARACTER SET utf8 NOT NULL COMMENT '简介',
  `img` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '图片',
  `url` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '链接',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '类型（0-未知 1-首页）',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态（0-未知 1-启用 2-禁用）',
  `remark` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '备注',
  `addon_name` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '应用名称',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  `delete_time` int(11) NOT NULL COMMENT '软删除标记',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='轮播图表\r\n@name 轮播图\r\n@is_menu 0\r\n@is_api 1\r\n@is_show 1\r\n@is_auth 1';

-- ----------------------------
-- Records of wp_sys_slide
-- ----------------------------
INSERT INTO `wp_sys_slide` VALUES ('3', '第一张', '1212', '/uploads/d6/683192d337a9dd643d02b84a53f940.jpg', '', '1', '1', '', '', '1567075517', '1573545779', '1573545779');
INSERT INTO `wp_sys_slide` VALUES ('5', '第二张', '', '/uploads/95/30ee872686eb4b55cee31d48d325b8.jpg', '', '1', '1', '', '', '1567415809', '1573545775', '1573545775');
INSERT INTO `wp_sys_slide` VALUES ('6', '第三张', '', '/uploads/e0/488c7a7f482c8832e6f3a17e4792ba.jpg', '', '1', '1', '', '', '1567415825', '1573545773', '1573545773');
INSERT INTO `wp_sys_slide` VALUES ('8', '第四张', '111', '/uploads/e3/6e3c0bd645a85527bed3df11b5812a.jpg', '', '1', '1', '', '', '1567560555', '1573545769', '1573545769');
INSERT INTO `wp_sys_slide` VALUES ('9', '2542', '2f', '/uploads/b6/789b8f226c18ed0139bffbc0e98be7.jpg', '', '1', '1', '', '', '1571029950', '1571030008', '1571030007');
INSERT INTO `wp_sys_slide` VALUES ('10', 'gggg', '这是个图片', '/uploads/4f/7b37b7ef20b72de033af82c40832fd.png', '', '1', '1', '', '', '1572665713', '1573613184', '0');
INSERT INTO `wp_sys_slide` VALUES ('11', '轮播图', '轮播图杀鸡', '/uploads/dd/efe0692c1b5966d0616c00bffe27a0.jpg', 'https://www.yuzhua.com/qy/gszc/type/2.html', '1', '1', '', '', '1573545836', '1573612400', '0');

-- ----------------------------
-- Table structure for `wp_sys_update_media`
-- ----------------------------
DROP TABLE IF EXISTS `wp_sys_update_media`;
CREATE TABLE `wp_sys_update_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 NOT NULL COMMENT '文件名称',
  `media` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '媒体视频',
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='上传媒体视频信息表\r\n@name 上传视频\r\n@is_api 0\r\n@is_show 0\r\n@is_auth 0';

-- ----------------------------
-- Records of wp_sys_update_media
-- ----------------------------
INSERT INTO `wp_sys_update_media` VALUES ('32', '89fb0668883982ede4eb3783d7d19c.mp4', 'uploads/75/89fb0668883982ede4eb3783d7d19c.mp4', '1570614762');
INSERT INTO `wp_sys_update_media` VALUES ('33', 'fe98bee1fbe9d1a5d92314623c9ea7.MOV', 'uploads/c2/fe98bee1fbe9d1a5d92314623c9ea7.MOV', '1570864141');
INSERT INTO `wp_sys_update_media` VALUES ('34', '38ba8cb9b70943328b388f8579e836.MOV', 'uploads/fe/38ba8cb9b70943328b388f8579e836.MOV', '1570871713');
INSERT INTO `wp_sys_update_media` VALUES ('35', '9e4e17966071f9299e19161af4107e.mp4', 'uploads/84/9e4e17966071f9299e19161af4107e.mp4', '1571031860');
INSERT INTO `wp_sys_update_media` VALUES ('36', '8358cb03823296d45b954661518401.mp4', 'uploads/27/8358cb03823296d45b954661518401.mp4', '1571128809');
INSERT INTO `wp_sys_update_media` VALUES ('37', 'aef20c0240aa6400c978ce99ba93c0.MP4', 'uploads/82/aef20c0240aa6400c978ce99ba93c0.MP4', '1571132511');
INSERT INTO `wp_sys_update_media` VALUES ('38', '4c3f2373b3d01ba78a75d153d04fe3.MP4', 'uploads/fb/4c3f2373b3d01ba78a75d153d04fe3.MP4', '1571379093');

-- ----------------------------
-- Table structure for `wp_sys_update_picture`
-- ----------------------------
DROP TABLE IF EXISTS `wp_sys_update_picture`;
CREATE TABLE `wp_sys_update_picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 NOT NULL COMMENT '文件名称',
  `thumb` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '缩略图',
  `picture` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '原图',
  `reduce` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT '质量缩小正方图',
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='上传图片信息表\r\n@name 上传图片\r\n@is_api 0\r\n@is_show 0\r\n@is_auth 0';

-- ----------------------------
-- Records of wp_sys_update_picture
-- ----------------------------
INSERT INTO `wp_sys_update_picture` VALUES ('1', '2d0cf4ff5af74153344101fc466dd2.PNG', 'uploads/thumb/e7/2d0cf4ff5af74153344101fc466dd2.PNG', 'uploads/e7/2d0cf4ff5af74153344101fc466dd2.PNG', 'uploads/reduce/e7/2d0cf4ff5af74153344101fc466dd2.PNG', '1546276980');
INSERT INTO `wp_sys_update_picture` VALUES ('2', 'c71ec69624de9a4606257adc853cee.jpg', 'uploads/thumb/37/c71ec69624de9a4606257adc853cee.jpg', 'uploads/37/c71ec69624de9a4606257adc853cee.jpg', 'uploads/reduce/37/c71ec69624de9a4606257adc853cee.jpg', '1546277097');
INSERT INTO `wp_sys_update_picture` VALUES ('3', '56f4f35c778cfc9d594829ef027533.jpg', 'uploads/thumb/bd/56f4f35c778cfc9d594829ef027533.jpg', 'uploads/bd/56f4f35c778cfc9d594829ef027533.jpg', 'uploads/reduce/bd/56f4f35c778cfc9d594829ef027533.jpg', '1547092986');
INSERT INTO `wp_sys_update_picture` VALUES ('4', '5922981ee34a494301328cac865aee.jpg', 'uploads/thumb/05/5922981ee34a494301328cac865aee.jpg', 'uploads/05/5922981ee34a494301328cac865aee.jpg', 'uploads/reduce/05/5922981ee34a494301328cac865aee.jpg', '1565254384');
INSERT INTO `wp_sys_update_picture` VALUES ('5', '8bc0d52a1e643b04e4a169f8682eaf.jpg', 'uploads/thumb/13/8bc0d52a1e643b04e4a169f8682eaf.jpg', 'uploads/13/8bc0d52a1e643b04e4a169f8682eaf.jpg', 'uploads/reduce/13/8bc0d52a1e643b04e4a169f8682eaf.jpg', '1565432177');
INSERT INTO `wp_sys_update_picture` VALUES ('6', '481dfe2c1683571d917d40176b4e23.jpg', 'uploads/thumb/e8/481dfe2c1683571d917d40176b4e23.jpg', 'uploads/e8/481dfe2c1683571d917d40176b4e23.jpg', 'uploads/reduce/e8/481dfe2c1683571d917d40176b4e23.jpg', '1566874322');
INSERT INTO `wp_sys_update_picture` VALUES ('7', 'a1a76441b4da770097e1af0a650b93.png', 'uploads/thumb/e0/a1a76441b4da770097e1af0a650b93.png', 'uploads/e0/a1a76441b4da770097e1af0a650b93.png', 'uploads/reduce/e0/a1a76441b4da770097e1af0a650b93.png', '1566886731');
INSERT INTO `wp_sys_update_picture` VALUES ('8', 'b96bbb19c82b712538d9eba562873a.png', 'uploads/thumb/b5/b96bbb19c82b712538d9eba562873a.png', 'uploads/b5/b96bbb19c82b712538d9eba562873a.png', 'uploads/reduce/b5/b96bbb19c82b712538d9eba562873a.png', '1566887320');
INSERT INTO `wp_sys_update_picture` VALUES ('9', 'ff64e06df8fdae6a177274a36e63bf.jpg', 'uploads/thumb/b0/ff64e06df8fdae6a177274a36e63bf.jpg', 'uploads/b0/ff64e06df8fdae6a177274a36e63bf.jpg', 'uploads/reduce/b0/ff64e06df8fdae6a177274a36e63bf.jpg', '1566891768');
INSERT INTO `wp_sys_update_picture` VALUES ('10', '90ca1feb2fc0b45f1c8096a1d7ef32.jpg', 'uploads/thumb/32/90ca1feb2fc0b45f1c8096a1d7ef32.jpg', 'uploads/32/90ca1feb2fc0b45f1c8096a1d7ef32.jpg', 'uploads/reduce/32/90ca1feb2fc0b45f1c8096a1d7ef32.jpg', '1566892194');
INSERT INTO `wp_sys_update_picture` VALUES ('11', '001345982eafaf930f4479c2a1f038.png', 'uploads/thumb/bc/001345982eafaf930f4479c2a1f038.png', 'uploads/bc/001345982eafaf930f4479c2a1f038.png', 'uploads/reduce/bc/001345982eafaf930f4479c2a1f038.png', '1566892200');
INSERT INTO `wp_sys_update_picture` VALUES ('12', '4095cab44a7860197eb513a1f8f069.jpg', 'uploads/thumb/c5/4095cab44a7860197eb513a1f8f069.jpg', 'uploads/c5/4095cab44a7860197eb513a1f8f069.jpg', 'uploads/reduce/c5/4095cab44a7860197eb513a1f8f069.jpg', '1566892919');
INSERT INTO `wp_sys_update_picture` VALUES ('13', '94c717bd82b07e5847fad6722cf4ce.jpg', 'uploads/thumb/83/94c717bd82b07e5847fad6722cf4ce.jpg', 'uploads/83/94c717bd82b07e5847fad6722cf4ce.jpg', 'uploads/reduce/83/94c717bd82b07e5847fad6722cf4ce.jpg', '1566894018');
INSERT INTO `wp_sys_update_picture` VALUES ('14', '2c7e424defcde7ff52f166b5309370.jpg', 'uploads/thumb/e4/2c7e424defcde7ff52f166b5309370.jpg', 'uploads/e4/2c7e424defcde7ff52f166b5309370.jpg', 'uploads/reduce/e4/2c7e424defcde7ff52f166b5309370.jpg', '1566895523');
INSERT INTO `wp_sys_update_picture` VALUES ('15', '2129f0bd5f18e957e60bd4f7e2c118.jpg', 'uploads/thumb/47/2129f0bd5f18e957e60bd4f7e2c118.jpg', 'uploads/47/2129f0bd5f18e957e60bd4f7e2c118.jpg', 'uploads/reduce/47/2129f0bd5f18e957e60bd4f7e2c118.jpg', '1566895524');
INSERT INTO `wp_sys_update_picture` VALUES ('16', '789b8f226c18ed0139bffbc0e98be7.jpg', 'uploads/thumb/b6/789b8f226c18ed0139bffbc0e98be7.jpg', 'uploads/b6/789b8f226c18ed0139bffbc0e98be7.jpg', 'uploads/reduce/b6/789b8f226c18ed0139bffbc0e98be7.jpg', '1566895527');
INSERT INTO `wp_sys_update_picture` VALUES ('17', '2f8290ea4edf9d5e8a0bf550da19fc.jpg', 'uploads/thumb/22/2f8290ea4edf9d5e8a0bf550da19fc.jpg', 'uploads/22/2f8290ea4edf9d5e8a0bf550da19fc.jpg', 'uploads/reduce/22/2f8290ea4edf9d5e8a0bf550da19fc.jpg', '1567667322');
INSERT INTO `wp_sys_update_picture` VALUES ('19', '7ba32668ebc629b2ea56efefc3db87.jpg', 'uploads/thumb/98/7ba32668ebc629b2ea56efefc3db87.jpg', 'uploads/98/7ba32668ebc629b2ea56efefc3db87.jpg', 'uploads/reduce/98/7ba32668ebc629b2ea56efefc3db87.jpg', '1570439676');
INSERT INTO `wp_sys_update_picture` VALUES ('20', '6be0210cc4d23569e64a6c6db06152.jpg', 'uploads/thumb/c2/6be0210cc4d23569e64a6c6db06152.jpg', 'uploads/c2/6be0210cc4d23569e64a6c6db06152.jpg', 'uploads/reduce/c2/6be0210cc4d23569e64a6c6db06152.jpg', '1570440022');
INSERT INTO `wp_sys_update_picture` VALUES ('21', '0ef1bf7e9801670b59e390ddc8a951.png', 'uploads/thumb/68/0ef1bf7e9801670b59e390ddc8a951.png', 'uploads/68/0ef1bf7e9801670b59e390ddc8a951.png', 'uploads/reduce/68/0ef1bf7e9801670b59e390ddc8a951.png', '1570441044');
INSERT INTO `wp_sys_update_picture` VALUES ('22', 'fafd8c9a3a4a8d679c4e1b6e542e78.jpg', 'uploads/thumb/ff/fafd8c9a3a4a8d679c4e1b6e542e78.jpg', 'uploads/ff/fafd8c9a3a4a8d679c4e1b6e542e78.jpg', 'uploads/reduce/ff/fafd8c9a3a4a8d679c4e1b6e542e78.jpg', '1570441173');
INSERT INTO `wp_sys_update_picture` VALUES ('23', '9280693b25b8c02d4a89476624a4ae.jpg', 'uploads/thumb/17/9280693b25b8c02d4a89476624a4ae.jpg', 'uploads/17/9280693b25b8c02d4a89476624a4ae.jpg', 'uploads/reduce/17/9280693b25b8c02d4a89476624a4ae.jpg', '1570518143');
INSERT INTO `wp_sys_update_picture` VALUES ('24', '747287bf612d5b330c9218bc692fa6.jpg', 'uploads/thumb/68/747287bf612d5b330c9218bc692fa6.jpg', 'uploads/68/747287bf612d5b330c9218bc692fa6.jpg', 'uploads/reduce/68/747287bf612d5b330c9218bc692fa6.jpg', '1570519227');
INSERT INTO `wp_sys_update_picture` VALUES ('25', '50289c3f7602c25b179ad7ff8c166e.jpg', 'uploads/thumb/98/50289c3f7602c25b179ad7ff8c166e.jpg', 'uploads/98/50289c3f7602c25b179ad7ff8c166e.jpg', 'uploads/reduce/98/50289c3f7602c25b179ad7ff8c166e.jpg', '1570519363');
INSERT INTO `wp_sys_update_picture` VALUES ('26', '30ee872686eb4b55cee31d48d325b8.jpg', 'uploads/thumb/95/30ee872686eb4b55cee31d48d325b8.jpg', 'uploads/95/30ee872686eb4b55cee31d48d325b8.jpg', 'uploads/reduce/95/30ee872686eb4b55cee31d48d325b8.jpg', '1570519904');
INSERT INTO `wp_sys_update_picture` VALUES ('27', '431de76ccabc0ef3c7dd5dc73e7d1f.jpg', 'uploads/thumb/8a/431de76ccabc0ef3c7dd5dc73e7d1f.jpg', 'uploads/8a/431de76ccabc0ef3c7dd5dc73e7d1f.jpg', 'uploads/reduce/8a/431de76ccabc0ef3c7dd5dc73e7d1f.jpg', '1570520041');
INSERT INTO `wp_sys_update_picture` VALUES ('28', '488c7a7f482c8832e6f3a17e4792ba.jpg', 'uploads/thumb/e0/488c7a7f482c8832e6f3a17e4792ba.jpg', 'uploads/e0/488c7a7f482c8832e6f3a17e4792ba.jpg', 'uploads/reduce/e0/488c7a7f482c8832e6f3a17e4792ba.jpg', '1570520472');
INSERT INTO `wp_sys_update_picture` VALUES ('29', '683192d337a9dd643d02b84a53f940.jpg', 'uploads/thumb/d6/683192d337a9dd643d02b84a53f940.jpg', 'uploads/d6/683192d337a9dd643d02b84a53f940.jpg', 'uploads/reduce/d6/683192d337a9dd643d02b84a53f940.jpg', '1570520680');
INSERT INTO `wp_sys_update_picture` VALUES ('30', '6e3c0bd645a85527bed3df11b5812a.jpg', 'uploads/thumb/e3/6e3c0bd645a85527bed3df11b5812a.jpg', 'uploads/e3/6e3c0bd645a85527bed3df11b5812a.jpg', 'uploads/reduce/e3/6e3c0bd645a85527bed3df11b5812a.jpg', '1570522364');
INSERT INTO `wp_sys_update_picture` VALUES ('31', 'e9e5bd0e5a88a1135c8dad83bb45ad.jpg', 'uploads/thumb/4c/e9e5bd0e5a88a1135c8dad83bb45ad.jpg', 'uploads/4c/e9e5bd0e5a88a1135c8dad83bb45ad.jpg', 'uploads/reduce/4c/e9e5bd0e5a88a1135c8dad83bb45ad.jpg', '1570523036');
INSERT INTO `wp_sys_update_picture` VALUES ('32', 'd662548f1a0eb40c4d0fae514871b1.jpg', 'uploads/thumb/61/d662548f1a0eb40c4d0fae514871b1.jpg', 'uploads/61/d662548f1a0eb40c4d0fae514871b1.jpg', 'uploads/reduce/61/d662548f1a0eb40c4d0fae514871b1.jpg', '1570780519');
INSERT INTO `wp_sys_update_picture` VALUES ('33', 'c8762b38241025d15bcaa9b5f2074a.png', 'uploads/thumb/d2/c8762b38241025d15bcaa9b5f2074a.png', 'uploads/d2/c8762b38241025d15bcaa9b5f2074a.png', 'uploads/reduce/d2/c8762b38241025d15bcaa9b5f2074a.png', '1570789951');
INSERT INTO `wp_sys_update_picture` VALUES ('34', '868124293e98bd6cbeb1b7d8dd88e9.jpg', 'uploads/thumb/df/868124293e98bd6cbeb1b7d8dd88e9.jpg', 'uploads/df/868124293e98bd6cbeb1b7d8dd88e9.jpg', 'uploads/reduce/df/868124293e98bd6cbeb1b7d8dd88e9.jpg', '1570862165');
INSERT INTO `wp_sys_update_picture` VALUES ('35', 'ece82734cefb0c5bb43b72abee2013.jpg', 'uploads/thumb/ef/ece82734cefb0c5bb43b72abee2013.jpg', 'uploads/ef/ece82734cefb0c5bb43b72abee2013.jpg', 'uploads/reduce/ef/ece82734cefb0c5bb43b72abee2013.jpg', '1570862165');
INSERT INTO `wp_sys_update_picture` VALUES ('36', '5ec933db4bf0766895ad2619653923.jpg', 'uploads/thumb/50/5ec933db4bf0766895ad2619653923.jpg', 'uploads/50/5ec933db4bf0766895ad2619653923.jpg', 'uploads/reduce/50/5ec933db4bf0766895ad2619653923.jpg', '1571031191');
INSERT INTO `wp_sys_update_picture` VALUES ('37', 'a952ac195f505fd5ec4363a28130c8.jpg', 'uploads/thumb/22/a952ac195f505fd5ec4363a28130c8.jpg', 'uploads/22/a952ac195f505fd5ec4363a28130c8.jpg', 'uploads/reduce/22/a952ac195f505fd5ec4363a28130c8.jpg', '1571031379');
INSERT INTO `wp_sys_update_picture` VALUES ('38', '507f4e5679e6f0bcb7f90f7ed4b6b4.jpg', 'uploads/thumb/fd/507f4e5679e6f0bcb7f90f7ed4b6b4.jpg', 'uploads/fd/507f4e5679e6f0bcb7f90f7ed4b6b4.jpg', 'uploads/reduce/fd/507f4e5679e6f0bcb7f90f7ed4b6b4.jpg', '1571033863');
INSERT INTO `wp_sys_update_picture` VALUES ('39', '7658d52bc5cb07f9c95e44aaac98bc.jpg', 'uploads/thumb/b0/7658d52bc5cb07f9c95e44aaac98bc.jpg', 'uploads/b0/7658d52bc5cb07f9c95e44aaac98bc.jpg', 'uploads/reduce/b0/7658d52bc5cb07f9c95e44aaac98bc.jpg', '1571034945');
INSERT INTO `wp_sys_update_picture` VALUES ('40', 'c95ae7a12a43984fd0da89a237986f.jpg', 'uploads/thumb/8a/c95ae7a12a43984fd0da89a237986f.jpg', 'uploads/8a/c95ae7a12a43984fd0da89a237986f.jpg', 'uploads/reduce/8a/c95ae7a12a43984fd0da89a237986f.jpg', '1571106362');
INSERT INTO `wp_sys_update_picture` VALUES ('41', '4ae74afa694faa908b165e2de7a5e6.jpg', 'uploads/thumb/a6/4ae74afa694faa908b165e2de7a5e6.jpg', 'uploads/a6/4ae74afa694faa908b165e2de7a5e6.jpg', 'uploads/reduce/a6/4ae74afa694faa908b165e2de7a5e6.jpg', '1571106449');
INSERT INTO `wp_sys_update_picture` VALUES ('42', '590825889a3de476473fad9d98fc43.jpg', 'uploads/thumb/a2/590825889a3de476473fad9d98fc43.jpg', 'uploads/a2/590825889a3de476473fad9d98fc43.jpg', 'uploads/reduce/a2/590825889a3de476473fad9d98fc43.jpg', '1571126266');
INSERT INTO `wp_sys_update_picture` VALUES ('43', 'dcc6162fea8b303b124bdfb651ff3e.jpg', 'uploads/thumb/f7/dcc6162fea8b303b124bdfb651ff3e.jpg', 'uploads/f7/dcc6162fea8b303b124bdfb651ff3e.jpg', 'uploads/reduce/f7/dcc6162fea8b303b124bdfb651ff3e.jpg', '1571126268');
INSERT INTO `wp_sys_update_picture` VALUES ('44', '1b4db692ef1d9b16e8a68a854d315d.jpg', 'uploads/thumb/e9/1b4db692ef1d9b16e8a68a854d315d.jpg', 'uploads/e9/1b4db692ef1d9b16e8a68a854d315d.jpg', 'uploads/reduce/e9/1b4db692ef1d9b16e8a68a854d315d.jpg', '1571128809');
INSERT INTO `wp_sys_update_picture` VALUES ('45', '908584676709cc320cf4c5c80669fc.jpg', 'uploads/thumb/e4/908584676709cc320cf4c5c80669fc.jpg', 'uploads/e4/908584676709cc320cf4c5c80669fc.jpg', 'uploads/reduce/e4/908584676709cc320cf4c5c80669fc.jpg', '1571191780');
INSERT INTO `wp_sys_update_picture` VALUES ('46', '901f45a7f1f7c922ac728d8411e2f3.png', 'uploads/thumb/4a/901f45a7f1f7c922ac728d8411e2f3.png', 'uploads/4a/901f45a7f1f7c922ac728d8411e2f3.png', 'uploads/reduce/4a/901f45a7f1f7c922ac728d8411e2f3.png', '1571192229');
INSERT INTO `wp_sys_update_picture` VALUES ('47', '334d33112e34831d9436d374b0a014.jpg', 'uploads/thumb/7a/334d33112e34831d9436d374b0a014.jpg', 'uploads/7a/334d33112e34831d9436d374b0a014.jpg', 'uploads/reduce/7a/334d33112e34831d9436d374b0a014.jpg', '1571192809');
INSERT INTO `wp_sys_update_picture` VALUES ('48', '2d4d5e3de0b25a852051d4de8f1199.jpg', 'uploads/thumb/fa/2d4d5e3de0b25a852051d4de8f1199.jpg', 'uploads/fa/2d4d5e3de0b25a852051d4de8f1199.jpg', 'uploads/reduce/fa/2d4d5e3de0b25a852051d4de8f1199.jpg', '1571193137');
INSERT INTO `wp_sys_update_picture` VALUES ('49', 'eceed6a718f210cb4a407287bed54a.jpg', 'uploads/thumb/9f/eceed6a718f210cb4a407287bed54a.jpg', 'uploads/9f/eceed6a718f210cb4a407287bed54a.jpg', 'uploads/reduce/9f/eceed6a718f210cb4a407287bed54a.jpg', '1571193205');
INSERT INTO `wp_sys_update_picture` VALUES ('50', '5b203b9bc3c6203fb46ed5b2eabdf4.jpg', 'uploads/thumb/5b/5b203b9bc3c6203fb46ed5b2eabdf4.jpg', 'uploads/5b/5b203b9bc3c6203fb46ed5b2eabdf4.jpg', 'uploads/reduce/5b/5b203b9bc3c6203fb46ed5b2eabdf4.jpg', '1571193207');
INSERT INTO `wp_sys_update_picture` VALUES ('51', 'adc6b843122043ee164c8bdf40ed7b.jpg', 'uploads/thumb/7c/adc6b843122043ee164c8bdf40ed7b.jpg', 'uploads/7c/adc6b843122043ee164c8bdf40ed7b.jpg', 'uploads/reduce/7c/adc6b843122043ee164c8bdf40ed7b.jpg', '1571194184');
INSERT INTO `wp_sys_update_picture` VALUES ('52', '1c746dcc3ccd48d116c8f9a4b62dec.jpg', 'uploads/thumb/d2/1c746dcc3ccd48d116c8f9a4b62dec.jpg', 'uploads/d2/1c746dcc3ccd48d116c8f9a4b62dec.jpg', 'uploads/reduce/d2/1c746dcc3ccd48d116c8f9a4b62dec.jpg', '1571194185');
INSERT INTO `wp_sys_update_picture` VALUES ('53', '2ab60b9583cf30e6a74b5cdaee3c17.jpg', 'uploads/thumb/76/2ab60b9583cf30e6a74b5cdaee3c17.jpg', 'uploads/76/2ab60b9583cf30e6a74b5cdaee3c17.jpg', 'uploads/reduce/76/2ab60b9583cf30e6a74b5cdaee3c17.jpg', '1571290924');
INSERT INTO `wp_sys_update_picture` VALUES ('54', '4d7b336c47dd765d9d195b7863a132.jpg', 'uploads/thumb/cd/4d7b336c47dd765d9d195b7863a132.jpg', 'uploads/cd/4d7b336c47dd765d9d195b7863a132.jpg', 'uploads/reduce/cd/4d7b336c47dd765d9d195b7863a132.jpg', '1571378049');
INSERT INTO `wp_sys_update_picture` VALUES ('55', 'be90dcd46481e55b711e5528480df7.jpg', 'uploads/thumb/32/be90dcd46481e55b711e5528480df7.jpg', 'uploads/32/be90dcd46481e55b711e5528480df7.jpg', 'uploads/reduce/32/be90dcd46481e55b711e5528480df7.jpg', '1571379082');
INSERT INTO `wp_sys_update_picture` VALUES ('56', 'ee34cc23fbea96f846475155f9ba3b.jpg', 'uploads/thumb/3b/ee34cc23fbea96f846475155f9ba3b.jpg', 'uploads/3b/ee34cc23fbea96f846475155f9ba3b.jpg', 'uploads/reduce/3b/ee34cc23fbea96f846475155f9ba3b.jpg', '1572665688');
INSERT INTO `wp_sys_update_picture` VALUES ('57', 'e4aa81787534875cf29913bfddb658.jpg', 'uploads/thumb/3b/e4aa81787534875cf29913bfddb658.jpg', 'uploads/3b/e4aa81787534875cf29913bfddb658.jpg', 'uploads/reduce/3b/e4aa81787534875cf29913bfddb658.jpg', '1572855758');
INSERT INTO `wp_sys_update_picture` VALUES ('58', 'c86edb4b65a145d1e34fa990252d23.jpg', 'uploads/thumb/4a/c86edb4b65a145d1e34fa990252d23.jpg', 'uploads/4a/c86edb4b65a145d1e34fa990252d23.jpg', 'uploads/reduce/4a/c86edb4b65a145d1e34fa990252d23.jpg', '1573544573');
INSERT INTO `wp_sys_update_picture` VALUES ('59', 'b09fa2ec590604a7010af0d757eccf.jpg', 'uploads/thumb/c9/b09fa2ec590604a7010af0d757eccf.jpg', 'uploads/c9/b09fa2ec590604a7010af0d757eccf.jpg', 'uploads/reduce/c9/b09fa2ec590604a7010af0d757eccf.jpg', '1573544721');
INSERT INTO `wp_sys_update_picture` VALUES ('60', 'efe0692c1b5966d0616c00bffe27a0.jpg', 'uploads/thumb/dd/efe0692c1b5966d0616c00bffe27a0.jpg', 'uploads/dd/efe0692c1b5966d0616c00bffe27a0.jpg', 'uploads/reduce/dd/efe0692c1b5966d0616c00bffe27a0.jpg', '1573612393');
INSERT INTO `wp_sys_update_picture` VALUES ('61', '7b37b7ef20b72de033af82c40832fd.png', 'uploads/thumb/4f/7b37b7ef20b72de033af82c40832fd.png', 'uploads/4f/7b37b7ef20b72de033af82c40832fd.png', 'uploads/reduce/4f/7b37b7ef20b72de033af82c40832fd.png', '1573613182');
INSERT INTO `wp_sys_update_picture` VALUES ('62', 'fe0d485e186b58cad217ea6704f239.png', 'uploads/thumb/b6/fe0d485e186b58cad217ea6704f239.png', 'uploads/b6/fe0d485e186b58cad217ea6704f239.png', 'uploads/reduce/b6/fe0d485e186b58cad217ea6704f239.png', '1573617558');
INSERT INTO `wp_sys_update_picture` VALUES ('63', '85a12abe29784b157ee8dbb033c408.png', 'uploads/thumb/fa/85a12abe29784b157ee8dbb033c408.png', 'uploads/fa/85a12abe29784b157ee8dbb033c408.png', 'uploads/reduce/fa/85a12abe29784b157ee8dbb033c408.png', '1573643198');

-- ----------------------------
-- Table structure for `wp_sys_user`
-- ----------------------------
DROP TABLE IF EXISTS `wp_sys_user`;
CREATE TABLE `wp_sys_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '用户名',
  `nickname` varchar(50) NOT NULL COMMENT '昵称',
  `realname` varchar(50) NOT NULL COMMENT '姓名',
  `avatar` varchar(255) NOT NULL COMMENT '头像',
  `gender` tinyint(4) NOT NULL COMMENT '性别（0-其他 1-男 2-女）',
  `identity_number` varchar(20) NOT NULL COMMENT '身份证号',
  `province` varchar(50) NOT NULL COMMENT '省',
  `city` varchar(50) NOT NULL COMMENT '市',
  `district` varchar(50) NOT NULL COMMENT '县区',
  `address` varchar(255) NOT NULL COMMENT '详细地址',
  `passwd` varchar(50) NOT NULL COMMENT '密码',
  `email` varchar(100) NOT NULL COMMENT 'Email',
  `mobile` varchar(20) NOT NULL COMMENT '手机',
  `birthday` int(11) NOT NULL COMMENT '生日',
  `Invite_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '邀请码',
  `other_param` varchar(255) NOT NULL COMMENT '附加参数',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态（0-禁用 1-启用）',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后一次登陆时间',
  `last_login_ip` varchar(20) NOT NULL COMMENT '最后一次登陆ip',
  `token` varchar(50) NOT NULL COMMENT 'token',
  `token_expire_in` int(11) NOT NULL COMMENT 'token过期时间',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  `delete_time` int(11) NOT NULL COMMENT '软删除标记',
  `frozen_time` int(11) NOT NULL COMMENT '封停时间',
  `frozen_start_time` int(11) NOT NULL COMMENT '封停开始时间',
  `frozen_end_time` int(11) NOT NULL COMMENT '封停结束时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `index_user_token` (`token`) USING BTREE COMMENT 'token唯一'
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='用户表\r\n@name 用户\r\n@is_api 1\r\n@is_show 1\r\n@is_auth 1';

-- ----------------------------
-- Records of wp_sys_user
-- ----------------------------
INSERT INTO `wp_sys_user` VALUES ('6', 'user_EIAhIz', '啊啊啊啊', '', '', '0', '', '', '', '', '', '14e1b600b1fd579f47433b88e8d85291', '', '13612341234', '123', '', '', '1', '1573460019', '192.168.1.70', '9d1938e24e40ba2f845ce03e53290485', '1576052019', '1569309000', '1573460019', '0', '0', '0', '0');
INSERT INTO `wp_sys_user` VALUES ('7', 'user_LcyCKf', 'user_LcyCKf', '', '', '0', '', '', '', '', '', '14e1b600b1fd579f47433b88e8d85291', '', '13712341234', '0', '', '', '1', '0', '', '27a36e1decd950b129b3dbae1e399858', '0', '1569309011', '1570770448', '0', '0', '0', '0');
INSERT INTO `wp_sys_user` VALUES ('8', 'user_AGEdAd', 'user_AGEdAd', '', '', '0', '', '', '', '', '', 'c4ca4238a0b923820dcc509a6f75849b', '', '13412341235', '0', '', '', '1', '0', '', '39630014affe628fa3ef48a37672936e', '0', '1570417408', '1570417408', '0', '0', '0', '0');
INSERT INTO `wp_sys_user` VALUES ('9', 'user_AiTnkY', '犹犹豫豫123', '', '/uploads/8a/c95ae7a12a43984fd0da89a237986f.jpg', '0', '', '', '', '', '', 'f59bd65f7edafb087a81d4dca06c4910', '', '18337137693', '1571241600', '', '', '1', '1572686987', '192.168.1.114', 'a0531999bfeffa8392984515d31719aa', '1575278987', '1570418070', '1572686987', '0', '0', '0', '0');
INSERT INTO `wp_sys_user` VALUES ('10', 'user_gB6aha', '高', '', '/uploads/cd/4d7b336c47dd765d9d195b7863a132.jpg', '0', '', '', '', '', '', '511b0d5f341bddbd9a5348923b48d14c', '', '17603227337', '1571241600', '', '', '1', '1571386751', '192.168.1.122', '00b407d5e596c0e93fc4724fb191a7f1', '1573978751', '1570605555', '1571386751', '0', '0', '0', '0');
INSERT INTO `wp_sys_user` VALUES ('11', 'user_BHkKE2', 'user_BHkKE2', '', '', '0', '', '', '', '', '', 'f59bd65f7edafb087a81d4dca06c4910', '', '15233057143', '0', '', '', '1', '1571385410', '192.168.1.163', '400e7fa955549f2ef3e07b675c0af523', '1573977410', '1571016751', '1571385410', '0', '0', '0', '0');
INSERT INTO `wp_sys_user` VALUES ('12', 'user_4tFqzN', '垂死病中惊坐起', '', '', '0', '', '', '', '', '', '14e1b600b1fd579f47433b88e8d85291', '', '18532045821', '0', '', '', '1', '1572592209', '192.168.1.130', '735874b41601e05fe7e316cb5e44c694', '1575184209', '1571036045', '1572592209', '0', '0', '0', '0');
INSERT INTO `wp_sys_user` VALUES ('13', 'user_H43lam', 'user_H43lam', '', '', '0', '', '', '', '', '', 'f59bd65f7edafb087a81d4dca06c4910', '', '15512062275', '0', '', '', '1', '1571386018', '192.168.1.137', '0efd225c2715c3557066cac493609e41', '1573978018', '1571385708', '1571386018', '0', '0', '0', '0');
INSERT INTO `wp_sys_user` VALUES ('19', 'user_UlI2Jb', 'user_UlI2Jb', '', '', '0', '', '', '', '', '', 'c4ca4238a0b923820dcc509a6f75849b', '', '13712341235', '0', '', '', '1', '1571631305', '192.168.1.50', '34a31b14c0821719b27fa299787b2ff5', '1574223305', '1571631305', '1572855390', '0', '86400', '1572855375', '1572941775');

-- ----------------------------
-- Table structure for `wp_sys_user_share_record`
-- ----------------------------
DROP TABLE IF EXISTS `wp_sys_user_share_record`;
CREATE TABLE `wp_sys_user_share_record` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid1` int(11) NOT NULL COMMENT '邀请人uid',
  `mobile1` varchar(20) NOT NULL COMMENT '邀请人手机',
  `nickname1` varchar(255) NOT NULL COMMENT '邀请人昵称',
  `realname1` varchar(255) NOT NULL COMMENT '邀请人姓名',
  `uid2` int(11) NOT NULL COMMENT '被邀请人uid',
  `mobile2` varchar(20) NOT NULL COMMENT '被邀请人手机',
  `nickname2` varchar(255) NOT NULL COMMENT '被邀请人昵称',
  `realname2` varchar(255) NOT NULL COMMENT '被邀请人姓名',
  `status` tinyint(4) NOT NULL COMMENT '邀请状态（0-未知 1-被邀请人注册 2-被邀请人支付）',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  `delete_time` int(11) NOT NULL COMMENT '软删除标记',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='用户分享记录表\n@name 用户分享记录\n@is_api 1\n@is_show 0\n@is_auth 1';

-- ----------------------------
-- Records of wp_sys_user_share_record
-- ----------------------------

-- ----------------------------
-- Table structure for `wp_sys_user_third`
-- ----------------------------
DROP TABLE IF EXISTS `wp_sys_user_third`;
CREATE TABLE `wp_sys_user_third` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '绑定用户uid',
  `openid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'openid',
  `unionid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'unionid',
  `channel` enum('none','alipay','facebook','google','line','qq','twitter','weibo','weixin') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'channel',
  `nick` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '昵称',
  `gender` tinyint(4) DEFAULT '0' COMMENT '性别（0-保密 1-男 2-女）',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '头像',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态（0-未知 1-绑定用户 2-未绑定 3-禁用）',
  `session_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '会话token（在未绑定用户之前 前端以会话token定位 目的是不公开openid）',
  `expire_time` int(11) DEFAULT NULL COMMENT 'token过期时间',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT COMMENT='第三方登录记录表\r\n@name 第三方登录记录\r\n@is_api 1\r\n@is_show 0\r\n@is_auth 1';

-- ----------------------------
-- Records of wp_sys_user_third
-- ----------------------------
INSERT INTO `wp_sys_user_third` VALUES ('1', '16', null, null, null, null, null, null, null, '1', null, null, null);
INSERT INTO `wp_sys_user_third` VALUES ('2', '0', 'sadfsdf', 'sadfas', 'qq', null, null, null, '2', '759da35fcbcb405b8023a1bd35f0e745', '1571625560', '1571625500', '1571625500');
INSERT INTO `wp_sys_user_third` VALUES ('3', '0', 'asdfasdf', 'asdf', 'qq', null, '0', null, '2', 'd8475cb83068165c1a9d60e5ab38fb58', '1571627499', '1571627439', '1571627439');
INSERT INTO `wp_sys_user_third` VALUES ('4', '0', 'sf', 'sdf', 'qq', null, '0', null, '2', '22aa71619b0ef17f7ef73ab0939b3217', '1571629235', '1571629175', '1571629175');
INSERT INTO `wp_sys_user_third` VALUES ('5', '0', 'sf1', 'sdf', 'qq', null, '0', null, '2', 'e56cbaaf76ceda16434acdaf23fdfd6b', '1571629404', '1571629344', '1571629344');
INSERT INTO `wp_sys_user_third` VALUES ('6', '0', 'sf10', 'sdf', 'qq', null, '0', null, '2', '6b48d66b7eff44e8d382c54df707e778', '1571629533', '1571629507', '1571629507');
INSERT INTO `wp_sys_user_third` VALUES ('7', '0', 'sfd', 'sf', 'qq', null, '0', null, '2', 'b9763792e621dbec8186e9e73366d324', '1571630836', '1571630776', '1571630776');
INSERT INTO `wp_sys_user_third` VALUES ('8', '0', 'o37oX1ZGQOGJrvqfEDTk2iyOSp94', 'oCmrZ0uinLmsKz3I2SYX5r4FRuE8', 'weixin', null, '1', 'https://thirdwx.qlogo.cn/mmopen/vi_32/489mc9HUHgPibnoS9rRZWteS7mvOWu2kIpTcPhiarDSib5rjwJk4yhc4sJ7FEYBN8naP1UaB27N9DqumhrG84tzDQ/132', '2', '7949b3f9603f46d3ad707d8905232486', '1572577145', '1572577085', '1572577085');

-- ----------------------------
-- Table structure for `wp_sys_vars`
-- ----------------------------
DROP TABLE IF EXISTS `wp_sys_vars`;
CREATE TABLE `wp_sys_vars` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `var` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '识别变量名',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称',
  `intro` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '简介',
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '变量值（json）',
  `type` enum('none','normal') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal' COMMENT '类型（普通）',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  `delete_time` int(11) NOT NULL COMMENT '软删除标记',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='系统变量表\r\n@name 系统变量\r\n@is_api 1\r\n@is_show 0\r\n@is_auth 1';

-- ----------------------------
-- Records of wp_sys_vars
-- ----------------------------
INSERT INTO `wp_sys_vars` VALUES ('1', 'default_region', '默认地区省市', '', '{\"province\":\"河北省\",\"city\":\"廊坊市\",\"urban\":[\"安次区\",\"广阳区\",\"固安县\",\"永清县\",\"大城县\",\"文安县\",\"大厂回族自治县\",\"霸州市\",\"三河市\"]}', 'normal', '1568999851', '1568999851', '0');
INSERT INTO `wp_sys_vars` VALUES ('2', 'default_local_full_score', '廊坊中考总成绩', '', '680', 'normal', '1568999851', '1568999851', '0');
INSERT INTO `wp_sys_vars` VALUES ('3', 'default_cashdeposit_money', '默认保证金', '', '30000', 'normal', '1568999851', '1568999851', '0');
INSERT INTO `wp_sys_vars` VALUES ('4', 'TradingIndex', '交易指数', '没有简介', '{\"exponent\":\"123456\",\"preceding\":\"1236\",\"yesterday\":\"66\"}', 'normal', '0', '1573559808', '0');
