-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 13, 2017 at 09:55 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hautestep`
--

-- --------------------------------------------------------

--
-- Table structure for table `hs_analyse`
--

CREATE TABLE `hs_analyse` (
  `analyse_id` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `country` varchar(255) NOT NULL,
  `pages` varchar(255) NOT NULL,
  `referer` varchar(255) NOT NULL,
  `url` mediumtext NOT NULL,
  `isoCode` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `browser_version` varchar(255) NOT NULL,
  `browser_name` varchar(255) NOT NULL,
  `browser_platform` varchar(255) NOT NULL,
  `device` int(11) NOT NULL,
  `device_name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hs_analyse`
--

INSERT INTO `hs_analyse` (`analyse_id`, `ip`, `date`, `country`, `pages`, `referer`, `url`, `isoCode`, `city`, `state`, `postal_code`, `browser_version`, `browser_name`, `browser_platform`, `device`, `device_name`, `created_at`, `updated_at`) VALUES
(1, '::1', '2017-12-06 00:00:00', 'United States', '4', 'http://localhost/communityforum/public/notification', 'http://localhost/communityforum/public/topic/details/103', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-06 14:45:25', '2017-12-06 14:45:25'),
(2, '::1', '2017-12-06 00:00:00', 'United States', '4', 'http://localhost/communityforum/public/notification', 'http://localhost/communityforum/public/topic/details/103', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-06 14:45:25', '2017-12-06 14:45:25'),
(3, '::1', '2017-12-06 00:00:00', 'United States', '0', '-', 'http://localhost/communityforum/public/pages/join-us', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-06 15:17:32', '2017-12-06 15:17:32'),
(4, '::1', '2017-12-06 00:00:00', 'United States', '0', 'http://localhost/communityforum/public/', 'http://localhost/communityforum/public', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Ubuntu', 0, 'WebKit', '2017-12-06 15:17:57', '2017-12-06 15:17:57'),
(5, '::1', '2017-12-06 00:00:00', 'United States', '4', '-', 'http://localhost/communityforum/public/topic/details/654', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-06 15:24:57', '2017-12-06 15:24:57'),
(6, '::1', '2017-12-06 00:00:00', 'United States', '4', '-', 'http://localhost/communityforum/public/topic/details/654', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-06 15:26:04', '2017-12-06 15:26:04'),
(7, '::1', '2017-12-06 00:00:00', 'United States', '4', '-', 'http://localhost/communityforum/public/topic/details/6', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-06 15:26:06', '2017-12-06 15:26:06'),
(8, '::1', '2017-12-06 00:00:00', 'United States', '4', '-', 'http://localhost/communityforum/public/topic/details/2', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-06 15:26:11', '2017-12-06 15:26:11'),
(9, '::1', '2017-12-06 00:00:00', 'United States', '0', '-', 'http://localhost/communityforum/public', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-06 15:26:16', '2017-12-06 15:26:16'),
(10, '::1', '2017-12-06 00:00:00', 'United States', '4', 'http://localhost/communityforum/public/', 'http://localhost/communityforum/public/topic/details/8', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-06 15:26:19', '2017-12-06 15:26:19'),
(11, '::1', '2017-12-06 00:00:00', 'United States', '0', 'http://localhost/communityforum/public/admin/dashboard', 'http://localhost/communityforum/public', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-06 16:06:49', '2017-12-06 16:06:49'),
(12, '::1', '2017-12-06 00:00:00', 'United States', '2', 'http://localhost/communityforum/public/', 'http://localhost/communityforum/public/new-signup', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-06 16:06:51', '2017-12-06 16:06:51'),
(13, '::1', '2017-12-06 00:00:00', 'United States', '4', 'http://localhost/communityforum/public/', 'http://localhost/communityforum/public/topic/details/8', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-06 16:12:56', '2017-12-06 16:12:56'),
(14, '::1', '2017-12-06 00:00:00', 'United States', '4', 'http://localhost/communityforum/public/', 'http://localhost/communityforum/public/topic/details/8', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-06 16:12:56', '2017-12-06 16:12:56'),
(15, '::1', '2017-12-06 00:00:00', 'United States', '0', 'http://localhost/hautestep/', 'http://localhost/hautestep/public', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-06 17:49:39', '2017-12-06 17:49:39'),
(16, '::1', '2017-12-06 00:00:00', 'United States', '0', '-', 'http://localhost/hautestep/public', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-06 18:14:26', '2017-12-06 18:14:26'),
(17, '::1', '2017-12-06 00:00:00', 'United States', '0', 'http://localhost/hautestep/public/admin/users', 'http://localhost/hautestep/public', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-06 19:28:21', '2017-12-06 19:28:21'),
(18, '::1', '2017-12-06 00:00:00', 'United States', '1', 'http://localhost/hautestep/public/', 'http://localhost/hautestep/public/login', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-06 19:39:47', '2017-12-06 19:39:47'),
(19, '::1', '2017-12-06 00:00:00', 'United States', '2', 'http://localhost/hautestep/public/login', 'http://localhost/hautestep/public/new-signup', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-06 19:39:55', '2017-12-06 19:39:55'),
(20, '127.0.0.1', '2017-12-08 00:00:00', 'United States', '0', '-', 'http://amit.hautestep.my', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-08 11:38:20', '2017-12-08 11:38:20'),
(21, '127.0.0.1', '2017-12-08 00:00:00', 'United States', '1', 'http://amit.hautestep.my/', 'http://amit.hautestep.my/login', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-08 11:38:48', '2017-12-08 11:38:48'),
(22, '127.0.0.1', '2017-12-08 00:00:00', 'United States', '0', 'http://amit.hautestep.my/', 'http://amit.hautestep.my', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-08 12:40:20', '2017-12-08 12:40:20'),
(23, '127.0.0.1', '2017-12-08 00:00:00', 'United States', '1', 'http://amit.hautestep.my/', 'http://amit.hautestep.my/login', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-08 12:40:23', '2017-12-08 12:40:23'),
(24, '127.0.0.1', '2017-12-08 00:00:00', 'United States', '0', 'http://amit.hautestep.my/', 'http://amit.hautestep.my', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-08 12:40:37', '2017-12-08 12:40:37'),
(25, '127.0.0.1', '2017-12-08 00:00:00', 'United States', '0', '-', 'http://amit.hautestep.my', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-08 18:43:25', '2017-12-08 18:43:25'),
(26, '127.0.0.1', '2017-12-08 00:00:00', 'United States', '0', 'http://amit.hautestep.my/', 'http://amit.hautestep.my', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-08 18:43:33', '2017-12-08 18:43:33'),
(27, '127.0.0.1', '2017-12-08 00:00:00', 'United States', '1', 'http://amit.hautestep.my/', 'http://amit.hautestep.my/login', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-08 18:43:35', '2017-12-08 18:43:35'),
(28, '127.0.0.1', '2017-12-08 00:00:00', 'United States', '2', 'http://amit.hautestep.my/login', 'http://amit.hautestep.my/new-signup', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-08 18:43:41', '2017-12-08 18:43:41'),
(29, '::1', '2017-12-09 00:00:00', 'United States', '0', '-', 'http://localhost/hautestep/public', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-09 11:38:31', '2017-12-09 11:38:31'),
(30, '::1', '2017-12-09 00:00:00', 'United States', '1', 'http://localhost/hautestep/public/', 'http://localhost/hautestep/public/login', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-09 11:38:51', '2017-12-09 11:38:51'),
(31, '::1', '2017-12-09 00:00:00', 'United States', '2', 'http://localhost/hautestep/public/login', 'http://localhost/hautestep/public/new-signup', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-09 11:38:55', '2017-12-09 11:38:55'),
(32, '::1', '2017-12-09 00:00:00', 'United States', '0', 'http://localhost/hautestep/public/', 'http://localhost/hautestep/public', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-09 12:39:02', '2017-12-09 12:39:02'),
(33, '::1', '2017-12-09 00:00:00', 'United States', '2', 'http://localhost/hautestep/public/', 'http://localhost/hautestep/public/new-signup', 'US', 'New Haven', 'CT', '06510', '62.0.3202.94', 'Chrome', 'Linux', 0, 'WebKit', '2017-12-09 12:39:05', '2017-12-09 12:39:05');

-- --------------------------------------------------------

--
-- Table structure for table `hs_banners`
--

CREATE TABLE `hs_banners` (
  `banner_id` int(11) NOT NULL,
  `banner_title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `banner_sub_title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `banner_desc` longtext CHARACTER SET latin1,
  `banner_image` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `lang_id` int(11) NOT NULL DEFAULT '0',
  `counter` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hs_banners`
