/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : dcat_admin_v5.6

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2022-01-11 14:10:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin_extensions
-- ----------------------------
DROP TABLE IF EXISTS `admin_extensions`;
CREATE TABLE `admin_extensions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `is_enabled` tinyint(4) NOT NULL DEFAULT '0',
  `options` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_extensions_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_extensions
-- ----------------------------

-- ----------------------------
-- Table structure for admin_extension_histories
-- ----------------------------
DROP TABLE IF EXISTS `admin_extension_histories`;
CREATE TABLE `admin_extension_histories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1',
  `version` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `detail` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_extension_histories_name_index` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_extension_histories
-- ----------------------------

-- ----------------------------
-- Table structure for admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uri` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extension` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `show` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_menu
-- ----------------------------
INSERT INTO `admin_menu` VALUES ('1', '0', '1', 'Index', 'feather icon-bar-chart-2', '/', '', '1', '2021-12-25 06:08:52', null);
INSERT INTO `admin_menu` VALUES ('2', '0', '2', 'Admin', 'feather icon-settings', '', '', '1', '2021-12-25 06:08:52', null);
INSERT INTO `admin_menu` VALUES ('3', '2', '3', 'Administrator', null, 'auth/users', '', '1', '2021-12-25 06:08:52', '2021-12-30 11:30:31');
INSERT INTO `admin_menu` VALUES ('4', '2', '4', 'Roles', '', 'auth/roles', '', '1', '2021-12-25 06:08:52', null);
INSERT INTO `admin_menu` VALUES ('5', '2', '5', 'Permission', '', 'auth/permissions', '', '1', '2021-12-25 06:08:52', null);
INSERT INTO `admin_menu` VALUES ('6', '2', '6', 'Menu', '', 'auth/menu', '', '1', '2021-12-25 06:08:52', null);
INSERT INTO `admin_menu` VALUES ('7', '2', '7', 'Extensions', '', 'auth/extensions', '', '1', '2021-12-25 06:08:52', null);
INSERT INTO `admin_menu` VALUES ('8', '0', '8', 'Goods', 'fa-align-justify', null, '', '1', '2021-12-25 14:53:04', '2021-12-30 11:23:46');
INSERT INTO `admin_menu` VALUES ('9', '8', '9', 'Category', null, '/category', '', '1', '2021-12-25 14:53:19', '2021-12-30 11:25:15');
INSERT INTO `admin_menu` VALUES ('10', '8', '10', 'GoodsList', null, '/goods', '', '1', '2021-12-25 15:32:44', '2021-12-30 11:25:54');
INSERT INTO `admin_menu` VALUES ('11', '8', '11', 'PicList', null, '/pic', '', '1', '2021-12-25 16:54:07', '2021-12-30 11:26:19');
INSERT INTO `admin_menu` VALUES ('12', '0', '12', 'Users', 'fa-user-o', null, '', '1', '2021-12-30 11:29:17', '2021-12-30 11:29:17');
INSERT INTO `admin_menu` VALUES ('13', '12', '13', 'UserList', null, '/users', '', '1', '2021-12-30 11:32:26', '2021-12-30 11:33:02');
INSERT INTO `admin_menu` VALUES ('14', '12', '14', 'Address', null, '/address', '', '1', '2021-12-30 13:55:51', '2021-12-30 13:55:51');
INSERT INTO `admin_menu` VALUES ('15', '2', '15', 'Operation Log', null, 'auth/operation-logs', '', '0', '2021-12-30 15:24:59', '2021-12-30 15:25:20');

-- ----------------------------
-- Table structure for admin_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_permissions`;
CREATE TABLE `admin_permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `http_method` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `http_path` text COLLATE utf8mb4_unicode_ci,
  `order` int(11) NOT NULL DEFAULT '0',
  `parent_id` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_permissions_slug_unique` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_permissions
-- ----------------------------
INSERT INTO `admin_permissions` VALUES ('1', 'Auth management', 'auth-management', '', '', '1', '0', '2021-12-25 06:08:52', null);
INSERT INTO `admin_permissions` VALUES ('2', 'Users', 'users', '', '/auth/users*', '2', '1', '2021-12-25 06:08:52', null);
INSERT INTO `admin_permissions` VALUES ('3', 'Roles', 'roles', '', '/auth/roles*', '3', '1', '2021-12-25 06:08:52', null);
INSERT INTO `admin_permissions` VALUES ('4', 'Permissions', 'permissions', '', '/auth/permissions*', '4', '1', '2021-12-25 06:08:52', null);
INSERT INTO `admin_permissions` VALUES ('5', 'Menu', 'menu', '', '/auth/menu*', '5', '1', '2021-12-25 06:08:52', null);
INSERT INTO `admin_permissions` VALUES ('6', 'Extension', 'extension', '', '/auth/extensions*', '6', '1', '2021-12-25 06:08:52', null);

