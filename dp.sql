-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2019-02-14 13:36:49
-- 服务器版本： 5.6.36-log
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dp`
--

-- --------------------------------------------------------

--
-- 表的结构 `dp_address`
--

CREATE TABLE IF NOT EXISTS `dp_address` (
  `address_id` int(10) unsigned NOT NULL,
  `is_default` tinyint(3) DEFAULT '0',
  `member_id` int(10) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `lat` varchar(20) DEFAULT NULL,
  `lng` varchar(20) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `add_time` int(11) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='用户收货地址表';

--
-- 转存表中的数据 `dp_address`
--

INSERT INTO `dp_address` (`address_id`, `is_default`, `member_id`, `address`, `lat`, `lng`, `mobile`, `name`, `add_time`, `province`) VALUES
(1, 1, 8, '啊嘞', '39.528145', '116.71112', '17600522642', '康先生', 1545709084, '浙商广场A座(广阳区浙商广场爱民东道北)'),
(2, 1, 9, '1231654', '39.5228', '116.71051', '13521324008', '刘亚楠', 1545714680, '河北省廊坊市'),
(3, 1, 2, '146号', '39.539646', '116.70825', '13766666666', '龙', 1545714878, '廊坊市公安交警一大队(广阳道146号)'),
(9, 0, 2, '明明年年', '39.69021', '116.63731', '18523645789', '明年', 1545715402, '北京市大兴区长子营镇小黑垡村民委员会'),
(11, 1, 7, '123321', '39.5228', '116.71051', '13599996666', '张三', 1545728680, '河北省廊坊市广阳区康宁街2号'),
(12, 1, 20, '大家都能', '34.238537', '108.90001', '17719598468', '多喝点宝贝', 1545885216, '蓝溪国际大厦(高新三路高新九号广场)'),
(13, 1, 22, '502', '34.239033', '108.899605', '15291335257', '王新波', 1545888525, '蓝溪国际酒店(高新四路高新九号广场)'),
(14, 0, 22, '502', '34.239033', '108.899605', '15291335257', '王新波', 1545888526, '蓝溪国际酒店(高新四路高新九号广场)'),
(15, 1, 21, '2206', '34.238895', '108.89977', '13227752592', '完成', 1545888936, '蓝溪国际大厦(高新三路高新九号广场)'),
(16, 1, 19, '2206', '34.238877387032', '108.90034943819', '13227752592', '王聪', 1545888995, '西安市蓝溪国际大厦(高新三路高新九号广场)'),
(17, 0, 7, '康宁路 333号', '39.5228', '116.71051', '13688889999', '测试地址二', 1545890949, '河北省廊坊市广阳区康宁街2号'),
(18, 1, 27, '逸惠园', '34.50566496457', '109.47242754051', '18066666666', '杨江峰', 1546047185, '渭南市新洲华盛(新洲华盛仓程路西200米)'),
(19, 1, 70, '1', '39.52805', '116.71127', '15138899622', 'hsk', 1546062009, '河北省廊坊市广阳区浙商广场(爱民东道北)'),
(20, 0, 70, 'vv', '39.527744', '116.7116', '15139955611', '感受感受刚刚', 1546062087, '爱民东道(廊坊市广阳区)');

-- --------------------------------------------------------

--
-- 表的结构 `dp_admin_user`
--

CREATE TABLE IF NOT EXISTS `dp_admin_user` (
  `id` smallint(5) unsigned NOT NULL,
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '管理员用户名',
  `password` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员密码',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1 启用 0 禁用',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `last_login_time` datetime DEFAULT NULL COMMENT '最后登录时间',
  `last_login_ip` varchar(20) DEFAULT NULL COMMENT '最后登录IP'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员表';

--
-- 转存表中的数据 `dp_admin_user`
--

INSERT INTO `dp_admin_user` (`id`, `username`, `password`, `status`, `create_time`, `last_login_time`, `last_login_ip`) VALUES
(1, 'admin', '0dfc7612f607db6c17fd99388e9e5f9c', 1, '2016-10-18 15:28:37', '2019-01-14 11:28:25', '113.133.243.253');

-- --------------------------------------------------------

--
-- 表的结构 `dp_after_sale`
--

CREATE TABLE IF NOT EXISTS `dp_after_sale` (
  `id` int(10) unsigned NOT NULL COMMENT '上门售后表',
  `uid` int(10) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `tel` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `create_time` int(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='上门售后表';

--
-- 转存表中的数据 `dp_after_sale`
--

INSERT INTO `dp_after_sale` (`id`, `uid`, `name`, `tel`, `address`, `create_time`) VALUES
(1, 9, '测试', '13521234008', '11', 1545715088),
(2, 2, '兴民', '18632645723', '治你WWI', 1545716299),
(3, 2, '滴定', '18632642336', '弟妹', 1545716327);

-- --------------------------------------------------------

--
-- 表的结构 `dp_article`
--

CREATE TABLE IF NOT EXISTS `dp_article` (
  `id` int(10) unsigned NOT NULL COMMENT '文章ID',
  `cid` smallint(5) unsigned NOT NULL COMMENT '分类ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `introduction` varchar(255) DEFAULT '' COMMENT '简介',
  `content` longtext COMMENT '内容',
  `author` varchar(20) DEFAULT '' COMMENT '作者',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0 待审核  1 审核',
  `reading` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '阅读量',
  `thumb` varchar(255) DEFAULT '' COMMENT '缩略图',
  `photo` text COMMENT '图集',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否置顶  0 不置顶  1 置顶',
  `is_recommend` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐  0 不推荐  1 推荐',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `publish_time` datetime NOT NULL COMMENT '发布时间'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='文章表';

--
-- 转存表中的数据 `dp_article`
--

INSERT INTO `dp_article` (`id`, `cid`, `title`, `introduction`, `content`, `author`, `status`, `reading`, `thumb`, `photo`, `is_top`, `is_recommend`, `sort`, `create_time`, `publish_time`) VALUES
(1, 1, '测试文章一', '', '<p>测试内容</p>', 'admin', 1, 0, '', NULL, 0, 0, 0, '2017-04-11 14:10:10', '2017-04-11 14:09:45');

-- --------------------------------------------------------

--
-- 表的结构 `dp_auth_group`
--

CREATE TABLE IF NOT EXISTS `dp_auth_group` (
  `id` mediumint(8) unsigned NOT NULL,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` varchar(255) NOT NULL COMMENT '权限规则ID'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='权限组表';

--
-- 转存表中的数据 `dp_auth_group`
--

INSERT INTO `dp_auth_group` (`id`, `title`, `status`, `rules`) VALUES
(1, '超级管理组', 1, '1,2,3,73,74,5,6,7,8,9,10,11,12,39,40,41,42,43,14,13,20,21,22,23,24,15,25,26,27,28,29,30,16,17,44,45,46,47,48,18,49,50,51,52,53,19,31,32,33,34,35,36,37,54,55,58,59,60,61,62,56,63,64,65,66,67,57,68,69,70,71,72');

-- --------------------------------------------------------

--
-- 表的结构 `dp_auth_group_access`
--

CREATE TABLE IF NOT EXISTS `dp_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限组规则表';

--
-- 转存表中的数据 `dp_auth_group_access`
--

INSERT INTO `dp_auth_group_access` (`uid`, `group_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `dp_auth_rule`
--

