-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 11, 2019 at 11:39 AM
-- Server version: 5.7.25-0ubuntu0.16.04.2
-- PHP Version: 7.0.32-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_reactBlog`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contactus_notification`
--

CREATE TABLE `contactus_notification` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `user_type` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(100) NOT NULL,
  `instagram_handle` char(255) NOT NULL,
  `message` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_ip` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` int(11) NOT NULL,
  `template_name` varchar(150) DEFAULT NULL,
  `template_name_hebrew` varchar(150) NOT NULL,
  `template_subject` text,
  `template_subject_hebrew` text NOT NULL,
  `template_body` text,
  `template_body_hebrew` text NOT NULL,
  `template_sms_body` text NOT NULL,
  `template_sms_body_hebrew` text NOT NULL,
  `template_subject_admin` text,
  `template_subject_admin_hebrew` text NOT NULL,
  `template_body_admin` text,
  `template_body_admin_hebrew` text NOT NULL,
  `template_sms_body_admin` text NOT NULL,
  `template_sms_body_admin_hebrew` text NOT NULL,
  `template_sms_enable` int(10) NOT NULL COMMENT '1=yes,2=No',
  `template_email_enable` int(10) NOT NULL COMMENT '1=yes,2=No',
  `template_created` datetime NOT NULL,
  `template_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `template_name`, `template_name_hebrew`, `template_subject`, `template_subject_hebrew`, `template_body`, `template_body_hebrew`, `template_sms_body`, `template_sms_body_hebrew`, `template_subject_admin`, `template_subject_admin_hebrew`, `template_body_admin`, `template_body_admin_hebrew`, `template_sms_body_admin`, `template_sms_body_admin_hebrew`, `template_sms_enable`, `template_email_enable`, `template_created`, `template_updated`) VALUES
(1, 'Registration Confirmation', '', 'Registration Confirmation - Flowhaus', '', '<p><strong>Hi, <strong>{user_name}</strong>!</strong><br /><br /><br />Thank you for signing up with FlowHaus.<br />To get started, visit our website&nbsp;by clicking the button below.</p>\r\n<p>For login use below credentials,</p>\r\n<p><strong>Email Address - </strong><strong>{email}</strong></p>\r\n<div class="text-align: center;display:block;width:100%;"><a style="background-color: #fbfbfb; color: #343539; font-size: 18px; padding: 10px 0; border: solid 1px rgba(104, 104, 104, 0.24) !important; border-radius: 4px; text-decoration: none; display: block; width: 270px; text-align: center; font-weight: bold; margin: 0 auto;" href="http://flowhaus.com">Visit Flowhaus</a></div>', '', '', '', 'New User Registration - Flowhaus', '', '<table style="vertical-align: middle; background-color: #373435; text-align: center; color: #fff; font-size: 24px; font-family: arial,sans-serif;" width="100%" cellpadding="30">\r\n<tbody>\r\n<tr>\r\n<td>New user registered successfully</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<table style="font-family: arial,sans-serif; padding: 40px 0px;" border="0" width="100%">\r\n<tbody>\r\n<tr>\r\n<td>\r\n<table style="font-size: 15px; padding-left: 15px; padding-right: 15px; color: #373d3f; text-align: center; font-family: arial,sans-serif; box-sizing: border-box;" width="100%">\r\n<tbody>\r\n<tr>\r\n<td style="padding: 0px 0 15px; text-align: center;" align="center">Here is the signup detail of the {user_name}</td>\r\n</tr>\r\n<tr>\r\n<td style="padding: 0px 0 15px; text-align: center;" align="center"><strong style="font-family: arial,sans-serif;">Full Name:</strong> {user_name}</td>\r\n</tr>\r\n<tr>\r\n<td style="padding: 0px 0 15px; text-align: center;" align="center"><strong style="font-family: arial,sans-serif;">Email Address:</strong> {email}</td>\r\n</tr>\r\n<tr>\r\n<td style="padding: 0px 0 15px; text-align: center;" align="center"><strong style="font-family: arial,sans-serif;">Created Date:</strong> {created}</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>', '', '', '', 1, 1, '2017-08-03 02:28:00', '2019-01-25 03:40:00'),
(2, 'Forgot Password', '', 'Forgot Password-Flowhaus', '', '<p><strong>Hi, <strong>{name}</strong>! </strong><br /><br /><br />There was a request to change your password.<br /><br />If you didn\'t make this request, please ignore this email. Otherwise, please click the button below to change your password.<br /><br /><br /><br /><br /><br /></p>\r\n<div style="text-align: center; display: block; width: 100%;"><a style="background-color: #fbfbfb; color: #343539; font-size: 18px; padding: 10px 0; border: solid 1px rgba(104, 104, 104, 0.24) !important; border-radius: 4px; text-decoration: none; display: block; width: 270px; text-align: center; font-weight: bold; margin: 0 auto;" href="http://localhost:3000/reset-password/{reset_link}">Change Password</a></div>\r\n<p><br /><br /></p>', '', '', '', '', '', '', '', '', '', 1, 1, '2017-08-03 02:30:36', '2018-12-21 10:38:26'),
(3, 'Reset Password', '', 'Reset Password - Flowhaus', '', '<p><strong>Hi, <strong>{user_name}</strong>!</strong><br /><br /><br />Your password has been successfully updated. <br /><br />If you didn\'t&nbsp;request to change&nbsp;your password,&nbsp;please let us know immediately.<br /><br /><br /></p>\r\n<div class="text-align: center;display:block;width:100%;"><a style="background-color: #fbfbfb; color: #343539; font-size: 18px; padding: 10px 0; border: solid 1px rgba(104, 104, 104, 0.24) !important; border-radius: 4px; text-decoration: none; display: block; width: 270px; text-align: center; font-weight: bold; margin: 0 auto;" href="localhost:3000/contact-us">Contact Us</a></div>\r\n<p><br /><br /></p>', '', '', '', '', '', '', '', '', '', 2, 1, '2018-04-03 17:18:31', '2018-12-20 11:53:58'),
(4, 'Reset Password Admin', '', 'Reset Password - Flowhaus', '', '<p><strong>Hi, <strong>{user_name}</strong>!</strong><br /><br /><br />Your password has been successfully updated. <br /><br />If you didn\'t request to change your password, please let us know immediately.<br /><br /><br /></p>\r\n', '', '', '', '', '', '', '', '', '', 2, 1, '2018-04-03 17:18:31', '2018-12-11 12:06:38'),
(102, 'Contact Us Notification', '', 'Flowhaus User Subject', '', '<p>Hi {name}!</p>\r\n<p>&nbsp;</p>\r\n<p><span style="font-weight: 400;">Thank you for contacting us, you&rsquo;ll hear back from us soon.</span></p>\r\n<p>&nbsp;</p>', '', '', '', 'Flowhaus Admin Subject', '', '<table style="font-size: 15px; color: #373d3f; text-align: center; font-family: arial,sans-serif; box-sizing: border-box;" width="100%" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td style="padding: 0px 0px 8px; text-align: left; text-transform: capitalize;" align="center">Below are the details of the {name}</td>\r\n</tr>\r\n<tr>\r\n<td style="padding: 0px 0px 8px; text-align: left; text-transform: capitalize;" align="center"><strong style="font-family: arial,sans-serif;">Name:</strong> {name}</td>\r\n</tr>\r\n<tr>\r\n<td style="padding: 0px 0px 8px; text-align: left;" align="center"><strong style="font-family: arial,sans-serif;">Email Address:</strong> {email}</td>\r\n</tr>\r\n<tr>\r\n<td style="padding: 0px 0px 8px; text-align: left; text-transform: capitalize;" align="center"><strong style="font-family: arial,sans-serif;">User Type :</strong> {user_type}</td>\r\n</tr>\r\n<tr>\r\n<td style="padding: 0px 0px 8px; text-align: left;" align="center"><strong style="font-family: arial,sans-serif;">Website:</strong> {website}</td>\r\n</tr>\r\n<tr>\r\n<td style="padding: 0px 0px 8px; text-align: left;" align="center"><strong style="font-family: arial,sans-serif;">Instagram Handle:</strong> {instagram_handle}</td>\r\n</tr>\r\n<tr>\r\n<td style="padding: 0px 0px 8px; text-align: left; text-transform: capitalize;" align="center"><strong style="font-family: arial,sans-serif;">Message:</strong> {message}</td>\r\n</tr>\r\n</tbody>\r\n</table>', '', '', '', 0, 0, '2018-12-11 04:47:07', '2019-01-25 04:09:27'),
(107, 'Admin Forgot password ', '', 'Forgot password ', '', '<p><strong>Hi, <strong>{first_name} {last_name}</strong>! </strong><br /><br /><br />There was a request to change your password.<br /><br />If you didn\'t make this request, please ignore this email. Otherwise, please click the button below to change your password.<br /><br /><br /><br /><br /><br /></p>\r\n<div style="text-align: center; display: block; width: 100%;"><a style="background-color: #fbfbfb; color: #343539; font-size: 18px; padding: 10px 0; border: solid 1px rgba(104, 104, 104, 0.24) !important; border-radius: 4px; text-decoration: none; display: block; width: 270px; text-align: center; font-weight: bold; margin: 0 auto;" href="http://205.134.251.196/~examin8/CI/flowhaus/reset_admin_password?token={reset_link}">Change Password</a></div>\r\n<p><br /><br /></p>', '', '', '', '', '', '', '', '', '', 0, 0, '2019-01-02 05:00:09', '2019-01-03 10:54:36'),
(108, 'User\'s Email Change Template', '', 'Email change request', '', '<p><strong>Hi, <strong>{first_name} {last_name}</strong>! </strong><br /><br /><br />There was a request to change your Email address.<br /><br />The Flowhaus admin has changed the email that you have shared with us<br /><br /><strong>Thanks &amp; Regards</strong></p>\r\n<p><strong> Flowhaus Team</strong><br /><br /><br /><br /></p>', '', '', '', '', '', '', '', '', '', 0, 0, '2019-01-07 03:28:38', '2019-01-25 03:00:10');

-- --------------------------------------------------------

--
-- Table structure for table `fh_blog_articles`
--

CREATE TABLE `fh_blog_articles` (
  `blog_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `blog_article_type_id` int(10) DEFAULT NULL,
  `blog_title` varchar(150) DEFAULT NULL,
  `short_description` text,
  `url` varchar(200) DEFAULT NULL,
  `cover_photo` varchar(400) DEFAULT NULL,
  `blog_tag` text,
  `cover_photo_thumbnail` varchar(100) NOT NULL,
  `slug` varchar(250) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(5) DEFAULT '1' COMMENT '0=inactive,1=active,2=deleted',
  `description` text NOT NULL,
  `type_other` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `order_by` float(10,2) DEFAULT '0.00',
  `approved_by_admin` int(11) NOT NULL DEFAULT '3' COMMENT '0=not approved,1=approved,3=pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fh_blog_article_type`
