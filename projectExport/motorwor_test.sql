-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 29, 2024 at 08:27 PM
-- Server version: 10.6.18-MariaDB-cll-lve
-- PHP Version: 8.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `motorwor_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `assign`
--

CREATE TABLE `assign` (
  `assign_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `assign_no` int(11) NOT NULL COMMENT 'ลำดับการมอบหมาย (แยกตาม pick/pack)',
  `assign_date` varchar(10) DEFAULT NULL,
  `operation_type` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'pick/pack',
  `operation_member` int(11) NOT NULL COMMENT 'พนักงานที่ถูกมอบมาย',
  `dt_start` datetime NOT NULL COMMENT 'วัน/เวลา กดปุ่มเริ่มทำงาน',
  `dt_stop` datetime NOT NULL COMMENT 'วัน/เวลา กดปุ่มหยุดทำงาน',
  `remark_type_emp` int(11) NOT NULL,
  `comment_emp` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `remark_type_mgr` int(11) NOT NULL,
  `comment_mgr` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `assign_status` varchar(2) NOT NULL COMMENT 'สถานะใบงาน',
  `flag_assign` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'flag ใบงาน',
  `assign_create_date` datetime NOT NULL,
  `assign_modify_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `assign`
--

INSERT INTO `assign` (`assign_id`, `sale_id`, `assign_no`, `assign_date`, `operation_type`, `operation_member`, `dt_start`, `dt_stop`, `remark_type_emp`, `comment_emp`, `remark_type_mgr`, `comment_mgr`, `assign_status`, `flag_assign`, `assign_create_date`, `assign_modify_date`) VALUES
(1, 1, 1, '28/10/2024', 'pick', 11, '2024-10-28 21:39:26', '2024-10-29 07:15:49', 1, 'all', 0, '', '4', '', '2024-10-29 15:55:03', '2024-10-29 15:55:06'),
(2, 1, 1, '28/10/2024', 'pack', 11, '2024-10-28 01:41:48', '2024-10-28 01:41:48', 0, '', 0, '', '2', '', '2024-10-29 15:54:55', '2024-10-29 15:54:59'),
(4, 2, 1, '29/10/2024', 'pack', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '', 0, '', '', '', '2024-10-29 15:54:41', '2024-10-29 15:54:51'),
(3, 2, 1, '29/10/2024', 'pick', 11, '2024-10-29 13:03:46', '2024-10-29 13:04:29', 1, 'sdf', 0, '', '4', '', '2024-10-29 14:10:49', '2024-10-29 16:10:01');

-- --------------------------------------------------------

--
-- Table structure for table `assign_detail`
--

CREATE TABLE `assign_detail` (
  `assign_id` int(11) NOT NULL,
  `assign_detail_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `sale_detail_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_count` int(11) NOT NULL COMMENT 'จำนวนนับได้',
  `detail_remark_type_emp` int(11) NOT NULL,
  `detail_comment_emp` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `detail_comment_mgr` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `assign_detail`
--