-- ----------------------------
-- Table structure for admin_permission_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_permission_menu`;
CREATE TABLE `admin_permission_menu` (
  `permission_id` bigint(20) NOT NULL,
  `menu_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `admin_permission_menu_permission_id_menu_id_unique` (`permission_id`,`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_permission_menu
-- ----------------------------

-- ----------------------------
-- Table structure for admin_roles
-- ----------------------------
DROP TABLE IF EXISTS `admin_roles`;
CREATE TABLE `admin_roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_roles_slug_unique` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_roles
-- ----------------------------
INSERT INTO `admin_roles` VALUES ('1', 'Administrator', 'administrator', '2021-12-25 06:08:52', '2021-12-25 06:08:52');

-- ----------------------------
-- Table structure for admin_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_menu`;
CREATE TABLE `admin_role_menu` (
  `role_id` bigint(20) NOT NULL,
  `menu_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `admin_role_menu_role_id_menu_id_unique` (`role_id`,`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_role_menu
-- ----------------------------
INSERT INTO `admin_role_menu` VALUES ('1', '1', '2022-01-06 11:10:34', '2022-01-06 11:10:34');
INSERT INTO `admin_role_menu` VALUES ('1', '2', '2022-01-06 11:10:34', '2022-01-06 11:10:34');
INSERT INTO `admin_role_menu` VALUES ('1', '3', '2022-01-06 11:10:34', '2022-01-06 11:10:34');
INSERT INTO `admin_role_menu` VALUES ('1', '4', '2022-01-06 11:10:34', '2022-01-06 11:10:34');
INSERT INTO `admin_role_menu` VALUES ('1', '5', '2022-01-06 11:10:34', '2022-01-06 11:10:34');
INSERT INTO `admin_role_menu` VALUES ('1', '6', '2022-01-06 11:10:34', '2022-01-06 11:10:34');
INSERT INTO `admin_role_menu` VALUES ('1', '7', '2022-01-06 11:10:34', '2022-01-06 11:10:34');
INSERT INTO `admin_role_menu` VALUES ('1', '8', '2022-01-06 11:10:34', '2022-01-06 11:10:34');
INSERT INTO `admin_role_menu` VALUES ('1', '9', '2022-01-06 11:10:34', '2022-01-06 11:10:34');
INSERT INTO `admin_role_menu` VALUES ('1', '10', '2022-01-06 11:10:34', '2022-01-06 11:10:34');
INSERT INTO `admin_role_menu` VALUES ('1', '11', '2022-01-06 11:10:34', '2022-01-06 11:10:34');
INSERT INTO `admin_role_menu` VALUES ('1', '12', '2022-01-06 11:10:34', '2022-01-06 11:10:34');
INSERT INTO `admin_role_menu` VALUES ('1', '13', '2022-01-06 11:10:34', '2022-01-06 11:10:34');
INSERT INTO `admin_role_menu` VALUES ('1', '14', '2022-01-06 11:10:34', '2022-01-06 11:10:34');
INSERT INTO `admin_role_menu` VALUES ('1', '15', '2022-01-06 11:10:34', '2022-01-06 11:10:34');

-- ----------------------------
-- Table structure for admin_role_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_permissions`;
CREATE TABLE `admin_role_permissions` (
  `role_id` bigint(20) NOT NULL,
  `permission_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `admin_role_permissions_role_id_permission_id_unique` (`role_id`,`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_role_permissions
-- ----------------------------
INSERT INTO `admin_role_permissions` VALUES ('1', '2', '2022-01-06 11:10:34', '2022-01-06 11:10:34');
INSERT INTO `admin_role_permissions` VALUES ('1', '3', '2022-01-06 11:10:34', '2022-01-06 11:10:34');
INSERT INTO `admin_role_permissions` VALUES ('1', '4', '2022-01-06 11:10:34', '2022-01-06 11:10:34');
INSERT INTO `admin_role_permissions` VALUES ('1', '5', '2022-01-06 11:10:34', '2022-01-06 11:10:34');
INSERT INTO `admin_role_permissions` VALUES ('1', '6', '2022-01-06 11:10:34', '2022-01-06 11:10:34');

-- ----------------------------
-- Table structure for admin_role_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_users`;
CREATE TABLE `admin_role_users` (
  `role_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `admin_role_users_role_id_user_id_unique` (`role_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_role_users
-- ----------------------------
INSERT INTO `admin_role_users` VALUES ('1', '1', '2021-12-25 06:08:52', '2021-12-25 06:08:52');

-- ----------------------------
-- Table structure for admin_settings
-- ----------------------------
DROP TABLE IF EXISTS `admin_settings`;
CREATE TABLE `admin_settings` (
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_settings
-- ----------------------------
INSERT INTO `admin_settings` VALUES ('name', '心选折扣仓', '2022-01-04 14:35:42', '2022-01-04 14:35:42');
INSERT INTO `admin_settings` VALUES ('url', 'http://dcat-admin-v56.cc/', '2022-01-04 14:35:42', '2022-01-04 14:35:42');
INSERT INTO `admin_settings` VALUES ('logo', 'images/4ceab01799b05a3f2429df968e0f84da.jpg', '2022-01-04 14:35:42', '2022-01-04 14:35:42');
INSERT INTO `admin_settings` VALUES ('lang', 'zh_CN', '2022-01-04 14:35:42', '2022-01-04 14:35:42');
INSERT INTO `admin_settings` VALUES ('layout', '{\"body_class\":[\"sidebar-separate\"],\"color\":\"green\",\"sidebar_style\":\"primary\",\"horizontal_menu\":false}', '2022-01-04 14:35:42', '2022-01-04 14:35:42');
INSERT INTO `admin_settings` VALUES ('helpers', '{\"enable\":1}', '2022-01-04 14:35:42', '2022-01-04 14:35:42');

-- ----------------------------
-- Table structure for admin_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_users_username_unique` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_users
-- ----------------------------
INSERT INTO `admin_users` VALUES ('1', 'admin', '$2y$10$uqclcXC..nls/j3jaD9pNOlJPhhiP3upiH6COj.BP/1F66iVM0bSi', 'Administrator', 'images/da6c1ed72d861434dab88fb1844b4f7b.jpeg', '5VN8fGISNLSFM9dSuiFIKhRUAxymwsbU0Sbuld1lHqX8qF50rcP1ARpGYnGb', '2021-12-25 06:08:52', '2022-01-11 11:03:19');

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `icon` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES ('1', '0', '0', '粮油', 'images/1732037c0f2013ae4fb8462731488a5e.png', '2021-12-25 15:15:36', '2022-01-05 11:49:38');
INSERT INTO `category` VALUES ('2', '0', '1', '米面', 'images/be83a1012ac41af9e4395632eda6222f.png', '2021-12-25 15:17:22', '2022-01-05 11:49:50');
INSERT INTO `category` VALUES ('3', '0', '2', '零食', 'images/c4d30553be0b9943bf52706382b74642.png', '2021-12-25 15:17:44', '2022-01-05 11:49:58');
INSERT INTO `category` VALUES ('4', '1', '3', '金龙鱼', null, '2021-12-25 15:28:59', '2021-12-25 15:47:52');
INSERT INTO `category` VALUES ('5', '0', '4', '清洁', 'images/5f322aa49612d8741451c14f3d34a176.png', '2021-12-25 15:46:22', '2022-01-05 11:50:06');
INSERT INTO `category` VALUES ('6', '0', '5', '生鲜', 'images/34236a0246ec378b184bffe13b301e7b.png', '2022-01-06 14:16:41', '2022-01-06 14:16:41');
INSERT INTO `category` VALUES ('7', '0', '6', '水果', 'images/8d1f3ef8a99e768ba39e4a58d9aba5cf.png', '2022-01-06 14:16:57', '2022-01-06 14:16:57');

-- ----------------------------
-- Table structure for goods
-- ----------------------------
DROP TABLE IF EXISTS `goods`;
CREATE TABLE `goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` tinyint(4) NOT NULL,
  `goods_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `goods_shorttitle` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `goods_keywords` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `goods_property` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `goods_description` text COLLATE utf8mb4_unicode_ci,
  `goods_price` decimal(8,2) NOT NULL,
  `goods_original_price` decimal(8,2) DEFAULT NULL,
  `goods_cost` decimal(8,2) DEFAULT NULL,
  `goods_sell_num` tinyint(4) DEFAULT '0',
  `goods_stock` tinyint(4) NOT NULL DEFAULT '0',
  `goods_unit` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of goods
-- ----------------------------
INSERT INTO `goods` VALUES ('1', '3', '盼盼小面包盼盼小面包盼盼小面包盼盼小面包盼盼小面包盼盼小面包盼盼小面包', '盼盼小面包', '零食,面包', '1,2,3', '', '1.00', '0.00', '0.00', '0', '10', '箱', '1', '2021-12-28 10:02:44', '2022-01-10 11:54:13', null);
INSERT INTO `goods` VALUES ('6', '1', '金龙鱼调和油', '', '', '1,3', '', '1.50', '0.00', '0.00', '0', '15', '桶', '0', '2021-12-28 11:45:11', '2022-01-10 11:54:23', null);
INSERT INTO `goods` VALUES ('7', '3', '盼盼小面包', '', '', '1,3', '', '2.00', '0.00', '0.00', '0', '20', '箱', '1', '2021-12-28 11:48:44', '2022-01-10 11:54:44', null);
INSERT INTO `goods` VALUES ('10', '3', '士力架', '士力架', '', '2', '<p>士力架士力架士力架士力架士力架士力架</p>', '2.80', '3.00', '2.50', '56', '99', '盒', '1', '2021-12-29 11:32:47', '2022-01-10 11:54:32', null);
INSERT INTO `goods` VALUES ('11', '3', '露露杏仁露', '露露', '', '2,3', '<p>露露露露露露露露露露露露露露</p>', '55.00', '65.00', '45.00', '56', '99', '箱', '1', '2021-12-29 14:32:26', '2022-01-10 11:54:39', null);

-- ----------------------------
-- Table structure for goods_spec
-- ----------------------------
DROP TABLE IF EXISTS `goods_spec`;
CREATE TABLE `goods_spec` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL,
  `goods_key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `goods_value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `goods_desc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of goods_spec
-- ----------------------------
INSERT INTO `goods_spec` VALUES ('1', '10', '颜色', '白,红', null, '2021-12-29 14:10:14', '2021-12-29 14:10:14');
INSERT INTO `goods_spec` VALUES ('2', '10', '有效期', '2022-11-11', null, '2021-12-29 14:11:19', '2021-12-29 14:11:19');
INSERT INTO `goods_spec` VALUES ('3', '10', '重量', '25g', null, '2021-12-29 14:11:19', '2021-12-29 14:11:19');
INSERT INTO `goods_spec` VALUES ('4', '9', '有效期', '2022-11-11', null, '2021-12-29 14:17:28', '2021-12-29 14:17:28');
INSERT INTO `goods_spec` VALUES ('5', '11', '有效期', '2022-11-11', '111', '2021-12-29 14:32:26', '2021-12-29 14:33:01');
INSERT INTO `goods_spec` VALUES ('6', '11', '重量', '500g', '222', '2021-12-29 14:32:26', '2021-12-29 14:33:01');
INSERT INTO `goods_spec` VALUES ('7', '11', '件数', '1箱', '333', '2021-12-29 14:32:26', '2021-12-29 14:33:01');
INSERT INTO `goods_spec` VALUES ('8', '8', '有效期', '2022-11-11', null, '2021-12-29 14:38:01', '2021-12-29 14:38:01');
INSERT INTO `goods_spec` VALUES ('9', '8', '重量', '25kg', null, '2021-12-29 14:38:01', '2021-12-29 14:38:01');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('3', '2016_01_04_173148_create_admin_tables', '1');
INSERT INTO `migrations` VALUES ('4', '2020_09_07_090635_create_admin_settings_table', '1');
INSERT INTO `migrations` VALUES ('5', '2020_09_22_015815_create_admin_extensions_table', '1');
INSERT INTO `migrations` VALUES ('6', '2020_11_01_083237_update_admin_menu_table', '1');
INSERT INTO `migrations` VALUES ('7', '2021_12_25_145247_create_category_table', '2');
INSERT INTO `migrations` VALUES ('8', '2021_12_25_150344_create_category_table', '3');
INSERT INTO `migrations` VALUES ('9', '2021_12_25_151053_create_category_table', '4');
INSERT INTO `migrations` VALUES ('10', '2021_12_25_151514_create_category_table', '5');
INSERT INTO `migrations` VALUES ('11', '2021_12_25_153213_create_goods_table', '6');
INSERT INTO `migrations` VALUES ('12', '2021_12_25_165317_create_pic_table', '7');
INSERT INTO `migrations` VALUES ('13', '2021_12_29_112021_create_goods_spec_table', '8');
INSERT INTO `migrations` VALUES ('14', '2021_12_30_111945_create_users_table', '9');
INSERT INTO `migrations` VALUES ('15', '2021_12_30_113828_create_users_table', '10');
INSERT INTO `migrations` VALUES ('16', '2021_12_30_113843_create_pic_table', '11');
INSERT INTO `migrations` VALUES ('17', '2021_12_30_135426_create_users_address_table', '12');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for pic
-- ----------------------------
DROP TABLE IF EXISTS `pic`;
CREATE TABLE `pic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL,
  `pic_desc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pic_url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_master` tinyint(4) DEFAULT NULL,
  `pic_order` tinyint(4) DEFAULT NULL,
  `pic_status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of pic
-- ----------------------------
INSERT INTO `pic` VALUES ('15', '1', '啊啊啊啊', '20211230/images/23b18812e964510d5046090a7b29da9d.jpeg', '1', '2', '1', '2021-12-30 10:13:32', '2021-12-30 10:13:32');
INSERT INTO `pic` VALUES ('16', '1', '2', '20211230/images/d0b23c5330bc837fa3728f7cf2432244.jpeg', '0', '0', '1', '2021-12-30 10:13:32', '2021-12-30 10:13:32');
INSERT INTO `pic` VALUES ('17', '11', '1', '20211230/images/975623e3aa1134b19267a74607228510.jpeg', '0', '0', '1', '2021-12-30 10:16:02', '2021-12-30 10:16:02');
INSERT INTO `pic` VALUES ('18', '11', '2', '20211230/images/b0b151deaa998b05e5eaa274ca174f0d.jpeg', '1', '0', '1', '2021-12-30 10:16:02', '2021-12-30 10:16:02');
INSERT INTO `pic` VALUES ('19', '6', '1', '20211230/images/a9695a6221f9642f1381ed59b18de715.jpeg', '0', '0', '1', '2021-12-30 10:32:44', '2021-12-30 10:32:44');
INSERT INTO `pic` VALUES ('20', '6', '2', '20211230/images/803b7451ca19a9f0be28d3db7fa59645.jpeg', '0', '0', '1', '2021-12-30 10:32:44', '2021-12-30 10:32:44');
INSERT INTO `pic` VALUES ('21', '10', '1', '20211230/images/ed157a18bfa7fd291f78287a038cc8d2.jpeg', '0', '0', '1', '2021-12-30 11:09:52', '2021-12-30 11:09:52');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `remember_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `headimg` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sex` tinyint(4) DEFAULT '0',
  `ipone` char(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `appid` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'test1', '123456', '111111@qq.com', '13', 'images/f9184ee3230b9db6adf951031cf870a8.jpeg', '0', '13244697914', '1212', '12121212', '1', '2021-12-30 14:06:50', '2021-12-30 14:27:29', null);
INSERT INTO `users` VALUES ('2', 'test2', '123456', '111111@qq.com', null, 'images/588fbb48e0ed66f4344af232d7aea775.jpeg', '0', '15465464646', null, null, '1', '2021-12-30 14:28:58', '2021-12-30 14:28:58', null);
INSERT INTO `users` VALUES ('3', 'xiaoxiao', null, null, null, null, '0', null, null, null, '1', '2021-12-30 15:53:46', '2021-12-30 15:53:46', null);

-- ----------------------------
-- Table structure for users_address
-- ----------------------------
DROP TABLE IF EXISTS `users_address`;
CREATE TABLE `users_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `shipping_user` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `shipping_ipone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `zip` smallint(6) DEFAULT NULL,
  `province` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `district` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `is_default` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users_address
-- ----------------------------
INSERT INTO `users_address` VALUES ('1', '1', '嘿嘿', '18888888888', null, '北京', '北京', '朝阳区', '望京', '0', '2021-12-30 16:03:21', '2021-12-31 15:33:50', null);
INSERT INTO `users_address` VALUES ('2', '1', '哈哈', '11999999999', null, '河北', '邯郸', '丛台区', '嘉华大厦嘉华大厦嘉华大厦嘉华大厦嘉华大厦嘉华大厦嘉华大厦嘉华大厦嘉华大厦', '1', '2021-12-30 16:04:52', '2021-12-31 15:33:51', null);
INSERT INTO `users_address` VALUES ('3', '2', '悠悠', '11666666666', null, '山东', '聊城', '东阿县', '222', '0', '2021-12-30 16:05:33', '2021-12-30 16:05:33', null);