CREATE TABLE IF NOT EXISTS `dp_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL,
  `name` varchar(80) NOT NULL DEFAULT '' COMMENT '规则名称',
  `title` varchar(20) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `pid` smallint(5) unsigned NOT NULL COMMENT '父级ID',
  `icon` varchar(50) DEFAULT '' COMMENT '图标',
  `sort` tinyint(4) unsigned NOT NULL COMMENT '排序',
  `condition` char(100) DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=92 DEFAULT CHARSET=utf8 COMMENT='规则表';

--
-- 转存表中的数据 `dp_auth_rule`
--

INSERT INTO `dp_auth_rule` (`id`, `name`, `title`, `type`, `status`, `pid`, `icon`, `sort`, `condition`) VALUES
(1, 'admin/System/default', '系统配置', 1, 1, 0, 'fa fa-gears', 0, ''),
(2, 'admin/System/siteConfig', '站点配置', 1, 1, 1, '', 0, ''),
(3, 'admin/System/updateSiteConfig', '更新配置', 1, 0, 1, '', 0, ''),
(5, 'admin/Menu/default', '菜单管理', 1, 1, 0, 'fa fa-bars', 0, ''),
(6, 'admin/Menu/index', '后台菜单', 1, 1, 5, '', 0, ''),
(7, 'admin/Menu/add', '添加菜单', 1, 0, 6, '', 0, ''),
(8, 'admin/Menu/save', '保存菜单', 1, 0, 6, '', 0, ''),
(9, 'admin/Menu/edit', '编辑菜单', 1, 0, 6, '', 0, ''),
(10, 'admin/Menu/update', '更新菜单', 1, 0, 6, '', 0, ''),
(11, 'admin/Menu/delete', '删除菜单', 1, 0, 6, '', 0, ''),
(12, 'admin/Nav/index', '导航管理', 1, 0, 5, '', 0, ''),
(13, 'admin/Category/index', '栏目管理', 1, 1, 14, 'fa fa-sitemap', 0, ''),
(14, 'admin/Content/default', '内容管理', 1, 0, 0, 'fa fa-file-text', 0, ''),
(15, 'admin/Article/index', '文章管理', 1, 0, 14, '', 0, ''),
(16, 'admin/User/default', '用户管理', 1, 1, 0, 'fa fa-users', 0, ''),
(17, 'admin/User/index', '普通用户', 1, 1, 16, '', 0, ''),
(18, 'admin/AdminUser/index', '管理员', 1, 1, 16, '', 0, ''),
(19, 'admin/AuthGroup/index', '权限组', 1, 1, 16, '', 0, ''),
(20, 'admin/Category/add', '添加栏目', 1, 0, 13, '', 0, ''),
(21, 'admin/Category/save', '保存栏目', 1, 0, 13, '', 0, ''),
(22, 'admin/Category/edit', '编辑栏目', 1, 0, 13, '', 0, ''),
(23, 'admin/Category/update', '更新栏目', 1, 0, 13, '', 0, ''),
(24, 'admin/Category/delete', '删除栏目', 1, 0, 13, '', 0, ''),
(25, 'admin/Article/add', '添加文章', 1, 0, 15, '', 0, ''),
(26, 'admin/Article/save', '保存文章', 1, 0, 15, '', 0, ''),
(27, 'admin/Article/edit', '编辑文章', 1, 0, 15, '', 0, ''),
(28, 'admin/Article/update', '更新文章', 1, 0, 15, '', 0, ''),
(29, 'admin/Article/delete', '删除文章', 1, 0, 15, '', 0, ''),
(30, 'admin/Article/toggle', '文章审核', 1, 0, 15, '', 0, ''),
(31, 'admin/AuthGroup/add', '添加权限组', 1, 0, 19, '', 0, ''),
(32, 'admin/AuthGroup/save', '保存权限组', 1, 0, 19, '', 0, ''),
(33, 'admin/AuthGroup/edit', '编辑权限组', 1, 0, 19, '', 0, ''),
(34, 'admin/AuthGroup/update', '更新权限组', 1, 0, 19, '', 0, ''),
(35, 'admin/AuthGroup/delete', '删除权限组', 1, 0, 19, '', 0, ''),
(36, 'admin/AuthGroup/auth', '授权', 1, 0, 19, '', 0, ''),
(37, 'admin/AuthGroup/updateAuthGroupRule', '更新权限组规则', 1, 0, 19, '', 0, ''),
(39, 'admin/Nav/add', '添加导航', 1, 0, 12, '', 0, ''),
(40, 'admin/Nav/save', '保存导航', 1, 0, 12, '', 0, ''),
(41, 'admin/Nav/edit', '编辑导航', 1, 0, 12, '', 0, ''),
(42, 'admin/Nav/update', '更新导航', 1, 0, 12, '', 0, ''),
(43, 'admin/Nav/delete', '删除导航', 1, 0, 12, '', 0, ''),
(44, 'admin/User/add', '添加用户', 1, 0, 17, '', 0, ''),
(45, 'admin/User/save', '保存用户', 1, 0, 17, '', 0, ''),
(46, 'admin/User/edit', '编辑用户', 1, 0, 17, '', 0, ''),
(47, 'admin/User/update', '更新用户', 1, 0, 17, '', 0, ''),
(48, 'admin/User/delete', '删除用户', 1, 0, 17, '', 0, ''),
(49, 'admin/AdminUser/add', '添加管理员', 1, 0, 18, '', 0, ''),
(50, 'admin/AdminUser/save', '保存管理员', 1, 0, 18, '', 0, ''),
(51, 'admin/AdminUser/edit', '编辑管理员', 1, 0, 18, '', 0, ''),
(52, 'admin/AdminUser/update', '更新管理员', 1, 0, 18, '', 0, ''),
(53, 'admin/AdminUser/delete', '删除管理员', 1, 0, 18, '', 0, ''),
(54, 'admin/Slide/default', '轮播图管理', 1, 1, 0, 'fa fa-wrench', 0, ''),
(55, 'admin/SlideCategory/index', '轮播分类', 1, 0, 54, '', 0, ''),
(56, 'admin/Slide/index', '轮播图管理', 1, 1, 54, '', 0, ''),
(57, 'admin/Link/index', '友情链接', 1, 0, 54, 'fa fa-link', 0, ''),
(58, 'admin/SlideCategory/add', '添加分类', 1, 0, 55, '', 0, ''),
(59, 'admin/SlideCategory/save', '保存分类', 1, 0, 55, '', 0, ''),
(60, 'admin/SlideCategory/edit', '编辑分类', 1, 0, 55, '', 0, ''),
(61, 'admin/SlideCategory/update', '更新分类', 1, 0, 55, '', 0, ''),
(62, 'admin/SlideCategory/delete', '删除分类', 1, 0, 55, '', 0, ''),
(63, 'admin/Slide/add', '添加轮播', 1, 0, 56, '', 0, ''),
(64, 'admin/Slide/save', '保存轮播', 1, 0, 56, '', 0, ''),
(65, 'admin/Slide/edit', '编辑轮播', 1, 0, 56, '', 0, ''),
(66, 'admin/Slide/update', '更新轮播', 1, 0, 56, '', 0, ''),
(67, 'admin/Slide/delete', '删除轮播', 1, 0, 56, '', 0, ''),
(68, 'admin/Link/add', '添加链接', 1, 0, 57, '', 0, ''),
(69, 'admin/Link/save', '保存链接', 1, 0, 57, '', 0, ''),
(70, 'admin/Link/edit', '编辑链接', 1, 0, 57, '', 0, ''),
(71, 'admin/Link/update', '更新链接', 1, 0, 57, '', 0, ''),
(72, 'admin/Link/delete', '删除链接', 1, 0, 57, '', 0, ''),
(73, 'admin/ChangePassword/index', '修改密码', 1, 1, 1, '', 0, ''),
(74, 'admin/ChangePassword/updatePassword', '更新密码', 1, 0, 1, '', 0, ''),
(75, 'admin/Setting/setting', '小程序配置', 1, 1, 0, 'fa fa-home', 0, ''),
(77, 'admin/Mall/###', '商品管理', 1, 1, 0, 'fa fa-home', 0, ''),
(78, 'admin/Mall/index', '商品管理', 1, 1, 77, '', 0, ''),
(79, 'admin/System/companyConfig', '公司信息配置', 1, 1, 0, 'fa fa-home', 0, ''),
(80, 'admin/PeisongMember/###', '配送管理', 1, 1, 0, 'fa fa-home', 0, ''),
(81, 'admin/PeisongMember/index', '配送员管理', 1, 1, 80, 'fa fa-home', 0, ''),
(82, 'admin/PeisongOrder/index', '配送订单管理', 1, 1, 80, '', 0, ''),
(83, 'admin/PeisongOrder/call_order', '呼叫订单管理', 1, 1, 80, '', 0, ''),
(84, 'admin/Coupon/###', '优惠卷管理', 1, 1, 0, 'fa fa-home', 0, ''),
(85, 'admin/Coupon/index', '优惠卷管理', 1, 1, 84, '', 0, ''),
(86, 'admin/Order/###', '订单管理', 1, 1, 0, 'fa fa-home', 0, ''),
(87, 'admin/Order/index', '订单管理', 1, 1, 86, '', 0, ''),
(88, 'admin/AfterSale/###', '上门售后', 1, 1, 0, 'fa fa-home', 0, ''),
(89, 'admin/AfterSale/index', '售后列表', 1, 1, 88, '', 0, ''),
(90, 'admin/Comment/###', '评价管理', 1, 1, 0, 'fa fa-home', 0, ''),
(91, 'admin/Comment/index', '评论列表', 1, 1, 90, '', 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `dp_category`
--

CREATE TABLE IF NOT EXISTS `dp_category` (
  `id` int(10) unsigned NOT NULL COMMENT '分类ID',
  `name` varchar(50) NOT NULL COMMENT '分类名称',
  `alias` varchar(50) DEFAULT '' COMMENT '导航别名',
  `content` longtext COMMENT '分类内容',
  `thumb` varchar(255) DEFAULT '' COMMENT '缩略图',
  `icon` varchar(20) DEFAULT '' COMMENT '分类图标',
  `list_template` varchar(50) DEFAULT '' COMMENT '分类列表模板',
  `detail_template` varchar(50) DEFAULT '' COMMENT '分类详情模板',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '分类类型  1  列表  2 单页',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `path` varchar(255) DEFAULT '' COMMENT '路径',
  `create_time` datetime NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='分类表';

--
-- 转存表中的数据 `dp_category`
--

INSERT INTO `dp_category` (`id`, `name`, `alias`, `content`, `thumb`, `icon`, `list_template`, `detail_template`, `type`, `sort`, `pid`, `path`, `create_time`) VALUES
(1, '分类一', '', '', '', '', '', '', 1, 0, 0, '0,', '2016-12-22 18:22:24');

-- --------------------------------------------------------

--
-- 表的结构 `dp_comment`
--

CREATE TABLE IF NOT EXISTS `dp_comment` (
  `id` int(10) unsigned NOT NULL,
  `uid` int(10) DEFAULT NULL,
  `mid` int(10) DEFAULT NULL,
  `order_id` int(10) DEFAULT NULL,
  `content` longtext,
  `photo` text,
  `score` int(10) DEFAULT NULL,
  `add_time` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评论表';

-- --------------------------------------------------------

--
-- 表的结构 `dp_config`
--

CREATE TABLE IF NOT EXISTS `dp_config` (
  `id` int(10) unsigned NOT NULL,
  `k` varchar(100) CHARACTER SET gbk NOT NULL COMMENT '变量名',
  `v` varchar(255) CHARACTER SET gbk NOT NULL COMMENT '变量值',
  `name` varchar(255) CHARACTER SET gbk NOT NULL COMMENT '变量说明'
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COMMENT='自定义变量';

--
-- 转存表中的数据 `dp_config`
--

INSERT INTO `dp_config` (`id`, `k`, `v`, `name`) VALUES
(49, 'UserAppID', 'wx965aa9ed069d64b8', '小程序ID'),
(50, 'UserAppSecret', 'b7e7738e0bcff0dd5ca2efebcac35b2d', '小程序SECRET'),
(51, 'MchID', '1519674101', '商户ID'),
(52, 'WxKey', '15291335257152913352571529133525', '商户Key'),
(55, 'DistributionAppID', 'wxaeaba634e517aadf', '小程序ID'),
(56, 'DistributionAppSecret', '610c726781b5ab8881a1ab223cb89b2e', '小程序secret'),
(57, 'ApiclientKey', '/public/uploads/File/20181224/ec7a95ab738c179fbe4741acc54e2f8b.pem', '支付证书key'),
(58, 'ApiclientCert', '/public/uploads/File/20181224/0de70bc788190670b07e485404021fc9.pem', '支付证书秘钥'),
(59, 'SmsAppID', '1400168241', '短信APPID'),
(60, 'SmsAppKey', 'e6ac1b01d79ed136587c5dcd3b64a6c8', '短信KEY'),
(61, 'SmsTemplateId', '245014', 'ID'),
(62, 'SmsSign', '陕西保之林环保科技公司', '公司名称');

-- --------------------------------------------------------

--
-- 表的结构 `dp_coupon`
--

CREATE TABLE IF NOT EXISTS `dp_coupon` (
  `id` int(10) unsigned NOT NULL,
  `title` varchar(64) DEFAULT NULL COMMENT '标题',
  `price` int(10) DEFAULT NULL COMMENT '优惠价格',
  `man_price` int(10) DEFAULT NULL COMMENT '满多少可用',
  `bg_data` int(10) DEFAULT NULL COMMENT '开始日期',
  `end_data` int(10) DEFAULT NULL COMMENT '结束日期',
  `is_online` tinyint(3) DEFAULT NULL COMMENT '是否上线',
  `num` int(10) DEFAULT NULL COMMENT '发放数量',
  `receive_num` int(10) DEFAULT NULL COMMENT '已领取数量',
  `add_time` int(10) DEFAULT NULL,
  `orderby` int(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='优惠卷表';

--
-- 转存表中的数据 `dp_coupon`
--

INSERT INTO `dp_coupon` (`id`, `title`, `price`, `man_price`, `bg_data`, `end_data`, `is_online`, `num`, `receive_num`, `add_time`, `orderby`) VALUES
(2, '测试', 200, 200, 1545628768, 1545974370, 1, 21, NULL, 1545715179, 22);

-- --------------------------------------------------------

--
-- 表的结构 `dp_link`
--

CREATE TABLE IF NOT EXISTS `dp_link` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '链接名称',
  `link` varchar(255) DEFAULT '' COMMENT '链接地址',
  `image` varchar(255) DEFAULT '' COMMENT '链接图片',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1 显示  2 隐藏',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='友情链接表';

-- --------------------------------------------------------

--
-- 表的结构 `dp_mall`
--

CREATE TABLE IF NOT EXISTS `dp_mall` (
  `goods_id` int(10) unsigned NOT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT '商品标题',
  `name` varchar(64) DEFAULT NULL COMMENT '名称',
  `warrantyone` int(10) DEFAULT NULL COMMENT '延保一年',
  `warrantytwo` int(10) DEFAULT NULL COMMENT '延保两年',
  `price` int(10) DEFAULT NULL COMMENT '原价',
  `stock` int(10) DEFAULT NULL COMMENT '库存数量',
  `banner` text COMMENT '轮播图',
  `homeImg` varchar(255) DEFAULT NULL COMMENT '首页图片',
  `photo` text COMMENT '图片',
  `is_online` tinyint(3) DEFAULT NULL COMMENT '1上架2下架',
  `is_home` tinyint(3) DEFAULT NULL COMMENT '是否在首页展示 1是、2不是’',
  `sales` smallint(5) DEFAULT NULL COMMENT '月销售量',
  `add_time` int(10) DEFAULT NULL COMMENT ' ',
  `type_id` int(10) DEFAULT NULL COMMENT '分类ID',
  `orderby` int(10) DEFAULT NULL COMMENT '排序',
  `admit` text COMMENT '承若',
  `details` text COMMENT '商品详情'
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='商品表';

--
-- 转存表中的数据 `dp_mall`
--

INSERT INTO `dp_mall` (`goods_id`, `title`, `name`, `warrantyone`, `warrantytwo`, `price`, `stock`, `banner`, `homeImg`, `photo`, `is_online`, `is_home`, `sales`, `add_time`, `type_id`, `orderby`, `admit`, `details`) VALUES
(2, '简易款两轮电动车（12A）', '简易款两轮电动车（12A）', 4900, 7900, 30000, 95, '["http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181229\\/5d63386543941ccef94c3ab9c1c92672.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181229\\/190e5e20e587c873779de2c0ab00b02b.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181229\\/349f0a8916e48346258fc27114e4e40f.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181229\\/fdc928166fe9fc0069706784cb1010dc.jpg"]', 'http://dp.mendian51.cn/public/uploads/Image/20181226/96d0c80888e88aa0c3eba387d6a6c666.jpg', 'http://dp.mendian51.cn/public/uploads/Image/20181230/2efefae3a844ab015610e2f03b11caba.jpg', 1, 1, 63, 1545706025, 1, 30, '品牌保障，24小时退换，官方授权，极速退款，送货上门，免费安装', '&lt;p&gt;&lt;img title=&quot;1545704296982027.jpg&quot; alt=&quot;1.jpg&quot; src=&quot;http://dp.mendian51.cn/public/uploads/images/20181225/1545704296982027.jpg&quot;/&gt;&lt;img title=&quot;1545704298893299.jpg&quot; alt=&quot;2.jpg&quot; src=&quot;http://dp.mendian51.cn/public/uploads/images/20181225/1545704298893299.jpg&quot;/&gt;&lt;img title=&quot;1545704300982596.png&quot; alt=&quot;3.png&quot; src=&quot;http://dp.mendian51.cn/public/uploads/images/20181225/1545704300982596.png&quot;/&gt;&lt;img title=&quot;1545704312837717.jpg&quot; alt=&quot;1.jpg&quot; src=&quot;http://dp.mendian51.cn/public/uploads/images/20181225/1545704312837717.jpg&quot;/&gt;&lt;img title=&quot;1545704314419384.jpg&quot; alt=&quot;2.jpg&quot; src=&quot;http://dp.mendian51.cn/public/uploads/images/20181225/1545704314419384.jpg&quot;/&gt;&lt;img title=&quot;1545704316775488.jpg&quot; alt=&quot;3.jpg&quot; src=&quot;http://dp.mendian51.cn/public/uploads/images/20181225/1545704316775488.jpg&quot;/&gt;&lt;img title=&quot;1545704318691899.jpg&quot; alt=&quot;4.jpg&quot; src=&quot;http://dp.mendian51.cn/public/uploads/images/20181225/1545704318691899.jpg&quot;/&gt;&lt;/p&gt;'),
(3, '踏板式两轮电动车（20A）', '踏板式两轮电动车（20A）', 4900, 7900, 40000, 56, '["http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181229\\/75084b71853ab46dadd4371d03904091.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181229\\/f2a177f5bdb9ee62b1a69092543b291a.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181229\\/e0d2f8ad585186e45bd84f3fc6aa3e18.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181229\\/9ff66d2dc2a3a2af1c548e92380c69b5.jpg"]', 'http://dp.mendian51.cn/public/uploads/Image/20181229/45e628e57b1b36fa1f1984f6bc361243.jpg', 'http://dp.mendian51.cn/public/uploads/Image/20181230/3ddf47f28ba793f2ed86e0612ddbb0e8.jpg', 1, 1, 36, 1546055133, 1, 29, '品牌保障，24小时退换，官方授权，极速退款，送货上门，免费安装', '&lt;p&gt;&lt;img title=&quot;1546054947590401.jpg&quot; alt=&quot;商品详情-下方详解图1.jpg&quot; src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546054947590401.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;img title=&quot;1546055005540369.jpg&quot; alt=&quot;商品详情-下方详解图2.jpg&quot; src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546055005540369.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img title=&quot;1546055019725295.png&quot; alt=&quot;商品详情-下方详解图3.png&quot; src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546055019725295.png&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;img title=&quot;1546055073271703.jpg&quot; alt=&quot;商品详情-下方详解图4.jpg&quot; src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546055073271703.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img title=&quot;1546055087767869.jpg&quot; alt=&quot;商品详情-下方详解图5.jpg&quot; src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546055087767869.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img title=&quot;1546055099228358.jpg&quot; alt=&quot;商品详情-下方详解图6.jpg&quot; src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546055099228358.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img title=&quot;1546055112616876.jpg&quot; alt=&quot;商品详情-下方详解图7.jpg&quot; src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546055112616876.jpg&quot;/&gt;&lt;/p&gt;'),
(4, '载重式三轮电动车（32A）', '载重式三轮电动车（32A）', 4900, 7900, 64000, 56, '["http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181229\\/2572cbbc623852b55e709c577e779f8f.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181229\\/d032063b522276ccf2ffaf6c32780fe2.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181229\\/12495036e266eb205d3b49af4632bb19.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181229\\/d6e2e0e2ba6ff317aef2b7b44cb4c2e3.jpg"]', 'http://dp.mendian51.cn/public/uploads/Image/20181229/e5a6af4a5329ba8c47fec615131ccbf3.jpg', 'http://dp.mendian51.cn/public/uploads/Image/20181230/ea9caf34eb9469e0c863aa5b2c33e0f0.jpg', 1, 1, 12, 1546056421, 1, 28, '品牌保障，24小时退换，官方授权，极速退款，送货上门，免费安装', '&lt;p&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546139975942782.jpg&quot; title=&quot;1546139975942782.jpg&quot; alt=&quot;商品详情-下方详解图1.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546140139698187.jpg&quot; title=&quot;1546140139698187.jpg&quot; alt=&quot;商品详情-下方详解图5.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546140145825481.jpg&quot; title=&quot;1546140145825481.jpg&quot; alt=&quot;商品详情-下方详解图4.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546139998249823.jpg&quot; title=&quot;1546139998249823.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546139998519452.jpg&quot; title=&quot;1546139998519452.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;'),
(5, '载重式三轮电动车（45A）', '载重式三轮电动车（45A）', 4900, 7900, 86000, 63, '["http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181229\\/7d3bf0627e03f30eeccc0819c2ca2a7f.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181229\\/f0164a9758eeccca6460aec581607a82.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181229\\/e8cdb3bdda978165a65792d787f3b32d.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181229\\/aa1c91c943fc8b35ec8675209900562d.jpg"]', 'http://dp.mendian51.cn/public/uploads/Image/20181230/c17a172d1cbab0145dc3c159b5fc8a32.jpg', 'http://dp.mendian51.cn/public/uploads/Image/20181230/58da5352196ce4eb39f929c70cf7a8be.jpg', 1, 1, 20, 1546056793, 1, 0, '品牌保障，24小时退换，官方授权，极速退款，送货上门，免费安装', '&lt;p&gt;&lt;img title=&quot;1546056670173043.jpg&quot; alt=&quot;商品详情-下方详解图1.jpg&quot; src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546056670173043.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img title=&quot;1546056681980292.jpg&quot; alt=&quot;商品详情-下方详解图2.jpg&quot; src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546056681980292.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img title=&quot;1546056690424807.png&quot; alt=&quot;商品详情-下方详解图3.png&quot; src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546056690424807.png&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;img title=&quot;1546056724853782.jpg&quot; alt=&quot;商品详情-下方详解图5.jpg&quot; src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546056724853782.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546140198301140.jpg&quot; title=&quot;1546140198301140.jpg&quot; alt=&quot;商品详情-下方详解图4.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img title=&quot;1546056737534478.jpg&quot; alt=&quot;商品详情-下方详解图6.jpg&quot; src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546056737534478.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img title=&quot;1546056749190636.jpg&quot; alt=&quot;商品详情-下方详解图7.jpg&quot; src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546056749190636.jpg&quot;/&gt;&lt;/p&gt;'),
(6, '48V12A', '48V12A', 4900, 7900, 30000, 25, '["http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/226b21baf29dddf11003db3c66f9f8a2.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/a08fb17155e1e9eaf20679a8faa5066a.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/f40010b43cdf378afaa77d3c8f571135.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/98b25285b563e172220cbbd7945cb442.jpg"]', 'http://dp.mendian51.cn/public/uploads/Image/20181230/5a1e2ec3e10357350fa60c28137e7d34.jpg', 'http://dp.mendian51.cn/public/uploads/Image/20181230/4dba96c6a43de4719807a96f42c65e65.jpg', 1, 2, 14, 1546057322, 2, 30, '品牌保障，24小时退换，官方授权，极速退款，送货上门，免费安装', '&lt;p&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546057050781479.jpg&quot; title=&quot;1546057050781479.jpg&quot; alt=&quot;商品详情-下方详解图1.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546057061437409.jpg&quot; title=&quot;1546057061437409.jpg&quot; alt=&quot;商品详情-下方详解图2.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546057078582651.png&quot; title=&quot;1546057078582651.png&quot; alt=&quot;商品详情-下方详解图3.png&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546057122892777.jpg&quot; title=&quot;1546057122892777.jpg&quot; alt=&quot;商品详情-下方详解图5.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546140272421990.jpg&quot; title=&quot;1546140272421990.jpg&quot; alt=&quot;商品详情-下方详解图4.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546057136909450.jpg&quot; title=&quot;1546057136909450.jpg&quot; alt=&quot;商品详情-下方详解图6.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546057249480327.jpg&quot; title=&quot;1546057249480327.jpg&quot; alt=&quot;商品详情-下方详解图7.jpg&quot;/&gt;&lt;/p&gt;'),
(7, '48V20A', '48V20A', 4900, 7900, 40000, 54, '["http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181229\\/a855dea3a92a5685d2a1160fc67640da.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181229\\/b83b56610dc19739ff7dc0fef759ad48.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181229\\/085fd72a315be31e2ae4591af30261b7.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181229\\/0aa5a9a376238a7f42ab8fe67b0d17dd.jpg"]', 'http://dp.mendian51.cn/public/uploads/Image/20181230/481548094ff0efdd27a37342851cb14e.jpg', 'http://dp.mendian51.cn/public/uploads/Image/20181230/14c1ef79d665f2711ac7c11b110a1cfc.jpg', 1, 2, 23, 1546057633, 2, 29, '品牌保障，24小时退换，官方授权，极速退款，送货上门，免费安装', '&lt;p&gt;&lt;img title=&quot;1546057435384666.jpg&quot; alt=&quot;商品详情-下方详解图1.jpg&quot; src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546057435384666.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img title=&quot;1546057446978149.jpg&quot; alt=&quot;商品详情-下方详解图2.jpg&quot; src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546057446978149.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img title=&quot;1546057458983014.png&quot; alt=&quot;商品详情-下方详解图3.png&quot; src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546057458983014.png&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img title=&quot;1546057473516617.jpg&quot; alt=&quot;商品详情-下方详解图4.jpg&quot; src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546057473516617.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img title=&quot;1546057488674692.jpg&quot; alt=&quot;商品详情-下方详解图5.jpg&quot; src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546057488674692.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img title=&quot;1546057535640881.jpg&quot; alt=&quot;商品详情-下方详解图6.jpg&quot; src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546057535640881.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img title=&quot;1546057549916501.jpg&quot; alt=&quot;商品详情-下方详解图7.jpg&quot; src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546057549916501.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;'),
(8, '48V32A', '48V32A', 4900, 7900, 64000, 51, '["http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181229\\/513009f402685fae107aff0ef85f8e7f.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181229\\/4c6c2ddc1131ba87401872f7cd2918af.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181229\\/76ccef145c657b978b0de56a5dd00bd2.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181229\\/5910ba4ec80b94d8225edf58e5f94aa0.jpg"]', 'http://dp.mendian51.cn/public/uploads/Image/20181230/f3cf33602025246ee2cbc5b08922dfaa.jpg', 'http://dp.mendian51.cn/public/uploads/Image/20181230/2ef3c680c0d07cedb35d286e36e57a5c.jpg', 1, 2, 12, 1546057912, 2, 28, '品牌保障，24小时退换，官方授权，极速退款，送货上门，免费安装', '&lt;p&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546057753782470.jpg&quot; title=&quot;1546057753782470.jpg&quot; alt=&quot;商品详情-下方详解图1.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546057804832909.jpg&quot; title=&quot;1546057804832909.jpg&quot; alt=&quot;商品详情-下方详解图2.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546057817336023.png&quot; title=&quot;1546057817336023.png&quot; alt=&quot;商品详情-下方详解图3.png&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546057831214751.jpg&quot; title=&quot;1546057831214751.jpg&quot; alt=&quot;商品详情-下方详解图4.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546057847654620.jpg&quot; title=&quot;1546057847654620.jpg&quot; alt=&quot;商品详情-下方详解图5.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546057865410875.jpg&quot; title=&quot;1546057865410875.jpg&quot; alt=&quot;商品详情-下方详解图6.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181229/1546057890785413.jpg&quot; title=&quot;1546057890785413.jpg&quot; alt=&quot;商品详情-下方详解图7.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;'),
(9, '载重式大三轮电动车专用动力电瓶', '48V45A', 4900, 7900, 86000, 100, '["http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/2df4120729688826e9ee73800ccea18d.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/de867482e8d8752cf012720f33e8dae3.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/4ce64f7425bfb9e4892c58694e6e6ee8.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/d304d33b8d6929e619d82b7ce5976d54.jpg"]', 'http://dp.mendian51.cn/public/uploads/Image/20181230/e04a0d414ba36ad03de8a4ea636e40a1.jpg', 'http://dp.mendian51.cn/public/uploads/Image/20181230/9030004b29f32df1b8b6122678bc1e34.jpg', 1, 2, 20, 1546140908, 2, 27, '品牌保障，24小时退换，官方授权，极速退款，送货上门，免费安装', '&lt;p&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546140703727044.jpg&quot; title=&quot;1546140703727044.jpg&quot; alt=&quot;商品详情-下方详解图1.jpg&quot; width=&quot;722&quot; height=&quot;270&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546140706100614.jpg&quot; title=&quot;1546140706100614.jpg&quot; alt=&quot;商品详情-下方详解图2.jpg&quot; width=&quot;616&quot; height=&quot;265&quot;/&gt;，&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546140709430071.png&quot; title=&quot;1546140709430071.png&quot; alt=&quot;商品详情-下方详解图3.png&quot;/&gt;，&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546140717517333.jpg&quot; title=&quot;1546140717517333.jpg&quot; alt=&quot;商品详图-下方详解图5.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546140721993422.jpg&quot; title=&quot;1546140721993422.jpg&quot; alt=&quot;商品详情-下方详解图4.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546140724311021.jpg&quot; title=&quot;1546140724311021.jpg&quot; alt=&quot;商品详情-下方详解图6.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546140726590078.jpg&quot; title=&quot;1546140726590078.jpg&quot; alt=&quot;商品详情-下方详解图7.jpg&quot;/&gt;&lt;/p&gt;'),
(11, '60V20A', '60V20A', 4900, 7900, 50000, 100, '["http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/cc4e6db17927f975511177200c224964.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/a0340225840b38953a673724fd57f898.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/64869db5223fd67db2f8b25241f1ed7b.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/f1bc3d184a53b4fcbe088ee591e4854a.jpg"]', 'http://dp.mendian51.cn/public/uploads/Image/20181230/e848e1a807705e400dd9369ccb1a2150.jpg', 'http://dp.mendian51.cn/public/uploads/Image/20181230/7bf170d3209354963a4d90cdf5ec564b.jpg', 1, 2, 30, 1546141058, 2, 6, '品牌保障，24小时退换，官方授权，极速退款，送货上门，免费安装', '&lt;p&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546140993195112.jpg&quot; title=&quot;1546140993195112.jpg&quot; alt=&quot;商品详情-下方详解图1.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546140996239951.jpg&quot; title=&quot;1546140996239951.jpg&quot; alt=&quot;商品详情-下方详解图2.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546140999323088.png&quot; title=&quot;1546140999323088.png&quot; alt=&quot;商品详情-下方详解图3.png&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141004347621.jpg&quot; title=&quot;1546141004347621.jpg&quot; alt=&quot;商品详情-下方详解图5.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141007738671.jpg&quot; title=&quot;1546141007738671.jpg&quot; alt=&quot;商品详情-下方详解图4.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141010458871.jpg&quot; title=&quot;1546141010458871.jpg&quot; alt=&quot;商品详情-下方详解图6.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141013780588.jpg&quot; title=&quot;1546141013780588.jpg&quot; alt=&quot;商品详情-下方详解图7.jpg&quot;/&gt;&lt;/p&gt;'),
(12, '60V32A', '60V32A', 4900, 7900, 79000, 200, '["http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/4457a253e14c39d5825262357ca2423a.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/6565911fffe8057fe7c2335271ee3938.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/b1464b2de896213ae0e3cd753b4c258a.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/3097aa7b4162d72fd229f9a755ceab6f.jpg"]', 'http://dp.mendian51.cn/public/uploads/Image/20181230/6e3ee72c9d9cbd8b6713cf7717329bb7.jpg', 'http://dp.mendian51.cn/public/uploads/Image/20181230/98a15da036df028bb433dbc7db3ab065.jpg', 1, 2, 50, 1546141444, 2, 5, '品牌保障，24小时退换，官方授权，极速退款，送货上门，免费安装', '&lt;p&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141353947896.jpg&quot; title=&quot;1546141353947896.jpg&quot; alt=&quot;商品详情-下方详解图1.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141355771889.jpg&quot; title=&quot;1546141355771889.jpg&quot; alt=&quot;商品详情-下方详解图2.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141358290192.png&quot; title=&quot;1546141358290192.png&quot; alt=&quot;商品详情-下方详解图3.png&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141362973397.jpg&quot; title=&quot;1546141362973397.jpg&quot; alt=&quot;商品详情-下方详解图5.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141365296772.jpg&quot; title=&quot;1546141365296772.jpg&quot; alt=&quot;商品详情-下方详解图4.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141369353158.jpg&quot; title=&quot;1546141369353158.jpg&quot; alt=&quot;商品详情-下方详解图6.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141372324417.jpg&quot; title=&quot;1546141372324417.jpg&quot; alt=&quot;商品详情-下方详解图7.jpg&quot;/&gt;&lt;/p&gt;'),
(13, '60V45A', '60V45A', 4900, 7900, 107000, 100, '["http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/da8d2945ddf940adf62d7fafc8a8e327.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/6fa731de4b3acffa2f1e976640139c15.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/26ee278dc221846208b0f72e69493b30.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/bb1ecd2f59b9af5cc27e1f2845671f12.jpg"]', 'http://dp.mendian51.cn/public/uploads/Image/20181230/b26b2ae6457e8f52c0541fb5db14de3a.jpg', 'http://dp.mendian51.cn/public/uploads/Image/20181230/25e77e662fa0803c1e70ed12bf7b35c3.jpg', 1, 2, 30, 1546141627, 2, 4, '品牌保障，24小时退换，官方授权，极速退款，送货上门，免费安装', '&lt;p&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141548824903.jpg&quot; title=&quot;1546141548824903.jpg&quot; alt=&quot;商品详情-下方详解图1.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141551425373.jpg&quot; title=&quot;1546141551425373.jpg&quot; alt=&quot;商品详情-下方详解图2.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141554843483.png&quot; title=&quot;1546141554843483.png&quot; alt=&quot;商品详情-下方详解图3.png&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141560173826.jpg&quot; title=&quot;1546141560173826.jpg&quot; alt=&quot;商品详图-下方详解图5.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141566956377.jpg&quot; title=&quot;1546141566956377.jpg&quot; alt=&quot;商品详情-下方详解图4.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141570795201.jpg&quot; title=&quot;1546141570795201.jpg&quot; alt=&quot;商品详情-下方详解图6.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141573285504.jpg&quot; title=&quot;1546141573285504.jpg&quot; alt=&quot;商品详情-下方详解图7.jpg&quot;/&gt;&lt;/p&gt;'),
(14, '72V20A', '72V20A', 4900, 7900, 59000, 100, '["http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/d24d260cdd94320b6733b766a3dd4c68.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/058286ed0448c60029a8a240846592c4.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/10f9f7e1f3cd3bd0ad04d3b6d697786b.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/7fb3c47f40cf4b368bc6cb67649e7e6b.jpg"]', 'http://dp.mendian51.cn/public/uploads/Image/20181230/b35daeee35958f7509a03eb965ee544b.jpg', 'http://dp.mendian51.cn/public/uploads/Image/20181230/899e9babb14c9a5adbfd6cb78d116868.jpg', 1, 2, 20, 1546141914, 2, 3, '品牌保障，24小时退换，官方授权，极速退款，送货上门，免费安装', '&lt;p&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141872504609.jpg&quot; title=&quot;1546141872504609.jpg&quot; alt=&quot;商品详情-下方详解图1.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141875414919.jpg&quot; title=&quot;1546141875414919.jpg&quot; alt=&quot;商品详情-下方详解图2.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141879170016.png&quot; title=&quot;1546141879170016.png&quot; alt=&quot;商品详情-下方详解图3.png&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141883946183.jpg&quot; title=&quot;1546141883946183.jpg&quot; alt=&quot;商品详情-下方详解图5.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141886532251.jpg&quot; title=&quot;1546141886532251.jpg&quot; alt=&quot;商品详情-下方详解图4.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141889758600.jpg&quot; title=&quot;1546141889758600.jpg&quot; alt=&quot;商品详情-下方详解图6.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141892632122.jpg&quot; title=&quot;1546141892632122.jpg&quot; alt=&quot;商品详情-下方详解图7.jpg&quot;/&gt;&lt;/p&gt;'),
(15, '72V32A', '72V32A', 4900, 7900, 93000, 100, '["http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/5016ec2d768e20f6c40cce92d4c6716a.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/73e8b400e3479daa8ab0ebfaf15b8030.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/47f87ccdf3dfcf973a31ac336633221e.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/f4247ac42a1b3f7ea0ec07702d7ffd82.jpg"]', 'http://dp.mendian51.cn/public/uploads/Image/20181230/0afb0c4f4c7436ee6f9649ad5747b74f.jpg', 'http://dp.mendian51.cn/public/uploads/Image/20181230/d1b14087fd2900752ab91b17e088227d.jpg', 1, 2, 30, 1546142009, 2, 2, '品牌保障，24小时退换，官方授权，极速退款，送货上门，免费安装', '&lt;p&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141974429128.jpg&quot; title=&quot;1546141974429128.jpg&quot; alt=&quot;商品详情-下方详解图1.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141977617074.jpg&quot; title=&quot;1546141977617074.jpg&quot; alt=&quot;商品详情-下方详解图2.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141981704097.png&quot; title=&quot;1546141981704097.png&quot; alt=&quot;商品详情-下方详解图3.png&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141984919294.jpg&quot; title=&quot;1546141984919294.jpg&quot; alt=&quot;商品详情-下方详解图5.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141986417457.jpg&quot; title=&quot;1546141986417457.jpg&quot; alt=&quot;商品详情-下方详解图4.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141989818955.jpg&quot; title=&quot;1546141989818955.jpg&quot; alt=&quot;商品详情-下方详解图6.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141992172037.jpg&quot; title=&quot;1546141992172037.jpg&quot; alt=&quot;商品详情-下方详解图7.jpg&quot;/&gt;&lt;/p&gt;'),
(16, '72V45A', '72V45A', 4900, 7900, 128000, 100, '["http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/b2e68929ec7ccbb5bb5f82a4c88fe654.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/6d451f490ebaa71fc4a633535d6a6dee.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/c97ac96d2a297b92b17a46f828ffba8b.jpg","http:\\/\\/dp.mendian51.cn\\/public\\/uploads\\/Image\\/20181230\\/222cf2b6f055da923526ed198d2aa152.jpg"]', 'http://dp.mendian51.cn/public/uploads/Image/20181230/da671a44f120b0c17738da1c52061660.jpg', 'http://dp.mendian51.cn/public/uploads/Image/20181230/4d0edeb0995bc932d32f8c5adcee4e58.jpg', 1, 2, 18, 1546142110, 2, 1, '品牌保障，24小时退换，官方授权，极速退款，送货上门，免费安装', '&lt;p&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546142052143898.jpg&quot; title=&quot;1546142052143898.jpg&quot; alt=&quot;商品详情-下方详解图1.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546142055787339.jpg&quot; title=&quot;1546142055787339.jpg&quot; alt=&quot;商品详情-下方详解图2.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546142057263778.png&quot; title=&quot;1546142057263778.png&quot; alt=&quot;商品详情-下方详解图3.png&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546142063991429.jpg&quot; title=&quot;1546142063991429.jpg&quot; alt=&quot;商品详图-下方详解图5.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546142066672138.jpg&quot; title=&quot;1546142066672138.jpg&quot; alt=&quot;商品详情-下方详解图4.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546142068466728.jpg&quot; title=&quot;1546142068466728.jpg&quot; alt=&quot;商品详情-下方详解图6.jpg&quot;/&gt;&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546142071866184.jpg&quot; title=&quot;1546142071866184.jpg&quot; alt=&quot;商品详情-下方详解图7.jpg&quot;/&gt;&lt;/p&gt;');

-- --------------------------------------------------------

--
-- 表的结构 `dp_mall_sku`
--

CREATE TABLE IF NOT EXISTS `dp_mall_sku` (
  `sku_id` int(10) unsigned NOT NULL,
  `goods_id` int(10) DEFAULT NULL,
  `news_money` int(10) DEFAULT NULL,
  `name` varchar(65) DEFAULT NULL,
  `price` int(10) DEFAULT NULL,
  `add_time` int(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='商品SKU表';

--
-- 转存表中的数据 `dp_mall_sku`
--

INSERT INTO `dp_mall_sku` (`sku_id`, `goods_id`, `news_money`, `name`, `price`, `add_time`) VALUES
(1, 1, 132100, '1232', 32100, 1545706014),
(2, 2, 30000, '48V12AH', 40000, 1545706025),
(3, 3, 40000, '48V20Ah', 60000, 1546055133),
(4, 3, 50000, '60V20Ah', 75000, 1546055898),
(5, 3, 59000, '72V20Ah', 90000, 1546055898),
(6, 4, 64000, '48V32Ah', 92000, 1546056421),
(7, 4, 79000, '60V32Ah', 115000, 1546056421),
(8, 4, 93000, '72V32Ah', 138000, 1546056421),
(9, 5, 86000, '48V45Ah', 124000, 1546056793),
(10, 5, 107000, '60V45Ah', 155000, 1546056793),
(11, 5, 128000, '70V45Ah', 186000, 1546056793),
(12, 6, 30000, '48V12Ah', 40000, 1546057322),
(13, 7, 40000, '48V20Ah', 60000, 1546057633),
(14, 8, 64000, '48V32Ah', 92000, 1546057912),
(15, 9, 86000, '48V45A', 124000, 1546140908),
(16, 10, 86000, '48V45A', 124000, 1546140909),
(17, 11, 50000, '60V20A', 75000, 1546141058),
(18, 12, 79000, '60V32A', 115000, 1546141444),
(19, 13, 107000, '60V45A', 155000, 1546141627),
(20, 14, 59000, '72V20A', 90000, 1546141914),
(21, 15, 93000, '72V32A', 138000, 1546142009),
(22, 16, 128000, '72V45A', 186000, 1546142110);

-- --------------------------------------------------------

--
-- 表的结构 `dp_nav`
--

CREATE TABLE IF NOT EXISTS `dp_nav` (
  `id` int(10) unsigned NOT NULL,
  `pid` int(10) unsigned NOT NULL COMMENT '父ID',
  `name` varchar(20) NOT NULL COMMENT '导航名称',
  `alias` varchar(20) DEFAULT '' COMMENT '导航别称',
  `link` varchar(255) DEFAULT '' COMMENT '导航链接',
  `icon` varchar(255) DEFAULT '' COMMENT '导航图标',
  `target` varchar(10) DEFAULT '' COMMENT '打开方式',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态  0 隐藏  1 显示',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='导航表';

-- --------------------------------------------------------

--
-- 表的结构 `dp_order`
--

CREATE TABLE IF NOT EXISTS `dp_order` (
  `order_id` int(10) unsigned NOT NULL,
  `member_id` int(10) DEFAULT NULL COMMENT '用户ID',
  `total_money` int(10) DEFAULT NULL COMMENT '一共支付',
  `need_pay` int(10) DEFAULT NULL COMMENT '实际需要支付',
  `pay_money` int(10) DEFAULT NULL COMMENT '在线支付',
  `pay_coupon` int(10) DEFAULT NULL COMMENT '优惠券支付',
  `coupon_id` int(10) DEFAULT NULL COMMENT '优惠券id',
  `pay_yue` int(10) DEFAULT NULL COMMENT '余额支付',
  `pay_time` int(10) DEFAULT NULL COMMENT '支付时间',
  `pay_info` text COMMENT '支付信息',
  `refund_info` text COMMENT '微信退款信息',
  `name` varchar(255) DEFAULT NULL COMMENT '联系人',
  `mobile` varchar(255) DEFAULT NULL COMMENT '联系方式',
  `province` varchar(255) DEFAULT NULL COMMENT '省市区',
  `address` varchar(255) DEFAULT NULL COMMENT '联系地址',
  `status` tinyint(3) DEFAULT NULL COMMENT '0--等待支付 1--等待发货 2--已发货,等待接单  3--取货中  4--配送中 5--已收货 6--申请退货 7--退货中 8--申请换货  9--换货中 10--换货成功  11--已完成   12--用户已取消订单  13--已完成退货   14--已退款  15--已失效',
  `lat` varchar(15) DEFAULT NULL,
  `lng` varchar(15) DEFAULT NULL,
  `last_time` int(10) DEFAULT NULL COMMENT '最后支付时间 加 30 分钟',
  `add_time` int(10) DEFAULT NULL,
  `actual_price` int(10) DEFAULT NULL COMMENT '微信实际支付的价格',
  `reason` varchar(255) DEFAULT NULL COMMENT '退款原因',
  `info` varchar(255) DEFAULT NULL COMMENT '备注',
  `invalid` tinyint(3) DEFAULT NULL COMMENT '0.未失效 1.已失效',
  `is_chang` tinyint(3) DEFAULT NULL COMMENT '0 -- 发货  1--换货    2--退货'
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COMMENT='订单表';

--
-- 转存表中的数据 `dp_order`
--

INSERT INTO `dp_order` (`order_id`, `member_id`, `total_money`, `need_pay`, `pay_money`, `pay_coupon`, `coupon_id`, `pay_yue`, `pay_time`, `pay_info`, `refund_info`, `name`, `mobile`, `province`, `address`, `status`, `lat`, `lng`, `last_time`, `add_time`, `actual_price`, `reason`, `info`, `invalid`, `is_chang`) VALUES
(1, 9, 30000, 30000, 30000, 0, 0, 0, NULL, NULL, NULL, '刘亚楠', '13521324008', '河北省廊坊市', '1231654', 15, '39.5228', '116.71051', 1545716500, 1545714700, NULL, NULL, '备注', NULL, NULL),
(2, 2, 2, 2, 2, 0, 0, 0, 1545715646, '{"appid":"wx965aa9ed069d64b8","attach":"2","bank_type":"CFT","cash_fee":"2","fee_type":"CNY","is_subscribe":"N","mch_id":"1519674101","nonce_str":"MwhDJvj8ldE5KCLU","openid":"o25j15bfbw3A70VUjAayQN57VsNg","out_trade_no":"151967410166832","result_code":"SUCCESS","return_code":"SUCCESS","return_msg":"OK","sign":"277D78328CF808F77A3269F28EC6C74E","time_end":"20181225132725","total_fee":"2","trade_state":"SUCCESS","trade_state_desc":"\\u652f\\u4ed8\\u6210\\u529f","trade_type":"JSAPI","transaction_id":"4200000211201812250638453104"}', '{"appid":"wx965aa9ed069d64b8","cash_fee":"2","cash_refund_fee":"2","coupon_refund_count":"0","coupon_refund_fee":"0","mch_id":"1519674101","nonce_str":"EhBTiFjJs3T7Z463","out_refund_no":"1519674101781692","out_trade_no":"151967410166832","refund_channel":[],"refund_fee":"2","refund_id":"50000009262018122507655035975","result_code":"SUCCESS","return_code":"SUCCESS","return_msg":"OK","sign":"D6AAE1B67EEDA3085C668325566E39F8","total_fee":"2","transaction_id":"4200000211201812250638453104"}', '龙', '13766666666', '廊坊市公安交警一大队(广阳道146号)', '146号', 14, '39.539646', '116.70825', 1545717440, 1545715640, NULL, NULL, '备注', NULL, NULL),
(3, 2, 2, 2, 2, 0, 0, 0, NULL, NULL, NULL, '龙', '13766666666', '廊坊市公安交警一大队(广阳道146号)', '146号', 15, '39.539646', '116.70825', 1545717523, 1545715723, NULL, NULL, '备注', NULL, NULL),
(4, 2, 1, 1, 1, 0, 0, 0, 1545715859, '{"appid":"wx965aa9ed069d64b8","attach":"4","bank_type":"CFT","cash_fee":"1","fee_type":"CNY","is_subscribe":"N","mch_id":"1519674101","nonce_str":"CAM2Jb5U2kDdkuiU","openid":"o25j15bfbw3A70VUjAayQN57VsNg","out_trade_no":"151967410146834","result_code":"SUCCESS","return_code":"SUCCESS","return_msg":"OK","sign":"99CEF4152B3091E3398E95B8F61E3E48","time_end":"20181225133057","total_fee":"1","trade_state":"SUCCESS","trade_state_desc":"\\u652f\\u4ed8\\u6210\\u529f","trade_type":"JSAPI","transaction_id":"4200000232201812259407789583"}', '{"appid":"wx965aa9ed069d64b8","cash_fee":"1","cash_refund_fee":"1","coupon_refund_count":"0","coupon_refund_fee":"0","mch_id":"1519674101","nonce_str":"ydymDMAjen6R55Ar","out_refund_no":"1519674101367024","out_trade_no":"151967410146834","refund_channel":[],"refund_fee":"1","refund_id":"50000709102018122507667794900","result_code":"SUCCESS","return_code":"SUCCESS","return_msg":"OK","sign":"8AED92F16A88E7DD77398BC61504C08E","total_fee":"1","transaction_id":"4200000232201812259407789583"}', '龙', '13766666666', '廊坊市公安交警一大队(广阳道146号)', '146号', 14, '39.539646', '116.70825', 1545717653, 1545715853, NULL, NULL, '备注', NULL, 0),
(5, 2, 3, 3, 3, 0, 0, 0, 1545720651, '{"appid":"wx965aa9ed069d64b8","attach":"5","bank_type":"CFT","cash_fee":"3","fee_type":"CNY","is_subscribe":"N","mch_id":"1519674101","nonce_str":"7uopRndXDmEziwwb","openid":"o25j15bfbw3A70VUjAayQN57VsNg","out_trade_no":"151967410179115","result_code":"SUCCESS","return_code":"SUCCESS","return_msg":"OK","sign":"507B6DE425F6C3936885B7874B5240F6","time_end":"20181225145050","total_fee":"3","trade_state":"SUCCESS","trade_state_desc":"\\u652f\\u4ed8\\u6210\\u529f","trade_type":"JSAPI","transaction_id":"4200000225201812258524229592"}', '{"appid":"wx965aa9ed069d64b8","cash_fee":"3","cash_refund_fee":"3","coupon_refund_count":"0","coupon_refund_fee":"0","mch_id":"1519674101","nonce_str":"i5l9xIz54hqkaQz6","out_refund_no":"1519674101770665","out_trade_no":"151967410179115","refund_channel":[],"refund_fee":"3","refund_id":"50000009112018122507667438854","result_code":"SUCCESS","return_code":"SUCCESS","return_msg":"OK","sign":"F0CC86B9A98AF2B7465B88F2A20AF714","total_fee":"3","transaction_id":"4200000225201812258524229592"}', '龙', '13766666666', '廊坊市公安交警一大队(广阳道146号)', '146号', 14, '39.539646', '116.70825', 1545722445, 1545720645, NULL, NULL, '备注', NULL, NULL),
(6, 2, 1, 1, 1, 0, 0, 0, NULL, NULL, NULL, '龙', '13766666666', '廊坊市公安交警一大队(广阳道146号)', '146号', 12, '39.539646', '116.70825', 1545722735, 1545720935, NULL, NULL, '备注', NULL, NULL),
(7, 2, 1, 1, 1, 0, 0, 0, NULL, NULL, NULL, '龙', '13766666666', '廊坊市公安交警一大队(广阳道146号)', '146号', 4, '39.539646', '116.70825', 1545722810, 1545731085, NULL, NULL, '备注', NULL, NULL),
(8, 2, 1, 1, 1, 0, 0, 0, 1545721068, '{"appid":"wx965aa9ed069d64b8","attach":"8","bank_type":"CFT","cash_fee":"1","fee_type":"CNY","is_subscribe":"N","mch_id":"1519674101","nonce_str":"g7E6E5ki28kE6RWI","openid":"o25j15bfbw3A70VUjAayQN57VsNg","out_trade_no":"151967410191308","result_code":"SUCCESS","return_code":"SUCCESS","return_msg":"OK","sign":"BDE47D5FD104194D1CE392C63A12E0F8","time_end":"20181225145746","total_fee":"1","trade_state":"SUCCESS","trade_state_desc":"\\u652f\\u4ed8\\u6210\\u529f","trade_type":"JSAPI","transaction_id":"4200000224201812254544625095"}', '{"appid":"wx965aa9ed069d64b8","cash_fee":"1","cash_refund_fee":"1","coupon_refund_count":"0","coupon_refund_fee":"0","mch_id":"1519674101","nonce_str":"JWhQBfiOOW7agakr","out_refund_no":"1519674101140248","out_trade_no":"151967410191308","refund_channel":[],"refund_fee":"1","refund_id":"50000709092018122507587615690","result_code":"SUCCESS","return_code":"SUCCESS","return_msg":"OK","sign":"BF90C1552822FBB2022AF94A505C065B","total_fee":"1","transaction_id":"4200000224201812254544625095"}', '龙', '13766666666', '廊坊市公安交警一大队(广阳道146号)', '146号', 14, '39.539646', '116.70825', 1545722862, 1545721062, NULL, NULL, '备注', NULL, NULL),
(9, 2, 2, 2, 2, 0, 0, 0, 1545727772, '{"appid":"wx965aa9ed069d64b8","attach":"9","bank_type":"CFT","cash_fee":"2","fee_type":"CNY","is_subscribe":"N","mch_id":"1519674101","nonce_str":"ByhRZNtBrIKBn2T9","openid":"o25j15bfbw3A70VUjAayQN57VsNg","out_trade_no":"151967410193779","result_code":"SUCCESS","return_code":"SUCCESS","return_msg":"OK","sign":"F01E4C1EFCD4A5D73C8C092DF4A29295","time_end":"20181225164930","total_fee":"2","trade_state":"SUCCESS","trade_state_desc":"\\u652f\\u4ed8\\u6210\\u529f","trade_type":"JSAPI","transaction_id":"4200000235201812255091542601"}', '{"appid":"wx965aa9ed069d64b8","cash_fee":"2","cash_refund_fee":"2","coupon_refund_count":"0","coupon_refund_fee":"0","mch_id":"1519674101","nonce_str":"q2YHFoJV7DqtkVRa","out_refund_no":"1519674101214289","out_trade_no":"151967410193779","refund_channel":[],"refund_fee":"2","refund_id":"50000109162018122507591155504","result_code":"SUCCESS","return_code":"SUCCESS","return_msg":"OK","sign":"B386126E74E59E3679B959E0EACA73E6","total_fee":"2","transaction_id":"4200000235201812255091542601"}', '龙', '13766666666', '廊坊市公安交警一大队(广阳道146号)', '146号', 14, '39.539646', '116.70825', 1545729565, 1545727765, NULL, NULL, '备注', NULL, 0),
(10, 2, 1, 1, 1, 0, 0, 0, 1545727826, '{"appid":"wx965aa9ed069d64b8","attach":"10","bank_type":"CFT","cash_fee":"1","fee_type":"CNY","is_subscribe":"N","mch_id":"1519674101","nonce_str":"gHQyzEhtphR14xKZ","openid":"o25j15bfbw3A70VUjAayQN57VsNg","out_trade_no":"1519674101840210","result_code":"SUCCESS","return_code":"SUCCESS","return_msg":"OK","sign":"E4D6F5DD7405A1E6C9C167D28895C64B","time_end":"20181225165025","total_fee":"1","trade_state":"SUCCESS","trade_state_desc":"\\u652f\\u4ed8\\u6210\\u529f","trade_type":"JSAPI","transaction_id":"4200000235201812253383826090"}', NULL, '龙', '13766666666', '廊坊市公安交警一大队(广阳道146号)', '146号', 10, '39.539646', '116.70825', 1545729621, 1545727821, NULL, NULL, '备注', NULL, 1),
(11, 2, 1, 1, 1, 0, 0, 0, 1545728102, '{"appid":"wx965aa9ed069d64b8","attach":"11","bank_type":"CFT","cash_fee":"1","fee_type":"CNY","is_subscribe":"N","mch_id":"1519674101","nonce_str":"acm3gS41gG4G05BI","openid":"o25j15bfbw3A70VUjAayQN57VsNg","out_trade_no":"1519674101572611","result_code":"SUCCESS","return_code":"SUCCESS","return_msg":"OK","sign":"053EA31E6CB94AF39581F63FF55DBDD0","time_end":"20181225165501","total_fee":"1","trade_state":"SUCCESS","trade_state_desc":"\\u652f\\u4ed8\\u6210\\u529f","trade_type":"JSAPI","transaction_id":"4200000227201812257147487988"}', NULL, '龙', '13766666666', '廊坊市公安交警一大队(广阳道146号)', '146号', 5, '39.539646', '116.70825', 1545729898, 1545728098, NULL, NULL, '备注', NULL, 0),
(12, 2, 1, 1, 1, 0, 0, 0, NULL, NULL, NULL, '龙', '13766666666', '廊坊市公安交警一大队(广阳道146号)', '146号', 15, '39.539646', '116.70825', 1545730472, 1545728672, NULL, NULL, '备注', NULL, NULL),
(13, 7, 2, 2, 2, 0, 0, 0, NULL, NULL, NULL, '张三', '13599996666', '河北省廊坊市广阳区康宁街2号', '123321', 6, '39.5228', '116.71051', 1545831221, 1545731221, NULL, NULL, '备注', NULL, NULL),
(14, 7, 2, 2, 0, 0, 0, 2, NULL, NULL, NULL, '张三', '13599996666', '河北省廊坊市广阳区康宁街2号', '123321', 11, '39.5228', '116.71051', 1545733441, 1545731641, NULL, NULL, '备注', NULL, NULL),
(15, 9, 1, 1, 0, 0, 0, 1, NULL, NULL, NULL, '刘亚楠', '13521324008', '河北省廊坊市', '1231654', 12, '39.5228', '116.71051', 1545788836, 1545787036, NULL, NULL, '备注', NULL, 0),
(16, 9, 1, 1, 0, 0, 0, 1, NULL, NULL, NULL, '刘亚楠', '13521324008', '河北省廊坊市', '1231654', 12, '39.5228', '116.71051', 1545789710, 1545787910, NULL, NULL, '备注', NULL, 0),
(17, 9, 1, 1, 0, 0, 0, 1, NULL, NULL, NULL, '刘亚楠', '13521324008', '河北省廊坊市', '1231654', 12, '39.5228', '116.71051', 1545789868, 1545788069, NULL, NULL, '备注', NULL, 0),
(18, 9, 1, 1, 0, 0, 0, 1, NULL, NULL, NULL, '刘亚楠', '13521324008', '河北省廊坊市', '1231654', 12, '39.5228', '116.71051', 1545791385, 1545789585, NULL, NULL, '备注', NULL, 0),
(19, 9, 1, 1, 0, 0, 0, 1, NULL, NULL, NULL, '刘亚楠', '13521324008', '河北省廊坊市', '1231654', 12, '39.5228', '116.71051', 1545792011, 1545790211, NULL, NULL, '备注', NULL, 0),
(20, 8, 1, 1, 0, 0, 0, 1, NULL, NULL, NULL, '康先生', '17600522642', '浙商广场A座(广阳区浙商广场爱民东道北)', '啊嘞', 12, '39.528145', '116.71112', 1545792556, 1545790756, NULL, NULL, '备注', NULL, 0),
(21, 8, 1, 1, 0, 0, 0, 1, NULL, NULL, NULL, '康先生', '17600522642', '浙商广场A座(广阳区浙商广场爱民东道北)', '啊嘞', 12, '39.528145', '116.71112', 1545793107, 1545791307, NULL, NULL, '备注', NULL, 0),
(22, 9, 1, 1, 0, 0, 0, 1, NULL, NULL, NULL, '刘亚楠', '13521324008', '河北省廊坊市', '1231654', 12, '39.5228', '116.71051', 1545793317, 1545791517, NULL, NULL, '备注', NULL, 0),
(23, 2, 1, 1, 1, 0, 0, 0, 1545806358, '{"appid":"wx965aa9ed069d64b8","attach":"23","bank_type":"CFT","cash_fee":"1","fee_type":"CNY","is_subscribe":"N","mch_id":"1519674101","nonce_str":"RqdokPSgFsz6AaMB","openid":"o25j15bfbw3A70VUjAayQN57VsNg","out_trade_no":"1519674101761323","result_code":"SUCCESS","return_code":"SUCCESS","return_msg":"OK","sign":"137EF32F055A7E1D6564CF78C688491E","time_end":"20181226143917","total_fee":"1","trade_state":"SUCCESS","trade_state_desc":"\\u652f\\u4ed8\\u6210\\u529f","trade_type":"JSAPI","transaction_id":"4200000216201812268207176832"}', NULL, '龙', '13766666666', '廊坊市公安交警一大队(广阳道146号)', '146号', 1, '39.539646', '116.70825', 1545808152, 1545806352, NULL, NULL, '备注', NULL, NULL),
(24, 20, 1, 1, 1, 0, 0, 0, NULL, NULL, NULL, '多喝点宝贝', '17719598468', '蓝溪国际大厦(高新三路高新九号广场)', '大家都能', 15, '34.238537', '108.90001', 1545887024, 1545885224, NULL, NULL, '备注', NULL, NULL),
(25, 22, 1, 1, 1, 0, 0, 0, 1545888568, '{"appid":"wx965aa9ed069d64b8","attach":"25","bank_type":"CFT","cash_fee":"1","fee_type":"CNY","is_subscribe":"N","mch_id":"1519674101","nonce_str":"uLsvFlPtuB8zoFUL","openid":"o25j15d3A9UcQjhAtI1RZdQ_KzI8","out_trade_no":"1519674101868725","result_code":"SUCCESS","return_code":"SUCCESS","return_msg":"OK","sign":"971E91870DB9FAC5B39FAE89EB15B3D2","time_end":"20181227132927","total_fee":"1","trade_state":"SUCCESS","trade_state_desc":"\\u652f\\u4ed8\\u6210\\u529f","trade_type":"JSAPI","transaction_id":"4200000219201812276663316543"}', NULL, '王新波', '15291335257', '蓝溪国际酒店(高新四路高新九号广场)', '502', 6, '34.239033', '108.899605', 1545890360, 1545888560, NULL, NULL, '备注', NULL, NULL),
(26, 22, 1, 1, 1, 0, 0, 0, NULL, NULL, NULL, '王新波', '15291335257', '蓝溪国际酒店(高新四路高新九号广场)', '502', 12, '34.239033', '108.899605', 1545890361, 1545888561, NULL, NULL, '备注', NULL, NULL),
(27, 22, 1, 1, 1, 0, 0, 0, NULL, NULL, NULL, '王新波', '15291335257', '蓝溪国际酒店(高新四路高新九号广场)', '502', 12, '34.239033', '108.899605', 1545890630, 1545888830, NULL, NULL, '备注', NULL, NULL),
(28, 22, 1, 1, 1, 0, 0, 0, 1545888888, '{"appid":"wx965aa9ed069d64b8","attach":"28","bank_type":"CFT","cash_fee":"1","fee_type":"CNY","is_subscribe":"N","mch_id":"1519674101","nonce_str":"hBEbzOrusSQ19S5B","openid":"o25j15d3A9UcQjhAtI1RZdQ_KzI8","out_trade_no":"1519674101372528","result_code":"SUCCESS","return_code":"SUCCESS","return_msg":"OK","sign":"FC3D40B925B3356DB4C9F1EE92F0418B","time_end":"20181227133447","total_fee":"1","trade_state":"SUCCESS","trade_state_desc":"\\u652f\\u4ed8\\u6210\\u529f","trade_type":"JSAPI","transaction_id":"4200000215201812275392468006"}', '{"appid":"wx965aa9ed069d64b8","cash_fee":"1","cash_refund_fee":"1","coupon_refund_count":"0","coupon_refund_fee":"0","mch_id":"1519674101","nonce_str":"kceYyUsLV1NSbgdc","out_refund_no":"15196741012817528","out_trade_no":"1519674101372528","refund_channel":[],"refund_fee":"1","refund_id":"50000609122018122707697312523","result_code":"SUCCESS","return_code":"SUCCESS","return_msg":"OK","sign":"248D83727B9412BEA3A4BB0EB8E9BEBD","total_fee":"1","transaction_id":"4200000215201812275392468006"}', '王新波', '15291335257', '蓝溪国际酒店(高新四路高新九号广场)', '502', 14, '34.239033', '108.899605', 1545890681, 1545888881, NULL, NULL, '备注', NULL, NULL),
(29, 20, 1, 1, 1, 0, 0, 0, NULL, NULL, NULL, '多喝点宝贝', '17719598468', '蓝溪国际大厦(高新三路高新九号广场)', '大家都能', 12, '34.238537', '108.90001', 1545890725, 1545888925, NULL, NULL, '备注', NULL, NULL),
(30, 21, 1, 1, 1, 0, 0, 0, NULL, NULL, NULL, '完成', '13227752592', '蓝溪国际大厦(高新三路高新九号广场)', '2206', 15, '34.238895', '108.89977', 1545890747, 1545888947, NULL, NULL, '备注', NULL, NULL),
(31, 19, 1, 1, 1, 0, 0, 0, 1545889014, '{"appid":"wx965aa9ed069d64b8","attach":"31","bank_type":"CFT","cash_fee":"1","fee_type":"CNY","is_subscribe":"N","mch_id":"1519674101","nonce_str":"2DEdr69kpVOMIeoh","openid":"o25j15ZFdtLZIZ3vTbwZq9JST3y8","out_trade_no":"1519674101589131","result_code":"SUCCESS","return_code":"SUCCESS","return_msg":"OK","sign":"B9576588E8DDAD0BB4A61B12D550CC35","time_end":"20181227133653","total_fee":"1","trade_state":"SUCCESS","trade_state_desc":"\\u652f\\u4ed8\\u6210\\u529f","trade_type":"JSAPI","transaction_id":"4200000222201812279292045399"}', NULL, '王聪', '13227752592', '西安市蓝溪国际大厦(高新三路高新九号广场)', '2206', 5, '34.238877387032', '108.90034943819', 1545890808, 1545889008, NULL, NULL, '备注', NULL, NULL),
(32, 22, 1, 1, 1, 0, 0, 0, 1545889191, '{"appid":"wx965aa9ed069d64b8","attach":"32","bank_type":"CFT","cash_fee":"1","fee_type":"CNY","is_subscribe":"N","mch_id":"1519674101","nonce_str":"qOirB52LqUrZ0KDA","openid":"o25j15d3A9UcQjhAtI1RZdQ_KzI8","out_trade_no":"1519674101670432","result_code":"SUCCESS","return_code":"SUCCESS","return_msg":"OK","sign":"4C608555A2C51C48B3D5DC47B642D3AF","time_end":"20181227133950","total_fee":"1","trade_state":"SUCCESS","trade_state_desc":"\\u652f\\u4ed8\\u6210\\u529f","trade_type":"JSAPI","transaction_id":"4200000234201812270042420365"}', '{"appid":"wx965aa9ed069d64b8","cash_fee":"1","cash_refund_fee":"1","coupon_refund_count":"0","coupon_refund_fee":"0","mch_id":"1519674101","nonce_str":"dl8E1qEsHEIfxLg8","out_refund_no":"15196741019098332","out_trade_no":"1519674101670432","refund_channel":[],"refund_fee":"1","refund_id":"50000509162018122707723115617","result_code":"SUCCESS","return_code":"SUCCESS","return_msg":"OK","sign":"BDD95C5CC4352CAC3F46155D553495F1","total_fee":"1","transaction_id":"4200000234201812270042420365"}', '王新波', '15291335257', '蓝溪国际酒店(高新四路高新九号广场)', '502', 14, '34.239033', '108.899605', 1545890983, 1545889183, NULL, NULL, '备注', NULL, NULL),
(33, 20, 1, 1, 1, 0, 0, 0, 1545889213, '{"appid":"wx965aa9ed069d64b8","attach":"33","bank_type":"CFT","cash_fee":"1","fee_type":"CNY","is_subscribe":"N","mch_id":"1519674101","nonce_str":"1FnPtEc9sgcVYVDG","openid":"o25j15V3wcZWUb1d-XNzszLr8v-I","out_trade_no":"1519674101512633","result_code":"SUCCESS","return_code":"SUCCESS","return_msg":"OK","sign":"2A15F3C401A928A3A7774B6AA5D75902","time_end":"20181227134012","total_fee":"1","trade_state":"SUCCESS","trade_state_desc":"\\u652f\\u4ed8\\u6210\\u529f","trade_type":"JSAPI","transaction_id":"4200000226201812278328794447"}', NULL, '多喝点宝贝', '17719598468', '蓝溪国际大厦(高新三路高新九号广场)', '大家都能', 1, '34.238537', '108.90001', 1545890991, 1545889191, NULL, NULL, '备注', NULL, NULL),
(34, 22, 1, 1, 1, 0, 0, 0, 1545889285, '{"appid":"wx965aa9ed069d64b8","attach":"34","bank_type":"CFT","cash_fee":"1","fee_type":"CNY","is_subscribe":"N","mch_id":"1519674101","nonce_str":"SDjI9IvgLaTs0XSn","openid":"o25j15d3A9UcQjhAtI1RZdQ_KzI8","out_trade_no":"1519674101129434","result_code":"SUCCESS","return_code":"SUCCESS","return_msg":"OK","sign":"C84C69ADAD43D9FC4F44578F468A30D3","time_end":"20181227134123","total_fee":"1","trade_state":"SUCCESS","trade_state_desc":"\\u652f\\u4ed8\\u6210\\u529f","trade_type":"JSAPI","transaction_id":"4200000235201812279874069431"}', NULL, '王新波', '15291335257', '蓝溪国际酒店(高新四路高新九号广场)', '502', 1, '34.239033', '108.899605', 1545891076, 1545889276, NULL, NULL, '备注', NULL, NULL),
(35, 27, 3, 3, 3, 0, 0, 0, 1546047213, '{"appid":"wx965aa9ed069d64b8","attach":"35","bank_type":"CFT","cash_fee":"3","fee_type":"CNY","is_subscribe":"N","mch_id":"1519674101","nonce_str":"vjQKZ6KR158ycTKj","openid":"o25j15X2T8qFmEaWjOx1qj_v5M_c","out_trade_no":"1519674101735235","result_code":"SUCCESS","return_code":"SUCCESS","return_msg":"OK","sign":"1CE17539BEE892778F59696FFFC75E07","time_end":"20181229093332","total_fee":"3","trade_state":"SUCCESS","trade_state_desc":"\\u652f\\u4ed8\\u6210\\u529f","trade_type":"JSAPI","transaction_id":"4200000238201812294790176871"}', NULL, '杨江峰', '18066666666', '渭南市新洲华盛(新洲华盛仓程路西200米)', '逸惠园', 1, '34.50566496457', '109.47242754051', 1546049005, 1546047205, NULL, NULL, '备注', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `dp_order_goods`
--

CREATE TABLE IF NOT EXISTS `dp_order_goods` (
  `order_goods_id` int(10) unsigned NOT NULL,
  `order_id` int(10) DEFAULT NULL,
  `member_id` int(10) DEFAULT NULL COMMENT '用户ID',
  `photo` varchar(255) DEFAULT NULL COMMENT 'sku图片',
  `goods_name` varchar(255) DEFAULT NULL COMMENT '商品名称',
  `price` int(10) DEFAULT NULL COMMENT '这里存的是购买时的单价',
  `num` int(10) DEFAULT NULL COMMENT '购买的数量',
  `add_time` int(10) DEFAULT NULL,
  `goods_id` int(10) DEFAULT NULL,
  `sku_id` int(10) DEFAULT NULL,
  `is_comment` tinyint(3) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COMMENT='订单商品表';

--
-- 转存表中的数据 `dp_order_goods`
--

INSERT INTO `dp_order_goods` (`order_goods_id`, `order_id`, `member_id`, `photo`, `goods_name`, `price`, `num`, `add_time`, `goods_id`, `sku_id`, `is_comment`) VALUES
(1, 1, 9, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 30000, 1, NULL, 2, 2, NULL),
(2, 2, 2, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 2, 1, NULL, 2, 2, NULL),
(3, 3, 2, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 2, 1, NULL, 2, 2, NULL),
(4, 4, 2, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 1, 1, NULL, 2, 2, NULL),
(5, 5, 2, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 3, 3, NULL, 2, 2, NULL),
(6, 6, 2, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 1, 1, NULL, 2, 2, NULL),
(7, 7, 2, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 1, 1, NULL, 2, 2, NULL),
(8, 8, 2, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 1, 1, NULL, 2, 2, NULL),
(9, 9, 2, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 2, 2, NULL, 2, 2, NULL),
(10, 10, 2, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 1, 1, NULL, 2, 2, NULL),
(11, 11, 2, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 1, 1, NULL, 2, 2, NULL),
(12, 12, 2, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 1, 1, NULL, 2, 2, NULL),
(13, 13, 7, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 2, 1, NULL, 2, 2, NULL),
(14, 14, 7, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 2, 1, NULL, 2, 2, NULL),
(15, 15, 9, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 1, 1, NULL, 2, 2, NULL),
(16, 16, 9, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 1, 1, NULL, 2, 2, NULL),
(17, 17, 9, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 1, 1, NULL, 2, 2, NULL),
(18, 18, 9, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 1, 1, NULL, 2, 2, NULL),
(19, 19, 9, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 1, 1, NULL, 2, 2, NULL),
(20, 20, 8, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 1, 1, NULL, 2, 2, NULL),
(21, 21, 8, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 1, 1, NULL, 2, 2, NULL),
(22, 22, 9, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 1, 1, NULL, 2, 2, NULL),
(23, 23, 2, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 1, 1, NULL, 2, 2, NULL),
(24, 24, 20, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 1, 1, NULL, 2, 2, NULL),
(25, 25, 22, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 1, 1, NULL, 2, 2, NULL),
(26, 26, 22, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 1, 1, NULL, 2, 2, NULL),
(27, 27, 22, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 1, 1, NULL, 2, 2, NULL),
(28, 28, 22, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 1, 1, NULL, 2, 2, NULL),
(29, 29, 20, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 1, 1, NULL, 2, 2, NULL),
(30, 30, 21, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 1, 1, NULL, 2, 2, NULL),
(31, 31, 19, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 1, 1, NULL, 2, 2, NULL),
(32, 32, 22, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 1, 1, NULL, 2, 2, NULL),
(33, 33, 20, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 1, 1, NULL, 2, 2, NULL),
(34, 34, 22, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 1, 1, NULL, 2, 2, NULL),
(35, 35, 27, 'http://dp.mendian51.cn/public/uploads/Image/20181225/e9c76e7e8c2f511fc36fc4cd56e2fbee.png', '简易款两轮电动车（12）', 3, 3, NULL, 2, 2, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `dp_order_log`
--

CREATE TABLE IF NOT EXISTS `dp_order_log` (
  `id` int(10) unsigned NOT NULL COMMENT '主键',
  `uid` int(10) DEFAULT NULL COMMENT '用户id',
  `order_id` int(10) DEFAULT NULL COMMENT '订单id',
  `type` tinyint(3) DEFAULT NULL COMMENT '0--发货  1--换货',
  `status` tinyint(3) DEFAULT NULL COMMENT '0--等待支付 1--等待发货 2--已发货,等待接单  3--取货中  4--配送中 5--已收货 6--申请退货 7--退货中 8--申请换货  9--换货中 10--换货成功  11--已完成   12--用户已取消订单  13--已完成退货   14--已退款  15--已失效',
  `add_time` int(11) DEFAULT NULL COMMENT '记录时间'
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8 COMMENT='订单日志表';

--
-- 转存表中的数据 `dp_order_log`
--

INSERT INTO `dp_order_log` (`id`, `uid`, `order_id`, `type`, `status`, `add_time`) VALUES
(1, 2, 2, 0, 14, 1545715688),
(9, 2, 5, 0, 14, 1545720764),
(10, 2, 8, 0, 14, 1545721085),
(12, 2, 4, 0, 2, 1545726651),
(13, 2, 4, 0, 3, 1545726923),
(14, 2, 4, 0, 14, 1545726958),
(15, 2, 9, 0, 2, 1545727783),
(16, 2, 9, 0, 14, 1545727796),
(17, 2, 10, 0, 2, 1545727832),
(18, 2, 10, 0, 3, 1545727940),
(19, 2, 10, 0, 4, 1545727950),
(20, 2, 10, 0, 5, 1545727954),
(21, 2, 10, 0, 8, 1545728018),
(22, 2, 10, 1, 9, 1545728025),
(23, 2, 10, 0, 10, 1545728050),
(24, 2, 11, 0, 2, 1545728106),
(25, 2, 11, 0, 3, 1545728120),
(26, 2, 11, 0, 4, 1545728122),
(27, 2, 11, 0, 5, 1545728124),
(28, 7, 13, 0, 6, 1545731617),
(29, 7, 14, 0, 5, 1545731649),
(30, 9, 15, 0, 2, 1545787606),
(31, 9, 15, 0, 12, 1545787725),
(32, 9, 16, 0, 2, 1545787924),
(33, 9, 16, 0, 12, 1545787964),
(34, 9, 17, 0, 2, 1545788091),
(35, 9, 17, 0, 3, 1545788234),
(36, 9, 17, 0, 12, 1545788238),
(37, 9, 18, 0, 2, 1545789620),
(39, 9, 17, 0, 12, 1545789820),
(40, 9, 17, 12, 1, 1545789820),
(41, 9, 18, 0, 12, 1545789879),
(42, 9, 18, 12, 1, 1545789879),
(43, 9, 19, 0, 2, 1545790217),
(44, 9, 19, 0, 12, 1545790248),
(45, 9, 19, 12, 1, 1545790248),
(46, 9, 19, 0, 12, 1545790441),
(47, 9, 19, 12, 1, 1545790441),
(50, 9, 19, 0, 12, 1545790589),
(51, 9, 19, 1, 12, 1545790589),
(54, 9, 19, 0, 12, 1545790721),
(55, 9, 19, 1, 12, 1545790721),
(56, 8, 20, 0, 2, 1545790799),
(57, 8, 20, 0, 12, 1545790853),
(58, 8, 20, 1, 12, 1545790853),
(59, 8, 21, 0, 2, 1545791315),
(60, 8, 21, 0, 12, 1545791369),
(61, 8, 21, 1, 12, 1545791369),
(62, 8, 21, 0, 2, 1545791433),
(65, 8, 21, 0, 12, 1545791474),
(66, 8, 21, 1, 12, 1545791474),
(67, 9, 22, 0, 2, 1545791535),
(68, 9, 22, 0, 12, 1545791546),
(69, 9, 22, 1, 12, 1545791546),
(70, 22, 25, 0, 5, 1545888649),
(71, 19, 31, 0, 5, 1545889060),
(72, 22, 32, 0, 14, 1545889207),
(73, 22, 28, 0, 14, 1545889209),
(74, 22, 25, 0, 6, 1545889240);

-- --------------------------------------------------------

--
-- 表的结构 `dp_peisong_member`
--

CREATE TABLE IF NOT EXISTS `dp_peisong_member` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `mobile` char(11) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `card_positive` varchar(255) DEFAULT NULL,
  `card_back` varchar(255) DEFAULT NULL,
  `card` char(18) DEFAULT NULL,
  `place` text,
  `review` tinyint(3) DEFAULT NULL,
  `status` tinyint(3) DEFAULT NULL,
  `create_time` int(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='配送员表';

--
-- 转存表中的数据 `dp_peisong_member`
--

INSERT INTO `dp_peisong_member` (`id`, `name`, `mobile`, `password`, `card_positive`, `card_back`, `card`, `place`, `review`, `status`, `create_time`) VALUES
(1, '小小龙', '18632642336', '2ac0f70be07e11867cd796293e6a1211', 'http://dp.mendian51.cn/public/uploads/Image/20181225/5c95230ab4cb6c01431b2253386ab7a1.jpg', 'http://dp.mendian51.cn/public/uploads/Image/20181225/27931360ad23126c14f24d2c8407e9a3.jpg', '131023199010109080', '流量', 1, 1, 1545716022),
(2, 'HSK', '15838719682', '25f9e794323b453885f5181f1b624d0b', 'http://dp.mendian51.cn/public/uploads/Image/20181225/e7561ec8353777b200c0f4a9e68fa455.png', 'http://dp.mendian51.cn/public/uploads/Image/20181225/a17f3a19b84c84c0f7935516462d28ee.jpg', '411329199512248864', '河北廊坊', 1, 1, 1545726402),
(4, '1310', '13521234008', '25f9e794323b453885f5181f1b624d0b', 'http://dp.mendian51.cn/public/uploads/Image/20181226/20a8097206a824fa8d28b466aa5ae24d.png', 'http://dp.mendian51.cn/public/uploads/Image/20181226/9e2a42253b52b506aa35692166fd620f.png', '131022199204161121', '河北省廊坊市广阳区康宁街2号', 1, 1, 1545791991);

-- --------------------------------------------------------

--
-- 表的结构 `dp_peisong_member_position`
--

CREATE TABLE IF NOT EXISTS `dp_peisong_member_position` (
  `member_id` int(10) unsigned NOT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL,
  `add_time` int(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='配送员位置表';

--
-- 转存表中的数据 `dp_peisong_member_position`
--

INSERT INTO `dp_peisong_member_position` (`member_id`, `lat`, `lng`, `add_time`) VALUES
(1, '39.52809000651042', '116.71122531467014', 1545811700),
(2, '39.5850843641493', '116.74592230902778', 1547299821),
(3, '39.5228', '116.71051', 1545791541),
(4, '39.5228', '116.71051', 1545792026);

-- --------------------------------------------------------

--
-- 表的结构 `dp_peisong_order`
--

CREATE TABLE IF NOT EXISTS `dp_peisong_order` (
  `id` int(10) unsigned NOT NULL,
  `order_id` int(10) DEFAULT NULL COMMENT '店铺订单id',
  `member_id` int(10) DEFAULT NULL COMMENT '接收配送的配送员id',
  `type` tinyint(3) DEFAULT NULL COMMENT '0--发货    1--换货  2--退货',
  `status` tinyint(3) DEFAULT NULL COMMENT '0待接单  1取货中  2配送中  3已完成',
  `member_ids` text COMMENT '接收推送的配送员id',
  `add_time` int(10) DEFAULT NULL COMMENT '添加时间',
  `complete_time` int(10) DEFAULT NULL COMMENT '完成时间'
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='配送订单表';

--
-- 转存表中的数据 `dp_peisong_order`
--

INSERT INTO `dp_peisong_order` (`id`, `order_id`, `member_id`, `type`, `status`, `member_ids`, `add_time`, `complete_time`) VALUES
(9, 4, 1, 0, 2, '[1,2]', 1545726923, NULL),
(10, 9, 1, 0, 2, '[1,2]', 1545727935, NULL),
(11, 10, 1, 0, 3, '[1,2]', 1545727940, 1545727954),
(12, 10, 1, 1, 3, '[2]', 1545728045, 1545728050),
(13, 11, 1, 0, 3, '[1,2]', 1545728120, 1545728124);

-- --------------------------------------------------------

--
-- 表的结构 `dp_slide`
--

CREATE TABLE IF NOT EXISTS `dp_slide` (
  `id` int(10) unsigned NOT NULL,
  `cid` int(10) unsigned NOT NULL COMMENT '分类ID',
  `name` varchar(50) NOT NULL COMMENT '轮播图名称',
  `description` varchar(255) DEFAULT '' COMMENT '说明',
  `link` varchar(255) DEFAULT '' COMMENT '链接',
  `target` varchar(10) DEFAULT '' COMMENT '打开方式',
  `image` varchar(255) DEFAULT '' COMMENT '轮播图片',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态  1 显示  0  隐藏',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序'
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='轮播图表';

--
-- 转存表中的数据 `dp_slide`
--

INSERT INTO `dp_slide` (`id`, `cid`, `name`, `description`, `link`, `target`, `image`, `status`, `sort`) VALUES
(7, 1, '2', '', '', '_self', 'http://dp.mendian51.cn/public/uploads/Image/20190102/0953146f41c13628805249faa169056b.jpg', 1, 0),
(6, 1, '1', '', '', '_self', 'http://dp.mendian51.cn/public/uploads/Image/20190102/fe7ac2ec9b6382002b2881faa058424a.jpg', 1, 0),
(8, 1, '3', '', '', '_self', 'http://dp.mendian51.cn/public/uploads/Image/20190102/b2f07fe92cf1d788d8ba8845dbe85b4b.jpg', 1, 0),
(9, 1, '4', '', '', '_self', 'http://dp.mendian51.cn/public/uploads/Image/20190102/0c04282a7d107e923234e36297a72e0f.jpg', 1, 0),
(11, 1, '5', '', '', '_self', 'http://dp.mendian51.cn/public/uploads/Image/20181225/b414242069f54689acf6cb4953137198.png', 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `dp_slide_category`
--

CREATE TABLE IF NOT EXISTS `dp_slide_category` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '轮播图分类'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='轮播图分类表';

--
-- 转存表中的数据 `dp_slide_category`
--

INSERT INTO `dp_slide_category` (`id`, `name`) VALUES
(1, '首页轮播');

-- --------------------------------------------------------

--
-- 表的结构 `dp_system`
--

CREATE TABLE IF NOT EXISTS `dp_system` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL COMMENT '配置项名称',
  `value` text NOT NULL COMMENT '配置项值'
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='系统配置表';

--
-- 转存表中的数据 `dp_system`
--

INSERT INTO `dp_system` (`id`, `name`, `value`) VALUES
(1, 'site_config', 'a:1:{s:10:"site_title";s:18:"电瓶管理后台";}'),
(2, 'company_config', 'a:7:{s:4:"name";s:39:"陕西保之林环保科技有限公司";s:4:"logo";s:89:"http://dp.mendian51.cn/public/uploads/Image/20181230/cd754a01bd4d37973c3acdd40c2946e4.jpg";s:3:"tel";s:12:"0913-2159666";s:6:"weixin";s:11:"13571397444";s:7:"address";s:45:"陕西省渭南市临渭区西五路怡惠园";s:6:"slogan";s:61:"绿色环保    以旧换新     免费上门    免费安装";s:7:"content";s:5260:"&lt;p style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;;font-family:宋体;font-size:29px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;公司简介&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141316628108.png&quot; title=&quot;1546141316628108.png&quot; alt=&quot;微信图片_20181230112449.png&quot;/&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;text-indent:28px&quot;&gt;&lt;span style=&quot;;font-family:宋体;font-size:19px&quot;&gt;“沃换电瓶”隶属于陕西保之林环保科技有限公司，公司成立于&lt;span style=&quot;font-family:Times New Roman&quot;&gt;2018&lt;/span&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;年&lt;/span&gt;&lt;span style=&quot;font-family:Times New Roman&quot;&gt;8&lt;/span&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;月&lt;/span&gt;&lt;span style=&quot;font-family:Times New Roman&quot;&gt;8&lt;/span&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;日，注册资本&lt;/span&gt;&lt;span style=&quot;font-family:Times New Roman&quot;&gt;300&lt;/span&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;万元人民币，坐落于陕西省渭南市。公司主要立足于蓄电瓶领域。为广大客户提供电动车电瓶的安装、配送、售后服务。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;text-indent: 38px; text-align: center;&quot;&gt;&lt;span style=&quot;;font-family:宋体;font-size:19px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;公司开发出的&lt;/span&gt;“沃换电瓶”小程序利用互联网平台为客户实现了微信平台销售，以旧换新（上门兑换，免费安装）、道路救援、售后保障、电瓶租赁等，便利、实惠、快捷、安全的服务功能。公司与陕西维保环保科技有限公司达成合作协议，现以有效地实现了新电瓶合法销售，旧电瓶合法储存，转运的服务条件。&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141553523702.png&quot; title=&quot;1546141553523702.png&quot; alt=&quot;微信图片_20181230112605.png&quot;/&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;;font-family:宋体;font-size:19px&quot;&gt;“沃换电瓶”平台拥有专业的服务团队成员，从后台处理接待，外勤上门服务，售后维护保障，诚信务实、全心全意为广大客户提供一套完整的服务系。&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141587359590.png&quot; title=&quot;1546141587359590.png&quot; alt=&quot;微信图片_20181230112743.png&quot;/&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;;font-family:宋体;font-size:19px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;公司承诺：&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;;font-family:宋体;font-size:19px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;各大知名品牌电瓶、任你选、放心选。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;;font-family:宋体;font-size:19px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;拒绝高价兑换，拒绝劣质商品，诚信务实、全心全意、&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;;font-family:宋体;font-size:19px&quot;&gt;1&lt;span style=&quot;font-family:宋体&quot;&gt;、 所有电瓶出自正规厂家，安装时如发现翻新，非正品电瓶，我们将为您提供三年的新电瓶使用权。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;;font-family:宋体;font-size:19px&quot;&gt;2&lt;span style=&quot;font-family:宋体&quot;&gt;、 每块电瓶都有唯一的识别码，请您再安装前查询识别码辨别真伪&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;;font-family:宋体;font-size:19px&quot;&gt;3&lt;span style=&quot;font-family:宋体&quot;&gt;、 免费上门安装，如在安装时有工作人员向您收取安装费用，一经核实，将安装收取费用的十倍赔付与您。&lt;img src=&quot;http://dp.mendian51.cn/public/uploads/images/20181230/1546141614356002.png&quot; title=&quot;1546141614356002.png&quot; alt=&quot;微信图片_20181230113154.png&quot;/&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;margin-left: 63px; text-align: center;&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family: Arial;color: rgb(0, 128, 0);font-size: 29px;background: rgb(255, 255, 255)&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;全新生活、品质生活、无忧生活、便利生活&lt;/span&gt;&lt;/span&gt;&lt;/strong&gt;&lt;strong&gt;&lt;span style=&quot;font-family: 宋体;color: rgb(0, 128, 0);font-size: 29px;background: rgb(255, 255, 255)&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;。&lt;/span&gt;&lt;/span&gt;&lt;/strong&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;;font-family:宋体;font-size:19px&quot;&gt;&lt;span style=&quot;font-family:宋体&quot;&gt;&lt;/span&gt;&lt;/span&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;;font-family:宋体;font-size:19px&quot;&gt;&lt;/span&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;";}');

-- --------------------------------------------------------

--
-- 表的结构 `dp_user`
--

CREATE TABLE IF NOT EXISTS `dp_user` (
  `id` int(10) unsigned NOT NULL,
  `openid` varchar(255) DEFAULT NULL COMMENT '微信用户ID',
  `username` varchar(255) DEFAULT NULL COMMENT '用户名',
  `headimg` varchar(255) DEFAULT NULL COMMENT '用户头像',
  `balance` decimal(11,2) DEFAULT NULL COMMENT '账户余额',
  `type` tinyint(3) DEFAULT NULL COMMENT '1--用户端  2--配送端',
  `status` tinyint(3) DEFAULT '1' COMMENT '用户状态  1 正常  2 禁止',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `last_login_time` int(10) DEFAULT NULL COMMENT '最后登陆时间',
  `last_login_ip` varchar(50) DEFAULT NULL COMMENT '最后登录IP'
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8 COMMENT='用户表';

--
-- 转存表中的数据 `dp_user`
--

INSERT INTO `dp_user` (`id`, `openid`, `username`, `headimg`, `balance`, `type`, `status`, `create_time`, `last_login_time`, `last_login_ip`) VALUES
(7, 'o25j15Wm-c4-tnQaVvcDpkZv4NeY', '嗯？', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTLX8CvFhfCXYiaOSWt2fZxHIuYcahftnsQzMfiayD4hnTrl5KdyOJxjBV3pVmHtic7VonX8awWQCYrQQ/132', '99999.98', 1, 1, 1545709001, 1545983728, '101.30.71.203'),
(2, 'o25j15bfbw3A70VUjAayQN57VsNg', '小小龍Rickey', 'https://wx.qlogo.cn/mmopen/vi_32/PiajxSqBRaELAdGQ6sKqaqjicZoVKkE5Uu9972mtSYqa0uPsjcAIPv9dNicwoypvhPhp7J6lA7ZgL3FA3rVSoglCA/132', NULL, 1, 1, 1545707281, 1545803023, '60.10.227.114'),
(3, 'o25j15XrAhCsMQTt0xsUYYJyeMVw', 'Mr.L', 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eqlB4aISRDNxPl3FJPmYsQe3GAdWj0TibwWOZzJbxgW6583cop0icQpn4s6YXxQibgsxywFibmUFsr7Ng/132', NULL, 1, 1, 1545707996, 1546045408, '118.212.209.181'),
(4, 'oCAnj5JiGgc0iz6EqTi1OSOBj4Z8', '树上小海鲜', 'https://wx.qlogo.cn/mmopen/vi_32/iaDXltFylKJtrdmG1eRIyyXtBldVOBFLhQEBJmSHXEx2jcH8qAq0JRBXOIBSVt4qzVPicDvNglIxqXYUEma11GeQ/132', NULL, 2, NULL, 1545708159, 1545708159, '117.136.47.167'),
(5, 'o25j15X6JgFU5DEHrju9QdNZmsWs', '树上小海鲜', 'https://wx.qlogo.cn/mmopen/vi_32/kfvlwBwC4tIaCqQtjbRibRKp9HpXgkQHGt9ZZiave1xRKQ6twWwiblic3zR0g67UoPY8iblvN2FBx7cJ88gGzxzGmtw/132', NULL, 1, 1, 1545708168, 1545715136, '117.136.47.168'),
(8, 'o25j15cMGpw1zCJyd2afwRekuglY', 'Geek！', 'https://wx.qlogo.cn/mmopen/vi_32/pYaS1ecUqRgFDHb2x1D2m15M7LrehlpODaTqT9IYP3BXLr5Kmp19JqDSRRia8u1ZA1S4kA8ZyeeoeJEHsVT3Q2w/132', '1000.02', 1, 1, 1545709012, 1545709012, '60.10.227.114'),
(9, 'o25j15b-2PtoGMVltfCYA8D1AZ9w', '刘雅楠', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTLfPhdDppyibCicsibRusdSYzqkj7mJgFpAtIMWt8hD7mQ7guGgiatedj2iaBj8uQ5pOWRbFIcoN4pWhhg/132', '1000000.07', 1, 1, 1545714610, 1545808479, '60.10.227.114'),
(18, 'o25j15fxgAfxPBY92bfep5QWJobM', '怀得祯', 'https://wx.qlogo.cn/mmhead/7hoTYqx28VsqScuELgF4FtonokJ4kE9e51xB1f17e9g/132', NULL, 1, 1, 1545819701, 1546333533, '101.227.139.172'),
(10, 'oCAnj5MEiZA45k7vxJU0ycwjFFxI', '小小龍Rickey', 'https://wx.qlogo.cn/mmopen/vi_32/PiajxSqBRaEIzAUQjyjfvhiby7ImBiaTzHfPTCbib5j3l7BHrmfdfy2ShM0wzKeVmeICqxhFlGIQw7P0nnTrdC2uyg/132', NULL, 2, 1, 1545715880, 1545802987, '60.10.227.114'),
(11, 'o25j15b6xU6mUhvbFAfRKjxzAOHY', '张露穎', 'https://wx.qlogo.cn/mmopen/vi_32/PiajxSqBRaEIMofYkO8EjABozHHT96dFCCNdUVicSq1VEj9VxAIicyZccwmWliax3k7Tiamicg9n61ybh6riaEyvWnurw/132', NULL, 1, 1, 1545722789, 1545722789, '60.10.227.114'),
(12, 'oCAnj5CUNggbfMw5plstdlf1Hpe8', '凌渡', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKeiaicNmzzB9o8ZQZHj42uzzbftCpul4FiazDLerwiavGoGj7Dy5zLWjArMQOheNpuY1xGNZtibYfQMHw/132', NULL, 2, 1, 1545744501, 1545744501, '223.104.3.184'),
(13, 'o25j15Zzr1TXBx4SK7XEqnP8g5RI', '赖嘉文', 'https://wx.qlogo.cn/mmhead/kp7RhPHq1dnetOnSu8q8mEE17BxvCptZiaegucUOqz8s/132', NULL, 1, 1, 1545765341, 1547442123, '101.227.139.172'),
(14, 'oCAnj5ErRVNAG1KxvnDB5PeEUzrU', '刘雅楠', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTLYUMHh2ukSSBic89M889e1mm2HyPBHlQibic9IqvnUqzU1GmesesSffIgae2oZ3qovPeM0jmqVELEOQ/132', NULL, 2, 1, 1545787204, 1545891076, '60.10.227.114'),
(15, 'oCAnj5E9d1KGFS8aT0Ujt478duVo', '陈韦修', 'https://wx.qlogo.cn/mmhead/MMBSIgSNtOSPb1s0iaWldsyIs7BF0KfoZvq5TBNV98EM/132', NULL, 2, 1, 1545792339, 1545792339, '101.227.139.172'),
(16, 'o25j15Yhzpik8wOUrsQGgBJ2XrBA', '科技让盈利更轻松', 'https://wx.qlogo.cn/mmopen/vi_32/xJULMRk8oic7gSVJOPVickvYN52t0Br6YWXDia5luibdI0ujaldjI5XYDVkibp9HMAq5798XMLib9Kbpd54rvcgbkoTg/132', NULL, 1, 1, 1545798317, 1545798317, '113.200.107.132'),
(17, 'o25j15ZsieP0sdD9cJIM9r1f2bAE', '王江琇', 'https://wx.qlogo.cn/mmhead/Xiarz4Ie8iaUgXXJd2UicZBCAWSMawn62fvRMhwRaHa1vM/132', NULL, 1, 1, 1545799903, 1547279773, '58.247.206.140'),
(19, 'o25j15ZFdtLZIZ3vTbwZq9JST3y8', '好久不见', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTLwsCeOicGtiaWLhZCYY0rD0uBzXlwpQvBu0R3pxTbPXdW2VuABWepVhLqcU0ovtCXJgcmQIj2VwvbQ/132', NULL, 1, 1, 1545881854, 1545881854, '113.200.106.157'),
(20, 'o25j15V3wcZWUb1d-XNzszLr8v-I', '薛薛。', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKzpD1QE1Hnr811JtcV3YODYvuESGibLNkibJ0eFsibhbq2oyomEkbonghicDrgQMmN1GC66eaicfmiajnw/132', NULL, 1, 1, 1545885124, 1545885124, '113.138.32.130'),
(21, 'o25j15QPxfpg_IjkHt0pR7srNbf8', '科技让盈利更轻松', 'https://wx.qlogo.cn/mmopen/vi_32/wV9WFt6r45g9Xlh69QVkq7tHSOniakymUhDaSLemRykjr2I2Vb70grqib7bHSox80EfbbADrI9HGOBqmZvMyibTIg/132', NULL, 1, 1, 1545885305, 1545885308, '1.81.78.221'),
(22, 'o25j15d3A9UcQjhAtI1RZdQ_KzI8', 'Xin,Boo', 'https://wx.qlogo.cn/mmopen/vi_32/Ud9hE6xZZJdSd8e8Uqiafe6IvUTdKIMbcUSgCtH2wAytvo5bibY1182SW8w4R4iao4ic0UgZTX5SHt0TVkHD6k9siag/132', NULL, 1, 1, 1545888397, 1546047438, '117.32.82.218'),
(23, 'o25j15SwVrVEae_DpY9xy4KTYMS0', '林盈威', 'https://wx.qlogo.cn/mmhead/prFSL4YMJ8U3CicHHUN8WPToNPzLcPoWyuQkAUBc4gjI/132', NULL, 1, 1, 1545889128, 1546232065, '101.227.139.172'),
(24, 'o25j15ePKmlj7IcPDCPa1PTfBHl8', 'The catcher in the rye', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJOCFdmKAGVRkSvP09RD9XbomcAHa0EcRiaPvBA4B0QWta2RW2wZoVpO7thErgK0u913l2NWGW4Org/132', NULL, 1, 1, 1545914030, 1545914030, '117.136.87.128'),
(25, 'o25j15eF1C1iCekHjgxtmTccqEyI', '刘枝达', 'https://wx.qlogo.cn/mmhead/MlVJUgoB1WoDyHeYLweDdAGZK1rVxibvER8RMNBz1m1Q/132', NULL, 1, 1, 1545926425, 1546317302, '101.227.139.172'),
(26, 'o25j15SvMydq5wRToeYmT1NdYDwo', '陈伟义', 'https://wx.qlogo.cn/mmhead/Ecia6bBpSdFaibK829Zh0Ce6Ru1SVdATdZsbunU7cVSls/132', NULL, 1, 1, 1545971155, 1547619628, '223.166.222.109'),
(27, 'o25j15X2T8qFmEaWjOx1qj_v5M_c', ' ', 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83er3buhru0LAs0EmVHJicaDNCexX2RQ68hiadsFSKUre32M2uQiaZSicklU92xw0Mzl1KjPVYFtTC6Hd2w/132', NULL, 1, 1, 1545978899, 1547604589, '117.33.54.221'),
(28, 'oCAnj5P-f11wNDQPLuXudyt6z-Zg', '王裕仁', 'https://wx.qlogo.cn/mmhead/WkWHPibib6QibzQcjatlC9crcjBuKPRq6hCpX7Hw0Ebrd0/132', NULL, 2, 1, 1545998664, 1546056648, '101.91.60.108'),
(29, 'o25j15Tjw1g0q7lvOSuf9JtG63hM', '苏国维', 'https://wx.qlogo.cn/mmhead/DAStBzzFoWlhSu73NrXx6rlzeqp4riacLTQQBwsic56p0/132', NULL, 1, 1, 1545998840, 1547462510, '223.166.222.109'),
(30, 'o25j15Uv2QpHwgxs9lVg6aCBUNi8', '阿Ray是我', 'https://wx.qlogo.cn/mmopen/vi_32/PiajxSqBRaEJqdhiaeSyZHVKWaNjxx0xARFAVX3vULgfxGrWn2neAZHrFy5jhwG3Sfg0QkRNOtcF3Xt1MM3rfHcA/132', NULL, 1, 1, 1546025158, 1546025158, '1.83.237.242'),
(31, 'o25j15Xf9EFy3-CM5PJUtrIUwvv8', 'MustBeSuccessful1', 'https://wx.qlogo.cn/mmopen/vi_32/NHF3xU7LAVuLIsgUNHSfA0KicicqJib8ib7IOkVBoCDoulUjHtBTWicibI1rMpPqUoicXIxnias8Zb9mfI0iaNQINNXnHDg/132', NULL, 1, 1, 1546046965, 1547120985, '124.23.133.225'),
(32, 'o25j15bxuVLxksn907MBxIg_15nI', 'only', 'https://wx.qlogo.cn/mmopen/vi_32/w6EXaiaLPZCY9YsGtMSfz7vKpg2WeiauRaAfD7IuUU1lXZ2bYQ8wPSpVcibF7lqqNLPwn11DsibCB0AYp0BiaB0g7HQ/132', NULL, 1, 1, 1546047245, 1546047245, '1.86.20.255'),
(33, 'o25j15bJ8kBQMaW0_FBthUqGsTgU', '浅  默', 'https://wx.qlogo.cn/mmopen/vi_32/tKvmZ3Vs4t7VXw9jyfqwMT2lLAluN5CAy69lnQDZC2EZFxEmWfWWp1LJhia1MaSpibX3o1a2sEDKjGPuib40nqtgg/132', NULL, 1, 1, 1546053237, 1546053237, '42.90.119.178'),
(34, 'oCAnj5Ls0g7YST9NHMUyxkF_xfPE', '王其娇', 'https://wx.qlogo.cn/mmhead/01mMoQQKibEiceTlibaZghensqm9ia4X21ONxPTfdpOoDIY/132', NULL, 2, 1, 1546080404, 1546080404, '101.227.139.172'),
(35, 'o25j15cjsopx6xQGnwARClHHzVYs', '瑞灿不锈钢', 'https://wx.qlogo.cn/mmopen/vi_32/tj0C5ufRN5dLT2Ap9kr8oreMaVfK70b4YKg4uzTRHN1ZpDp0BLEw1lgfVYhDn9kicMCw3H34BEh2CaP9Q8JQR5Q/132', NULL, 1, 1, 1546141337, 1546141337, '106.44.169.236'),
(36, 'o25j15TOikeW4DZ0xw-BoLY7NVxw', '华夏游云', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTLOe0zhPv5iboqswsA78GmbpChlPptYC8co05k7JyNjNQAM7ONH413XA4WyK2D2oBPBznG4a7o8XbQ/132', NULL, 1, 1, 1546150643, 1546150643, '123.138.233.83'),
(37, 'o25j15S2e_FWFSgvNvhNoTO56p60', '门店无忧技术总监', 'https://wx.qlogo.cn/mmopen/vi_32/xvib1JpibvCHHMxLAJqTmicLLmk2FSQYVcxtw4iadjUicufudSOhUbXEGRn4yTuYR571pbDDY3SibZZ4NiaoWTQUjcY1g/132', NULL, 1, 1, 1546155592, 1546155592, '221.11.61.124'),
(38, 'o25j15b4I6YxHT2nhV5TLZeZCAmw', '张世菊', 'https://wx.qlogo.cn/mmopen/vi_32/F6Cr8ib2GJtuFBSK64paqm6I9bqIv35Vib0YQghURc5SzHu8kehRSXOhSwtLaoyResjFFibcjZXINswLaoacNJ98Q/132', NULL, 1, 1, 1546167642, 1546167642, '101.30.69.217'),
(39, 'oCAnj5IFC7u9ERwUtqiFs_SU2DKg', '王慧娟', 'https://wx.qlogo.cn/mmhead/QU2aHlSAwA2JgTiaBUs2ZpbPxgBu625UONUHrAJVxWnI/132', NULL, 2, 1, 1546182551, 1546869683, '101.91.60.108'),
(40, 'o25j15aStmjYcP88X9Bcte8s9ySA', '杭翰真', 'https://wx.qlogo.cn/mmhead/kwUNQYnG6ibA3RpYtPmhcWUoo0XFLnaGJhCv8qzAsJkk/132', NULL, 1, 1, 1546182619, 1547528000, '101.91.60.108'),
(41, 'o25j15WK2CgaL8N6OKpRQlqBRw-U', '@', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTK6YqZtWUzibj6HEQ7LGAN11vPXCslicDIJbicQNrs7WurPD3MnhU7eoj5xNXUmhtjrqyGIMbUeU6ASg/132', NULL, 1, 1, 1546228362, 1546228362, '124.23.134.209'),
(42, 'o25j15T2lqandrSUACJvvIedWMTU', 'A AA张少轩《渭南科力发电机》', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTIZjXKnlcnQuSvJZoNDynRrctmH2MH9pmk1BOThvl0QIvacNSYvsWnaQ8RTQricADhLw22pEjVTtow/132', NULL, 1, 1, 1546392825, 1546392825, '113.138.94.148'),
(43, 'o25j15cK5efCe7TGkhbLIIHmLhaY', '少年不哭', 'https://wx.qlogo.cn/mmopen/vi_32/ajNVdqHZLLDJzx2pWdJTdhUd1TyBN5gmLGicwTpT95Ad58Xu5PcicapwhK7Sr3USicRliacsTZOavJqULvuciamibozQ/132', NULL, 1, 1, 1546421032, 1546421033, '60.10.227.114'),
(44, 'o25j15ekwzD_hRp6LUJGpbCdTLVU', '梁康', 'https://wx.qlogo.cn/mmopen/vi_32/wVmIE9yw8rK99GJLhFclLd0ia5wDZ52zSRK6n5Ura6uOj9HVUy4e1oapAn8PnwcriaOP3EDRWLSS3QleNkCedXpA/132', NULL, 1, 1, 1546425607, 1546425607, '117.136.87.70'),
(45, 'oCAnj5PxPjEXR8h7WWqntgDUsOws', '扎带批发零售 15690266635', 'https://wx.qlogo.cn/mmopen/vi_32/WicSf2eL9ic6FDLoKx0yklznVQIttSjkxA9sicUZP68ficibdDNCKv9cGdznpmIP4yzC5HZJ8pmyaAbeicSshvXOuK4w/132', NULL, 2, 1, 1546649888, 1546649888, '120.11.217.137'),
(46, 'o25j15Tu2qlK0p3jAQLqtJamVCZk', '杨盈秀', 'https://wx.qlogo.cn/mmhead/ItBJUpybjRPdORiahWwooUEXzWT6cFwe59UStEVibx6sc/132', NULL, 1, 1, 1546664943, 1547354927, '101.91.60.108'),
(47, 'o25j15QTQvkCzrOr2G21okb95Kvw', '独家记忆', 'https://wx.qlogo.cn/mmopen/vi_32/9nBRRPiaiadhXqvibIYiaVKmh2ibENoQYCFe9KLywOhQx7Jfz2jyCbiaHACKG1sjq09wcEcuJuOl1teyNZb6kMLVIiaBw/132', NULL, 1, 1, 1546677868, 1546677868, '113.140.104.193'),
(48, 'o25j15Sm15bqvt77x7Iak0ax2-IE', '陈玉翰', 'https://wx.qlogo.cn/mmhead/VB1rsYrhNqpEPqThmWiafBJKBSJsAtb9nPdObl2AibPib0/132', NULL, 1, 1, 1546689290, 1547138164, '223.166.222.109'),
(49, 'o25j15ZKXF-_wAPuTGV5KW1HU7Es', '明明', 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTIRz7iamlketIyQkb1JzPzUnTKtUnViaVAVWGaDNk6x3PDZO9KUCsYUVJOJt8ibW6wn1yyOOPuYCuMibg/132', NULL, 1, 1, 1546736482, 1546736482, '117.136.87.135'),
(50, 'oCAnj5KV7WR2GZ4JEcWuxc-QJ_Ks', '夏昭来', 'https://wx.qlogo.cn/mmhead/QfSa1iao7BUIH1XjR978mPicbzqDfc7cROQ4TjOa7r4f4/132', NULL, 2, 1, 1546771059, 1546771059, '223.166.222.109'),
(51, 'oCAnj5HrfLCLUuq33lAuXACobEb8', '北斗农业.中国', 'https://wx.qlogo.cn/mmopen/vi_32/uF1xskrrH1Wt3diaJHGXv6zZH4Dw0oUtg9wdW4oTib9K6icFqLkO4ibKYK6wuUIdAibTPxclLRvxYKSbe2y45icYvtLQ/132', NULL, 2, 1, 1546818948, 1546818948, '117.136.73.228'),
(52, 'o25j15UVeeE3poQFSFXgBOGrNesY', '立马，金彭电动专卖（铁炉街北）', 'https://wx.qlogo.cn/mmopen/vi_32/lO18wictFDSANjTx3kkVJLYuDV2Uy2EiagHycP3EWSpEiciaiaACCtYSQ3IEP7N7hrvdyicDiafgegNajpC2bG4cicK7CA/132', NULL, 1, 1, 1546868944, 1546868944, '36.40.120.76'),
(56, 'o25j15RfmIJw-OUhARPqXgVvhC3w', '科技让盈利更轻松', 'https://wx.qlogo.cn/mmopen/vi_32/c8gxVbbJtPNOq8cHEqouiaCwibPOMnVEC0aLGZVDKKOibVp8eUPO0bMAnicXEBX57AunZNdo1j5f2WeicS4NWu4IDMw/132', NULL, 1, 1, 1547519821, 1547519821, '123.138.232.184'),
(53, 'o25j15VnBPoPWxSuXcpvhymOLCoA', '兴平', 'https://wx.qlogo.cn/mmopen/vi_32/dQQR8nfd3k8zO9Z7TjOxSuEca522qBfBRsjhOY19mZMvoppvttUwaLkG5lfNFw6JHae9sf9CDVcOXFib5aDZ51w/132', NULL, 1, 1, 1547039241, 1547039241, '125.76.133.251'),
(54, 'o25j15eaE_0WpEu3ngSJqE0dou7A', '空空如也', 'https://wx.qlogo.cn/mmopen/vi_32/ibYCL2nbctJBvJYPS2ibyIkMWmO2q5bjyjV34WHSKcTUTibneIyRkof5fVqtXUXh8aKR9Az3XyLaPBxlEUw99vjlg/132', NULL, 1, 1, 1547126956, 1547126956, '113.138.92.131'),
(55, 'oCAnj5BF_Rf-YmydYklFIgecedfM', '宋小佳', 'https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83erRSNlNBgPITaPvAVia3RbcSA1x6pBT86yhBfCx0cdV9Kf4FC2uqLbE8temdfdOocwItEgZ5FTXKcg/132', NULL, 2, 1, 1547175275, 1547175275, '101.38.90.39'),
(57, 'o25j15QiPR1lkdwbSH0G_w78inFI', '科技让盈利更轻松', 'https://wx.qlogo.cn/mmopen/vi_32/EHmuGqibpSzFG0IxJERQldfNd6KgaL5p95ugUbxsvo3xnydo1w8rDz4DaZhfax4x7OictLP5bceycmvtmFhxtCQA/132', NULL, 1, 1, 1547519884, 1547519884, '221.11.61.48'),
(58, 'oCAnj5BGeq6OU8j7aYxeQJnim3bk', '科技让盈利更轻松', 'https://wx.qlogo.cn/mmopen/vi_32/sdjAia4EqiaCcZIdr4xX2UhvEj5OpkPKeU3yuJThfWUKl4m8M0SMrkFPmiblwnEjfIYv1EsAaRsHMibeia4VXHaNmbg/132', NULL, 2, 1, 1547519901, 1547519901, '221.11.61.48'),
(59, 'oCAnj5N3UIBtHkaTKL3SckaKWW14', '科技让盈利更轻松', 'https://wx.qlogo.cn/mmopen/vi_32/kSMWfq7ZbWibKrv5Hyo1LLqO7oMeo0W4UOvbcKQvZRfGq3lFcX7YCD02v3FB0usWrgCBeBltJiceTJksn3BiaMpEQ/132', NULL, 2, 1, 1547520024, 1547520024, '113.200.107.60'),
(60, 'o25j15SKn-N7BLdXZ_sp5CWIS5HM', '科技让盈利更轻松', 'https://wx.qlogo.cn/mmopen/vi_32/K9BCiak9dnHYPZOsBZIQWb3oIiaqmhXo2wvA97KX7jl21gJ1aFcAQ8Ihp4qxEGpdBu52JE146HeKz9nZZS6RoD5w/132', NULL, 1, 1, 1547520050, 1547520050, '113.200.107.60'),
(61, 'oCAnj5JevnZC5I7ukKjsg9U-7-rg', '张欣桦', 'https://wx.qlogo.cn/mmhead/dWRXFewyt4gjUqXRyc5E3PfgA0AasF1PhpHfwKhEPwY/132', NULL, 2, 1, 1547620923, 1547620923, '223.166.222.109');

-- --------------------------------------------------------

--
-- 表的结构 `dp_user_balance_log`
--

CREATE TABLE IF NOT EXISTS `dp_user_balance_log` (
  `id` int(10) unsigned NOT NULL,
  `uid` int(10) DEFAULT NULL COMMENT '用户id',
  `type` tinyint(3) DEFAULT NULL COMMENT '1--充值   2--消费  3--退款  4--余额提现',
  `money` decimal(11,2) DEFAULT NULL COMMENT '金额',
  `balance` decimal(11,2) DEFAULT NULL COMMENT '余额',
  `status` tinyint(3) DEFAULT NULL COMMENT '0--未支付  1--已支付',
  `pay_money` decimal(11,2) DEFAULT NULL COMMENT '支付(提现)金额',
  `pay_time` int(10) DEFAULT NULL COMMENT '充值(提现)--支付时间',
  `pay_info` text COMMENT '充值(提现)--支付信息',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间'
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='用户消费记录表';

--
-- 转存表中的数据 `dp_user_balance_log`
--

INSERT INTO `dp_user_balance_log` (`id`, `uid`, `type`, `money`, `balance`, `status`, `pay_money`, `pay_time`, `pay_info`, `create_time`) VALUES
(1, 7, 2, '0.02', '99999.98', 1, NULL, NULL, NULL, 1545731641),
(2, 9, 2, '0.01', '999999.99', 1, NULL, NULL, NULL, 1545787036),
(3, 9, 3, '0.01', '1000000.00', 1, NULL, NULL, NULL, 1545787725),
(4, 9, 2, '0.01', '999999.99', 1, NULL, NULL, NULL, 1545787910),
(5, 9, 3, '0.01', '1000000.00', 1, NULL, NULL, NULL, 1545787964),
(6, 9, 2, '0.01', '999999.99', 1, NULL, NULL, NULL, 1545788069),
(7, 9, 3, '0.01', '1000000.00', 1, NULL, NULL, NULL, 1545788238),
(8, 9, 2, '0.01', '999999.99', 1, NULL, NULL, NULL, 1545789585),
(10, 9, 3, '0.01', '1000000.01', 1, NULL, NULL, NULL, 1545789820),
(11, 9, 3, '0.01', '1000000.02', 1, NULL, NULL, NULL, 1545789879),
(12, 9, 2, '0.01', '1000000.01', 1, NULL, NULL, NULL, 1545790211),
(13, 9, 3, '0.01', '1000000.02', 1, NULL, NULL, NULL, 1545790248),
(14, 9, 3, '0.01', '1000000.03', 1, NULL, NULL, NULL, 1545790441),
(16, 9, 3, '0.01', '1000000.05', 1, NULL, NULL, NULL, 1545790589),
(18, 9, 3, '0.01', '1000000.07', 1, NULL, NULL, NULL, 1545790721),
(19, 8, 2, '0.01', '999.99', 1, NULL, NULL, NULL, 1545790756),
(20, 8, 3, '0.01', '1000.00', 1, NULL, NULL, NULL, 1545790853),
(21, 8, 2, '0.01', '999.99', 1, NULL, NULL, NULL, 1545791307),
(22, 8, 3, '0.01', '1000.00', 1, NULL, NULL, NULL, 1545791369),
(24, 8, 3, '0.01', '1000.02', 1, NULL, NULL, NULL, 1545791474),
(25, 9, 2, '0.01', '1000000.06', 1, NULL, NULL, NULL, 1545791517),
(26, 9, 3, '0.01', '1000000.07', 1, NULL, NULL, NULL, 1545791546);

-- --------------------------------------------------------

--
-- 表的结构 `dp_user_coupon`
--

CREATE TABLE IF NOT EXISTS `dp_user_coupon` (
  `user_coupon_id` int(10) unsigned NOT NULL,
  `member_id` int(10) DEFAULT NULL COMMENT '用户id',
  `coupon_id` int(10) DEFAULT NULL COMMENT '优惠券id',
  `is_use` tinyint(3) DEFAULT NULL COMMENT '是否使用 0--未使用  1--已使用',
  `user_time` int(10) DEFAULT NULL COMMENT '使用时间',
  `bg_data` int(10) DEFAULT NULL COMMENT '使用日期',
  `end_data` int(10) DEFAULT NULL COMMENT '结束日期',
  `price` int(10) DEFAULT NULL COMMENT '优惠价格',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `add_time` int(10) DEFAULT NULL,
  `man_price` int(10) DEFAULT NULL,
  `coupon_num` text COMMENT '优惠卷卡号'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户优惠卷表';

--
-- 转存表中的数据 `dp_user_coupon`
--

INSERT INTO `dp_user_coupon` (`user_coupon_id`, `member_id`, `coupon_id`, `is_use`, `user_time`, `bg_data`, `end_data`, `price`, `title`, `add_time`, `man_price`, `coupon_num`) VALUES
(1, 2, 2, 0, NULL, 1545628768, 1545974370, 200, '测试', 1545720918, 200, '22018122514551894246290');

-- --------------------------------------------------------

--
-- 表的结构 `dp_verification_code`
--

CREATE TABLE IF NOT EXISTS `dp_verification_code` (
  `id` int(10) unsigned NOT NULL,
  `mobile` varchar(11) DEFAULT NULL COMMENT '手机',
  `code` varchar(255) DEFAULT NULL COMMENT '验证码',
  `type` tinyint(3) DEFAULT NULL COMMENT '1--后台发送   2--小程序发送',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='短信验证码表';

--
-- 转存表中的数据 `dp_verification_code`
--

INSERT INTO `dp_verification_code` (`id`, `mobile`, `code`, `type`, `create_time`) VALUES
(1, '18632642336', '418472', 1, 1545715935),
(2, '15838719682', '503543', 1, 1545726312),
(3, '13521234008', '992669', 1, 1545786806),
(4, '13521234008', '871074', 2, 1545791684);

-- --------------------------------------------------------

--
-- 表的结构 `os_admin_user`
--

CREATE TABLE IF NOT EXISTS `os_admin_user` (
  `id` smallint(5) unsigned NOT NULL,
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '管理员用户名',
  `password` varchar(50) NOT NULL DEFAULT '' COMMENT '管理员密码',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1 启用 0 禁用',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `last_login_time` datetime DEFAULT NULL COMMENT '最后登录时间',
  `last_login_ip` varchar(20) DEFAULT NULL COMMENT '最后登录IP'
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='管理员表';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dp_address`
--
ALTER TABLE `dp_address`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `dp_admin_user`
--
ALTER TABLE `dp_admin_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`) USING BTREE;