INSERT INTO `assign_detail` (`assign_id`, `assign_detail_id`, `sale_id`, `sale_detail_id`, `product_id`, `product_count`, `detail_remark_type_emp`, `detail_comment_emp`, `detail_comment_mgr`) VALUES
(1, 1, 1, 1, 1, 4, 1, 'dddd', NULL),
(1, 2, 1, 5, 5, 4, 1, 'dddd', NULL),
(1, 3, 1, 4, 4, 4, 1, 'dddd', NULL),
(1, 4, 1, 2, 2, 5, 1, '123', NULL),
(3, 5, 2, 7, 3, 1, 1, 't1', NULL),
(3, 6, 2, 6, 1, 0, 0, '', NULL),
(3, 7, 2, 12, 3, 1, 1, '123', NULL),
(3, 8, 2, 6, 1, 0, 0, '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `flag_detail_count`
--

CREATE TABLE `flag_detail_count` (
  `sale_detail_id` int(11) NOT NULL,
  `assign_id` int(11) NOT NULL,
  `product_count` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `flag_detail_count`
--

INSERT INTO `flag_detail_count` (`sale_detail_id`, `assign_id`, `product_count`) VALUES
(2, 1, 5),
(1, 2, 1),
(3, 1, 1),
(5, 1, 4),
(4, 1, 4),
(7, 3, 3),
(6, 3, 2),
(12, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `master_customer`
--

CREATE TABLE `master_customer` (
  `customer_id` int(11) NOT NULL,
  `customer_code` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `customer_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `customer_create_date` datetime NOT NULL,
  `customer_modify_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `master_customer`
--

INSERT INTO `master_customer` (`customer_id`, `customer_code`, `customer_name`, `customer_create_date`, `customer_modify_date`) VALUES
(1, '61080-000384', 'customer1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, '61080-000178', 'customer3', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, '61080-000361', 'customer4', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `master_product`
--

CREATE TABLE `master_product` (
  `product_id` int(11) NOT NULL,
  `product_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `product_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `product_create_date` datetime NOT NULL,
  `product_modify_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `master_product`
--

INSERT INTO `master_product` (`product_id`, `product_code`, `product_name`, `product_create_date`, `product_modify_date`) VALUES
(1, 'THK3FAN61200TA', 'ชุดตะกร้าหน้าและขายึด W125-i ปี2022', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, '08234-2MBK8LT3', 'น้ำมันเครื่องสังเคราะห์แท้ MB 0.8L ฝาดำ', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, '42711-K16-943', 'ยางนอกล้อหลัง (DUNLOP)(110/90-12 M/C 64J)', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, '33470-K3M-T01', 'ชุดไฟเลี้ยวหน้าซ้าย', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, '64331-K2L-D00ZE', 'ฝาครอบกลางตัวถังด้านขวา รถสีดำ', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `master_sale`
--

CREATE TABLE `master_sale` (
  `sale_id` int(11) NOT NULL,
  `sale_code` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'เลขที่ใบขาย',
  `sale_date` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'วันที่ขาย',
  `customer_id` int(11) NOT NULL,
  `remark` varchar(500) NOT NULL COMMENT 'หมายเหตุใบขาย',
  `sale_create_date` datetime NOT NULL,
  `sale_modify_date` datetime NOT NULL,
  `packing_code` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'เลขที่หยิบ (ไม่ import)',
  `flag_pick` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'flag การหยิบ (ไม่ import)',
  `flag_pack` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'flag การแพ็ค (ไม่ import)'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `master_sale`
--

INSERT INTO `master_sale` (`sale_id`, `sale_code`, `sale_date`, `customer_id`, `remark`, `sale_create_date`, `sale_modify_date`, `packing_code`, `flag_pick`, `flag_pack`) VALUES
(1, '67WHSL/0009427', '01/05/2567', 1, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '1', '1'),
(2, '67WHSL/0009428', '01/06/2567', 1, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '1', '1'),
(3, '67WHSL/0009429', '23/08/2567', 3, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '1', '1'),
(4, '67WHSL/0009430', '12/09/2567', 3, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '1', '1'),
(5, '67WHSL/0009431', '27/09/2567', 2, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `master_sale_detail`
--

CREATE TABLE `master_sale_detail` (
  `sale_detail_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `sale_detail_num` int(11) NOT NULL COMMENT 'ลำดับ item',
  `product_id` int(11) NOT NULL,
  `product_location` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `product_qty` decimal(10,0) NOT NULL,
  `flag_count` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'flag การนับ'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `master_sale_detail`
--

INSERT INTO `master_sale_detail` (`sale_detail_id`, `sale_id`, `sale_detail_num`, `product_id`, `product_location`, `product_qty`, `flag_count`) VALUES
(1, 1, 1, 1, 'ลัง 5056', 5, 'N'),
(2, 1, 2, 2, 'ลัง 1111', 12, 'N'),
(3, 1, 3, 3, 'สต๊อก', 3, 'Y'),
(4, 1, 4, 4, 'สต๊อก', 5, 'N'),
(5, 1, 5, 5, 'สต๊อก', 5, 'N'),
(6, 2, 1, 1, 'ลัง 5056', 3, 'N'),
(7, 2, 2, 3, 'สต๊อก', 3, ''),
(8, 3, 1, 1, 'ลัง 5056', 3, ''),
(9, 4, 1, 1, 'สต๊อก', 3, ''),
(10, 5, 1, 1, 'สต๊อก', 3, ''),
(11, 1, 6, 1, 'สต๊อก', 3, ''),
(12, 2, 3, 3, 'ลัง 123', 10, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `member_id` int(2) NOT NULL,
  `member_name` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_pic` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_type` int(1) NOT NULL,
  `userlogin` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `passlogin` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_status` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_insert` varchar(19) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `member_update` varchar(19) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`member_id`, `member_name`, `member_pic`, `member_type`, `userlogin`, `passlogin`, `member_status`, `member_insert`, `member_update`) VALUES
(1, 'watinee', '1_Pic.jpg', 1, 'maimai', '123', '1', '0000-00-00 00:00:00', '2024-10-04 14:46:05'),
(2, 'emp1', '2_pic.png', 3, 'e1', '1', '1', '2024-07-17 14:19:54', '2024-10-25 13:03:05'),
(3, 'emp2', '3_pic.png', 3, 'e2', '1', '1', '2024-07-17 14:19:54', '2024-10-24 16:08:59'),
(4, 'emp3', '4_pic.png', 3, 'user_emp3', '123', '1', '2024-07-17 14:19:54', '2024-10-24 16:13:23'),
(5, 'admin_test', '5_pic.png', 1, 'admin', '1', '1', '2024-09-28 11:12:01', '2024-10-24 16:14:16'),
(6, '', 'avatar04.png', 0, '', 'a', 'D', '2024-09-28 11:12:01', '2024-10-24 14:42:58'),
(7, 'test', '7_pic.png', 3, 'test123', '123', 'D', '2024-10-04 14:50:17', '2024-10-04 14:50:17'),
(8, 'test', '8_pic.png', 3, 'test123', '123', 'D', '2024-10-04 17:34:02', '2024-10-04 17:34:02'),
(9, 'พนักงานหยิบ', '9_pic.png', 3, 'test123', '123', 'D', '2024-10-04 17:34:41', '2024-10-04 17:49:15'),
(10, 'น้ำผึ้ง', '10_pic.png', 2, 'Bee', '123', '1', '2024-10-07 14:49:35', '2024-10-15 14:04:35'),
(11, 'น้ำผึ้ง2', '', 3, 'Bee2', '123', '1', '2024-10-07 14:50:16', '2024-10-15 06:27:26'),
(12, 'ชื่อ                        นามสกุล', '', 1, 'Bee3', '123', 'D', '2024-10-18 23:37:04', '2024-10-18 23:37:04'),
(13, 'test', '', 1, '1', '1', 'D', '2024-10-18 23:51:30', '2024-10-18 23:51:30'),
(14, 'test', '', 1, '1', '1', 'D', '2024-10-18 23:52:25', '2024-10-18 23:52:25'),
(15, 'test mai', '15_pic.png', 3, 'm', 'm', '1', '2024-10-25 15:17:50', '2024-10-25 15:17:50'),
(16, '11', '16_pic.png', 3, '11', '11', '0', '2024-10-25 15:22:43', '2024-10-25 15:32:12'),
(17, '22', '17_pic.png', 2, '22', '22', '1', '2024-10-25 15:26:59', '2024-10-25 15:27:11'),
(18, '01', '', 2, '01', '01', '1', '2024-10-25 15:33:09', '2024-10-25 15:33:32');

-- --------------------------------------------------------

--
-- Table structure for table `member_type`
--

CREATE TABLE `member_type` (
  `member_type` int(11) NOT NULL,
  `member_type_name` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `member_type`
--

INSERT INTO `member_type` (`member_type`, `member_type_name`) VALUES
(1, 'ผู้ดูแลระบบ'),
(2, 'หัวหน้า'),
(3, 'พนักงาน');

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `order_status_id` varchar(2) NOT NULL,
  `order_status_name` varchar(15) NOT NULL,
  `order_category` int(11) NOT NULL,
  `order_status_dash` varchar(100) NOT NULL,
  `order_status_detail` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`order_status_id`, `order_status_name`, `order_category`, `order_status_dash`, `order_status_detail`) VALUES
('1', 'รอมอบหมาย', 1, '<span data-toggle=\'tooltip\'  class=\'badge custom-badge\'>รอมอบหมาย</span>', ''),
('2', 'มอบหมาย', 2, '<span data-toggle=\'tooltip\'  class=\'badge bg-blue\'>มอบหมาย</span>', ''),
('3', 'กำลังหยิบ', 3, '<span data-toggle=\'tooltip\'  class=\'badge bg-yellow\'>กำลังหยิบ</span>', ''),
('4', 'หยิบไม่สำเร็จ', 5, '<span data-toggle=\'tooltip\'  class=\'badge bg-red\'>หยิบไม่สำเร็จ</span>', '<span style=color:red>หยิบไม่สำเร็จ</span>'),
('41', 'หยิบสำเร็จ', 4, '<span data-toggle=\'tooltip\'  class=\'badge bg-green\'>หยิบสำเร็จ</span>', ''),
('42', 'จบงานหยิบ', 5, '<span data-toggle=\'tooltip\'  class=\'badge bg-red\'>จบงานหยิบ</span>', ''),
('43', 'รอหยิบใหม่', 1, '<span data-toggle=\'tooltip\'  class=\'badge custom-badge\'>รอหยิบใหม่</span>', ''),
('5', 'กำลังแพ็ค', 3, '<span data-toggle=\'tooltip\'  class=\'badge bg-yellow\'>กำลังแพ็ค</span>', ''),
('6', 'แพ็คไม่สำเร็จ', 5, '<span data-toggle=\'tooltip\'  class=\'badge bg-red\'>แพ็คไม่สำเร็จ</span>', ''),
('61', 'แพ็คสำเร็จ', 4, '<span data-toggle=\'tooltip\'  class=\'badge bg-green\'>แพ็คสำเร็จ</span>', ''),
('62', 'จบงานแพ็ค', 5, '<span data-toggle=\'tooltip\'  class=\'badge bg-red\'>จบงานแพ็ค</span>', ''),
('63', 'รอแพ็คใหม่', 1, '<span data-toggle=\'tooltip\'  class=\'badge custom-badge\'>รอแพ็คใหม่</span>', '');

-- --------------------------------------------------------

--
-- Table structure for table `remark_type`
--

CREATE TABLE `remark_type` (
  `remark_type_id` int(11) NOT NULL,
  `remark_type_name` varchar(100) DEFAULT NULL,
  `remark_type_status` varchar(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `remark_type`
--

INSERT INTO `remark_type` (`remark_type_id`, `remark_type_name`, `remark_type_status`) VALUES
(1, 'หาสินค้าไม่เจอ', '1'),
(2, 'เวลาในการจัดไม่เพียงพอ', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assign`
--
ALTER TABLE `assign`
  ADD PRIMARY KEY (`assign_id`,`sale_id`);

--
-- Indexes for table `assign_detail`
--
ALTER TABLE `assign_detail`
  ADD PRIMARY KEY (`assign_detail_id`);

--
-- Indexes for table `flag_detail_count`
--
ALTER TABLE `flag_detail_count`
  ADD PRIMARY KEY (`sale_detail_id`);

--
-- Indexes for table `master_customer`
--
ALTER TABLE `master_customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `master_product`
--
ALTER TABLE `master_product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `master_sale`
--
ALTER TABLE `master_sale`
  ADD PRIMARY KEY (`sale_id`);

--
-- Indexes for table `master_sale_detail`
--
ALTER TABLE `master_sale_detail`
  ADD PRIMARY KEY (`sale_detail_id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `member_type`
--
ALTER TABLE `member_type`
  ADD PRIMARY KEY (`member_type`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`order_status_id`);

--
-- Indexes for table `remark_type`
--
ALTER TABLE `remark_type`
  ADD PRIMARY KEY (`remark_type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