--

CREATE TABLE `fh_blog_article_type` (
  `blog_article_id` int(11) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `order_by` float NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fh_social_media`
--

CREATE TABLE `fh_social_media` (
  `sm_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `instagram` varchar(300) DEFAULT NULL,
  `facebook` varchar(300) DEFAULT NULL,
  `twitter` varchar(300) DEFAULT NULL,
  `youtube` varchar(300) DEFAULT NULL,
  `pinterest` varchar(300) DEFAULT NULL,
  `linkedin` varchar(300) DEFAULT NULL,
  `spotify` varchar(300) DEFAULT NULL,
  `facebook_followers` int(11) DEFAULT NULL,
  `instagram_followers` int(11) NOT NULL,
  `twitter_followers` int(11) DEFAULT NULL,
  `youtube_subscribers` int(11) DEFAULT NULL,
  `pinterest_followers` int(11) DEFAULT NULL,
  `linkedin_followers` int(11) NOT NULL,
  `total_reach` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fh_social_media`
--

INSERT INTO `fh_social_media` (`sm_id`, `user_id`, `instagram`, `facebook`, `twitter`, `youtube`, `pinterest`, `linkedin`, `spotify`, `facebook_followers`, `instagram_followers`, `twitter_followers`, `youtube_subscribers`, `pinterest_followers`, `linkedin_followers`, `total_reach`) VALUES
(7, 301, '', 'https://facebook.com/abh', 'https://twitter.com/abh', 'https://youtube.com/abh', 'https://pinterest.com/abh', 'https://linkedin.com/abh', 'https://spotify.com/abh', 2, 0, 3, 4, 5, 0, 6),
(8, 314, 'https://www.instagram.com/lisahomsy/', 'https://www.facebook.com/homsy.lisa', 'https://twitter.com/lisahomsy', 'https://www.youtube.com/channel/UCFipgZDZV19tsJgFyMyaB5Q?view_as=subscriber', 'https://www.pinterest.com/lisahomsy/', '', 'https://lisahomsy.com/about/', NULL, 0, NULL, NULL, NULL, 0, NULL),
(12, 333, 'https://www.instagram.com', 'https://www.instagram.com', 'https://www.instagram.com', 'https://www.instagram.com', 'https://www.instagram.com', 'https://www.instagram.com', 'https://www.instagram.com', 0, 0, 0, 0, 0, 0, 0),
(14, 334, 'https://instagram.com/abh', '', '', '', '', '', '', 2, 1, 3, 4, 5, 6, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` tinyint(11) NOT NULL,
  `option_name` varchar(255) NOT NULL,
  `option_value` varchar(255) NOT NULL,
  `status` tinyint(5) NOT NULL,
  `section` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1- social media and 2 -other'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `option_name`, `option_value`, `status`, `section`) VALUES
(1, 'FACEBOOK_URL', '', 1, 1),
(2, 'TWITTER_URL', '', 1, 1),
(3, 'INSTAGRAM_URL', 'https://www.instagram.com/flowhaus_', 1, 1),
(4, 'YOUTUBE_URL', '', 1, 1),
(5, 'PINTREST_URL', '', 1, 1),
(6, 'LINKEDIN_URL', '', 1, 1),
(7, 'SHOPIFY_URL', '', 1, 1),
(8, 'EMAIL', 'info@flowhaus.com', 1, 0),
(9, 'SUPPORT_EMAIL', '', 1, 0),
(10, 'ADDRESS', '', 1, 0),
(11, 'WEBSITE', 'www.mywebsite.com', 1, 0),
(12, 'PHONE', '', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `page_id` int(10) UNSIGNED NOT NULL,
  `type_of_section` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1=frontend 2=seller',
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_content` text COLLATE utf8mb4_unicode_ci,
  `meta_keyword` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=active 2=deactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `post_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website_type` tinyint(2) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(20) NOT NULL,
  `user_role` tinyint(2) NOT NULL DEFAULT '1' COMMENT '0=superadmin 1=user',
  `first_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `last_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `user_name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` text NOT NULL,
  `salt` varchar(50) NOT NULL,
  `profile_image` varchar(250) DEFAULT NULL,
  `profile_thumbnail` varchar(250) DEFAULT NULL,
  `profile_thumbnail_small` varchar(250) DEFAULT NULL,
  `is_verified` int(11) NOT NULL DEFAULT '0',
  `is_recieve_email` int(11) DEFAULT NULL,
  `reset_token` text,
  `reset_password_time` varchar(100) NOT NULL,
  `last_ip` varchar(40) NOT NULL,
  `last_login` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `new_password_key` varchar(50) NOT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `created_ip` varchar(15) DEFAULT NULL,
  `order_by` float(10,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=Inactive 1=Active 2= Deactive by user 3=Banned',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_role`, `first_name`, `last_name`, `user_name`, `email`, `password`, `salt`, `profile_image`, `profile_thumbnail`, `profile_thumbnail_small`, `is_verified`, `is_recieve_email`, `reset_token`, `reset_password_time`, `last_ip`, `last_login`, `new_password_key`, `new_password_requested`, `created_ip`, `order_by`, `status`, `created`, `modified`) VALUES
(1, 0, 'Super', 'Admin', 'superadmin', 'superadmin@reactblog.com', '4668a1430cba2d8f5f450eda76cdc80d6fcc9ac1', 'b52b4f3257', NULL, NULL, NULL, 0, NULL, NULL, '14:11:08', '192.168.2.128', '2019-02-04 07:48:44', 'xhvUBAiWYPJu62CjQMVr', NULL, NULL, 0.00, 1, '2013-12-19 00:00:00', '2019-02-04 14:18:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `contactus_notification`
--
ALTER TABLE `contactus_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fh_blog_articles`
--
ALTER TABLE `fh_blog_articles`
  ADD PRIMARY KEY (`blog_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `blog_article_type_id` (`blog_article_type_id`);

--
-- Indexes for table `fh_blog_article_type`
--
ALTER TABLE `fh_blog_article_type`
  ADD PRIMARY KEY (`blog_article_id`);

--
-- Indexes for table `fh_social_media`
--
ALTER TABLE `fh_social_media`
  ADD PRIMARY KEY (`sm_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_role` (`user_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contactus_notification`
--
ALTER TABLE `contactus_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;
--
-- AUTO_INCREMENT for table `fh_blog_articles`
--
ALTER TABLE `fh_blog_articles`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fh_blog_article_type`
--
ALTER TABLE `fh_blog_article_type`
  MODIFY `blog_article_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fh_social_media`
--
ALTER TABLE `fh_social_media`
  MODIFY `sm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` tinyint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `page_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `fh_blog_articles`
--
ALTER TABLE `fh_blog_articles`
  ADD CONSTRAINT `fh_blog_articles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fh_blog_articles_ibfk_2` FOREIGN KEY (`blog_article_type_id`) REFERENCES `fh_blog_article_type` (`blog_article_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `fh_social_media`
--
ALTER TABLE `fh_social_media`
  ADD CONSTRAINT `fh_social_media_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