--
-- Indexes for table `dp_after_sale`
--
ALTER TABLE `dp_after_sale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dp_article`
--
ALTER TABLE `dp_article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dp_auth_group`
--
ALTER TABLE `dp_auth_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dp_auth_group_access`
--
ALTER TABLE `dp_auth_group_access`
  ADD UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `dp_auth_rule`
--
ALTER TABLE `dp_auth_rule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`) USING BTREE;

--
-- Indexes for table `dp_category`
--
ALTER TABLE `dp_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dp_comment`
--
ALTER TABLE `dp_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dp_config`
--
ALTER TABLE `dp_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dp_coupon`
--
ALTER TABLE `dp_coupon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dp_link`
--
ALTER TABLE `dp_link`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dp_mall`
--
ALTER TABLE `dp_mall`
  ADD PRIMARY KEY (`goods_id`);

--
-- Indexes for table `dp_mall_sku`
--
ALTER TABLE `dp_mall_sku`
  ADD PRIMARY KEY (`sku_id`);

--
-- Indexes for table `dp_nav`
--
ALTER TABLE `dp_nav`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dp_order`
--
ALTER TABLE `dp_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `dp_order_goods`
--
ALTER TABLE `dp_order_goods`
  ADD PRIMARY KEY (`order_goods_id`);

--
-- Indexes for table `dp_order_log`
--
ALTER TABLE `dp_order_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dp_peisong_member`
--
ALTER TABLE `dp_peisong_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dp_peisong_member_position`
--
ALTER TABLE `dp_peisong_member_position`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `dp_peisong_order`
--
ALTER TABLE `dp_peisong_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dp_slide`
--
ALTER TABLE `dp_slide`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dp_slide_category`
--
ALTER TABLE `dp_slide_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dp_system`
--
ALTER TABLE `dp_system`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dp_user`
--
ALTER TABLE `dp_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`openid`);

