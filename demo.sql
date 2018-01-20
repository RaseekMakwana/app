-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 04, 2016 at 07:14 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `user_type` int(11) NOT NULL,
  `first_name` varchar(150) NOT NULL,
  `last_name` varchar(150) NOT NULL,
  `username` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(32) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `profile_picture` varchar(250) DEFAULT NULL,
  `address1` text,
  `address2` text,
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `user_type`, `first_name`, `last_name`, `username`, `email`, `password`, `phone`, `profile_picture`, `address1`, `address2`, `created_date`, `updated_date`, `created_by`, `updated_by`, `status`) VALUES
(3, 1, 'Ajit', 'Vaniya', 'admin', 'ajit@siliconithub.com', '21232f297a57a5a743894a0e4a801fc3', '', 'WdSsGhqSrhMZPAK-bspR-O5X74H3TDic.png', '', '', '2016-10-24 05:39:04', '2016-10-27 07:19:55', 1, 3, 'Y'),
(4, 1, 'admin11', 'admin1', 'admin1', 'admin1@siliconithub.com', '0192023a7bbd73250516f069df18b500', '1234567899556', '', '', '', '2016-10-24 06:35:10', '2016-10-24 10:26:59', NULL, 4, 'Y'),
(5, 3, 'Superadmin', 'Superadmin', 'superadmin', 'ajit1@siliconithub.com', 'fae05f3ecdfe3c2394b926141f272b8e', '1234567899556', '', '', '', '2016-10-24 06:38:48', '2016-10-24 12:32:30', NULL, NULL, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `value` text,
  `created_by` int(11) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `status` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `created_by`, `created_date`, `updated_by`, `updated_date`, `status`) VALUES