--

INSERT INTO `hs_banners` (`banner_id`, `banner_title`, `banner_sub_title`, `banner_desc`, `banner_image`, `created_at`, `updated_at`, `status`, `lang_id`, `counter`) VALUES
(1, 'Banner one', NULL, '&lt;p&gt;Banner one&lt;/p&gt;\n', '1512992055_33349.jpeg', '2017-12-11 10:02:06', '2017-12-11 11:34:15', 1, 0, 0),
(2, 'Banner 2', NULL, '&lt;p&gt;BAnner two&lt;/p&gt;\n', '1512990072_54686.jpeg', '2017-12-11 11:01:12', '2017-12-11 11:01:12', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `hs_categories`
--

CREATE TABLE `hs_categories` (
  `category_id` int(11) NOT NULL,
  `category_title` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `category_desc` longtext CHARACTER SET latin1,
  `category_image` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hs_categories`
--

INSERT INTO `hs_categories` (`category_id`, `category_title`, `category_desc`, `category_image`, `created_at`, `updated_at`, `status`) VALUES
(2, 'Category 1', '&lt;p&gt;test&lt;/p&gt;\n', '1513064348_19185.jpg', '2017-12-12 07:39:08', '2017-12-12 07:39:08', 1);

-- --------------------------------------------------------

--
-- Table structure for table `hs_comments`
--

CREATE TABLE `hs_comments` (
  `comment_id` int(11) NOT NULL,
  `comment_key` varchar(255) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment_message` longtext NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(4) NOT NULL,
  `lang_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hs_comments`
--

INSERT INTO `hs_comments` (`comment_id`, `comment_key`, `post_id`, `comment_message`, `user_id`, `created_at`, `updated_at`, `status`, `lang_id`) VALUES
(1, '6824257e0153c8dd047cbc1cc3d97990', 1, 'this is my first comments', 12, '2016-08-31 05:48:16', '2016-08-31 05:48:16', 1, 1),
(2, '50b4e7d68fcac2c2b5e91ca8292fc701', 1, 'sdfsf', 13, '2016-08-31 05:48:38', '2017-12-08 14:40:24', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hs_config`
--

CREATE TABLE `hs_config` (
  `config_id` int(11) NOT NULL,
  `config_key` varchar(255) CHARACTER SET latin1 NOT NULL,
  `def_key` varchar(255) CHARACTER SET latin1 NOT NULL,
  `def_value` varchar(255) CHARACTER SET latin1 NOT NULL,
  `status` tinyint(4) NOT NULL,
  `is_static` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hs_config`
--

INSERT INTO `hs_config` (`config_id`, `config_key`, `def_key`, `def_value`, `status`, `is_static`, `created_at`, `updated_at`) VALUES
(43, 'dft2435345fd', 'website_title', 'Hautestep', 1, 1, '0000-00-00 00:00:00', '2015-12-22 06:06:39'),
(44, '234324sdasfds', 'google_plus_link', 'http://www.google.com', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(45, 'fgf54h5f64h5f4h5gf6h', 'facebook_link', 'social_facebook_link', 1, 1, '0000-00-00 00:00:00', '2015-12-21 10:28:37'),
(53, 'hgf4hfgh4fghfghfg89h7', 'pagination', '10', 1, 1, '2015-12-21 00:00:00', '2016-02-04 07:56:26'),
(54, 'dfsdff4gdfg5dfg5dgdfgdf87gd8g7', 'linked_in_link', 'https://www.linkedin.com/', 1, 1, '2015-12-21 00:00:00', '2015-12-21 00:00:00'),
(55, 'dds45ert87er89t7er9tre7t98er7ter8', 'twitter_link', 'https://twitter.com/', 1, 1, '2015-12-21 00:00:00', '2016-01-28 10:16:22'),
(56, 'sdf5s4df5sfdg7dfg8fd7gfd89g7df8g', 'contact_number', '07314058542', 1, 1, '0000-00-00 00:00:00', '2015-12-21 11:52:07'),
(57, 'fdf4df65df4787v8dre8r78werw897rew', 'admin_email', 'admin@xdeve.com', 1, 1, '2015-12-22 00:00:00', '2016-01-28 09:40:10'),
(58, 'dsfsd34rdsfi890ujskdnjsnf9809u435hfksf', 'no_reply_email', 'no-reply@mailinator.com', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(59, 'dfgd34rweriur984rjfh4', 'help_email', 'help@example.com', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `hs_faqs`
--

CREATE TABLE `hs_faqs` (
  `faq_id` int(11) NOT NULL,
  `faq_title` varchar(255) DEFAULT NULL,
  `faq_description` longtext,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hs_faqs`
--

INSERT INTO `hs_faqs` (`faq_id`, `faq_title`, `faq_description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Faq 1', '&lt;p&gt;&lt;strong&gt;Lorem Ipsum&lt;/strong&gt;&amp;nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&amp;#39;s standard dummy text ever since the 1500s,&amp;nbsp;&lt;/p&gt;\n', 1, '2017-12-12 06:15:00', '2017-12-12 06:15:13');

-- --------------------------------------------------------

--
-- Table structure for table `hs_notifications`
--

CREATE TABLE `hs_notifications` (
  `notification_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `subject` mediumtext CHARACTER SET latin1 NOT NULL,
  `notification` text CHARACTER SET latin1 NOT NULL,
  `is_read` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hs_notifications`
--

INSERT INTO `hs_notifications` (`notification_id`, `from_user_id`, `to_user_id`, `topic_id`, `subject`, `notification`, `is_read`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 73, 135, ' commented on your thread', 'Super Admin react on your About Fashion thread', 1, '2017-12-04 11:44:06', '2017-12-04 11:47:18', '0000-00-00 00:00:00'),
(2, 73, 1, 103, ' commented on your thread', 'rahul nagar react on your Do politicians have personal stylists? thread', 1, '2017-12-04 11:57:34', '2017-12-04 11:58:05', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `hs_pages`
--

CREATE TABLE `hs_pages` (
  `page_id` int(11) NOT NULL,
  `page_title` varchar(255) CHARACTER SET latin1 NOT NULL,
  `page_heading` varchar(255) CHARACTER SET latin1 NOT NULL,
  `page_slug` varchar(255) CHARACTER SET latin1 NOT NULL,
  `page_meta_keywords` varchar(255) CHARACTER SET latin1 NOT NULL,
  `page_meta_description` varchar(255) CHARACTER SET latin1 NOT NULL,
  `page_content` text CHARACTER SET latin1 NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hs_pages`
--

INSERT INTO `hs_pages` (`page_id`, `page_title`, `page_heading`, `page_slug`, `page_meta_keywords`, `page_meta_description`, `page_content`, `status`, `created_at`, `updated_at`) VALUES
(1, '', ' About us', 'about-us', '', '', '&lt;p&gt;&amp;ldquo;Whoneedsfashion.com&amp;rdquo;is the brainchild of us- a diverse, fun loving and a very chatty group of individuals. Some of us are ardent fashion supporters, others not so much. But the one thing that keeps us all together is our habit of unabashedly expressing ourselves. We thought of making this habit contagious and gather other attuned people.&lt;/p&gt;\n\n&lt;p&gt;Whoneedsfashion.com is a one of a kind social experiment in fashion, where we encourage eager and expressive individuals to join in and share their varying ideas and opinions on fashion and style.&lt;/p&gt;\n\n&lt;p&gt;You may not necessarily know the best spring collection of the year or the difference between couture and &amp;lsquo;ready-to-wear&amp;rsquo;, but to us, it doesn&amp;rsquo;t matter. What matters is your personal take on everything and anything related to fashion and style.&lt;/p&gt;\n\n&lt;p&gt;So, whether you are fashion lover, a fashion phobic or anyone in between, we are giving you the freedom to be unapologetically vocal about it. We have built an all-embracingforum for people to think, discover and most importantly be discovered.&lt;/p&gt;\n', 1, '2017-10-04 00:00:00', '2017-10-17 07:32:25'),
(2, '', 'WHO NEEDS FASHION', 'community-rules', '', '', '&lt;h3&gt;COMMUNITY RULES&lt;/h3&gt;\n\n&lt;p&gt;&amp;lsquo;Who Needs Fashion&amp;rsquo; is a progressive, fun-filled and informative discussion platform open to anyone with an opinion on fashion. While we appreciate and encourage freedom of speech, it is nice for all of us to maintain some basic ground rules to respect and maintain the sanctity of this online community.&amp;nbsp;&lt;/p&gt;\n\n&lt;ul&gt;\n	&lt;li&gt;Whoneedsfashion.com is a forum solely dedicated to discussions around the fashion and styling industry. It is necessary therefore to talk about topics only related to the categories specified. Thread topics other than fashion will be monitored by the admin and if not found contextual, will be removed in the best interest of the forum.&lt;/li&gt;\n	&lt;li&gt;While healthy debates are encouraged, offensive language, disrespect directed towards any member and profanity in any form or shape will not be tolerated. It will result in a communication by the moderator and repeated offences will result in suspension of the member&amp;rsquo;s account on the platform.&lt;/li&gt;\n	&lt;li&gt;We have a zero tolerance policy against any sort of bullying or body shaming regardless of age and gender; members or celebrities and public figures.&lt;/li&gt;\n	&lt;li&gt;Any discussion thread leading to flame wars between members will be monitored and deleted or evaluated based on the discretion of the moderators of the forum.&lt;/li&gt;\n	&lt;li&gt;Any form of pornography is not permitted and shall result in blocking of the user account.&lt;/li&gt;\n	&lt;li&gt;Negative discussion topics or comments against celebrities and public figures will not be countenanced.&lt;/li&gt;\n	&lt;li&gt;No political discussions will be allowed or tolerated in any form. This platform welcomes people regardless of their ideologies and views from varying cultures. Any negativity against any nationality, religion, gender, community, caste, creed, mother tongue, ethnicities etc is strictly prohibited.&lt;/li&gt;\n&lt;/ul&gt;\n\n&lt;h3&gt;FORUM REGULATIONS&lt;/h3&gt;\n\n&lt;p&gt;Here are some forum regulations to be remembered by the community members.&lt;/p&gt;\n\n&lt;ul&gt;\n	&lt;li&gt;If a new thread topic is same or similar to an earlier thread topic published, the admin may merge it with the most recent and active thread to avoid redundancy, duplication and empty threads.&lt;/li&gt;\n	&lt;li&gt;A certain discussion thread could be relevant in multiple categories. However, put it in the most relevant category closest to the topic of the thread.&lt;/li&gt;\n	&lt;li&gt;Mention reliable sources and give appropriate credits wherever necessary so that there are no copyright issues. Photographers, designers and journalists deserve to be recognised for their original work.&lt;/li&gt;\n	&lt;li&gt;Please do make sure that the quality of images posted is decently good. Unclear, pixelated, heavy files or images with very low resolution should be avoided.&lt;/li&gt;\n	&lt;li&gt;The primary language of communication on this forum English, for ease of use and understanding. Threads and discussions in Hindi and other regional languages is not recommended.&lt;/li&gt;\n&lt;/ul&gt;\n\n&lt;h3&gt;DISCLAIMER&lt;/h3&gt;\n\n&lt;p&gt;The purpose of this platform is to encourage discussions, interactions and collaborations&lt;/p&gt;\n\n&lt;p&gt;All statements, views, opinions, advices, information etc made available or seen on the forum are the responsibility of the author of the message and not of Whoneedsfashion (except when Whoneedsfashion is clearly specified as the author of the message)&lt;/p&gt;\n\n&lt;p&gt;Whoneedsfashion is not responsible for copyright infringements made by any members or third party resulting from the publication of your content on the forum web site.&lt;/p&gt;\n\n&lt;p&gt;The member shall by virtue of signing into the forum indemnify whoneedsfashion or any of its associates from any breach of copyright or proprietory infringement.&lt;/p&gt;\n', 0, '2017-10-24 00:00:00', '2017-10-25 10:42:35'),
(3, '', 'FAQs', 'faqs', '', '', '&lt;p&gt;Here you can find answers to questions about the forum and how it works. Use the links below or the search box on the homepage to find your way around.&lt;/p&gt;\n\n&lt;div&gt;\n&lt;p&gt;&lt;button&gt;GENERAL&lt;/button&gt;&lt;/p&gt;\n\n&lt;p&gt;&lt;span&gt;&lt;strong&gt;What is WhoNeedsFashion.com? &lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;\n\n&lt;p&gt;&lt;span&gt;&lt;strong&gt;WhoNeedsFashion.com&lt;/strong&gt;&amp;nbsp;is a fashion and style discussion platform where everyone who&amp;rsquo;s anyone can contribute their opinions, ideas and views. As a part of this community, you will get to interact with other members, and stay updated on latest in fashion and trends. This forum is for everyone wishing to contribute, regardless of their take on fashion and style.&lt;/span&gt;&lt;/p&gt;\n\n&lt;p&gt;&lt;span&gt;&lt;strong&gt;How do I become a part of &amp;ldquo;WhoNeedsFashion.com?&amp;rdquo;&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;\n\n&lt;p&gt;&lt;span&gt;To be a part of WhoNeedsFashion.com, you will need to &lt;strong&gt;register&lt;/strong&gt; on the forum. You can register using your Email or Facebook login details on the home page. Choose a unique username and password to complete the registration process.&lt;/span&gt;&lt;/p&gt;\n&lt;/div&gt;\n\n&lt;div&gt;\n&lt;p&gt;&lt;button&gt;THREADS, TOPICS and POSTS&lt;/button&gt;&lt;/p&gt;\n\n&lt;h4&gt;&lt;span&gt;What are threads and topics?&lt;/span&gt;&lt;/h4&gt;\n\n&lt;p&gt;&lt;span&gt;Threads are discussions in different categories started by members of the forum. They are open discussions where everyone is welcome to express their opinions through commenting.&lt;/span&gt;&lt;/p&gt;\n\n&lt;h4&gt;&lt;span&gt;How do I start a new thread?&lt;/span&gt;&lt;/h4&gt;\n\n&lt;p&gt;&lt;span&gt;You can start and post new threads by clicking on &amp;ldquo;Add a topic&amp;rdquo; once you become a registered member of the community.&lt;/span&gt;&lt;/p&gt;\n\n&lt;h4&gt;&lt;span&gt;How do I reply to a comment on my thread or someone else&amp;rsquo;s thread?&lt;/span&gt;&lt;/h4&gt;\n\n&lt;p&gt;&lt;span&gt;The option of reply is on every comment on the thread which allows the user to directly reply to that particular comment.&lt;/span&gt;&lt;/p&gt;\n\n&lt;h4&gt;&lt;span&gt;Can I attach images and videos while posting a new thread or replying to a thread?&lt;/span&gt;&lt;/h4&gt;\n\n&lt;p&gt;&lt;span&gt;Yes. You can attach images (jpeg, png and gif) and youtube links through the attachment icon present on the dialog box.&lt;/span&gt;&lt;/p&gt;\n\n&lt;h4&gt;&lt;span&gt;What are &amp;lsquo;top threads&amp;rsquo;?&lt;/span&gt;&lt;/h4&gt;\n\n&lt;p&gt;&lt;span&gt;Top threads are the most active and popular threads on the forum. You can reply to any of the trending threads by clicking on the thread and replying with &amp;lsquo;Post a Reply&amp;rsquo;&lt;/span&gt;&lt;/p&gt;\n\n&lt;h4&gt;&lt;span&gt;What are recent and featured tabs?&lt;/span&gt;&lt;/h4&gt;\n\n&lt;p&gt;&lt;span&gt;&amp;ldquo;Recent threads are the newest threads on the forum. Featured threads are threads started by our featured members- domain experts, renowned bloggers etc.&lt;/span&gt;&lt;/p&gt;\n\n&lt;h4&gt;&lt;span&gt;How do I look for specific threads or a particular discussion topic?&lt;/span&gt;&lt;/h4&gt;\n\n&lt;p&gt;&lt;span&gt;You can search by keyword, topic name, user name or a hash tag using the search bar on the top of the page. A quick way to also find threads it to browse the forum topics on the right hand side of the home page.&lt;/span&gt;&lt;/p&gt;\n\n&lt;h4&gt;&lt;span&gt;I have a topic in mind, but do not know how to categorise it?&lt;/span&gt;&lt;/h4&gt;\n\n&lt;p&gt;&lt;span&gt;You can put the category for your thread topic according to your discretion. The threads will be posted once they pass moderation. Hence, if the category you put isn&amp;rsquo;t right, the moderators will modify it using their discretion.&lt;/span&gt;&lt;/p&gt;\n\n&lt;h4&gt;&lt;span&gt;How long does a thread stay active?&lt;/span&gt;&lt;/h4&gt;\n\n&lt;p&gt;&lt;span&gt;A thread will stay active for 3 weeks from the date of its commencement.&lt;/span&gt;&lt;/p&gt;\n&lt;/div&gt;\n\n&lt;div&gt;\n&lt;p&gt;&lt;button&gt;POLLS&lt;/button&gt;&lt;/p&gt;\n\n&lt;h4&gt;&lt;span&gt;What are polls?&lt;/span&gt;&lt;/h4&gt;\n\n&lt;p&gt;&lt;span&gt;Polls are questions which are posted on the forum.&lt;/span&gt;&lt;/p&gt;\n\n&lt;h4&gt;&lt;span&gt;How do I vote for polls?&lt;/span&gt;&lt;/h4&gt;\n\n&lt;p&gt;&lt;span&gt;Each poll question has two options. You can click on the option you want and cast your vote.&lt;/span&gt;&lt;/p&gt;\n&lt;/div&gt;\n\n&lt;div&gt;\n&lt;p&gt;&lt;button&gt;SENTIMENT METER&lt;/button&gt;&lt;/p&gt;\n\n&lt;h4&gt;&lt;span&gt;What is the sentiment meter that I see on the on the home page?&lt;/span&gt;&lt;/h4&gt;\n\n&lt;p&gt;&lt;span&gt;The sentiment meter detects the positive and negative sentiment about fashion on the forum based on comment emojis.&lt;/span&gt;&lt;/p&gt;\n&lt;/div&gt;\n\n&lt;div&gt;\n&lt;p&gt;&lt;button&gt;HASHTAG CLOUD&lt;/button&gt;&lt;/p&gt;\n\n&lt;h4&gt;&lt;span&gt;What is the hash tag cloud?&lt;/span&gt;&lt;/h4&gt;\n\n&lt;p&gt;&lt;span&gt;The hash tag cloud shows the trending hash tags in discussion threads. Clicking on the tags will direct you to all the threads under that tag.&lt;/span&gt;&lt;/p&gt;\n&lt;/div&gt;\n\n&lt;div&gt;\n&lt;p&gt;&lt;button&gt;USER RELATED QUESTIONS&lt;/button&gt;&lt;/p&gt;\n\n&lt;h4&gt;&lt;span&gt;Can I add people on my profile?&lt;/span&gt;&lt;/h4&gt;\n\n&lt;p&gt;&lt;span&gt;Once you are registered, you will be automatically notified if your Facebook friends or email contacts are also members on the forum. You can also send requests to other users through the community/users tab or searching a specific username.&lt;/span&gt;&lt;/p&gt;\n\n&lt;h4&gt;&lt;span&gt;Can I become a featured member of the forum?&lt;/span&gt;&lt;/h4&gt;\n\n&lt;p&gt;&lt;span&gt;Featured members are fashion bloggers, domain experts and influencers who have created their niche in the fashion world. Also, once you are a registered member and are actively participating on the forum you can also become a featured member overtime when you have a substantial following.&lt;br /&gt;\nIf you are a domain expert and/or a renowned blogger, then you can collaborate with us directly by writing to us at (insert email id)&lt;/span&gt;&lt;/p&gt;\n\n&lt;h4&gt;&lt;span&gt;Can I edit my profile?&lt;/span&gt;&lt;/h4&gt;\n\n&lt;p&gt;&lt;span&gt;Yes, you can edit and change your display picture as and when you wish to.&lt;br /&gt;\nYour username cannot be changed once registered.&lt;/span&gt;&lt;/p&gt;\n\n&lt;h4&gt;&lt;span&gt;How do I find other members of the community?&lt;/span&gt;&lt;/h4&gt;\n\n&lt;p&gt;&lt;span&gt;The community tab on the upper side of the home page will take you to the database of all the existing members of the community. The search bar allows you to search directly by member&amp;rsquo;s username. You can also find active and online users on the home page.&lt;/span&gt;&lt;/p&gt;\n\n&lt;h4&gt;&lt;span&gt;I do not like some comments or things said on my thread. Can I delete them?&lt;/span&gt;&lt;/h4&gt;\n\n&lt;p&gt;&lt;span&gt;The forum is a free thinking space and everyone is entitled to have their opinion. So it&amp;rsquo;s not possible to delete comments which may differ from your opinion.&lt;/span&gt;&lt;/p&gt;\n\n&lt;h4&gt;&lt;span&gt;I just saw some inappropriate comments on the forum. How can I report them?&lt;/span&gt;&lt;/h4&gt;\n\n&lt;p&gt;&lt;span&gt;You can &amp;lsquo;report abuse&amp;rsquo; inappropriate and abusive comments by clicking on the button which will notify the moderators. Appropriate action will be taken in such cases purely on the discretion of the moderator.&lt;/span&gt;&lt;/p&gt;\n&lt;/div&gt;\n', 1, '2017-10-10 00:00:00', '2017-11-08 12:08:27'),
(4, '', 'Contact Us', 'contact-us', '', '', '&lt;h3&gt;&lt;strong&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit.&lt;/strong&gt;&lt;/h3&gt;\n\n&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis id felis finibus, consectetur urna id, tempus libero. Duis venenatis, metus eget facilisis interdum, tellus magna ullamcorper risus, hendrerit scelerisque lacus massa in augue. Integer a ex eget metus finibus egestas sed nec felis. Proin ut lobortis tellus.&lt;/p&gt;\n\n&lt;ul&gt;\n	&lt;li&gt;Whoneedsfashion.com is a forum solely dedicated to discussions around the fashion and styling industry. It is necessary therefore to talk about topics only related to the categories specified. Thread topics other than fashion will be monitored by the admin and if not found contextual, will be removed in the best interest of the forum.&lt;/li&gt;\n	&lt;li&gt;While healthy debates are encouraged, offensive language, disrespect directed towards any member and profanity in any form or shape will not be tolerated. It will result in a communication by the moderator and repeated offences will result in suspension of the member&amp;rsquo;s account on the platform.&lt;/li&gt;\n	&lt;li&gt;We have a zero tolerance policy against any sort of bullying or body shaming regardless of age and gender; members or celebrities and public figures.&lt;/li&gt;\n	&lt;li&gt;Any discussion thread leading to flame wars between members will be monitored and deleted or evaluated based on the discretion of the moderators of the forum.&lt;/li&gt;\n	&lt;li&gt;Any form of pornography is not permitted and shall result in blocking of the user account.&lt;/li&gt;\n	&lt;li&gt;Negative discussion topics or comments against celebrities and public figures will not be countenanced.&lt;/li&gt;\n	&lt;li&gt;No political discussions will be allowed or tolerated in any form. This platform welcomes people regardless of their ideologies and views from varying cultures. Any negativity against any nationality, religion, gender, community, caste, creed, mother tongue, ethnicities etc is strictly prohibited.&lt;/li&gt;\n&lt;/ul&gt;\n\n&lt;h3&gt;&lt;strong&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit.&lt;/strong&gt;&lt;/h3&gt;\n\n&lt;p&gt;Here are some forum regulations to be remembered by the community members.&lt;/p&gt;\n\n&lt;ul&gt;\n	&lt;li&gt;If a new thread topic is same or similar to an earlier thread topic published, the admin may merge it with the most recent and active thread to avoid redundancy, duplication and empty threads.&lt;/li&gt;\n	&lt;li&gt;A certain discussion thread could be relevant in multiple categories. However, put it in the most relevant category closest to the topic of the thread.&lt;/li&gt;\n	&lt;li&gt;Mention reliable sources and give appropriate credits wherever necessary so that there are no copyright issues. Photographers, designers and journalists deserve to be recognised for their original work.&lt;/li&gt;\n	&lt;li&gt;Please do make sure that the quality of images posted is decently good. Unclear, pixelated, heavy files or images with very low resolution should be avoided.&lt;/li&gt;\n	&lt;li&gt;The primary language of communication on this forum English, for ease of use and understanding. Threads and discussions in Hindi and other regional languages is not recommended.&lt;/li&gt;\n&lt;/ul&gt;\n\n&lt;h3&gt;&lt;strong&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit.&lt;/strong&gt;&lt;/h3&gt;\n\n&lt;p&gt;The purpose of this platform is to encourage discussions, interactions and collaborations&lt;/p&gt;\n\n&lt;p&gt;All statements, views, opinions, advices, information etc made available or seen on the forum are the responsibility of the author of the message and not of Whoneedsfashion (except when Whoneedsfashion is clearly specified as the author of the message)&lt;/p&gt;\n\n&lt;p&gt;Whoneedsfashion is not responsible for copyright infringements made by any members or third party resulting from the publication of your content on the forum web site.&lt;/p&gt;\n\n&lt;p&gt;The member shall by virtue of signing into the forum indemnify whoneedsfashion or any of its associates from any breach of copyright or proprietory infringement.&lt;/p&gt;\n', 1, '2017-10-10 00:00:00', '2017-11-06 11:01:58'),
(5, '', 'Join Us', 'join-us', '', '', '&lt;h4&gt;Create your fashion account. It&amp;#39;s free and only take a minute&lt;/h4&gt;\n', 1, '2017-10-24 00:00:00', '2017-12-06 16:14:02');

-- --------------------------------------------------------

--
-- Table structure for table `hs_permissions`
--

CREATE TABLE `hs_permissions` (
  `permission_id` int(11) NOT NULL,
  `permission_title` varchar(255) CHARACTER SET latin1 NOT NULL,
  `permission_slug` varchar(255) CHARACTER SET latin1 NOT NULL,
  `permission_description` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hs_permissions`
--

INSERT INTO `hs_permissions` (`permission_id`, `permission_title`, `permission_slug`, `permission_description`, `created_at`, `updated_at`) VALUES
(1, 'Common Edit', 'edit', 'Common Edit the data', '0000-00-00 00:00:00', '2015-10-14 10:26:49'),
(2, 'Common Add', 'add', 'Common Add new item', '0000-00-00 00:00:00', '2015-10-14 10:26:35'),
(3, 'Common Delete', 'delete', 'Common Delete Feature for any item or entry', '0000-00-00 00:00:00', '2015-10-14 10:13:33'),
(4, 'Common List', 'list', 'Common List any items or paginate', '0000-00-00 00:00:00', '2015-10-14 10:12:41'),
(5, 'Common view', 'view', 'Common View any item by id can be applicable any where', '0000-00-00 00:00:00', '2015-10-14 10:13:05'),
(8, 'Dashboard page', 'dashboard', 'Dashboard page for admin, staff, customer', '2015-10-14 10:01:00', '2015-10-14 10:01:00'),
(14, 'Users Add', 'users_add', 'Add Users', '2015-10-14 10:50:09', '2015-10-14 10:58:14'),
(15, 'User Edit', 'user_edit', 'Edit User data', '2015-10-14 10:50:26', '2015-10-14 10:57:57'),
(16, 'Users list', 'users_list', 'List Users', '2015-10-14 10:50:45', '2016-09-18 06:24:19'),
(17, 'Users delete', 'users_delete', 'Delete', '2015-10-14 10:51:04', '2015-10-14 10:57:27'),
(20, 'ACL', 'acl', 'ACL', '2015-10-30 08:05:57', '2015-10-30 08:05:57'),
(21, 'Category Management', 'category_management', 'Category Management', '2016-09-18 09:31:12', '2016-09-18 09:31:12'),
(23, 'Project Add ', 'add_project', 'User add project ', '2017-01-16 06:46:57', '2017-01-24 05:15:09'),
(24, 'Project Edit ', 'edit_project', 'User Edit Project', '2017-01-16 06:47:32', '2017-01-24 05:14:50'),
(25, 'Project View', 'view_project', 'User View Project', '2017-01-16 06:49:00', '2017-01-24 05:14:33'),
(26, 'Project Allocate', 'allocate_project', 'Allocate Project', '2017-01-16 06:50:07', '2017-01-24 05:14:13'),
(27, 'Project Delete  ', 'delete_project', 'Delete Project ', '2017-01-16 06:52:21', '2017-01-24 05:13:24'),
(28, 'Discrepancies Add ', 'add_discrepancies', 'Add Discrepancies', '2017-01-16 07:26:01', '2017-01-24 05:16:11'),
(29, 'Discrepancies Edit ', 'edit_discrepancies', 'Edit Discrepancies', '2017-01-16 07:26:25', '2017-01-24 05:16:23'),
(30, 'Discrepancies View ', 'view_discrepancies', 'View Discrepancies', '2017-01-16 07:26:44', '2017-01-24 05:16:34'),
(31, 'Discrepancies Delete ', 'delete_discrepancies', 'Delete Discrepancies', '2017-01-16 07:27:05', '2017-01-24 05:16:50'),
(32, 'Discrepancies Status Change ', 'change_status_discrepancies', 'Change Status of Discrepancies', '2017-01-16 07:27:41', '2017-01-24 05:17:17'),
(33, 'Discrepancies Priority Change  ', 'change_priority_discrepancies', 'Change Priority of Discrepancies', '2017-01-16 07:28:06', '2017-01-24 05:17:43'),
(34, 'Discrepancies Add Notes ', 'add_notes_discrepancies', 'Add Notes to Discrepancies', '2017-01-16 07:28:32', '2017-01-24 05:19:03'),
(35, 'Discrepancies  Document Add', 'add_doc_discrepancies', 'Add Document Discrepancies', '2017-01-16 07:28:54', '2017-01-24 09:02:47'),
(36, 'Discrepancies Edit Notes ', 'edit_notes_discrepancies', 'Edit Notes Discrepancies', '2017-01-19 11:14:54', '2017-01-24 05:19:30'),
(37, 'Discrepancies Delete Notes ', 'delete_notes_discrepancies', 'Delete Notes Discrepancies', '2017-01-19 11:19:25', '2017-01-24 05:19:43'),
(38, 'Discrepancies View Notes ', 'view_notes_discrepancies', 'View Notes Discrepancies', '2017-01-19 11:20:14', '2017-01-24 05:19:57'),
(39, 'Discrepancies Delete Document  ', 'delete_doc_discrepancies', 'Delete Document  Descrepanices', '2017-01-19 11:32:38', '2017-01-24 05:20:38'),
(40, 'Discrepancies View Document', 'view_doc_discrepancies', 'View Document Descrepanices\r\n', '2017-01-19 12:03:46', '2017-01-24 05:20:29'),
(41, 'Discrepancies Edit Document', 'edit_doc_discrepancies', 'Edit Document Descrepanices', '2017-01-19 12:04:56', '2017-01-24 05:20:51'),
(42, 'Discrepancies Change Category', 'change_category_discrepancies', 'Change Category Discrepancies', '2017-01-19 12:11:26', '2017-01-24 05:21:08'),
(43, 'User Edit profile', 'edit_profile', 'User edit his profile', '2017-01-25 09:29:10', '2017-01-25 09:29:10');

-- --------------------------------------------------------

--
-- Table structure for table `hs_permission_role`
--

CREATE TABLE `hs_permission_role` (
  `permission_role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_set` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hs_permission_role`
--

INSERT INTO `hs_permission_role` (`permission_role_id`, `permission_id`, `role_id`, `created_at`, `updated_at`, `is_set`) VALUES
(1, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(3, 2, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(4, 3, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(5, 4, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(6, 5, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(10, 8, 1, '2015-10-14 10:01:00', '2015-10-14 10:01:00', 1),
(45, 14, 1, '2015-10-14 10:50:09', '2015-10-14 10:50:09', 1),
(46, 15, 1, '2015-10-14 10:50:26', '2015-10-14 10:50:26', 1),
(47, 16, 1, '2015-10-14 10:50:45', '2015-10-14 10:50:45', 1),
(48, 17, 1, '2015-10-14 10:51:04', '2015-10-14 10:51:04', 1),
(57, 20, 1, '2015-10-30 08:05:57', '2015-10-30 08:05:57', 1),
(92, 4, 8, '2016-01-28 12:13:15', '2016-09-20 05:20:58', 1),
(93, 5, 8, '2016-01-28 12:13:22', '2016-09-20 05:20:56', 1),
(94, 8, 8, '2016-01-28 12:13:24', '2016-09-20 05:20:53', 1),
(95, 2, 8, '2016-01-28 12:44:53', '2016-09-18 06:24:34', 1),
(96, 3, 8, '2016-02-04 10:56:46', '2016-02-04 10:56:46', 1),
(97, 1, 8, '2016-02-04 10:56:48', '2016-02-04 10:56:48', 1),
(99, 21, 1, '2016-09-18 09:31:12', '2016-09-18 09:31:12', 1),
(102, 21, 8, '2016-09-26 05:08:28', '2017-01-19 12:22:42', 1),
(106, 20, 8, '2016-11-10 08:47:56', '2017-01-19 12:23:33', 0),
(107, 23, 1, '2017-01-16 06:46:57', '2017-01-16 06:46:57', 1),
(108, 24, 1, '2017-01-16 06:47:32', '2017-01-16 06:47:32', 1),
(109, 25, 1, '2017-01-16 06:49:00', '2017-01-16 06:49:00', 1),
(110, 26, 1, '2017-01-16 06:50:07', '2017-01-16 06:50:07', 1),
(111, 27, 1, '2017-01-16 06:52:21', '2017-01-16 06:52:21', 1),
(112, 28, 1, '2017-01-16 07:26:01', '2017-01-16 07:26:01', 1),
(113, 29, 1, '2017-01-16 07:26:25', '2017-01-16 07:26:25', 1),
(114, 30, 1, '2017-01-16 07:26:44', '2017-01-16 07:26:44', 1),
(115, 31, 1, '2017-01-16 07:27:05', '2017-01-16 07:27:05', 1),
(116, 32, 1, '2017-01-16 07:27:41', '2017-01-16 07:27:41', 1),
(117, 33, 1, '2017-01-16 07:28:06', '2017-01-16 07:28:06', 1),
(118, 34, 1, '2017-01-16 07:28:32', '2017-01-16 07:28:32', 1),
(119, 35, 1, '2017-01-16 07:28:54', '2017-01-16 07:28:54', 1),
(120, 28, 8, '2017-01-16 07:54:10', '2017-01-16 07:54:10', 1),
(121, 34, 8, '2017-01-16 07:54:11', '2017-01-24 12:43:41', 0),
(122, 23, 8, '2017-01-16 07:54:11', '2017-01-16 07:54:22', 1),
(123, 26, 8, '2017-01-16 07:54:11', '2017-01-16 07:54:11', 1),
(124, 33, 8, '2017-01-16 07:54:12', '2017-01-19 12:21:37', 0),
(125, 32, 8, '2017-01-16 07:54:13', '2017-01-19 12:22:38', 0),
(133, 31, 8, '2017-01-16 07:54:33', '2017-01-16 07:54:33', 1),
(135, 27, 8, '2017-01-16 07:54:38', '2017-01-16 07:54:38', 1),
(136, 29, 8, '2017-01-16 07:54:38', '2017-01-16 07:54:38', 1),
(139, 24, 8, '2017-01-16 07:54:40', '2017-01-16 07:54:40', 1),
(141, 35, 8, '2017-01-16 07:54:51', '2017-01-24 12:43:48', 0),
(143, 30, 8, '2017-01-16 07:54:55', '2017-01-24 11:07:35', 1),
(145, 25, 8, '2017-01-16 07:54:57', '2017-01-16 07:54:57', 1),
(147, 36, 1, '2017-01-19 11:14:54', '2017-01-19 11:14:54', 1),
(148, 37, 1, '2017-01-19 11:19:25', '2017-01-19 11:19:25', 1),
(149, 38, 1, '2017-01-19 11:20:14', '2017-01-19 11:20:14', 1),
(150, 39, 1, '2017-01-19 11:32:38', '2017-01-19 11:32:38', 1),
(151, 40, 1, '2017-01-19 12:03:46', '2017-01-19 12:03:46', 1),
(152, 41, 1, '2017-01-19 12:04:56', '2017-01-19 12:04:56', 1),
(153, 42, 1, '2017-01-19 12:11:26', '2017-01-19 12:11:26', 1),
(154, 40, 8, '2017-01-19 12:24:01', '2017-01-24 12:42:32', 1),
(156, 38, 8, '2017-01-19 12:41:26', '2017-01-24 12:42:32', 1),
(175, 8, 17, '2017-01-25 06:38:42', '2017-01-25 09:23:37', 1),
(176, 23, 17, '2017-01-25 06:38:42', '2017-01-25 10:06:50', 0),
(177, 25, 17, '2017-01-25 06:38:43', '2017-01-25 09:33:45', 1),
(178, 30, 17, '2017-01-25 06:38:43', '2017-01-25 10:11:01', 1),
(179, 8, 18, '2017-01-25 06:39:05', '2017-01-25 06:39:05', 1),
(180, 23, 18, '2017-01-25 06:39:05', '2017-01-25 06:39:05', 1),
(181, 25, 18, '2017-01-25 06:39:05', '2017-01-25 06:39:05', 1),
(182, 30, 18, '2017-01-25 06:39:05', '2017-01-25 06:39:05', 1),
(183, 21, 17, '2017-01-25 06:39:43', '2017-01-25 08:59:48', 0),
(184, 24, 17, '2017-01-25 07:11:28', '2017-01-25 09:35:05', 1),
(185, 26, 17, '2017-01-25 07:20:20', '2017-01-25 10:01:23', 1),
(186, 27, 17, '2017-01-25 07:37:52', '2017-01-25 09:57:52', 1),
(187, 16, 17, '2017-01-25 07:44:16', '2017-01-25 10:42:01', 0),
(188, 17, 17, '2017-01-25 07:44:44', '2017-01-25 09:32:07', 1),
(189, 14, 8, '2017-01-25 08:26:43', '2017-01-25 08:26:43', 1),
(190, 14, 17, '2017-01-25 08:26:57', '2017-01-25 09:32:19', 1),
(191, 15, 17, '2017-01-25 08:27:23', '2017-01-25 09:33:04', 1),
(192, 38, 17, '2017-01-25 08:31:24', '2017-01-25 10:19:06', 1),
(193, 35, 17, '2017-01-25 08:32:15', '2017-01-25 08:44:38', 0),
(194, 28, 17, '2017-01-25 08:41:57', '2017-01-25 09:22:25', 0),
(195, 40, 17, '2017-01-25 08:44:05', '2017-01-25 10:19:11', 1),
(196, 42, 17, '2017-01-25 08:53:06', '2017-01-25 09:22:26', 0),
(197, 36, 17, '2017-01-25 08:57:01', '2017-01-25 10:17:59', 1),
(198, 33, 17, '2017-01-25 08:57:25', '2017-01-25 10:16:34', 1),
(199, 41, 17, '2017-01-25 08:58:20', '2017-01-25 08:58:27', 0),
(200, 29, 17, '2017-01-25 08:58:32', '2017-01-25 10:18:25', 1),
(201, 43, 1, '2017-01-25 09:29:10', '2017-01-25 09:29:10', 1),
(202, 43, 17, '2017-01-25 09:32:27', '2017-01-25 09:32:27', 1),
(203, 43, 8, '2017-01-25 09:45:11', '2017-01-25 09:45:24', 0),
(204, 43, 18, '2017-01-25 09:45:12', '2017-01-25 09:45:26', 0),
(205, 32, 17, '2017-01-25 10:16:10', '2017-01-25 10:16:10', 1),
(206, 16, 18, '2017-01-25 10:39:38', '2017-01-25 10:39:38', 1);

-- --------------------------------------------------------

--
-- Table structure for table `hs_posts`
--

CREATE TABLE `hs_posts` (
  `post_id` int(11) NOT NULL,
  `post_key` varchar(255) CHARACTER SET latin1 NOT NULL,
  `post_author` varchar(255) CHARACTER SET latin1 NOT NULL,
  `post_title` varchar(255) CHARACTER SET latin1 NOT NULL,
  `post_sub_title` varchar(255) CHARACTER SET latin1 NOT NULL,
  `post_desc` longtext CHARACTER SET latin1 NOT NULL,
  `post_youtube_video_url` varchar(255) CHARACTER SET latin1 NOT NULL,
  `post_image` varchar(255) CHARACTER SET latin1 NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` tinyint(4) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `counter` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hs_posts`
--

INSERT INTO `hs_posts` (`post_id`, `post_key`, `post_author`, `post_title`, `post_sub_title`, `post_desc`, `post_youtube_video_url`, `post_image`, `created_at`, `updated_at`, `status`, `lang_id`, `counter`) VALUES
(1, '19be8b4a88008eb555675aed572f7711', 'rahul nagar', 'My7 post here', '', '&lt;p&gt;fsf fsf&lt;strong&gt;&amp;nbsp;thus is sij sjsfsfsfsfsfv&lt;/strong&gt;&lt;/p&gt;\n', '', '1512978711_77957.jpeg', '2016-08-30 10:54:54', '2017-12-11 07:51:51', 1, 1, 0),
(3, 'c942de4427d8545e0d05e888704ab118', 'title here', 'Sffs', '', '&lt;p&gt;sdfdsfds&lt;/p&gt;\n', '', '1512978696_47432.jpg', '2017-12-08 14:35:11', '2017-12-11 07:51:36', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `hs_roles`
--

CREATE TABLE `hs_roles` (
  `role_id` int(11) NOT NULL,
  `role_slug` varchar(255) NOT NULL,
  `role_title` varchar(80) NOT NULL,
  `role_level` tinyint(4) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hs_roles`
--

INSERT INTO `hs_roles` (`role_id`, `role_slug`, `role_title`, `role_level`, `description`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 'Super Admin', 1, 'Use this account with extreme caution. When using this account it is possible to cause irreversible damage to the system.', '0000-00-00 00:00:00', '2015-12-02 06:01:13'),
(2, 'member', 'Member', 2, 'Member', '2016-01-28 11:17:49', '2017-01-24 05:23:59'),
(3, 'stylist', 'Stylist', 3, 'Stylist', '2017-12-06 00:00:00', '2017-12-06 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `hs_users`
--

CREATE TABLE `hs_users` (
  `user_id` int(11) NOT NULL,
  `remember_token` varchar(255) NOT NULL,
  `signup_activation_key` varchar(255) NOT NULL,
  `reset_key` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `login_user` varchar(255) NOT NULL,
  `login_pass` varchar(255) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `email_verified` tinyint(4) NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `is_social_login` tinyint(4) NOT NULL,
  `facebook_login_id` varchar(255) NOT NULL,
  `facebook_access` text NOT NULL,
  `facebook_info` text NOT NULL,
  `google_login_id` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `gender` tinyint(4) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `last_login_date` datetime NOT NULL,
  `online_status` int(11) NOT NULL,
  `blocked` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hs_users`
--

INSERT INTO `hs_users` (`user_id`, `remember_token`, `signup_activation_key`, `reset_key`, `role_id`, `login_user`, `login_pass`, `salt`, `first_name`, `last_name`, `email`, `birthday`, `email_verified`, `user_image`, `is_social_login`, `facebook_login_id`, `facebook_access`, `facebook_info`, `google_login_id`, `phone_number`, `gender`, `address`, `created_at`, `updated_at`, `deleted_at`, `last_login_date`, `online_status`, `blocked`) VALUES
(1, 'YuWHfTBoJ34KjkAUZwW1XzzqGJjX0eyqfluaXFagCrKXNUJp8FhM1dDoGKdt', '', '', 1, 'superadmin', 'ee37ca91aab68a428a9648aef09ca2fae8f3490d355b9d8a3142b78edc8b60974ffcc39e1b3a90430f8d2f93bf5de1f51e45401ff23fd8960080469a6cc5fab9', '34bb864f2273273b8ba4201c0a76ea3d89245aab8307855c419f7bc624750fb1c67d5e29ac956fa530e89791d91b180294d7b9fa88e73936737f19f7b7894f66', 'Super', 'Admin', 'admin@xdeve.com', '0000-00-00', 0, '', 0, '', '', '', '', '584798798', 0, '', '0000-00-00 00:00:00', '2017-12-13 07:37:37', '0000-00-00 00:00:00', '2017-12-13 07:37:37', 1, 0),
(2, '', 'd7ea0c8583601ad82c19dcfe948c0864', '', 2, '', 'e6d4eff1980af84c0c6e087b2680d0816d31525d186b849caaf4c8e97f017b901533cf96d74f6f79a905f24ab45f284b5f0ef4ec1003608443c9dea7b2ac6cdc', 'd9fa3a1ade4fa20325befa88c104de46150548b3ff9832af2af064ee1fb5c4d1eff8ccf262e5501f306568fddf6ce396ccbfbee603f0e30621f6dbba828d984c', 'Rahul', 'Nagar', 'rahul@mailinator.com', '0000-00-00', 0, '1512729844_17246.png', 0, '', '', '', '', '9477987987', 0, '', '2017-12-08 16:14:04', '2017-12-08 16:14:43', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(3, '5U0EES1aGOzSwtYYVpwpGP8wKgQCdGT17oQ0M3hc6GmkfH1ZDvxNfgZnRFE9', '1a7a914cc92e47c502b970d87e180ba8', '', 2, '', '87d3b447d96fabacb190d0e4bb4d709ac39ed3c44e083888ac24e52e43d7caf5c37a5bd4ad118233904042fe50541c4a45f652ef589471d407e97ea4bc770230', '3a94684defea6391fcb9299f22282113c710b9f9e69eee52782ef3af9d699a06bf7c279f3bbeff89d21d674c9bc82f4ece6bf9aed2be6c6ff076abd225c1704b', 'dilip', 'vyas', 'dilip@mobappys.com', '0000-00-00', 0, '', 0, '', '', '', '', '9865329865', 0, '', '2017-12-09 11:39:09', '2017-12-11 07:50:38', '0000-00-00 00:00:00', '2017-12-11 07:50:38', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hs_analyse`
--
ALTER TABLE `hs_analyse`
  ADD PRIMARY KEY (`analyse_id`);

--
-- Indexes for table `hs_banners`
--
ALTER TABLE `hs_banners`
  ADD PRIMARY KEY (`banner_id`);

--
-- Indexes for table `hs_categories`
--
ALTER TABLE `hs_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `hs_comments`
--
ALTER TABLE `hs_comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `hs_config`
--
ALTER TABLE `hs_config`
  ADD PRIMARY KEY (`config_id`);

--
-- Indexes for table `hs_faqs`
--
ALTER TABLE `hs_faqs`
  ADD PRIMARY KEY (`faq_id`);

--
-- Indexes for table `hs_notifications`
--
ALTER TABLE `hs_notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `hs_pages`
--
ALTER TABLE `hs_pages`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `hs_permissions`
--
ALTER TABLE `hs_permissions`
  ADD PRIMARY KEY (`permission_id`);

--
-- Indexes for table `hs_permission_role`
--
ALTER TABLE `hs_permission_role`
  ADD PRIMARY KEY (`permission_role_id`);

--
-- Indexes for table `hs_posts`
--
ALTER TABLE `hs_posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `hs_roles`
--
ALTER TABLE `hs_roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `hs_users`
--
ALTER TABLE `hs_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hs_analyse`
--
ALTER TABLE `hs_analyse`
  MODIFY `analyse_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `hs_banners`
--
ALTER TABLE `hs_banners`
  MODIFY `banner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hs_categories`
--
ALTER TABLE `hs_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hs_comments`
--
ALTER TABLE `hs_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hs_config`
--
ALTER TABLE `hs_config`
  MODIFY `config_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `hs_faqs`
--
ALTER TABLE `hs_faqs`
  MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hs_notifications`
--
ALTER TABLE `hs_notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hs_pages`
--
ALTER TABLE `hs_pages`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hs_permissions`
--
ALTER TABLE `hs_permissions`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `hs_permission_role`
--
ALTER TABLE `hs_permission_role`
  MODIFY `permission_role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT for table `hs_posts`
--
ALTER TABLE `hs_posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hs_roles`
--
ALTER TABLE `hs_roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hs_users`
--
ALTER TABLE `hs_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