--
-- Indexes for table `dp_user_balance_log`
--
ALTER TABLE `dp_user_balance_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dp_user_coupon`
--
ALTER TABLE `dp_user_coupon`
  ADD PRIMARY KEY (`user_coupon_id`);

--
-- Indexes for table `dp_verification_code`
--
ALTER TABLE `dp_verification_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `os_admin_user`
--
ALTER TABLE `os_admin_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dp_address`
--
ALTER TABLE `dp_address`
  MODIFY `address_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `dp_admin_user`
--
ALTER TABLE `dp_admin_user`
  MODIFY `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `dp_after_sale`
--
ALTER TABLE `dp_after_sale`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '上门售后表',AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `dp_article`
--
ALTER TABLE `dp_article`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章ID',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `dp_auth_group`
--
ALTER TABLE `dp_auth_group`
  MODIFY `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `dp_auth_rule`
--
ALTER TABLE `dp_auth_rule`
  MODIFY `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=92;
--
-- AUTO_INCREMENT for table `dp_category`
--
ALTER TABLE `dp_category`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `dp_comment`
--
ALTER TABLE `dp_comment`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dp_config`
--
ALTER TABLE `dp_config`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `dp_coupon`
--
ALTER TABLE `dp_coupon`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `dp_link`
--
ALTER TABLE `dp_link`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dp_mall`
--
ALTER TABLE `dp_mall`
  MODIFY `goods_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `dp_mall_sku`
