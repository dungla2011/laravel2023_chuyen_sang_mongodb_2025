-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 01, 2025 at 01:20 PM
-- Server version: 10.6.22-MariaDB-0ubuntu0.22.04.1-log
-- PHP Version: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `glx2023_for_testing`
--

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_logs`
--

CREATE TABLE `affiliate_logs` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` int(11) NOT NULL,
  `id__` varchar(32) DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `purchase_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `value` decimal(10,0) DEFAULT NULL,
  `orders` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_categories`
--

CREATE TABLE `asset_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `orders` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `block_uis`
--

CREATE TABLE `block_uis` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `sname` varchar(128) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `summary2` text DEFAULT NULL,
  `module_table` varchar(255) DEFAULT NULL,
  `idModule` varchar(1024) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `log` text DEFAULT NULL,
  `siteid` int(11) DEFAULT NULL,
  `extra_info` text DEFAULT NULL,
  `image_list` varchar(1024) DEFAULT NULL,
  `tags_list` varchar(1024) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `status` smallint(6) DEFAULT 1,
  `content` text DEFAULT NULL,
  `guide_admin` text DEFAULT NULL,
  `extra_color_background` varchar(10) DEFAULT NULL,
  `extra_color_text` varchar(10) DEFAULT NULL,
  `group_name` varchar(32) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_key_value`
--