(1, 'compnay_name', 'Demo Project 1', NULL, '2016-10-22 13:07:50', NULL, NULL, 'Y'),
(2, 'address', 'Lorem ipsum', NULL, '2016-10-22 13:07:50', NULL, NULL, 'Y'),
(3, 'phone', '1234567890', NULL, '2016-10-22 13:07:50', NULL, NULL, 'Y'),
(4, 'email', 'test@siliconithub.com', NULL, '2016-10-22 13:07:50', NULL, NULL, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `system_actions`
--

CREATE TABLE `system_actions` (
  `id` int(11) NOT NULL,
  `controller_id` int(11) NOT NULL,
  `action_name` varchar(250) NOT NULL,
  `status` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `system_actions`
--

INSERT INTO `system_actions` (`id`, `controller_id`, `action_name`, `status`) VALUES
(1, 1, 'index', 'Y'),
(2, 1, 'logout', 'Y'),
(3, 1, 'settings', 'Y'),
(4, 2, 'index', 'Y'),
(5, 2, 'view', 'Y'),
(6, 2, 'create', 'Y'),
(7, 3, 'index', 'Y'),
(8, 3, 'create', 'Y'),
(9, 3, 'view', 'Y'),
(10, 3, 'update', 'Y'),
(11, 3, 'delete', 'Y'),
(12, 4, 'view', 'Y'),
(13, 4, 'create', 'Y'),
(14, 4, 'delete', 'Y'),
(15, 4, 'index', 'Y'),
(16, 5, 'view', 'Y'),
(17, 5, 'create', 'Y'),
(18, 5, 'delete', 'Y'),
(19, 5, 'index', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `system_controllers`
--

CREATE TABLE `system_controllers` (
  `id` int(11) NOT NULL,
  `controller_name` varchar(250) NOT NULL,
  `status` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `system_controllers`
--

INSERT INTO `system_controllers` (`id`, `controller_name`, `status`) VALUES
(1, 'dashboard', 'Y'),
(2, 'userroles', 'Y'),
(3, 'users', 'Y'),
(4, 'systemrolebasepermission', 'Y'),
(5, 'adminusers', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `system_role_base_permission`
--

CREATE TABLE `system_role_base_permission` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `controller_id` int(11) NOT NULL,
  `action_id` int(11) DEFAULT NULL,
  `allow_all_actions` enum('Y','N') NOT NULL DEFAULT 'N',
  `status` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `system_role_base_permission`
--

INSERT INTO `system_role_base_permission` (`id`, `role_id`, `controller_id`, `action_id`, `allow_all_actions`, `status`) VALUES
(1, 2, 2, NULL, 'N', 'Y'),
(2, 2, 3, NULL, 'N', 'Y'),
(3, 1, 2, NULL, 'Y', 'Y'),
(4, 1, 3, NULL, 'Y', 'Y'),
(5, 1, 4, NULL, 'Y', 'Y'),
(6, 1, 5, NULL, 'Y', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_type` int(11) NOT NULL,
  `first_name` varchar(150) DEFAULT NULL,
  `last_name` varchar(150) DEFAULT NULL,
  `username` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `token` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `profile_picture` varchar(250) DEFAULT NULL,
  `address1` text,
  `address2` text,
  `created_date` timestamp NULL DEFAULT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_type`, `first_name`, `last_name`, `username`, `email`, `password`, `token`, `phone`, `profile_picture`, `address1`, `address2`, `created_date`, `updated_date`, `created_by`, `updated_by`, `status`) VALUES
(1, 2, 'Ajit', 'Vaniya', 'ajit', 'admin@siliconithub.com', '21232f297a57a5a743894a0e4a801fc3', NULL, '12345612345', '', 'Lorem ipsum', 'Lorem ipsum', '2016-10-22 11:31:39', '2016-10-24 05:29:31', 1, NULL, 'Y'),
(2, 2, 'Sohail', 'Anjum', 'sohail', 'sohail@siliconithub.com', '21232f297a57a5a743894a0e4a801fc3', NULL, '12345612345', '1sBInuncbOskcFMR6x9oKbiO3HWWzF6u.png', 'lorem ipsum', 'lorem ipsum', '2016-10-24 05:28:00', '2016-10-24 05:28:00', NULL, NULL, 'Y'),
(3, 2, 'Raseek', 'Makwana', 'raseek', 'raseek@siliconithub.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, '1234567899', '', '', '', '2016-10-24 06:28:30', '2016-10-24 06:28:30', NULL, NULL, 'Y'),
(7, 2, 'test', 'test', 'test', 'test', 'e10adc3949ba59abbe56e057f20f883e', NULL, '1234567890', 'HYD-6j5SpcZDo2KIglrPIb3QOvFm4KDC.jpg', 'test', 'testt', '2016-10-24 10:03:05', '2016-10-24 10:03:05', NULL, NULL, 'Y'),
(8, 2, 'test', 'test', 'tst', 'ajit@siliconithub.com', 'e10adc3949ba59abbe56e057f20f883e', 'enh0U2vAxA0=', '1234567890', '', 'tst', '', '2016-10-24 10:04:20', '2016-10-27 07:35:17', NULL, NULL, 'Y'),
(9, 2, 'QA ', 'TEST', 'test99', 'abc@abc.cba', 'e10adc3949ba59abbe56e057f20f883e', NULL, '123456789', '', '', '', '2016-10-24 11:37:50', '2016-10-24 11:37:50', NULL, NULL, 'Y'),
(11, 2, 'Agency', 'ab', 'abc', 'ab@ab.c', 'e10adc3949ba59abbe56e057f20f883e', NULL, '12355', '', '', '', '2016-10-24 11:56:06', '2016-10-24 11:56:06', NULL, NULL, 'Y'),
(12, 2, 'test', 'test', 'test', 'ajit@siliconithub.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, '1234567', '', '', '', '2016-10-27 07:08:34', '2016-10-27 07:08:34', NULL, NULL, 'Y'),
(13, 2, 'test', 'test', 'test', 'ajit@siliconithub.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, '1234567', '', '', '', '2016-10-27 07:09:27', '2016-10-27 07:09:27', NULL, NULL, 'Y'),
(14, 2, 'test', 'test', 'test', 'ajit@siliconithub.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, '1234567', '', '', '', '2016-10-27 07:09:37', '2016-10-27 07:09:37', NULL, NULL, 'Y'),
(15, 2, 'lorem ipsum', 'lorem ipsum', 'lorem_ipsum', 'ajit@siliconithub.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'test', '', '', '', '2016-10-27 07:11:18', '2016-10-27 07:11:18', NULL, NULL, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL,
  `user_role` varchar(250) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `user_role`, `created_date`, `updated_date`, `created_by`, `updated_by`, `status`) VALUES
(1, 'admin', '2016-10-22 11:30:49', '0000-00-00 00:00:00', 0, 0, 'Y'),
(2, 'normal_user', '2016-10-22 11:30:46', '0000-00-00 00:00:00', 1, 1, 'Y'),
(3, 'Super Admin', '2016-10-24 10:42:53', '2016-10-24 10:42:53', 3, 3, 'Y');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_users_user_types` (`user_type`),
  ADD KEY `user_type` (`user_type`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `system_actions`
--
ALTER TABLE `system_actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_system_actions_system_controllers` (`controller_id`);

--
-- Indexes for table `system_controllers`
--
ALTER TABLE `system_controllers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_role_base_permission`
--
ALTER TABLE `system_role_base_permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_system_role_base_permission_system_controllers` (`controller_id`),
  ADD KEY `FK_system_role_base_permission_system_actions` (`action_id`),
  ADD KEY `FK_system_role_base_permission_user_roles` (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_users_user_types` (`user_type`),
  ADD KEY `user_type` (`user_type`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `system_actions`
--
ALTER TABLE `system_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `system_controllers`
--
ALTER TABLE `system_controllers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `system_role_base_permission`
--
ALTER TABLE `system_role_base_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `user_type` FOREIGN KEY (`user_type`) REFERENCES `user_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `system_actions`
--
ALTER TABLE `system_actions`
  ADD CONSTRAINT `FK_system_actions_system_controllers` FOREIGN KEY (`controller_id`) REFERENCES `system_controllers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_users_user_types` FOREIGN KEY (`user_type`) REFERENCES `user_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