--
ALTER TABLE `dp_mall_sku`
  MODIFY `sku_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `dp_nav`
--
ALTER TABLE `dp_nav`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dp_order`
--
ALTER TABLE `dp_order`
  MODIFY `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `dp_order_goods`
--
ALTER TABLE `dp_order_goods`
  MODIFY `order_goods_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `dp_order_log`
--
ALTER TABLE `dp_order_log`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',AUTO_INCREMENT=75;
--
-- AUTO_INCREMENT for table `dp_peisong_member`
--
ALTER TABLE `dp_peisong_member`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `dp_peisong_member_position`
--
ALTER TABLE `dp_peisong_member_position`
  MODIFY `member_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `dp_peisong_order`
--
ALTER TABLE `dp_peisong_order`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `dp_slide`
--
ALTER TABLE `dp_slide`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `dp_slide_category`
--
ALTER TABLE `dp_slide_category`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `dp_system`
--
ALTER TABLE `dp_system`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `dp_user`
--
ALTER TABLE `dp_user`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `dp_user_balance_log`
--
ALTER TABLE `dp_user_balance_log`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `dp_user_coupon`
--
ALTER TABLE `dp_user_coupon`
  MODIFY `user_coupon_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `dp_verification_code`
--
ALTER TABLE `dp_verification_code`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `os_admin_user`
--
ALTER TABLE `os_admin_user`
  MODIFY `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