CREATE TABLE `cache_key_value` (
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_key_values`
--

CREATE TABLE `cache_key_values` (
  `id` varchar(255) NOT NULL,
  `value` mediumtext DEFAULT NULL,
  `created_at` varchar(20) DEFAULT NULL,
  `updated_at` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` bigint(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT 0,
  `slug` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `site_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `change_logs`
--

CREATE TABLE `change_logs` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_id_admin` int(11) DEFAULT NULL,
  `change_log` mediumtext DEFAULT NULL,
  `tables` varchar(128) DEFAULT NULL,
  `id_row` int(11) DEFAULT NULL,
  `cmd` varchar(24) DEFAULT NULL,
  `ip_address` varchar(32) DEFAULT NULL,
  `tag_log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cloud_group`
--

CREATE TABLE `cloud_group` (
  `groupname` varchar(16) NOT NULL DEFAULT '',
  `gid` smallint(6) NOT NULL DEFAULT 5501,
  `members` varchar(16) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='Galaxy group table';

-- --------------------------------------------------------

--
-- Table structure for table `cloud_servers`
--

CREATE TABLE `cloud_servers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `domain` varchar(100) NOT NULL,
  `proxy_domain` varchar(100) DEFAULT '',
  `mount_list` text NOT NULL,
  `mount_list_disable_rep` text DEFAULT NULL,
  `replicate_now` tinyint(4) NOT NULL DEFAULT 0,
  `iscache` tinyint(4) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `enable` smallint(6) DEFAULT 0,
  `file_service_port` int(11) DEFAULT 16868,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cloud_transfer`
--

CREATE TABLE `cloud_transfer` (
  `id` bigint(20) NOT NULL,
  `userid` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `bytes` bigint(20) DEFAULT NULL,
  `host` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `ip` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `cmd` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `transfer_time` int(11) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `status` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conference_cats`
--

CREATE TABLE `conference_cats` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conference_infos`
--

CREATE TABLE `conference_infos` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `sub_title` varchar(256) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `images` varchar(128) DEFAULT NULL,
  `cat` smallint(6) DEFAULT NULL,
  `key_notes` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `conf1_video` text DEFAULT NULL,
  `conf1_images` varchar(1024) DEFAULT NULL,
  `conf1_image_title` varchar(256) DEFAULT NULL,
  `conf1_timesheet` text DEFAULT NULL,
  `conf1_keynote` varchar(1024) DEFAULT NULL,
  `conf1_name` varchar(256) DEFAULT NULL,
  `conf2_name` varchar(256) DEFAULT NULL,
  `conf2_keynote` varchar(1024) DEFAULT NULL,
  `conf2_timesheet` text DEFAULT NULL,
  `conf2_images` varchar(1024) DEFAULT NULL,
  `conf2_image_title` varchar(128) DEFAULT NULL,
  `conf2_video` text DEFAULT NULL,
  `conf3_video` text DEFAULT NULL,
  `conf3_images` varchar(1024) DEFAULT NULL,
  `conf3_image_title` varchar(128) DEFAULT NULL,
  `conf3_timesheet` text DEFAULT NULL,
  `conf3_keynote` varchar(1024) DEFAULT NULL,
  `conf3_name` varchar(256) DEFAULT NULL,
  `video_bottom` varchar(1024) DEFAULT NULL,
  `supporters` varchar(128) DEFAULT NULL,
  `right_column` text DEFAULT NULL,
  `orders` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cost_items`
--

CREATE TABLE `cost_items` (
  `id` int(11) NOT NULL,
  `item_name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `cost` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `depreciation` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crm_app_infos`
--

CREATE TABLE `crm_app_infos` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crm_messages`
--

CREATE TABLE `crm_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `msg_id` varchar(50) DEFAULT NULL,
  `cli_msg_id` varchar(50) DEFAULT NULL,
  `action_id` varchar(50) DEFAULT NULL,
  `msg_type` varchar(20) DEFAULT NULL,
  `uid_from` varchar(50) DEFAULT NULL,
  `id_to` varchar(50) DEFAULT NULL,
  `d_name` varchar(255) DEFAULT NULL,
  `ts` bigint(20) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `notify` tinyint(4) DEFAULT NULL,
  `ttl` int(11) DEFAULT NULL,
  `uin` varchar(50) DEFAULT NULL,
  `user_id_ext` varchar(50) DEFAULT NULL,
  `cmd` int(11) DEFAULT NULL,
  `st` int(11) DEFAULT NULL,
  `at` int(11) DEFAULT NULL,
  `real_msg_id` varchar(50) DEFAULT NULL,
  `thread_id` varchar(50) DEFAULT NULL,
  `is_self` tinyint(1) DEFAULT NULL,
  `property_ext` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`property_ext`)),
  `params_ext` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`params_ext`)),
  `channel_name` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crm_message_groups`
--

CREATE TABLE `crm_message_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `gid` varchar(256) DEFAULT NULL,
  `avatar` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `link_group` varchar(256) DEFAULT NULL,
  `channel_name` varchar(64) DEFAULT NULL,
  `full_info` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `demo_and_tag_tbls`
--

CREATE TABLE `demo_and_tag_tbls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED DEFAULT NULL,
  `demo_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `demo_folder_tbls`
--

CREATE TABLE `demo_folder_tbls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `parent_id` varchar(255) DEFAULT '0',
  `summary` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `log` varchar(255) DEFAULT NULL,
  `orders` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `demo_sub1s`
--

CREATE TABLE `demo_sub1s` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `demo_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sub_val` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `demo_tbls`
--

CREATE TABLE `demo_tbls` (
  `deleted_at` timestamp NULL DEFAULT NULL,
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `number1` int(11) DEFAULT NULL,
  `number2` int(11) DEFAULT NULL,
  `string1` varchar(255) DEFAULT NULL,
  `string2` varchar(255) DEFAULT NULL,
  `textarea1` varchar(255) DEFAULT NULL,
  `textarea2` varchar(255) DEFAULT NULL,
  `tag_list_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `parent_id` int(11) DEFAULT 0,
  `parent2` int(11) DEFAULT NULL,
  `parent_multi` text DEFAULT NULL,
  `parent_multi2` text DEFAULT NULL,
  `image_list1` text DEFAULT NULL,
  `image_list2` text DEFAULT NULL,
  `orders` int(11) DEFAULT 0,
  `name` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department_events`
--

CREATE TABLE `department_events` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `log` text DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department_users`
--

CREATE TABLE `department_users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `don_vi_hanh_chinhs`
--

CREATE TABLE `don_vi_hanh_chinhs` (
  `id` int(11) NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `type` varchar(32) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `orders` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `download_logs`
--

CREATE TABLE `download_logs` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `log` text DEFAULT NULL,
  `sid_download` double DEFAULT NULL,
  `file_refer_id` int(11) DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL,
  `file_id_enc` varchar(64) DEFAULT NULL,
  `filename` varchar(256) DEFAULT NULL,
  `size` bigint(20) DEFAULT NULL,
  `ip_request` varchar(64) DEFAULT NULL,
  `ip_download_done` varchar(64) DEFAULT NULL,
  `time_download_done` timestamp NULL DEFAULT NULL,
  `count_dl` int(11) DEFAULT 0,
  `sid_encode` varchar(64) DEFAULT NULL,
  `price_k` int(11) DEFAULT NULL,
  `user_id_file` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_and_users`
--

CREATE TABLE `event_and_users` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_event_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `sent_mail_at` datetime DEFAULT NULL,
  `sent_sms_at` datetime DEFAULT NULL,
  `confirm_join_at` datetime DEFAULT NULL,
  `deny_join_at` datetime DEFAULT NULL,
  `attend_at` datetime DEFAULT NULL,
  `note` text DEFAULT NULL,
  `extra_info1` varchar(256) DEFAULT NULL,
  `extra_info2` varchar(256) DEFAULT NULL,
  `extra_info3` varchar(256) DEFAULT NULL,
  `extra_info4` varchar(256) DEFAULT NULL,
  `extra_info5` varchar(256) DEFAULT NULL,
  `signature` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_face_infos`
--

CREATE TABLE `event_face_infos` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_event_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `extra_info` varchar(1024) DEFAULT NULL,
  `face_vector` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_infos`
--

CREATE TABLE `event_infos` (
  `id` int(11) NOT NULL,
  `id__` varchar(32) DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `name_sub` varchar(1024) DEFAULT NULL,
  `parent_id` int(11) DEFAULT 0,
  `orders` int(11) DEFAULT 0,
  `action` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `image_register` varchar(64) DEFAULT NULL,
  `opacity` smallint(6) DEFAULT 80,
  `log` text DEFAULT NULL,
  `location` varchar(256) DEFAULT NULL,
  `number_user` int(11) DEFAULT NULL,
  `time_start` datetime DEFAULT NULL,
  `time_end` datetime DEFAULT NULL,
  `mail_title1` varchar(512) DEFAULT NULL,
  `content1` text DEFAULT NULL,
  `content1_en` text DEFAULT NULL,
  `content3` text DEFAULT NULL,
  `content2` text DEFAULT NULL,
  `content2_en` text DEFAULT NULL,
  `content3_en` text DEFAULT NULL,
  `sms_content3` varchar(1024) DEFAULT NULL,
  `sms_content1` varchar(1024) DEFAULT NULL,
  `sms_content2` varchar(1024) DEFAULT NULL,
  `sms_content1_en` varchar(1024) DEFAULT NULL,
  `sms_content2_en` varchar(1024) DEFAULT NULL,
  `sms_content3_en` varchar(1024) DEFAULT NULL,
  `attached_files_email1` varchar(128) DEFAULT NULL,
  `attached_files_email1_en` varchar(64) DEFAULT NULL,
  `attached_files_email2` varchar(64) DEFAULT NULL,
  `attached_files_email2_en` varchar(64) DEFAULT NULL,
  `attached_files_email3` varchar(64) DEFAULT NULL,
  `attached_files_email3_en` varchar(64) DEFAULT NULL,
  `files` varchar(128) DEFAULT NULL,
  `mail_title2` varchar(512) DEFAULT NULL,
  `mail_title3` varchar(512) DEFAULT NULL,
  `mail_title1_en` varchar(512) DEFAULT NULL,
  `mail_title2_en` varchar(512) DEFAULT NULL,
  `mail_title3_en` varchar(512) DEFAULT NULL,
  `require_sign` smallint(6) DEFAULT 0,
  `require_sign_this_event` smallint(6) DEFAULT NULL,
  `allow_public_reg` smallint(6) DEFAULT 1,
  `reg_mail_01_vi` text DEFAULT NULL,
  `reg_mail_02_vi` text DEFAULT NULL,
  `reg_mail_01_en` text DEFAULT NULL,
  `reg_mail_02_en` text DEFAULT NULL,
  `reg_mail_title_vi1` varchar(512) DEFAULT NULL,
  `reg_mail_title_vi2` varchar(512) DEFAULT NULL,
  `reg_mail_title_en1` varchar(512) DEFAULT NULL,
  `reg_mail_title_en2` varchar(512) DEFAULT NULL,
  `department` int(11) DEFAULT NULL,
  `time_start_check_in` timestamp NULL DEFAULT NULL,
  `user_need_image_to_reg` smallint(6) DEFAULT 0,
  `limit_max_member` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_registers`
--

CREATE TABLE `event_registers` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_event_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `organization` varchar(255) DEFAULT NULL,
  `note` varchar(10240) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `first_name` varchar(128) DEFAULT NULL,
  `last_name` varchar(128) DEFAULT NULL,
  `reg_code` varchar(128) DEFAULT NULL,
  `reg_confirm_time` timestamp NULL DEFAULT NULL,
  `lang` varchar(4) DEFAULT NULL,
  `gender` smallint(6) DEFAULT NULL,
  `designation` varchar(128) DEFAULT NULL,
  `content_mail1` text DEFAULT NULL,
  `content_mail2` text DEFAULT NULL,
  `sub_event_list` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_send_actions`
--

CREATE TABLE `event_send_actions` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` mediumtext DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL COMMENT 'email,sms',
  `event_id` int(11) DEFAULT NULL,
  `done` tinyint(1) DEFAULT 0,
  `count_send` int(11) DEFAULT NULL,
  `pusher_chanel` varchar(64) DEFAULT NULL,
  `select_content` varchar(32) DEFAULT NULL,
  `select_user_type` varchar(32) DEFAULT NULL,
  `user_email_send_override` text DEFAULT NULL,
  `last_force_send` timestamp NULL DEFAULT NULL,
  `content_raw_send` text DEFAULT NULL,
  `list_uid_send_done` text DEFAULT NULL,
  `count_success` varchar(20) DEFAULT '',
  `pushed_all_sms_to_queue` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_send_email_logs`
--

CREATE TABLE `event_send_email_logs` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_send_info_logs`
--

CREATE TABLE `event_send_info_logs` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `event_user_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL COMMENT 'email,sms\r\n',
  `status` smallint(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` mediumtext DEFAULT NULL,
  `title_email` varchar(1024) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `content_sms` varchar(2048) DEFAULT NULL,
  `session_id` varchar(64) DEFAULT NULL COMMENT 'Mã duy nhất, có thể là time của sms',
  `sms_unique_session` varchar(64) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `send_or_get` varchar(10) DEFAULT NULL,
  `count_success` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `last_app_sms_request_to_send` timestamp NULL DEFAULT NULL,
  `done_at` varchar(50) DEFAULT NULL,
  `phone_send` varchar(20) DEFAULT NULL,
  `count_retry_send` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_send_sms_logs`
--

CREATE TABLE `event_send_sms_logs` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_settings`
--

CREATE TABLE `event_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `comment` varchar(128) DEFAULT NULL,
  `value` varchar(1024) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_user_groups`
--

CREATE TABLE `event_user_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT 0,
  `orders` int(11) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `phone` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_user_infos`
--

CREATE TABLE `event_user_infos` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `parent_extra` varchar(256) DEFAULT NULL,
  `parent_all` varchar(256) DEFAULT NULL,
  `title` varchar(64) DEFAULT NULL,
  `first_name` varchar(64) DEFAULT NULL,
  `last_name` varchar(64) DEFAULT NULL,
  `email` varchar(64) NOT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `address` varchar(128) DEFAULT NULL,
  `organization` text DEFAULT NULL,
  `designation` varchar(128) DEFAULT NULL,
  `language` varchar(3) DEFAULT 'vi' COMMENT 'vi/en/fr....',
  `extra_info1` varchar(1024) DEFAULT NULL,
  `extra_info2` varchar(1024) DEFAULT NULL,
  `extra_info3` varchar(1024) DEFAULT NULL,
  `extra_info4` varchar(256) DEFAULT NULL,
  `extra_info5` varchar(256) DEFAULT NULL,
  `signature` varchar(128) DEFAULT NULL,
  `note` varchar(512) DEFAULT NULL,
  `gender` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_user_payments`
--

CREATE TABLE `event_user_payments` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `face_data`
--

CREATE TABLE `face_data` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file_clouds`
--

CREATE TABLE `file_clouds` (
  `id` int(11) NOT NULL,
  `name` varchar(512) NOT NULL,
  `size` bigint(20) DEFAULT NULL,
  `file_path` varchar(256) CHARACTER SET ascii COLLATE ascii_general_ci DEFAULT NULL,
  `md5` varchar(32) CHARACTER SET ascii COLLATE ascii_general_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `crc32` varchar(16) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `location` varchar(256) CHARACTER SET ascii COLLATE ascii_general_ci DEFAULT NULL,
  `mime` varchar(128) DEFAULT NULL,
  `server1` varchar(128) DEFAULT NULL,
  `location1` varchar(128) DEFAULT NULL,
  `checksum` varchar(64) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `last_save_doc` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file_refers`
--

CREATE TABLE `file_refers` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `site` varchar(8) DEFAULT NULL COMMENT 'tên, ví dụ 4s, fs, gg,...',
  `remote_id` int(11) DEFAULT NULL,
  `remote_url` varchar(256) DEFAULT NULL,
  `filesize` bigint(20) DEFAULT NULL,
  `param1` varchar(64) DEFAULT NULL,
  `param2` varchar(64) DEFAULT NULL,
  `refer_obj` text DEFAULT NULL,
  `price_k` mediumint(9) DEFAULT NULL,
  `count_dl` int(11) DEFAULT NULL,
  `make_torrent` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file_share_permissions`
--

CREATE TABLE `file_share_permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file_uploads`
--

CREATE TABLE `file_uploads` (
  `id` bigint(20) NOT NULL,
  `id__` varchar(32) DEFAULT NULL,
  `name` varchar(256) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `file_path` varchar(512) DEFAULT NULL,
  `file_size` bigint(20) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT 0,
  `cloud_id` int(11) DEFAULT NULL,
  `md5` varchar(32) DEFAULT NULL,
  `crc32` varchar(16) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `mime` varchar(128) DEFAULT NULL,
  `refer` varchar(256) DEFAULT NULL,
  `count_download` int(11) DEFAULT 0,
  `idlink` int(11) DEFAULT NULL,
  `checksum` varchar(32) DEFAULT NULL,
  `link1` varchar(32) DEFAULT NULL,
  `ip_upload` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `folder_files`
--

CREATE TABLE `folder_files` (
  `id` int(11) NOT NULL,
  `id__` varchar(32) DEFAULT NULL,
  `name` varchar(256) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `orders` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) DEFAULT NULL,
  `link1` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gia_phas`
--

CREATE TABLE `gia_phas` (
  `id` int(11) NOT NULL,
  `id__` varchar(32) DEFAULT NULL,
  `parent_id` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `name` varchar(256) NOT NULL,
  `title` varchar(64) DEFAULT NULL,
  `home_address` varchar(64) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `orders` int(11) DEFAULT 0,
  `child_type` smallint(6) DEFAULT NULL COMMENT '=1 là con dâu, rể',
  `gender` smallint(6) DEFAULT 1,
  `birthday` varchar(30) DEFAULT NULL,
  `date_of_death` varchar(32) DEFAULT NULL,
  `place_birthday` varchar(64) DEFAULT NULL,
  `place_heaven` varchar(64) DEFAULT NULL,
  `child_of_second_married` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `last_name` varchar(128) DEFAULT NULL,
  `sur_name` varchar(128) DEFAULT NULL,
  `married_with` int(11) DEFAULT NULL,
  `image_list` varchar(1024) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tmp_old_id` int(11) DEFAULT NULL,
  `tmp_old_pid` int(11) DEFAULT NULL,
  `tmp_old_obj_json` text DEFAULT NULL,
  `phone_number` varchar(32) DEFAULT NULL,
  `email_address` varchar(64) DEFAULT NULL,
  `col_fix` mediumint(9) DEFAULT NULL,
  `row_fix` mediumint(9) DEFAULT NULL,
  `link_remote` text DEFAULT NULL,
  `set_nu_dinh` tinyint(1) DEFAULT NULL,
  `list_child_x_y` mediumtext DEFAULT NULL COMMENT 'vị trí x,y của từng lá, all lá con của cây\r\n, để không phải sắp xếp tự động gây chậm',
  `stepchild_of` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gia_pha_users`
--

CREATE TABLE `gia_pha_users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `max_quota_node` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `version_using` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hateco_certificates`
--

CREATE TABLE `hateco_certificates` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `ho` varchar(30) NOT NULL,
  `ten` varchar(30) NOT NULL,
  `ngay_sinh` date DEFAULT '0000-00-00',
  `noi_sinh` varchar(128) DEFAULT NULL,
  `gioi_tinh` varchar(16) DEFAULT NULL,
  `dan_toc` varchar(32) NOT NULL,
  `quoc_tich` varchar(64) DEFAULT NULL,
  `nganh_nghe` varchar(128) DEFAULT NULL,
  `trinh_do` varchar(20) DEFAULT NULL,
  `hinh_thuc` varchar(20) NOT NULL,
  `nam_tot_nghiep` int(11) DEFAULT NULL,
  `xep_loai` varchar(20) DEFAULT NULL,
  `so_qd_cong_nhan_tn` varchar(64) DEFAULT NULL,
  `ngay_qd` date DEFAULT NULL,
  `ngay_cap_bang` date DEFAULT NULL,
  `so_hieu_bang_tn` varchar(128) DEFAULT NULL,
  `so_vao_goc_cap_bang` varchar(128) DEFAULT NULL,
  `co_so_dao_tao` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hr_config_session_org_id_salaries`
--

CREATE TABLE `hr_config_session_org_id_salaries` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `session_type_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `orders` smallint(6) DEFAULT NULL,
  `status` smallint(6) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `org_id` int(11) DEFAULT NULL,
  `job_title_id` int(11) DEFAULT NULL,
  `salary_month` int(11) DEFAULT NULL,
  `num1` double DEFAULT NULL,
  `num2` double DEFAULT NULL,
  `num3` double DEFAULT NULL,
  `num4` double DEFAULT NULL,
  `num5` double DEFAULT NULL,
  `num6` double DEFAULT NULL,
  `num7` double DEFAULT NULL,
  `num8` double DEFAULT NULL,
  `num9` double DEFAULT NULL,
  `num10` double DEFAULT NULL,
  `num11` double DEFAULT NULL,
  `num12` double DEFAULT NULL,
  `num13` double DEFAULT NULL,
  `num14` double DEFAULT NULL,
  `num15` double DEFAULT NULL,
  `num16` double DEFAULT NULL,
  `num17` double DEFAULT NULL,
  `num18` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hr_contracts`
--

CREATE TABLE `hr_contracts` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hr_demo_time_events`
--

CREATE TABLE `hr_demo_time_events` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hr_employees`
--

CREATE TABLE `hr_employees` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `id_card` varchar(32) DEFAULT NULL,
  `idcard_date` date DEFAULT NULL,
  `idcard_place` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `address_permanent` text DEFAULT NULL,
  `birth_day` date DEFAULT NULL,
  `last_name` varchar(64) DEFAULT NULL,
  `first_name` varchar(64) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `insurance_id` varchar(64) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `work_status` smallint(6) DEFAULT NULL,
  `job_title` int(11) DEFAULT NULL,
  `group_time` int(11) DEFAULT NULL COMMENT 'Nhóm giờ làm việc',
  `parent_id` int(11) DEFAULT NULL,
  `orders` int(11) DEFAULT NULL,
  `admin_this_tree` smallint(6) DEFAULT NULL COMMENT 'Quản lý cây này và các cây con...',
  `sex` smallint(6) DEFAULT NULL,
  `home_town` text DEFAULT NULL,
  `certificate` text DEFAULT NULL,
  `skill` text DEFAULT NULL,
  `father_name` text DEFAULT NULL,
  `father_birthday` date DEFAULT NULL,
  `father_occupation` text DEFAULT NULL,
  `father_work_place` text DEFAULT NULL,
  `mother_name` text DEFAULT NULL,
  `mother_birthday` date DEFAULT NULL,
  `mother_occupation` text DEFAULT NULL,
  `mother_work_place` text DEFAULT NULL,
  `spouse_name` text DEFAULT NULL,
  `spouse_birthday` date DEFAULT NULL,
  `spouse_occupation` text DEFAULT NULL,
  `spouse_work_place` text DEFAULT NULL,
  `relatives_name` text DEFAULT NULL,
  `relatives_birthday` date DEFAULT NULL,
  `height` float DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `nation` text DEFAULT NULL,
  `str1` varchar(127) DEFAULT NULL,
  `str2` varchar(127) DEFAULT NULL,
  `str3` varchar(127) DEFAULT NULL,
  `str4` varchar(127) DEFAULT NULL,
  `str5` varchar(127) DEFAULT NULL,
  `str6` varchar(127) DEFAULT NULL,
  `str7` varchar(127) DEFAULT NULL,
  `str8` varchar(127) DEFAULT NULL,
  `str9` varchar(64) DEFAULT NULL,
  `str10` varchar(64) DEFAULT NULL,
  `str11` varchar(64) DEFAULT NULL,
  `str12` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hr_expense_col_mngs`
--

CREATE TABLE `hr_expense_col_mngs` (
  `id` int(11) NOT NULL,
  `field` varchar(30) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `org_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hr_extra_cost_employees`
--

CREATE TABLE `hr_extra_cost_employees` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `month` varchar(7) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `sparam1` int(11) DEFAULT NULL,
  `sparam2` int(11) DEFAULT NULL,
  `sparam3` int(11) DEFAULT NULL,
  `sparam4` int(11) DEFAULT NULL,
  `sparam5` int(11) DEFAULT NULL,
  `sparam6` int(11) DEFAULT NULL,
  `sparam7` int(11) DEFAULT NULL,
  `sparam8` int(11) DEFAULT NULL,
  `sparam9` int(11) DEFAULT NULL,
  `sparam10` int(11) DEFAULT NULL,
  `sparam11` int(11) DEFAULT NULL,
  `sparam12` int(11) DEFAULT NULL,
  `sparam13` int(11) DEFAULT NULL,
  `sparam14` int(11) DEFAULT NULL,
  `sparam15` int(11) DEFAULT NULL,
  `sparam16` int(11) DEFAULT NULL,
  `sparam17` int(11) DEFAULT NULL,
  `sparam18` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hr_jobs`
--

CREATE TABLE `hr_jobs` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hr_job_titles`
--

CREATE TABLE `hr_job_titles` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hr_kpi_cldvs`
--

CREATE TABLE `hr_kpi_cldvs` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hr_late_configs`
--

CREATE TABLE `hr_late_configs` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hr_log_tasks`
--

CREATE TABLE `hr_log_tasks` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hr_message_tasks`
--

CREATE TABLE `hr_message_tasks` (
  `id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `type` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hr_org_settings`
--

CREATE TABLE `hr_org_settings` (
  `id` int(11) NOT NULL,
  `org_id` int(11) DEFAULT NULL,
  `job_title_id` int(11) DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `num1` double DEFAULT NULL,
  `num2` double DEFAULT NULL,
  `num3` double DEFAULT NULL,
  `num4` double DEFAULT NULL,
  `num5` double DEFAULT NULL,
  `num6` double DEFAULT NULL,
  `num7` double DEFAULT NULL,
  `num8` double DEFAULT NULL,
  `num9` double DEFAULT NULL,
  `num10` double DEFAULT NULL,
  `num11` double DEFAULT NULL,
  `num12` double DEFAULT NULL,
  `num13` double DEFAULT NULL,
  `num14` double DEFAULT NULL,
  `num15` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hr_org_trees`
--

CREATE TABLE `hr_org_trees` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `orders` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hr_salaries`
--

CREATE TABLE `hr_salaries` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `job_title_id` int(11) DEFAULT NULL COMMENT 'Mức lương theo job_title',
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `log` text DEFAULT NULL,
  `salary_hour` int(11) DEFAULT NULL,
  `salary_day` int(11) DEFAULT NULL,
  `salary_week` int(11) DEFAULT NULL,
  `salary_month` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hr_salary_month_users`
--

CREATE TABLE `hr_salary_month_users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `month` varchar(7) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `sparam1` int(11) DEFAULT NULL,
  `sparam2` int(11) DEFAULT NULL,
  `sparam3` int(11) DEFAULT NULL,
  `sparam4` int(11) DEFAULT NULL,
  `sparam5` int(11) DEFAULT NULL,
  `sparam6` int(11) DEFAULT NULL,
  `sparam7` int(11) DEFAULT NULL,
  `sparam8` int(11) DEFAULT NULL,
  `sparam9` int(11) DEFAULT NULL,
  `sparam10` int(11) DEFAULT NULL,
  `sparam11` int(11) DEFAULT NULL,
  `sparam12` int(11) DEFAULT NULL,
  `sparam13` int(11) DEFAULT NULL,
  `sparam14` int(11) DEFAULT NULL,
  `sparam15` int(11) DEFAULT NULL,
  `sparam16` int(11) DEFAULT NULL,
  `sparam17` int(11) DEFAULT NULL,
  `sparam18` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hr_sample_time_events`
--

CREATE TABLE `hr_sample_time_events` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `time_frame` varchar(20) DEFAULT NULL,
  `cat1` int(11) DEFAULT NULL,
  `cat2` int(11) DEFAULT NULL,
  `num1` double DEFAULT NULL,
  `num2` double DEFAULT NULL,
  `num3` double DEFAULT NULL,
  `num4` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hr_session_types`
--

CREATE TABLE `hr_session_types` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `hour` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `log` text DEFAULT NULL,
  `orders` smallint(6) DEFAULT NULL,
  `num1` double DEFAULT NULL,
  `num2` double DEFAULT NULL,
  `num3` double DEFAULT NULL,
  `num4` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hr_tasks`
--

CREATE TABLE `hr_tasks` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_id_get` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `done` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `uid_list_chat` text DEFAULT NULL COMMENT 'Để gửi tin nhắn hàng loạt, ví dụ có thể các manager, user khác cùng tham gia vào chat của task này, thì UID sẽ được thêm vào đây',
  `type` smallint(6) DEFAULT NULL COMMENT 'Kiểu việc: 1 lần, hàng ngày, hàng tuần, tháng, ...'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hr_time_sheets`
--

CREATE TABLE `hr_time_sheets` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `time_in` float DEFAULT NULL,
  `time_out` float DEFAULT NULL,
  `over_time` varchar(10) DEFAULT NULL,
  `date_type` tinyint(4) DEFAULT NULL COMMENT 'Kiểu ngày: thường, nghỉ, lễ tết',
  `n_session` varchar(10) DEFAULT NULL,
  `meal` varchar(10) DEFAULT NULL,
  `n_hour` varchar(10) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL COMMENT 'ID gắn với công việc cụ thể (task_id) nếu cần',
  `org_id` int(11) DEFAULT NULL COMMENT 'Mỗi lần insert, là 1 ngày, user sẽ thuộc một ID tổ chức',
  `n_late` varchar(10) DEFAULT NULL,
  `time_frame` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hr_user_expenses`
--

CREATE TABLE `hr_user_expenses` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `time_frame` varchar(20) DEFAULT NULL,
  `cat1` int(11) DEFAULT NULL,
  `cat2` int(11) DEFAULT NULL,
  `num1` double DEFAULT NULL,
  `num2` double DEFAULT NULL,
  `num3` double DEFAULT NULL,
  `num4` double DEFAULT NULL,
  `num_1` double DEFAULT NULL,
  `num_2` double DEFAULT NULL,
  `num_3` double DEFAULT NULL,
  `num_4` double DEFAULT NULL,
  `num5` double DEFAULT NULL,
  `num6` double DEFAULT NULL,
  `num_5` double DEFAULT NULL,
  `num_6` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_users`
--

CREATE TABLE `log_users` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `admin_uid` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `action` text DEFAULT NULL,
  `url` text DEFAULT NULL,
  `ip` varchar(64) DEFAULT NULL,
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media_actors`
--

CREATE TABLE `media_actors` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media_authors`
--

CREATE TABLE `media_authors` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media_cats`
--

CREATE TABLE `media_cats` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media_folders`
--

CREATE TABLE `media_folders` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `orders` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media_items`
--

CREATE TABLE `media_items` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `parent_list` varchar(256) DEFAULT NULL,
  `parent_extra` varchar(256) DEFAULT NULL,
  `parent_all` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media_links`
--

CREATE TABLE `media_links` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `link` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `media_id` int(11) DEFAULT NULL,
  `refer` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media_vendors`
--

CREATE TABLE `media_vendors` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `members_members`
--

CREATE TABLE `members_members` (
  `id` bigint(20) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(255) NOT NULL DEFAULT '',
  `site_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_trees`
--

CREATE TABLE `menu_trees` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `orders` int(11) DEFAULT 0,
  `link` varchar(512) DEFAULT '',
  `gid_allow` varchar(255) DEFAULT NULL,
  `open_new_window` tinyint(4) DEFAULT 0,
  `icon` varchar(256) DEFAULT NULL,
  `id_news` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  `site_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_meta_infos`
--

CREATE TABLE `model_meta_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `table_name_model` varchar(255) NOT NULL,
  `field` varchar(255) DEFAULT NULL,
  `sname` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `full_desc` varchar(255) DEFAULT NULL,
  `order_field` int(11) DEFAULT 0,
  `dataType` int(11) DEFAULT NULL,
  `is_hiden_input` int(11) DEFAULT NULL,
  `show_in_index` varchar(255) DEFAULT NULL,
  `show_get_one` varchar(255) DEFAULT NULL,
  `searchable` varchar(255) DEFAULT NULL,
  `sortable` varchar(255) DEFAULT NULL,
  `editable` varchar(255) DEFAULT NULL,
  `editable_get_one` varchar(255) DEFAULT NULL,
  `readOnly` varchar(255) DEFAULT NULL,
  `limit_user_edit` varchar(255) DEFAULT NULL,
  `limit_dev_edit` varchar(255) DEFAULT NULL,
  `insertable` varchar(255) DEFAULT NULL,
  `join_func` varchar(255) DEFAULT NULL,
  `join_api` varchar(255) DEFAULT NULL,
  `join_api_field` varchar(255) DEFAULT NULL,
  `admin_url` varchar(255) DEFAULT NULL,
  `func_foreign_key_insert_update` varchar(255) DEFAULT NULL,
  `is_select` varchar(255) DEFAULT NULL,
  `css_class` varchar(255) DEFAULT NULL,
  `css_cell_class` varchar(255) DEFAULT NULL,
  `css` varchar(255) DEFAULT NULL,
  `link_to_view` varchar(255) DEFAULT NULL,
  `link_to_edit` varchar(255) DEFAULT NULL,
  `primary` varchar(255) DEFAULT NULL,
  `is_multilangg` varchar(255) DEFAULT NULL,
  `get_not_show` varchar(50) DEFAULT NULL,
  `join_relation_func` varchar(255) DEFAULT NULL,
  `data_type_in_db` varchar(128) DEFAULT NULL,
  `opt_field` int(11) DEFAULT NULL,
  `join_func_model` varchar(128) DEFAULT NULL,
  `width_col` mediumint(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `money_and_tags`
--

CREATE TABLE `money_and_tags` (
  `id` int(11) NOT NULL,
  `money_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `money_logs`
--

CREATE TABLE `money_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `log` text DEFAULT NULL,
  `cat` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `money_tags`
--

CREATE TABLE `money_tags` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `monitor_items`
--

CREATE TABLE `monitor_items` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `domain_url` varchar(512) DEFAULT NULL,
  `delay` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `my_documents`
--

CREATE TABLE `my_documents` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `summary` varchar(1024) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `refer` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `parent_list` varchar(256) DEFAULT NULL,
  `file_list` varchar(1024) DEFAULT NULL,
  `parent_extra` varchar(256) DEFAULT NULL,
  `parent_all` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `my_document_cats`
--

CREATE TABLE `my_document_cats` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `orders` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `my_tree_infos`
--

CREATE TABLE `my_tree_infos` (
  `id` int(11) NOT NULL,
  `id__` varchar(32) DEFAULT NULL,
  `name` varchar(256) NOT NULL,
  `title` varchar(256) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tree_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `image_list` varchar(64) DEFAULT NULL,
  `color_name` varchar(12) DEFAULT NULL,
  `color_title` varchar(12) DEFAULT NULL,
  `fontsize_name` smallint(6) DEFAULT NULL,
  `fontsize_title` smallint(6) DEFAULT NULL,
  `banner_name_margin_top` smallint(6) DEFAULT 0,
  `banner_name_margin_bottom` smallint(6) DEFAULT 0,
  `banner_title_margin_top` smallint(6) DEFAULT 0,
  `banner_title_margin_bottom` smallint(6) DEFAULT 0,
  `member_background_img` varchar(256) DEFAULT NULL,
  `member_background_img2` varchar(256) DEFAULT NULL,
  `banner_width` mediumint(9) DEFAULT NULL,
  `banner_height` mediumint(9) DEFAULT NULL,
  `banner_name_bold` varchar(20) DEFAULT NULL,
  `banner_name_italic` varchar(20) DEFAULT NULL,
  `banner_title_bold` varchar(20) DEFAULT NULL,
  `banner_title_italic` varchar(20) DEFAULT NULL,
  `banner_title_curver` mediumint(9) DEFAULT NULL,
  `banner_name_curver` mediumint(9) DEFAULT NULL,
  `banner_text_shadow_name` varchar(30) DEFAULT NULL,
  `banner_text_shadow_title` varchar(30) DEFAULT NULL,
  `banner_margin_top` smallint(6) DEFAULT NULL,
  `title_before_or_after_name` tinyint(4) DEFAULT 0,
  `tree_nodes_xy` mediumtext DEFAULT NULL COMMENT 'các tọa độ từng node thuộc cây này được lưu riêng tại đây',
  `minX` int(11) DEFAULT NULL,
  `minY` int(11) DEFAULT NULL COMMENT 'Vị trí Y Min của cả cây',
  `show_node_name_one` tinyint(4) DEFAULT 1,
  `show_node_title` tinyint(4) DEFAULT 1,
  `show_node_birthday_one` tinyint(4) DEFAULT 1,
  `show_node_date_of_death` tinyint(4) DEFAULT 1,
  `show_node_image` tinyint(4) DEFAULT 1,
  `node_width` smallint(6) DEFAULT NULL,
  `node_height` smallint(6) DEFAULT NULL,
  `space_node_x` smallint(6) DEFAULT NULL,
  `space_node_y` smallint(6) DEFAULT NULL,
  `font_size_node` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `network_marketings`
--

CREATE TABLE `network_marketings` (
  `id` int(11) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `log` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `orders` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint(20) NOT NULL,
  `name` varchar(256) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `log` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `content` mediumtext DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `status` smallint(6) DEFAULT 0,
  `meta_desc` text DEFAULT NULL,
  `options` int(11) DEFAULT NULL COMMENT '1 kiểu phân loại, ví dụ =1, ở top trang chủ; = 2 ở slide giữa...\r\n',
  `orders` int(11) DEFAULT NULL,
  `publish_status` int(11) DEFAULT NULL,
  `count_view` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news_folders`
--

CREATE TABLE `news_folders` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `parent_id` int(11) DEFAULT 0,
  `log` text DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `orders` int(11) DEFAULT NULL,
  `front` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ocr_images`
--

CREATE TABLE `ocr_images` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `draft` text DEFAULT NULL,
  `image_list` text DEFAULT NULL,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_infos`
--

CREATE TABLE `order_infos` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL COMMENT 'Tên chuyến',
  `from_address` varchar(256) DEFAULT NULL COMMENT 'Đi từ',
  `to_address` varchar(256) DEFAULT NULL COMMENT 'Đi đến',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT 0 COMMENT 'uid tạo đơn này',
  `phone_request` varchar(30) DEFAULT NULL COMMENT 'phone khách nếu có',
  `email_request` varchar(50) DEFAULT NULL COMMENT 'email khách nếu có',
  `note1` text DEFAULT NULL COMMENT 'Mô tả text , copy từ chat..., voice',
  `user_id_post` int(11) DEFAULT NULL COMMENT 'uid yêu cầu chuyến nếu có',
  `user_id_get` int(11) DEFAULT NULL COMMENT 'uid nhận chuyến nếu có',
  `service_require` tinyint(4) DEFAULT NULL COMMENT 'Hàng hóa yc, fakefield',
  `start_time` timestamp NULL DEFAULT NULL COMMENT 'Thời gian bắt đầu cần dịch vụ',
  `end_time` timestamp NULL DEFAULT NULL,
  `money` int(11) DEFAULT NULL COMMENT 'Số tiền',
  `done_at` timestamp NULL DEFAULT NULL COMMENT 'Thành công',
  `status` smallint(6) DEFAULT NULL COMMENT 'Trạng thái: thành công, hủy...',
  `image_list` varchar(256) DEFAULT NULL,
  `order_status` int(11) DEFAULT 0,
  `from_chanel` text DEFAULT NULL,
  `transaction_id_local` varchar(64) DEFAULT NULL,
  `transaction_id_remote` varchar(64) DEFAULT NULL,
  `remote_ip` varchar(32) DEFAULT NULL,
  `comment` varchar(1024) DEFAULT NULL,
  `usage_status` enum('not_available','available','used','') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL COMMENT 'là orderInfo id',
  `sku_id` int(11) DEFAULT NULL,
  `sku_string` varchar(256) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `price_org` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `client_session_time` varchar(16) DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `param1` int(11) DEFAULT NULL COMMENT 'Ví dụ số lượt tải của Gói download, lấy từ param1 của Sản phẩm',
  `used` int(11) DEFAULT 0 COMMENT 'Ví dụ số lượt tải đã sử dụng',
  `log` text DEFAULT NULL,
  `note` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_ships`
--

CREATE TABLE `order_ships` (
  `id` int(11) NOT NULL,
  `fee` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `remote_tracking_id` varchar(30) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `pick_time` timestamp NULL DEFAULT NULL,
  `delive_time` timestamp NULL DEFAULT NULL,
  `remote_label` varchar(64) DEFAULT NULL,
  `json_send` text DEFAULT NULL,
  `json_get` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `partner_infos`
--

CREATE TABLE `partner_infos` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `name` varchar(128) DEFAULT NULL COMMENT 'Tên thông tin',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `partner_name` varchar(64) DEFAULT '0' COMMENT 'Tên parnet',
  `token_api` varchar(255) DEFAULT NULL COMMENT 'Số tiền',
  `note` text DEFAULT NULL COMMENT 'Mô tả'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `payment_method` enum('pending','paid','failed','') DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pay_moneylogs`
--

CREATE TABLE `pay_moneylogs` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `money` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `route_name_code` varchar(255) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `prefix` varchar(255) NOT NULL,
  `url` varchar(512) DEFAULT NULL,
  `site_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `site_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `site_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plan_defines`
--

CREATE TABLE `plan_defines` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plan_define_values`
--

CREATE TABLE `plan_define_values` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plan_names`
--

CREATE TABLE `plan_names` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `status` smallint(6) DEFAULT NULL,
  `meta_desc` text DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `price1` int(11) DEFAULT NULL,
  `param1` int(11) DEFAULT NULL COMMENT 'tham số 1, ví dụ Số lượt tải download (có thể để trong SKU?)',
  `param2` int(11) DEFAULT NULL,
  `param3` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `parent_extra` varchar(255) DEFAULT NULL,
  `parent_all` varchar(255) DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `orders` smallint(6) DEFAULT NULL,
  `meta` text DEFAULT NULL,
  `refer` text DEFAULT NULL,
  `tmp` text DEFAULT NULL,
  `type` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_attributes`
--

CREATE TABLE `product_attributes` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `attribute_name` varchar(128) NOT NULL,
  `attribute_value` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_folders`
--

CREATE TABLE `product_folders` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `orders` smallint(11) DEFAULT NULL,
  `meta_desc` varchar(1024) DEFAULT NULL,
  `front` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image_name` varchar(255) NOT NULL,
  `site_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_tags`
--

CREATE TABLE `product_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `site_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_usages`
--

CREATE TABLE `product_usages` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `usage_type` varchar(64) DEFAULT NULL,
  `usage_current` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_variant_options`
--

CREATE TABLE `product_variant_options` (
  `id` int(11) NOT NULL,
  `product_variant_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_choices`
--

CREATE TABLE `quiz_choices` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `value` varchar(256) DEFAULT NULL,
  `value_richtext` text DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `is_right_choice` tinyint(4) DEFAULT NULL,
  `choice` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` text DEFAULT NULL,
  `note` text DEFAULT NULL,
  `orders` smallint(11) DEFAULT NULL,
  `enable` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_classes`
--

CREATE TABLE `quiz_classes` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `orders` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_flash_cards`
--

CREATE TABLE `quiz_flash_cards` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `question` text DEFAULT NULL,
  `answer` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_folders`
--

CREATE TABLE `quiz_folders` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT 0,
  `orders` int(11) DEFAULT NULL,
  `refer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `is_english` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `content_vi` text DEFAULT NULL,
  `content_textarea` text DEFAULT NULL,
  `draft` text DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `note_book` varchar(64) DEFAULT NULL,
  `type` smallint(6) DEFAULT NULL,
  `explains` text DEFAULT NULL,
  `hard_level` smallint(6) DEFAULT NULL,
  `class` varchar(64) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `parent_list` varchar(255) DEFAULT NULL,
  `refer` varchar(255) DEFAULT NULL,
  `tmp` text DEFAULT NULL,
  `obj_refer` text DEFAULT NULL,
  `log` text DEFAULT NULL,
  `cat1` int(11) DEFAULT NULL,
  `cat2` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_session_info_tests`
--

CREATE TABLE `quiz_session_info_tests` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `open_answer_time` timestamp NULL DEFAULT NULL,
  `close_answer_time` timestamp NULL DEFAULT NULL,
  `start_time_do` timestamp NULL DEFAULT NULL,
  `end_time_do` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_tests`
--

CREATE TABLE `quiz_tests` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `enable` tinyint(4) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tên các bài test';

-- --------------------------------------------------------

--
-- Table structure for table `quiz_test_questions`
--

CREATE TABLE `quiz_test_questions` (
  `id` int(11) NOT NULL,
  `test_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `note` text DEFAULT NULL,
  `orders` int(11) DEFAULT NULL,
  `enable` tinyint(4) DEFAULT 1,
  `parent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='các câu test chi tiết, gắn với 1 bài test';

-- --------------------------------------------------------

--
-- Table structure for table `quiz_user_and_tests`
--

CREATE TABLE `quiz_user_and_tests` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `test_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `percent_do` float DEFAULT NULL,
  `point` float DEFAULT NULL,
  `obj_result` text DEFAULT NULL,
  `count_post` int(11) DEFAULT 0,
  `session_id` int(11) DEFAULT NULL COMMENT 'Liên kết sang bảng QuizSessionTest\r\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_user_answers`
--

CREATE TABLE `quiz_user_answers` (
  `id` int(11) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `test_id` int(11) DEFAULT NULL,
  `choice_id` int(11) DEFAULT NULL,
  `explains` text DEFAULT NULL,
  `is_right` tinyint(4) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_user_classes`
--

CREATE TABLE `quiz_user_classes` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `parent_list` varchar(512) DEFAULT NULL,
  `note` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rand_table`
--

CREATE TABLE `rand_table` (
  `siteid` smallint(6) DEFAULT 0,
  `id` int(11) NOT NULL,
  `rand` varchar(8) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `site_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `site_id` int(11) NOT NULL DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_mngs`
--

CREATE TABLE `site_mngs` (
  `id` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `domain` varchar(128) DEFAULT NULL,
  `domain1` varchar(100) DEFAULT NULL,
  `domain2` varchar(100) DEFAULT NULL,
  `domain3` varchar(50) DEFAULT NULL,
  `domain4` varchar(50) DEFAULT NULL,
  `domain5` varchar(50) DEFAULT NULL,
  `templateName` varchar(100) DEFAULT 'default_news',
  `MEMBER_APP_NAME` varchar(50) DEFAULT 'DEFAULT NAME',
  `logo_image` varchar(255) DEFAULT NULL,
  `logo_image2` varchar(1024) DEFAULT NULL,
  `logo_image3` varchar(1024) DEFAULT NULL,
  `logo_text` varchar(30) DEFAULT NULL,
  `color1` varchar(12) DEFAULT NULL,
  `color2` varchar(12) DEFAULT NULL,
  `color3` varchar(12) DEFAULT NULL,
  `metaTitle` text DEFAULT NULL,
  `metaTitleEn` text DEFAULT NULL,
  `metaDescription` text DEFAULT NULL,
  `metaKeyword` text DEFAULT NULL,
  `metaHeader` text DEFAULT NULL,
  `FACEBOOK_APP_ID` varchar(200) DEFAULT '1842535416029056',
  `FACEBOOK_APP_SECRET` varchar(200) DEFAULT '639330ee1b76aea59a5edab7ed3e171e',
  `GOOGLE_OAUTH2_CLIENT_ID` varchar(200) DEFAULT '211733424826-d7dns77hrghn70tugmlbo7p15ugfed4m.apps.googleusercontent.com',
  `GOOGLE_OAUTH2_CLIENT_SECRET` varchar(200) DEFAULT 'BxHtGddkUIqQKPyEb957AjvY',
  `GOOGLE_SITE_VERIFICATION_CODE` varchar(256) DEFAULT NULL,
  `google_analytics_code` text DEFAULT NULL,
  `language` varchar(3) DEFAULT NULL,
  `siteid` int(11) DEFAULT NULL,
  `admin_email` varchar(128) DEFAULT NULL,
  `admin_phone_support` varchar(20) DEFAULT NULL,
  `admin_name` varchar(255) DEFAULT NULL,
  `address1` varchar(1024) DEFAULT NULL,
  `address2` text DEFAULT NULL,
  `cache_time_minute` int(11) DEFAULT 0,
  `cache_disable_to_time` int(11) DEFAULT 0,
  `useMongo` smallint(6) NOT NULL DEFAULT 0,
  `not_found_image_default` varchar(512) DEFAULT NULL,
  `facebook_message_appid` varchar(30) DEFAULT NULL,
  `facebook_message_link` varchar(255) DEFAULT NULL,
  `og_image_default` varchar(255) DEFAULT NULL,
  `maintain_text` text DEFAULT NULL,
  `remarketting` text DEFAULT NULL,
  `livechat` text DEFAULT NULL,
  `facebook_pixel` text DEFAULT NULL,
  `google_analytics_code2` text DEFAULT NULL,
  `metaTitle_en` varchar(255) DEFAULT NULL,
  `metaTitle_jp` varchar(255) DEFAULT NULL,
  `metaDescription_en` varchar(512) DEFAULT NULL,
  `metaDescription_jp` varchar(512) DEFAULT NULL,
  `metaKeyword_en` varchar(512) DEFAULT NULL,
  `metaKeyword_jp` varchar(512) DEFAULT NULL,
  `encode_id1` smallint(6) DEFAULT NULL,
  `encode_id2` smallint(6) DEFAULT NULL,
  `useMetaReserveOfData` int(11) DEFAULT NULL,
  `useMetaReserveOfNews` int(11) DEFAULT NULL,
  `maxSizeUploadWebMB` int(11) DEFAULT 10,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` int(11) DEFAULT NULL,
  `site_code` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `skus`
--

CREATE TABLE `skus` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sku` varchar(45) DEFAULT NULL,
  `price0` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `quantity` int(11) DEFAULT 0,
  `product_opt_list` varchar(256) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `param1` int(11) DEFAULT NULL COMMENT 'Có thể là số lượt tải gói download'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `skus_product_variant_options`
--

CREATE TABLE `skus_product_variant_options` (
  `sku_id` int(11) NOT NULL,
  `product_variant_id` int(11) NOT NULL,
  `product_variant_options_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `spendings`
--

CREATE TABLE `spendings` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL COMMENT 'Tên spend',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT 0 COMMENT 'uid tạo spen này',
  `cat` int(11) DEFAULT NULL COMMENT 'Phân loại',
  `money` int(11) DEFAULT NULL COMMENT 'Số tiền',
  `note` text DEFAULT NULL COMMENT 'Mô tả spend',
  `image_list` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `site_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tag_demos`
--

CREATE TABLE `tag_demos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `site_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_infos`
--

CREATE TABLE `task_infos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'UID của người tạo task này',
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL COMMENT 'Mô tả chi tiết Task',
  `status` enum('not_started','in_progress','completed','pending','canceled') DEFAULT 'not_started',
  `priority` enum('low','medium','high','urgent') DEFAULT 'medium',
  `due_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL COMMENT 'Gán cho UserID nào',
  `parent_id` int(11) DEFAULT 0 COMMENT 'Là ID của task cha',
  `orders` int(11) DEFAULT NULL COMMENT 'Thứ tự của Task.\r\nNếu nó nằm trong task cha, thì cũng theo thứ tự này. dùng để sắp xếp thứ tự hiển thị lên giao diện',
  `file_list` varchar(255) DEFAULT NULL COMMENT 'là các ID file, cách nhau bởi dấu , Link các file này sẽ có hàm lấy sau',
  `parent_extra` varchar(255) DEFAULT NULL,
  `parent_all` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `telesales`
--

CREATE TABLE `telesales` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL COMMENT 'Tên chuyến',
  `from_address` varchar(256) DEFAULT NULL COMMENT 'Đi từ',
  `to_address` varchar(256) DEFAULT NULL COMMENT 'Đi đến',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT 0 COMMENT 'uid tạo đơn này',
  `phone_request` varchar(30) DEFAULT NULL COMMENT 'phone khách nếu có',
  `email_request` varchar(50) DEFAULT NULL COMMENT 'email khách nếu có',
  `note1` text DEFAULT NULL COMMENT 'Mô tả text , copy từ chat..., voice',
  `note2` text DEFAULT NULL COMMENT 'Note của telesale',
  `user_id_post` int(11) DEFAULT NULL COMMENT 'uid yêu cầu chuyến nếu có',
  `user_id_get` int(11) DEFAULT NULL COMMENT 'uid nhận chuyến nếu có',
  `service_require` tinyint(4) DEFAULT NULL COMMENT 'Hàng hóa yc, fakefield',
  `start_time` timestamp NULL DEFAULT NULL COMMENT 'Thời gian bắt đầu cần dịch vụ',
  `end_time` timestamp NULL DEFAULT NULL,
  `money` int(11) DEFAULT NULL COMMENT 'Số tiền',
  `done_at` timestamp NULL DEFAULT NULL COMMENT 'Thành công',
  `status` smallint(6) DEFAULT NULL COMMENT 'Trạng thái: thành công, hủy...',
  `image_list` varchar(256) DEFAULT NULL,
  `order_status` int(11) DEFAULT 0,
  `from_chanel` text DEFAULT NULL,
  `order_id_link` int(11) NOT NULL,
  `token_time` timestamp NULL DEFAULT current_timestamp() COMMENT 'Thời gian telesale nhận đơn này',
  `api_key_ship` int(11) DEFAULT NULL,
  `print_status` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `telescope_entries`
--

CREATE TABLE `telescope_entries` (
  `sequence` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `batch_id` char(36) NOT NULL,
  `family_hash` varchar(255) DEFAULT NULL,
  `should_display_on_index` tinyint(1) NOT NULL DEFAULT 1,
  `type` varchar(20) NOT NULL,
  `content` longtext NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `telescope_entries_tags`
--

CREATE TABLE `telescope_entries_tags` (
  `entry_uuid` char(36) NOT NULL,
  `tag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `telescope_monitoring`
--

CREATE TABLE `telescope_monitoring` (
  `tag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test_mongo1s`
--

CREATE TABLE `test_mongo1s` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_download_sessions`
--

CREATE TABLE `tmp_download_sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `fid` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `done_bytes` bigint(20) DEFAULT 0,
  `ip_address` varchar(64) DEFAULT NULL,
  `ip_download_list` varchar(4096) DEFAULT NULL,
  `file_size` bigint(20) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `time_begin_update_byte` timestamp NULL DEFAULT NULL,
  `time_end_update_byte` timestamp NULL DEFAULT NULL,
  `logs` varchar(4096) DEFAULT NULL
) ENGINE=MEMORY DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `todo2s`
--

CREATE TABLE `todo2s` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `done_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transport_infos`
--

CREATE TABLE `transport_infos` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL COMMENT 'Tên chuyến',
  `from_address` varchar(256) DEFAULT NULL COMMENT 'Đi từ',
  `to_address` varchar(256) DEFAULT NULL COMMENT 'Đi đến',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT 0 COMMENT 'uid tạo đơn này',
  `phone_request` varchar(30) DEFAULT NULL COMMENT 'phone khách nếu có',
  `email_request` varchar(50) DEFAULT NULL COMMENT 'email khách nếu có',
  `text_desc` text DEFAULT NULL COMMENT 'Mô tả text , copy từ chat..., voice',
  `user_id_post` int(11) DEFAULT NULL COMMENT 'uid yêu cầu chuyến nếu có',
  `user_id_get` int(11) DEFAULT NULL COMMENT 'uid nhận chuyến nếu có',
  `service_require` int(11) DEFAULT NULL COMMENT 'Loại dịch vụ: xe 4, 6 chỗ',
  `start_time` timestamp NULL DEFAULT NULL COMMENT 'Thời gian bắt đầu cần dịch vụ',
  `end_time` timestamp NULL DEFAULT NULL,
  `money` int(11) DEFAULT NULL COMMENT 'Số tiền',
  `done_at` timestamp NULL DEFAULT NULL COMMENT 'Thành công',
  `status` smallint(6) DEFAULT NULL COMMENT 'Trạng thái: thành công, hủy...',
  `image_list` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tree_mng_col_fixes`
--

CREATE TABLE `tree_mng_col_fixes` (
  `id` int(11) NOT NULL,
  `pid` int(11) DEFAULT NULL,
  `node_id` int(11) DEFAULT NULL,
  `col_fix` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `typing_lessons`
--

CREATE TABLE `typing_lessons` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `parent_name` text DEFAULT NULL,
  `type_text` text DEFAULT NULL,
  `refer` text DEFAULT NULL,
  `name_en` text DEFAULT NULL,
  `parent_name_en` text DEFAULT NULL,
  `lesson` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `typing_test_results`
--

CREATE TABLE `typing_test_results` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `gsession` varchar(20) DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `type_text` text DEFAULT NULL,
  `lesson` mediumint(9) DEFAULT NULL,
  `speedw` mediumint(6) DEFAULT NULL,
  `speedc` mediumint(6) DEFAULT NULL,
  `accuracy` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uploader_infos`
--

CREATE TABLE `uploader_infos` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id__` varchar(32) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_admin` int(11) DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `token_user` varchar(255) DEFAULT NULL,
  `site_id` int(11) DEFAULT 0,
  `name` varchar(128) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `email_active_at` timestamp NULL DEFAULT NULL,
  `reg_str` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL,
  `reset_pw` varchar(128) DEFAULT NULL,
  `avatar` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_clouds`
--

CREATE TABLE `user_clouds` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quota_size` bigint(20) DEFAULT NULL,
  `quota_file` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `location_store_file` varchar(256) DEFAULT NULL,
  `glx_bytes_in_used` bigint(20) DEFAULT 0,
  `glx_files_in_used` int(11) DEFAULT 0,
  `quota_daily_download` int(11) DEFAULT NULL,
  `quota_limit_data` int(11) DEFAULT NULL,
  `glx_download_his` text DEFAULT NULL,
  `glx_shell` varchar(50) DEFAULT '/sbin/nologin',
  `glx_uid` int(11) DEFAULT 48,
  `glx_gid` int(11) DEFAULT 48
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `image_list` varchar(256) DEFAULT NULL,
  `log` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `affiliate_logs`
--
ALTER TABLE `affiliate_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `asset_categories`
--
ALTER TABLE `asset_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `block_uis`
--
ALTER TABLE `block_uis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sname` (`sname`);

--
-- Indexes for table `cache_key_value`
--
ALTER TABLE `cache_key_value`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_key_values`
--
ALTER TABLE `cache_key_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`quantity`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `change_logs`
--
ALTER TABLE `change_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tables` (`tables`),
  ADD KEY `id_row` (`id_row`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_id_admin` (`user_id_admin`);

--
-- Indexes for table `cloud_group`
--
ALTER TABLE `cloud_group`
  ADD KEY `groupname` (`groupname`);

--
-- Indexes for table `cloud_servers`
--
ALTER TABLE `cloud_servers`
  ADD UNIQUE KEY `domain` (`domain`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `cloud_transfer`
--
ALTER TABLE `cloud_transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conference_cats`
--
ALTER TABLE `conference_cats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `conference_infos`
--
ALTER TABLE `conference_infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `orders` (`orders`);

--
-- Indexes for table `cost_items`
--
ALTER TABLE `cost_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `crm_app_infos`
--
ALTER TABLE `crm_app_infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `crm_messages`
--
ALTER TABLE `crm_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `chanel_name` (`channel_name`),
  ADD KEY `uid_from` (`uid_from`),
  ADD KEY `id_to` (`id_to`),
  ADD KEY `thread_id` (`thread_id`),
  ADD KEY `type` (`type`),
  ADD KEY `created_at` (`created_at`),
  ADD KEY `msg_id` (`msg_id`),
  ADD KEY `ts` (`ts`);

--
-- Indexes for table `crm_message_groups`
--
ALTER TABLE `crm_message_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gid` (`gid`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `demo_and_tag_tbls`
--
ALTER TABLE `demo_and_tag_tbls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tag_id` (`tag_id`),
  ADD KEY `demo_id` (`demo_id`);

--
-- Indexes for table `demo_folder_tbls`
--
ALTER TABLE `demo_folder_tbls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `demo_sub1s`
--
ALTER TABLE `demo_sub1s`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `demo_tbls`
--
ALTER TABLE `demo_tbls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deleted_at` (`deleted_at`);
ALTER TABLE `demo_tbls` ADD FULLTEXT KEY `tag_list_id` (`tag_list_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `department_events`
--
ALTER TABLE `department_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `department_users`
--
ALTER TABLE `department_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id_2` (`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `don_vi_hanh_chinhs`
--
ALTER TABLE `don_vi_hanh_chinhs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders` (`orders`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `code` (`code`);

--
-- Indexes for table `download_logs`
--
ALTER TABLE `download_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `file_id` (`file_id`),
  ADD KEY `time_download_done` (`time_download_done`),
  ADD KEY `sid_download` (`sid_download`),
  ADD KEY `user_id_file` (`user_id_file`),
  ADD KEY `count_dl` (`count_dl`),
  ADD KEY `file_id_enc` (`file_id_enc`);

--
-- Indexes for table `event_and_users`
--
ALTER TABLE `event_and_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_event_id`),
  ADD KEY `status` (`status`),
  ADD KEY `user_id_2` (`user_id`);

--
-- Indexes for table `event_face_infos`
--
ALTER TABLE `event_face_infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `event_infos`
--
ALTER TABLE `event_infos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id__` (`id__`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `time_start` (`time_start`);

--
-- Indexes for table `event_registers`
--
ALTER TABLE `event_registers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `reg_code` (`reg_code`),
  ADD KEY `user_event_id` (`user_event_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `event_send_actions`
--
ALTER TABLE `event_send_actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `event_send_email_logs`
--
ALTER TABLE `event_send_email_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `event_send_info_logs`
--
ALTER TABLE `event_send_info_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`event_user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `user_id_2` (`user_id`),
  ADD KEY `sms_unique_session` (`sms_unique_session`),
  ADD KEY `content_sms` (`content_sms`(768)),
  ADD KEY `type` (`type`),
  ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `event_send_sms_logs`
--
ALTER TABLE `event_send_sms_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `event_settings`
--
ALTER TABLE `event_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `event_user_groups`
--
ALTER TABLE `event_user_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `event_user_infos`
--
ALTER TABLE `event_user_infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `email` (`email`) USING BTREE,
  ADD KEY `phone` (`phone`);
ALTER TABLE `event_user_infos` ADD FULLTEXT KEY `parent_all` (`parent_all`);
ALTER TABLE `event_user_infos` ADD FULLTEXT KEY `parent_extra` (`parent_extra`);

--
-- Indexes for table `event_user_payments`
--
ALTER TABLE `event_user_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `face_data`
--
ALTER TABLE `face_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `file_clouds`
--
ALTER TABLE `file_clouds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `md5` (`md5`),
  ADD KEY `crc32` (`crc32`),
  ADD KEY `deleted_at` (`deleted_at`);

--
-- Indexes for table `file_refers`
--
ALTER TABLE `file_refers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `remote_url_2` (`remote_url`),
  ADD UNIQUE KEY `remote_id_2` (`remote_id`,`site`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `site` (`site`),
  ADD KEY `remote_id` (`remote_id`),
  ADD KEY `count_dl` (`count_dl`);

--
-- Indexes for table `file_share_permissions`
--
ALTER TABLE `file_share_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `file_uploads`
--
ALTER TABLE `file_uploads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id___2` (`id__`),
  ADD KEY `cloud_id` (`cloud_id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `refer` (`refer`),
  ADD KEY `link1` (`link1`),
  ADD KEY `md5` (`md5`),
  ADD KEY `crc32` (`crc32`),
  ADD KEY `deleted_at` (`deleted_at`);

--
-- Indexes for table `folder_files`
--
ALTER TABLE `folder_files`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id__` (`id__`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `link1` (`link1`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `gia_phas`
--
ALTER TABLE `gia_phas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id__` (`id__`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `child_of_second_married` (`child_of_second_married`),
  ADD KEY `married_with` (`married_with`),
  ADD KEY `orders` (`orders`),
  ADD KEY `tmp_old_id` (`tmp_old_id`),
  ADD KEY `deleted_at` (`deleted_at`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `gia_pha_users`
--
ALTER TABLE `gia_pha_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `deleted_at` (`deleted_at`);

--
-- Indexes for table `hateco_certificates`
--
ALTER TABLE `hateco_certificates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `hr_config_session_org_id_salaries`
--
ALTER TABLE `hr_config_session_org_id_salaries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `org_and_name` (`org_id`,`session_type_id`,`job_title_id`) USING BTREE,
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `org_id` (`org_id`),
  ADD KEY `name` (`name`),
  ADD KEY `job_title_id` (`job_title_id`),
  ADD KEY `session_type_id` (`session_type_id`),
  ADD KEY `orders` (`orders`);

--
-- Indexes for table `hr_contracts`
--
ALTER TABLE `hr_contracts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `hr_demo_time_events`
--
ALTER TABLE `hr_demo_time_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `hr_employees`
--
ALTER TABLE `hr_employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `phone_number` (`phone_number`),
  ADD KEY `admin_this_tree` (`admin_this_tree`);

--
-- Indexes for table `hr_expense_col_mngs`
--
ALTER TABLE `hr_expense_col_mngs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `field` (`field`);

--
-- Indexes for table `hr_extra_cost_employees`
--
ALTER TABLE `hr_extra_cost_employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `month` (`month`);

--
-- Indexes for table `hr_jobs`
--
ALTER TABLE `hr_jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `hr_job_titles`
--
ALTER TABLE `hr_job_titles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `hr_kpi_cldvs`
--
ALTER TABLE `hr_kpi_cldvs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `hr_late_configs`
--
ALTER TABLE `hr_late_configs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `hr_log_tasks`
--
ALTER TABLE `hr_log_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `hr_message_tasks`
--
ALTER TABLE `hr_message_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `hr_org_settings`
--
ALTER TABLE `hr_org_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `org_id` (`org_id`) USING BTREE;

--
-- Indexes for table `hr_org_trees`
--
ALTER TABLE `hr_org_trees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `hr_salaries`
--
ALTER TABLE `hr_salaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `hr_salary_month_users`
--
ALTER TABLE `hr_salary_month_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `month` (`month`);

--
-- Indexes for table `hr_sample_time_events`
--
ALTER TABLE `hr_sample_time_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `cat1` (`cat1`),
  ADD KEY `time_frame` (`time_frame`);

--
-- Indexes for table `hr_session_types`
--
ALTER TABLE `hr_session_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `desc_short` (`desc`),
  ADD KEY `name_2` (`name`);

--
-- Indexes for table `hr_tasks`
--
ALTER TABLE `hr_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `user_id_get` (`user_id_get`);

--
-- Indexes for table `hr_time_sheets`
--
ALTER TABLE `hr_time_sheets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `org_id` (`org_id`);

--
-- Indexes for table `hr_user_expenses`
--
ALTER TABLE `hr_user_expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `cat1` (`cat1`),
  ADD KEY `time_frame` (`time_frame`);

--
-- Indexes for table `log_users`
--
ALTER TABLE `log_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `media_actors`
--
ALTER TABLE `media_actors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `media_authors`
--
ALTER TABLE `media_authors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `media_cats`
--
ALTER TABLE `media_cats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `media_folders`
--
ALTER TABLE `media_folders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `media_items`
--
ALTER TABLE `media_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `parent_id` (`parent_id`);
ALTER TABLE `media_items` ADD FULLTEXT KEY `parent_list` (`parent_list`);
ALTER TABLE `media_items` ADD FULLTEXT KEY `parent_extra` (`parent_extra`);
ALTER TABLE `media_items` ADD FULLTEXT KEY `parent_all` (`parent_all`);

--
-- Indexes for table `media_links`
--
ALTER TABLE `media_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `media_id` (`media_id`);

--
-- Indexes for table `media_vendors`
--
ALTER TABLE `media_vendors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `members_members`
--
ALTER TABLE `members_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_trees`
--
ALTER TABLE `menu_trees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_news` (`id_news`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_meta_infos`
--
ALTER TABLE `model_meta_infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `table_name_model` (`table_name_model`),
  ADD KEY `field` (`field`);

--
-- Indexes for table `money_and_tags`
--
ALTER TABLE `money_and_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `money_logs`
--
ALTER TABLE `money_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `money_tags`
--
ALTER TABLE `money_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monitor_items`
--
ALTER TABLE `monitor_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `my_documents`
--
ALTER TABLE `my_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `file_list` (`file_list`(768));
ALTER TABLE `my_documents` ADD FULLTEXT KEY `parent_list` (`parent_list`);
ALTER TABLE `my_documents` ADD FULLTEXT KEY `parent_extra` (`parent_extra`);
ALTER TABLE `my_documents` ADD FULLTEXT KEY `parent_all` (`parent_all`);

--
-- Indexes for table `my_document_cats`
--
ALTER TABLE `my_document_cats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `my_tree_infos`
--
ALTER TABLE `my_tree_infos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tree_id` (`tree_id`) USING BTREE,
  ADD UNIQUE KEY `id__` (`id__`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `deleted_at` (`deleted_at`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `network_marketings`
--
ALTER TABLE `network_marketings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_at` (`created_at`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `orders` (`orders`),
  ADD KEY `options` (`options`),
  ADD KEY `status` (`status`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `news_folders`
--
ALTER TABLE `news_folders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `front` (`front`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `ocr_images`
--
ALTER TABLE `ocr_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_infos`
--
ALTER TABLE `order_infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `transaction_id_local` (`transaction_id_local`),
  ADD KEY `transaction_id_remote` (`transaction_id_remote`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `bill_id` (`order_id`),
  ADD KEY `deleted_at` (`deleted_at`);

--
-- Indexes for table `order_ships`
--
ALTER TABLE `order_ships`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vendor and id` (`vendor_id`,`remote_label`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `vendor_id` (`vendor_id`),
  ADD KEY `remote_id` (`remote_tracking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `remote_label` (`remote_label`);

--
-- Indexes for table `partner_infos`
--
ALTER TABLE `partner_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `pay_moneylogs`
--
ALTER TABLE `pay_moneylogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`route_name_code`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `plan_defines`
--
ALTER TABLE `plan_defines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `plan_define_values`
--
ALTER TABLE `plan_define_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `plan_names`
--
ALTER TABLE `plan_names`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders` (`orders`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `created_at` (`created_at`),
  ADD KEY `status` (`status`),
  ADD KEY `type` (`type`);
ALTER TABLE `products` ADD FULLTEXT KEY `parent_extra` (`parent_extra`);
ALTER TABLE `products` ADD FULLTEXT KEY `parent_all` (`parent_all`);

--
-- Indexes for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_folders`
--
ALTER TABLE `product_folders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `orders` (`orders`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `front` (`front`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_tags`
--
ALTER TABLE `product_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_usages`
--
ALTER TABLE `product_usages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE_product_id_name` (`product_id`,`name`);

--
-- Indexes for table `product_variant_options`
--
ALTER TABLE `product_variant_options`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE_product_variant_id_name` (`product_variant_id`,`name`);

--
-- Indexes for table `quiz_choices`
--
ALTER TABLE `quiz_choices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `quiz_classes`
--
ALTER TABLE `quiz_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `quiz_flash_cards`
--
ALTER TABLE `quiz_flash_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `quiz_folders`
--
ALTER TABLE `quiz_folders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `refer` (`refer`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `deleted_at` (`deleted_at`);
ALTER TABLE `quiz_questions` ADD FULLTEXT KEY `parent_list` (`parent_list`);

--
-- Indexes for table `quiz_session_info_tests`
--
ALTER TABLE `quiz_session_info_tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `quiz_tests`
--
ALTER TABLE `quiz_tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `quiz_test_questions`
--
ALTER TABLE `quiz_test_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_id` (`test_id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `quiz_user_and_tests`
--
ALTER TABLE `quiz_user_and_tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`),
  ADD KEY `test_id` (`test_id`),
  ADD KEY `session_id` (`session_id`);

--
-- Indexes for table `quiz_user_answers`
--
ALTER TABLE `quiz_user_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `test_id` (`test_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `quiz_user_classes`
--
ALTER TABLE `quiz_user_classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);
ALTER TABLE `quiz_user_classes` ADD FULLTEXT KEY `parent_list` (`parent_list`);

--
-- Indexes for table `rand_table`
--
ALTER TABLE `rand_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rand` (`rand`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `site_mngs`
--
ALTER TABLE `site_mngs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `domain` (`domain`),
  ADD KEY `domain1` (`domain1`),
  ADD KEY `domain2` (`domain2`);

--
-- Indexes for table `skus`
--
ALTER TABLE `skus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `skus_product_id_products_id_idx` (`product_id`);
ALTER TABLE `skus` ADD FULLTEXT KEY `product_opt_list` (`product_opt_list`);

--
-- Indexes for table `skus_product_variant_options`
--
ALTER TABLE `skus_product_variant_options`
  ADD PRIMARY KEY (`sku_id`,`product_variant_options_id`,`product_variant_id`),
  ADD UNIQUE KEY `UNIQUE_sku_id_product_variant_id` (`sku_id`,`product_variant_id`),
  ADD KEY `spvo_product_variant_options_id_pro_idx` (`product_variant_options_id`),
  ADD KEY `spvo_product_variant_id_product_var_idx` (`product_variant_id`),
  ADD KEY `id1` (`id`);

--
-- Indexes for table `spendings`
--
ALTER TABLE `spendings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tag_demos`
--
ALTER TABLE `tag_demos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_infos`
--
ALTER TABLE `task_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `telesales`
--
ALTER TABLE `telesales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `print_status` (`print_status`);

--
-- Indexes for table `telescope_entries`
--
ALTER TABLE `telescope_entries`
  ADD PRIMARY KEY (`sequence`),
  ADD UNIQUE KEY `telescope_entries_uuid_unique` (`uuid`),
  ADD KEY `telescope_entries_batch_id_index` (`batch_id`),
  ADD KEY `telescope_entries_family_hash_index` (`family_hash`),
  ADD KEY `telescope_entries_created_at_index` (`created_at`),
  ADD KEY `telescope_entries_type_should_display_on_index_index` (`type`,`should_display_on_index`);

--
-- Indexes for table `telescope_entries_tags`
--
ALTER TABLE `telescope_entries_tags`
  ADD PRIMARY KEY (`entry_uuid`,`tag`),
  ADD KEY `telescope_entries_tags_tag_index` (`tag`);

--
-- Indexes for table `telescope_monitoring`
--
ALTER TABLE `telescope_monitoring`
  ADD PRIMARY KEY (`tag`);

--
-- Indexes for table `test_mongo1s`
--
ALTER TABLE `test_mongo1s`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `tmp_download_sessions`
--
ALTER TABLE `tmp_download_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `token` (`token`),
  ADD KEY `fid` (`fid`),
  ADD KEY `deleted_at` (`deleted_at`);

--
-- Indexes for table `todo2s`
--
ALTER TABLE `todo2s`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transport_infos`
--
ALTER TABLE `transport_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tree_mng_col_fixes`
--
ALTER TABLE `tree_mng_col_fixes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `node and pid` (`node_id`,`pid`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `typing_lessons`
--
ALTER TABLE `typing_lessons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lesson` (`lesson`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `typing_test_results`
--
ALTER TABLE `typing_test_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `uploader_infos`
--
ALTER TABLE `uploader_infos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `id__` (`id__`),
  ADD KEY `reset_pw` (`reset_pw`),
  ADD KEY `reg_str` (`reg_str`),
  ADD KEY `token_user` (`token_user`);

--
-- Indexes for table `user_clouds`
--
ALTER TABLE `user_clouds`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `deleted_at` (`deleted_at`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `affiliate_logs`
--
ALTER TABLE `affiliate_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asset_categories`
--
ALTER TABLE `asset_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `block_uis`
--
ALTER TABLE `block_uis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `change_logs`
--
ALTER TABLE `change_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cloud_servers`
--
ALTER TABLE `cloud_servers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cloud_transfer`
--
ALTER TABLE `cloud_transfer`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conference_cats`
--
ALTER TABLE `conference_cats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conference_infos`
--
ALTER TABLE `conference_infos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cost_items`
--
ALTER TABLE `cost_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crm_app_infos`
--
ALTER TABLE `crm_app_infos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crm_messages`
--
ALTER TABLE `crm_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crm_message_groups`
--
ALTER TABLE `crm_message_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `demo_and_tag_tbls`
--
ALTER TABLE `demo_and_tag_tbls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `demo_folder_tbls`
--
ALTER TABLE `demo_folder_tbls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `demo_sub1s`
--
ALTER TABLE `demo_sub1s`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `demo_tbls`
--
ALTER TABLE `demo_tbls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department_events`
--
ALTER TABLE `department_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department_users`
--
ALTER TABLE `department_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `don_vi_hanh_chinhs`
--
ALTER TABLE `don_vi_hanh_chinhs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `download_logs`
--
ALTER TABLE `download_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_and_users`
--
ALTER TABLE `event_and_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_face_infos`
--
ALTER TABLE `event_face_infos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_infos`
--
ALTER TABLE `event_infos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_registers`
--
ALTER TABLE `event_registers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_send_actions`
--
ALTER TABLE `event_send_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_send_email_logs`
--
ALTER TABLE `event_send_email_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_send_info_logs`
--
ALTER TABLE `event_send_info_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_send_sms_logs`
--
ALTER TABLE `event_send_sms_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_settings`
--
ALTER TABLE `event_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_user_groups`
--
ALTER TABLE `event_user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_user_infos`
--
ALTER TABLE `event_user_infos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_user_payments`
--
ALTER TABLE `event_user_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `face_data`
--
ALTER TABLE `face_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file_refers`
--
ALTER TABLE `file_refers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file_share_permissions`
--
ALTER TABLE `file_share_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `file_uploads`
--
ALTER TABLE `file_uploads`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `folder_files`
--
ALTER TABLE `folder_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gia_phas`
--
ALTER TABLE `gia_phas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gia_pha_users`
--
ALTER TABLE `gia_pha_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hateco_certificates`
--
ALTER TABLE `hateco_certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hr_config_session_org_id_salaries`
--
ALTER TABLE `hr_config_session_org_id_salaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hr_contracts`
--
ALTER TABLE `hr_contracts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hr_demo_time_events`
--
ALTER TABLE `hr_demo_time_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hr_employees`
--
ALTER TABLE `hr_employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hr_expense_col_mngs`
--
ALTER TABLE `hr_expense_col_mngs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hr_extra_cost_employees`
--
ALTER TABLE `hr_extra_cost_employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hr_jobs`
--
ALTER TABLE `hr_jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hr_job_titles`
--
ALTER TABLE `hr_job_titles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hr_kpi_cldvs`
--
ALTER TABLE `hr_kpi_cldvs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hr_late_configs`
--
ALTER TABLE `hr_late_configs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hr_log_tasks`
--
ALTER TABLE `hr_log_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hr_message_tasks`
--
ALTER TABLE `hr_message_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hr_org_settings`
--
ALTER TABLE `hr_org_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hr_org_trees`
--
ALTER TABLE `hr_org_trees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hr_salaries`
--
ALTER TABLE `hr_salaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hr_salary_month_users`
--
ALTER TABLE `hr_salary_month_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hr_sample_time_events`
--
ALTER TABLE `hr_sample_time_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hr_session_types`
--
ALTER TABLE `hr_session_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hr_tasks`
--
ALTER TABLE `hr_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hr_time_sheets`
--
ALTER TABLE `hr_time_sheets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hr_user_expenses`
--
ALTER TABLE `hr_user_expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_users`
--
ALTER TABLE `log_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media_actors`
--
ALTER TABLE `media_actors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media_authors`
--
ALTER TABLE `media_authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media_cats`
--
ALTER TABLE `media_cats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media_folders`
--
ALTER TABLE `media_folders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media_items`
--
ALTER TABLE `media_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media_links`
--
ALTER TABLE `media_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media_vendors`
--
ALTER TABLE `media_vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `members_members`
--
ALTER TABLE `members_members`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_trees`
--
ALTER TABLE `menu_trees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `model_meta_infos`
--
ALTER TABLE `model_meta_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `money_and_tags`
--
ALTER TABLE `money_and_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `money_logs`
--
ALTER TABLE `money_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `money_tags`
--
ALTER TABLE `money_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `monitor_items`
--
ALTER TABLE `monitor_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `my_documents`
--
ALTER TABLE `my_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `my_document_cats`
--
ALTER TABLE `my_document_cats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `my_tree_infos`
--
ALTER TABLE `my_tree_infos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `network_marketings`
--
ALTER TABLE `network_marketings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news_folders`
--
ALTER TABLE `news_folders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ocr_images`
--
ALTER TABLE `ocr_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_infos`
--
ALTER TABLE `order_infos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_ships`
--
ALTER TABLE `order_ships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `partner_infos`
--
ALTER TABLE `partner_infos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pay_moneylogs`
--
ALTER TABLE `pay_moneylogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plan_defines`
--
ALTER TABLE `plan_defines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plan_define_values`
--
ALTER TABLE `plan_define_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plan_names`
--
ALTER TABLE `plan_names`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_attributes`
--
ALTER TABLE `product_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_folders`
--
ALTER TABLE `product_folders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_tags`
--
ALTER TABLE `product_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_usages`
--
ALTER TABLE `product_usages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_variant_options`
--
ALTER TABLE `product_variant_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_choices`
--
ALTER TABLE `quiz_choices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_classes`
--
ALTER TABLE `quiz_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_flash_cards`
--
ALTER TABLE `quiz_flash_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_folders`
--
ALTER TABLE `quiz_folders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_session_info_tests`
--
ALTER TABLE `quiz_session_info_tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_tests`
--
ALTER TABLE `quiz_tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_test_questions`
--
ALTER TABLE `quiz_test_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_user_and_tests`
--
ALTER TABLE `quiz_user_and_tests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_user_answers`
--
ALTER TABLE `quiz_user_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_user_classes`
--
ALTER TABLE `quiz_user_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rand_table`
--
ALTER TABLE `rand_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_mngs`
--
ALTER TABLE `site_mngs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `skus`
--
ALTER TABLE `skus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `skus_product_variant_options`
--
ALTER TABLE `skus_product_variant_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spendings`
--
ALTER TABLE `spendings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tag_demos`
--
ALTER TABLE `tag_demos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_infos`
--
ALTER TABLE `task_infos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `telescope_entries`
--
ALTER TABLE `telescope_entries`
  MODIFY `sequence` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_mongo1s`
--
ALTER TABLE `test_mongo1s`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tmp_download_sessions`
--
ALTER TABLE `tmp_download_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `todo2s`
--
ALTER TABLE `todo2s`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transport_infos`
--
ALTER TABLE `transport_infos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tree_mng_col_fixes`
--
ALTER TABLE `tree_mng_col_fixes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `typing_lessons`
--
ALTER TABLE `typing_lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `typing_test_results`
--
ALTER TABLE `typing_test_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uploader_infos`
--
ALTER TABLE `uploader_infos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_clouds`
--
ALTER TABLE `user_clouds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `demo_and_tag_tbls`
--
ALTER TABLE `demo_and_tag_tbls`
  ADD CONSTRAINT `tag_id_and_demo_id_demo_id_foreign` FOREIGN KEY (`demo_id`) REFERENCES `demo_tbls` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tag_id_and_demo_id_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tag_demos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_product_id_products_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `product_variant_options`
--
ALTER TABLE `product_variant_options`
  ADD CONSTRAINT `product_variant_options_product_variant_id_product_variants_id` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `skus`
--
ALTER TABLE `skus`
  ADD CONSTRAINT `skus_product_id_products_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `skus_product_variant_options`
--
ALTER TABLE `skus_product_variant_options`
  ADD CONSTRAINT `skus_product_variant_options_sku_id_skus_id` FOREIGN KEY (`sku_id`) REFERENCES `skus` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `spvo_product_variant_id_product_variants_id` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `spvo_product_variant_options_id_product_variant_options_id` FOREIGN KEY (`product_variant_options_id`) REFERENCES `product_variant_options` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `telescope_entries_tags`
--
ALTER TABLE `telescope_entries_tags`
  ADD CONSTRAINT `telescope_entries_tags_entry_uuid_foreign` FOREIGN KEY (`entry_uuid`) REFERENCES `telescope_entries` (`uuid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
