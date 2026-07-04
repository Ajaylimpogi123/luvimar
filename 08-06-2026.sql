-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_luvimar
CREATE DATABASE IF NOT EXISTS `db_luvimar` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `db_luvimar`;

-- Dumping structure for table db_luvimar.bs_beginning_balance
CREATE TABLE IF NOT EXISTS `bs_beginning_balance` (
  `beg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `amount` decimal(9,2) NOT NULL,
  `is_deleted` tinyint(1) unsigned NOT NULL,
  `date_added` varchar(50) DEFAULT NULL,
  `date_modified` varchar(50) DEFAULT NULL,
  `date_deleted` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`beg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.bs_beginning_balance: 1 rows
/*!40000 ALTER TABLE `bs_beginning_balance` DISABLE KEYS */;
INSERT INTO `bs_beginning_balance` (`beg_id`, `amount`, `is_deleted`, `date_added`, `date_modified`, `date_deleted`) VALUES
	(1, 1000.00, 0, '2025-09-06 14:46:57', NULL, NULL);
/*!40000 ALTER TABLE `bs_beginning_balance` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.bs_branch
CREATE TABLE IF NOT EXISTS `bs_branch` (
  `branch_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `branch_name` varchar(100) NOT NULL,
  `branch_db` varchar(100) NOT NULL,
  `is_deleted` int(1) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`branch_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1008 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Dumping data for table db_luvimar.bs_branch: 1 rows
/*!40000 ALTER TABLE `bs_branch` DISABLE KEYS */;
INSERT INTO `bs_branch` (`branch_id`, `branch_name`, `branch_db`, `is_deleted`, `date_added`, `date_modified`, `date_deleted`) VALUES
	(1006, 'Bacolod', 'db_luvimar', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `bs_branch` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.bs_customer
CREATE TABLE IF NOT EXISTS `bs_customer` (
  `cust_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `branch_id` int(10) unsigned NOT NULL DEFAULT 0,
  `client_name` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `address` text NOT NULL,
  `customer_name` varchar(200) NOT NULL DEFAULT '',
  `contact_person` varchar(200) NOT NULL DEFAULT '',
  `contactno` varchar(100) NOT NULL DEFAULT '',
  `s_contactno` varchar(100) NOT NULL DEFAULT '',
  `messenger` varchar(200) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `image` varchar(200) NOT NULL DEFAULT '',
  `thumbnail` varchar(200) NOT NULL DEFAULT '',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `is_branch` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` varchar(50) DEFAULT NULL,
  `date_modified` varchar(50) DEFAULT NULL,
  `date_deleted` varchar(50) DEFAULT NULL,
  `last_login` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`cust_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Dumping data for table db_luvimar.bs_customer: ~5 rows (approximately)
INSERT INTO `bs_customer` (`cust_id`, `branch_id`, `client_name`, `address`, `customer_name`, `contact_person`, `contactno`, `s_contactno`, `messenger`, `email`, `image`, `thumbnail`, `is_deleted`, `is_branch`, `date_added`, `date_modified`, `date_deleted`, `last_login`) VALUES
	(1, 0, 'Juan De la Cruz', '', 'Juan De la Cruz', '', '09952681811', '', '', '', '', '', 1, 0, '2025-09-06 14:12:38', NULL, NULL, NULL),
	(2, 0, 'Walk In', '', 'Walk in', '', '', '', '', '', '', '', 0, 0, '2025-09-06 14:44:59', NULL, NULL, NULL),
	(3, 0, 'Luvimar', 'Bacolod', 'Luvi', 'Jess', '123456789', '', '', '', '', '', 0, 0, '2026-01-09 21:07:56', NULL, NULL, NULL),
	(4, 0, 'luvim', 'talisay', 'jesss', 'jeeeesss', '123456', '2', 'sa', 'a', '', '', 1, 0, '2026-02-01 19:31:19', '2026-04-01 19:07:41', NULL, NULL),
	(5, 0, 'Bacolod', 'Bacolod City', 'Branch', 'Luvimar', '09123456789', '09874563210', 'branches', '', '', '', 0, 0, '2026-04-01 19:23:47', NULL, NULL, NULL);

-- Dumping structure for table db_luvimar.bs_report
CREATE TABLE IF NOT EXISTS `bs_report` (
  `report_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `page` varchar(50) NOT NULL,
  `is_deleted` int(10) unsigned NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_deleted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`report_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1020 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Dumping data for table db_luvimar.bs_report: 9 rows
/*!40000 ALTER TABLE `bs_report` DISABLE KEYS */;
INSERT INTO `bs_report` (`report_id`, `name`, `description`, `page`, `is_deleted`, `date_added`, `date_deleted`) VALUES
	(1001, 'Released Product', 'Displays released products', 'release', 0, '2015-07-28 02:51:10', '0000-00-00 00:00:00'),
	(1013, 'Sales Detail', 'Displays total sales', 'sales', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(1014, 'Received Product', 'Displays received products', 'receive', 1, '2016-05-15 22:35:45', '0000-00-00 00:00:00'),
	(1015, 'Inventory', 'Displays inventory of products', 'inventory', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(1016, 'Sales Graph', 'Displays sales graph', 'sales_graph', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(1017, 'Accounts Receivable', 'Displays accounts receivable', 'ar_detail', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(1018, 'Returned Product', 'Displays returned products', 'returned', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(1019, 'Transfer', 'Displays transfer product', 'transfer', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(1, 'Expenses', 'Display Expense', 'expense', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `bs_report` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.bs_setting
CREATE TABLE IF NOT EXISTS `bs_setting` (
  `setting_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `directory` varchar(100) NOT NULL DEFAULT '',
  `system_title` varchar(100) NOT NULL DEFAULT '',
  `abrv` varchar(70) NOT NULL DEFAULT '',
  `year_developed` year(4) NOT NULL,
  `description` text NOT NULL,
  `developer` varchar(100) NOT NULL,
  `website` varchar(100) NOT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1014 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.bs_setting: 1 rows
/*!40000 ALTER TABLE `bs_setting` DISABLE KEYS */;
INSERT INTO `bs_setting` (`setting_id`, `directory`, `system_title`, `abrv`, `year_developed`, `description`, `developer`, `website`) VALUES
	(1001, 'luvimar', 'Luvimar Monitoring System', 'POS', '2025', '', 'Luvimar', '');
/*!40000 ALTER TABLE `bs_setting` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.bs_supplier
CREATE TABLE IF NOT EXISTS `bs_supplier` (
  `sup_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(100) NOT NULL DEFAULT '',
  `firstname` varchar(100) NOT NULL DEFAULT '',
  `lastname` varchar(100) NOT NULL DEFAULT '',
  `contactno` varchar(100) NOT NULL DEFAULT '',
  `address` text NOT NULL,
  `image` varchar(200) NOT NULL DEFAULT '',
  `thumbnail` varchar(200) NOT NULL DEFAULT '',
  `is_deleted` int(10) NOT NULL,
  `date_added` varchar(50) DEFAULT NULL,
  `date_modified` varchar(50) DEFAULT NULL,
  `date_deleted` varchar(50) DEFAULT NULL,
  `last_login` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sup_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Dumping data for table db_luvimar.bs_supplier: ~0 rows (approximately)

-- Dumping structure for table db_luvimar.bs_user
CREATE TABLE IF NOT EXISTS `bs_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(100) NOT NULL DEFAULT '',
  `firstname` varchar(100) NOT NULL DEFAULT '',
  `lastname` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `username` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `pass_text` varchar(200) NOT NULL DEFAULT '',
  `title` varchar(100) NOT NULL DEFAULT '',
  `contactno` varchar(100) NOT NULL DEFAULT '',
  `address` text DEFAULT NULL,
  `image` varchar(200) NOT NULL DEFAULT '',
  `thumbnail` varchar(200) NOT NULL DEFAULT '',
  `is_admin` tinyint(1) NOT NULL DEFAULT 1,
  `access_level` int(10) NOT NULL DEFAULT 1,
  `is_main_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_masterfile_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_category_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_cat_a_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_cat_e_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_cat_d_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_customer_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_cust_a_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_cust_e_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_cust_d_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_supplier_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_sup_a_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_sup_e_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_sup_d_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_product_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_prod_a_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_prod_e_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_prod_d_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_receive_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_return_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_sales_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_sale_v_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_sale_d_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_job_order_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_job_order_a_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_job_order_e_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_job_order_d_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_production_report_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_production_report_a_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_production_report_e_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_production_report_d_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_delivery_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_del_v_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_del_d_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_expense_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_exp_a_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_exp_e_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_exp_d_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_report_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_user_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_user_a_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_user_e_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_user_d_access` tinyint(1) NOT NULL DEFAULT 1,
  `added_by` int(10) DEFAULT NULL,
  `modified_by` int(10) DEFAULT NULL,
  `deleted_by` int(10) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `date_added` varchar(50) DEFAULT NULL,
  `date_modified` varchar(50) DEFAULT NULL,
  `date_deleted` varchar(50) DEFAULT NULL,
  `last_login` varchar(50) DEFAULT NULL,
  `theme` varchar(70) NOT NULL,
  `branch_num` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1453 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.bs_user: 1 rows
/*!40000 ALTER TABLE `bs_user` DISABLE KEYS */;
INSERT INTO `bs_user` (`user_id`, `emp_id`, `firstname`, `lastname`, `email`, `username`, `password`, `pass_text`, `title`, `contactno`, `address`, `image`, `thumbnail`, `is_admin`, `access_level`, `is_main_access`, `is_masterfile_access`, `is_category_access`, `is_cat_a_access`, `is_cat_e_access`, `is_cat_d_access`, `is_customer_access`, `is_cust_a_access`, `is_cust_e_access`, `is_cust_d_access`, `is_supplier_access`, `is_sup_a_access`, `is_sup_e_access`, `is_sup_d_access`, `is_product_access`, `is_prod_a_access`, `is_prod_e_access`, `is_prod_d_access`, `is_receive_access`, `is_return_access`, `is_sales_access`, `is_sale_v_access`, `is_sale_d_access`, `is_job_order_access`, `is_job_order_a_access`, `is_job_order_e_access`, `is_job_order_d_access`, `is_production_report_access`, `is_production_report_a_access`, `is_production_report_e_access`, `is_production_report_d_access`, `is_delivery_access`, `is_del_v_access`, `is_del_d_access`, `is_expense_access`, `is_exp_a_access`, `is_exp_e_access`, `is_exp_d_access`, `is_report_access`, `is_user_access`, `is_user_a_access`, `is_user_e_access`, `is_user_d_access`, `added_by`, `modified_by`, `deleted_by`, `is_deleted`, `date_added`, `date_modified`, `date_deleted`, `last_login`, `theme`, `branch_num`) VALUES
	(1002, '1600109', 'Admin', 'Admin', 'admin@gmail.com', 'admin', '81dc9bdb52d04dc20036dbd8313ed055', '1234', 'Senior Programmer', '123456789', 'Bacolod City', '', '', 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, '2008-08-01 19:18:51', '2022-04-20 12:56:25', '0000-00-00 00:00:00', '2026-06-08 10:12:48', 'cerulean', 0);
/*!40000 ALTER TABLE `bs_user` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.tbl_cart
CREATE TABLE IF NOT EXISTS `tbl_cart` (
  `ct_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pd_id` int(10) unsigned NOT NULL DEFAULT 0,
  `ct_qty` mediumint(8) unsigned NOT NULL DEFAULT 1,
  `ct_price` decimal(9,2) NOT NULL,
  `ct_cost` decimal(9,2) NOT NULL,
  `description` varchar(244) NOT NULL DEFAULT '',
  `job_description` varchar(100) DEFAULT NULL,
  `ct_session_id` char(32) NOT NULL DEFAULT '',
  `ct_date` varchar(100) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(10) unsigned NOT NULL DEFAULT 0,
  `is_type` tinyint(1) unsigned NOT NULL COMMENT '1=pc, 2=ib, 3=bx',
  PRIMARY KEY (`ct_id`),
  KEY `pd_id` (`pd_id`),
  KEY `ct_session_id` (`ct_session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tbl_cart: 0 rows
/*!40000 ALTER TABLE `tbl_cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_cart` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.tbl_cart_receive
CREATE TABLE IF NOT EXISTS `tbl_cart_receive` (
  `ct_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pd_id` int(10) unsigned NOT NULL DEFAULT 0,
  `ct_qty` mediumint(8) unsigned NOT NULL DEFAULT 1,
  `ct_cost` decimal(9,2) unsigned NOT NULL,
  `ct_price` decimal(9,2) unsigned NOT NULL,
  `ct_session_id` char(32) NOT NULL DEFAULT '',
  `ct_date` varchar(50) DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT 0,
  `is_type` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '1=pc, 2=ib, 3=bx',
  PRIMARY KEY (`ct_id`),
  KEY `pd_id` (`pd_id`),
  KEY `ct_session_id` (`ct_session_id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tbl_cart_receive: 0 rows
/*!40000 ALTER TABLE `tbl_cart_receive` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_cart_receive` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.tbl_cart_return
CREATE TABLE IF NOT EXISTS `tbl_cart_return` (
  `ct_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pd_id` int(10) unsigned NOT NULL DEFAULT 0,
  `ct_qty` mediumint(8) unsigned NOT NULL DEFAULT 1,
  `ct_cost` decimal(9,2) unsigned NOT NULL,
  `ct_price` decimal(9,2) unsigned NOT NULL,
  `ct_session_id` char(32) NOT NULL DEFAULT '',
  `ct_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(10) unsigned NOT NULL DEFAULT 0,
  `is_type` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`ct_id`),
  KEY `pd_id` (`pd_id`),
  KEY `ct_session_id` (`ct_session_id`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tbl_cart_return: 0 rows
/*!40000 ALTER TABLE `tbl_cart_return` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_cart_return` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.tbl_category
CREATE TABLE IF NOT EXISTS `tbl_category` (
  `cat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_parent_id` int(11) NOT NULL DEFAULT 0,
  `cat_name` varchar(50) NOT NULL DEFAULT '',
  `cat_description` varchar(200) NOT NULL DEFAULT '',
  `cat_image` varchar(255) NOT NULL DEFAULT '',
  `is_deleted` int(1) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tbl_category: 7 rows
/*!40000 ALTER TABLE `tbl_category` DISABLE KEYS */;
INSERT INTO `tbl_category` (`cat_id`, `cat_parent_id`, `cat_name`, `cat_description`, `cat_image`, `is_deleted`) VALUES
	(1, 0, 'Finish Product', '', '', 0),
	(2, 0, 'Raw Material', '', '', 0),
	(3, 2, 'items', '', '', 0),
	(4, 1, 'items', '', '', 0),
	(5, 0, 'Other Safety Products', '', '', 0),
	(6, 5, 'Items', '', '', 0),
	(7, 0, 'Fire ex', '5lbs', '', 1);
/*!40000 ALTER TABLE `tbl_category` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.tbl_job_order
CREATE TABLE IF NOT EXISTS `tbl_job_order` (
  `jo_id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) DEFAULT NULL,
  `joi_id` int(11) NOT NULL,
  `job_order_number` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `added_by` int(100) NOT NULL DEFAULT 0,
  `date_added` varchar(100) NOT NULL,
  `is_deleted` int(1) NOT NULL DEFAULT 0,
  `uid` varchar(100) NOT NULL,
  PRIMARY KEY (`jo_id`) USING BTREE,
  KEY `joi_id` (`joi_id`),
  KEY `branch_id` (`branch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_luvimar.tbl_job_order: ~2 rows (approximately)
INSERT INTO `tbl_job_order` (`jo_id`, `branch_id`, `joi_id`, `job_order_number`, `status`, `added_by`, `date_added`, `is_deleted`, `uid`) VALUES
	(1, NULL, 0, '1', 'completed', 1002, '2026-04-06', 0, ''),
	(2, NULL, 0, '2', 'completed', 1002, '2026-06-08', 0, '');

-- Dumping structure for table db_luvimar.tbl_jo_items
CREATE TABLE IF NOT EXISTS `tbl_jo_items` (
  `joi_id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `cust_id` varchar(100) NOT NULL,
  `pd_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `pd_name` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `pd_price` decimal(9,2) NOT NULL DEFAULT 0.00,
  `pd_serial` varchar(244) NOT NULL,
  `description` varchar(244) NOT NULL,
  `job_description` varchar(244) NOT NULL,
  `date_needed` varchar(110) NOT NULL,
  `remarks` varchar(244) NOT NULL,
  `joi_date_added` varchar(110) NOT NULL,
  `added_by` varchar(110) NOT NULL,
  `date_modified` varchar(110) NOT NULL,
  `date_deleted` varchar(110) NOT NULL,
  `uid` varchar(110) NOT NULL,
  `is_deleted` int(1) NOT NULL DEFAULT 0,
  `is_submitted` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`joi_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_luvimar.tbl_jo_items: ~1 rows (approximately)
INSERT INTO `tbl_jo_items` (`joi_id`, `branch_id`, `cust_id`, `pd_id`, `customer_name`, `pd_name`, `qty`, `pd_price`, `pd_serial`, `description`, `job_description`, `date_needed`, `remarks`, `joi_date_added`, `added_by`, `date_modified`, `date_deleted`, `uid`, `is_deleted`, `is_submitted`) VALUES
	(2, 1006, '5', 1, 'Bacolod', 'sample', 10, 10.00, '1', 'sample ', 'brandnew', '2026-04-23', '', '2026-04-06', '1002', '', '', 'c81e728d9d4c2f636f067f89cc14862c', 0, 1),
	(3, 1006, '5', 17, 'Bacolod', 'product 2', 2, 111.00, '', 'product 2 ', 'brandnew', '2026-06-08', '', '2026-06-08', '1002', '', '', 'eccbc87e4b5ce2fe28308fd9f2a7baf3', 0, 1);

-- Dumping structure for table db_luvimar.tbl_jo_items_new
CREATE TABLE IF NOT EXISTS `tbl_jo_items_new` (
  `join_id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `cust_id` varchar(100) NOT NULL,
  `pd_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `pd_name` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `pd_price` decimal(9,2) NOT NULL DEFAULT 0.00,
  `pd_serial` varchar(244) NOT NULL,
  `description` varchar(244) NOT NULL,
  `job_description` varchar(244) NOT NULL,
  `date_needed` varchar(110) NOT NULL,
  `remarks` varchar(244) NOT NULL,
  `join_date_added` varchar(110) NOT NULL,
  `added_by` varchar(110) NOT NULL,
  `date_modified` varchar(110) NOT NULL,
  `date_deleted` varchar(110) NOT NULL,
  `uid` varchar(110) NOT NULL,
  `is_deleted` int(1) NOT NULL DEFAULT 0,
  `is_submitted` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`join_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_luvimar.tbl_jo_items_new: ~0 rows (approximately)

-- Dumping structure for table db_luvimar.tbl_jo_list
CREATE TABLE IF NOT EXISTS `tbl_jo_list` (
  `jol_id` int(11) NOT NULL AUTO_INCREMENT,
  `joi_id` int(11) NOT NULL DEFAULT 0,
  `jo_id` int(11) NOT NULL DEFAULT 0,
  `pd_id` int(11) NOT NULL DEFAULT 0,
  `cust_id` int(11) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `added_by` varchar(100) DEFAULT NULL,
  `is_deleted` int(1) DEFAULT 0,
  `uid` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`jol_id`),
  KEY `joi_id` (`joi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_luvimar.tbl_jo_list: ~1 rows (approximately)
INSERT INTO `tbl_jo_list` (`jol_id`, `joi_id`, `jo_id`, `pd_id`, `cust_id`, `branch_id`, `user_id`, `added_by`, `is_deleted`, `uid`) VALUES
	(1, 2, 1, 1, 5, 1006, 1002, '1002', 0, NULL),
	(2, 3, 2, 17, 5, 1006, 1002, '1002', 0, NULL);

-- Dumping structure for table db_luvimar.tbl_jo_list_new
CREATE TABLE IF NOT EXISTS `tbl_jo_list_new` (
  `joln_id` int(11) NOT NULL AUTO_INCREMENT,
  `join_id` int(11) NOT NULL DEFAULT 0,
  `jo_id` int(11) NOT NULL DEFAULT 0,
  `pd_id` int(11) NOT NULL DEFAULT 0,
  `cust_id` int(11) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `added_by` varchar(100) DEFAULT NULL,
  `is_deleted` int(1) DEFAULT 0,
  `uid` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`joln_id`),
  KEY `join_id` (`join_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_luvimar.tbl_jo_list_new: ~0 rows (approximately)

-- Dumping structure for table db_luvimar.tbl_order
CREATE TABLE IF NOT EXISTS `tbl_order` (
  `od_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cust_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `invoice_num` varchar(100) NOT NULL,
  `or_num` varchar(100) NOT NULL,
  `jo_num` varchar(100) NOT NULL,
  `dr_num` varchar(100) NOT NULL,
  `po_num` varchar(100) NOT NULL,
  `person_received` varchar(200) NOT NULL,
  `terms_in_days` decimal(9,2) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `payment_mode` varchar(100) NOT NULL,
  `transaction_code` varchar(100) NOT NULL,
  `od_amount_due` decimal(9,2) NOT NULL,
  `od_discount` decimal(9,2) NOT NULL,
  `percent_discount` decimal(9,2) NOT NULL,
  `od_total_amt_due` decimal(9,2) NOT NULL,
  `od_cost` decimal(9,2) NOT NULL,
  `od_payment` decimal(9,2) NOT NULL,
  `od_change` decimal(9,2) NOT NULL,
  `od_collected_amount` decimal(9,2) NOT NULL,
  `dc_id` int(10) NOT NULL,
  `od_date` datetime DEFAULT NULL,
  `od_date_1` date DEFAULT NULL,
  `od_paid_date` date DEFAULT NULL,
  `date_due` date DEFAULT NULL,
  `delivery_date` varchar(70) DEFAULT NULL,
  `delivery_address` text DEFAULT NULL,
  `driver` varchar(70) DEFAULT NULL,
  `delivery_id` int(10) DEFAULT NULL,
  `is_delivery` int(1) unsigned NOT NULL,
  `is_delivered` int(1) unsigned NOT NULL,
  `is_open` int(1) unsigned NOT NULL,
  `is_paid` int(1) unsigned NOT NULL,
  `is_charge` int(1) unsigned NOT NULL,
  `is_foodpanda` int(1) unsigned NOT NULL,
  `is_deleted` int(1) unsigned NOT NULL,
  `released_by` int(10) unsigned NOT NULL,
  `deleted_by` int(10) unsigned NOT NULL,
  `date_deleted` datetime NOT NULL,
  `remarks` varchar(777) DEFAULT NULL,
  PRIMARY KEY (`od_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tbl_order: 0 rows
/*!40000 ALTER TABLE `tbl_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_order` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.tbl_order_item
CREATE TABLE IF NOT EXISTS `tbl_order_item` (
  `odi_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `od_id` int(10) unsigned NOT NULL DEFAULT 0,
  `pd_id` int(10) unsigned NOT NULL DEFAULT 0,
  `cust_id` int(10) unsigned NOT NULL DEFAULT 0,
  `branch_id` int(10) NOT NULL DEFAULT 0,
  `od_qty` int(10) unsigned NOT NULL DEFAULT 0,
  `od_price` decimal(9,2) NOT NULL,
  `od_cost` decimal(9,2) NOT NULL,
  `pd_qty_left` decimal(9,2) NOT NULL,
  `pd_type` varchar(70) NOT NULL,
  `odi_description` varchar(70) NOT NULL,
  `odi_job_description` varchar(70) NOT NULL,
  `is_accepted` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`odi_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tbl_order_item: 0 rows
/*!40000 ALTER TABLE `tbl_order_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_order_item` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.tbl_product
CREATE TABLE IF NOT EXISTS `tbl_product` (
  `pd_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` int(10) unsigned NOT NULL DEFAULT 0,
  `cat_parent_id` int(10) unsigned NOT NULL DEFAULT 0,
  `pd_barcode` varchar(100) NOT NULL DEFAULT '',
  `pd_name` varchar(100) NOT NULL DEFAULT '',
  `pd_name7` varchar(100) NOT NULL DEFAULT '',
  `pd_description` text NOT NULL,
  `pd_keyword` text NOT NULL,
  `pd_cost` decimal(9,2) NOT NULL DEFAULT 0.00,
  `pc_formula` decimal(9,2) DEFAULT NULL,
  `ib_formula` decimal(9,2) DEFAULT NULL,
  `bx_formula` decimal(9,2) DEFAULT NULL,
  `pc_price` decimal(9,2) DEFAULT NULL,
  `ib_price` decimal(9,2) DEFAULT NULL,
  `bx_price` decimal(9,2) DEFAULT NULL,
  `pc_qty` int(100) DEFAULT NULL,
  `ib_qty` decimal(9,2) DEFAULT 0.00,
  `bx_qty` decimal(9,2) DEFAULT 0.00,
  `pd_qty` decimal(9,2) DEFAULT NULL,
  `pd_mqty` decimal(9,2) DEFAULT NULL,
  `pd_expiration` varchar(100) DEFAULT NULL,
  `pd_image` varchar(200) DEFAULT NULL,
  `pd_thumbnail` varchar(200) DEFAULT NULL,
  `is_deleted` int(1) NOT NULL,
  `is_sold` int(1) NOT NULL,
  `is_added` int(1) NOT NULL,
  `date_added` varchar(50) DEFAULT NULL,
  `date_modified` varchar(50) DEFAULT NULL,
  `date_deleted` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`pd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tbl_product: 15 rows
/*!40000 ALTER TABLE `tbl_product` DISABLE KEYS */;
INSERT INTO `tbl_product` (`pd_id`, `cat_id`, `cat_parent_id`, `pd_barcode`, `pd_name`, `pd_name7`, `pd_description`, `pd_keyword`, `pd_cost`, `pc_formula`, `ib_formula`, `bx_formula`, `pc_price`, `ib_price`, `bx_price`, `pc_qty`, `ib_qty`, `bx_qty`, `pd_qty`, `pd_mqty`, `pd_expiration`, `pd_image`, `pd_thumbnail`, `is_deleted`, `is_sold`, `is_added`, `date_added`, `date_modified`, `date_deleted`) VALUES
	(1, 4, 1, '1', 'sample', 'sample', '', 'Finish Product', 10.00, 0.00, 0.00, 0.00, 10.00, 0.00, 0.00, 1, 0.00, 0.00, NULL, 0.00, '', '', '', 0, 0, 0, '2026-04-06 17:40:36', NULL, NULL),
	(17, 4, 1, '', 'product 2', 'product 2', '', 'Finish Product', 11.00, 0.00, 0.00, 0.00, 111.00, 0.00, 0.00, 11, 0.00, 0.00, NULL, 0.00, '', '', '', 0, 0, 0, '2026-06-08 10:17:58', NULL, NULL),
	(18, 4, 1, '', 'product 4', 'product 4', '', 'Finish Product', 11.00, 0.00, 0.00, 0.00, 111.00, 0.00, 0.00, 11, 0.00, 0.00, NULL, 0.00, '', '', '', 0, 0, 0, '2026-06-08 10:18:54', NULL, NULL),
	(19, 4, 1, '0000002', 'sample', 'sample', '', 'Finish Product', 10.00, NULL, NULL, NULL, 10.00, NULL, NULL, 1, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, '2026', NULL, NULL),
	(20, 4, 1, '0000003', 'sample', 'sample', '', 'Finish Product', 10.00, NULL, NULL, NULL, 10.00, NULL, NULL, 1, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, '2026', NULL, NULL),
	(21, 4, 1, '0000004', 'sample', 'sample', '', 'Finish Product', 10.00, NULL, NULL, NULL, 10.00, NULL, NULL, 1, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, '2026', NULL, NULL),
	(22, 4, 1, '0000005', 'sample', 'sample', '', 'Finish Product', 10.00, NULL, NULL, NULL, 10.00, NULL, NULL, 1, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, '2026', NULL, NULL),
	(23, 4, 1, '0000006', 'sample', 'sample', '', 'Finish Product', 10.00, NULL, NULL, NULL, 10.00, NULL, NULL, 1, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, '2026', NULL, NULL),
	(24, 4, 1, '0000007', 'sample', 'sample', '', 'Finish Product', 10.00, NULL, NULL, NULL, 10.00, NULL, NULL, 1, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, '2026', NULL, NULL),
	(25, 4, 1, '0000008', 'sample', 'sample', '', 'Finish Product', 10.00, NULL, NULL, NULL, 10.00, NULL, NULL, 1, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, '2026', NULL, NULL),
	(26, 4, 1, '0000009', 'sample', 'sample', '', 'Finish Product', 10.00, NULL, NULL, NULL, 10.00, NULL, NULL, 1, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, '2026', NULL, NULL),
	(27, 4, 1, '0000010', 'sample', 'sample', '', 'Finish Product', 10.00, NULL, NULL, NULL, 10.00, NULL, NULL, 1, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, '2026', NULL, NULL),
	(28, 4, 1, '0000011', 'sample', 'sample', '', 'Finish Product', 10.00, NULL, NULL, NULL, 10.00, NULL, NULL, 1, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, '2026', NULL, NULL),
	(29, 4, 1, '0000012', 'product 2', 'product 2', '', 'Finish Product', 11.00, NULL, NULL, NULL, 111.00, NULL, NULL, 1, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, '2026', NULL, NULL),
	(30, 4, 1, '0000013', 'product 2', 'product 2', '', 'Finish Product', 11.00, NULL, NULL, NULL, 111.00, NULL, NULL, 1, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, '2026', NULL, NULL);
/*!40000 ALTER TABLE `tbl_product` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.tbl_production_report
CREATE TABLE IF NOT EXISTS `tbl_production_report` (
  `pr_id` int(11) NOT NULL AUTO_INCREMENT,
  `jo_id` int(11) NOT NULL,
  `pr_num` varchar(100) NOT NULL DEFAULT '',
  `added_by` varchar(100) NOT NULL DEFAULT '',
  `status` varchar(100) NOT NULL DEFAULT '',
  `date_added` varchar(100) NOT NULL DEFAULT '',
  `is_deleted` varchar(100) NOT NULL DEFAULT '',
  `uid` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`pr_id`),
  KEY `jo_id` (`jo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_luvimar.tbl_production_report: ~2 rows (approximately)
INSERT INTO `tbl_production_report` (`pr_id`, `jo_id`, `pr_num`, `added_by`, `status`, `date_added`, `is_deleted`, `uid`) VALUES
	(1, 1, '1', '1002', 'completed', '2026-06-08', '', 'c4ca4238a0b923820dcc509a6f75849b'),
	(2, 2, '3', '1002', 'completed', '2026-06-08', '', 'c81e728d9d4c2f636f067f89cc14862c');

-- Dumping structure for table db_luvimar.tbl_product_log
CREATE TABLE IF NOT EXISTS `tbl_product_log` (
  `plog_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pd_id` int(10) unsigned NOT NULL DEFAULT 0,
  `pd_name` varchar(100) NOT NULL DEFAULT '',
  `pd_cost` decimal(9,2) NOT NULL DEFAULT 0.00,
  `pd_price` decimal(9,2) NOT NULL DEFAULT 0.00,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`plog_id`),
  KEY `pd_id` (`pd_id`),
  KEY `pd_name` (`pd_name`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tbl_product_log: 5 rows
/*!40000 ALTER TABLE `tbl_product_log` DISABLE KEYS */;
INSERT INTO `tbl_product_log` (`plog_id`, `pd_id`, `pd_name`, `pd_cost`, `pd_price`, `date_added`) VALUES
	(1, 1, 'Cy1', 11.00, 0.00, '2025-08-08 10:26:05'),
	(2, 3, 'Cylinder', 123.00, 0.00, '2025-08-27 16:20:33'),
	(3, 2, 'Nozzle', 20.00, 0.00, '2025-08-27 16:20:33'),
	(4, 2, 'Nozzle', 20.00, 0.00, '2025-08-27 16:21:41'),
	(5, 3, 'Cylinder', 123.00, 0.00, '2025-08-27 16:21:41');
/*!40000 ALTER TABLE `tbl_product_log` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.tbl_pr_items
CREATE TABLE IF NOT EXISTS `tbl_pr_items` (
  `pri_id` int(11) NOT NULL AUTO_INCREMENT,
  `jo_id` int(11) NOT NULL DEFAULT 0,
  `cust_id` int(11) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `pd_id` int(11) NOT NULL DEFAULT 0,
  `pr_qty` int(11) NOT NULL DEFAULT 0,
  `pr_serialf` varchar(240) NOT NULL,
  `pr_price` varchar(240) NOT NULL,
  `pr_description` varchar(240) NOT NULL,
  `part_replacement` varchar(240) DEFAULT NULL,
  `pr_remarks` varchar(240) DEFAULT NULL,
  `pr_date_added` varchar(240) DEFAULT NULL,
  `added_by` varchar(240) DEFAULT NULL,
  `date_modified` varchar(240) DEFAULT NULL,
  `date_deleted` varchar(240) DEFAULT NULL,
  `uid` varchar(240) DEFAULT NULL,
  `is_deleted` int(1) DEFAULT 0,
  `is_submitted` int(1) DEFAULT 0,
  PRIMARY KEY (`pri_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_luvimar.tbl_pr_items: ~1 rows (approximately)
INSERT INTO `tbl_pr_items` (`pri_id`, `jo_id`, `cust_id`, `branch_id`, `pd_id`, `pr_qty`, `pr_serialf`, `pr_price`, `pr_description`, `part_replacement`, `pr_remarks`, `pr_date_added`, `added_by`, `date_modified`, `date_deleted`, `uid`, `is_deleted`, `is_submitted`) VALUES
	(1, 1, 5, 1006, 1, 10, '1', '10.00', 'sample', NULL, NULL, '2026-04-06', '1002', NULL, NULL, 'c4ca4238a0b923820dcc509a6f75849b', 0, 1),
	(3, 2, 5, 1006, 17, 2, '', '111.00', 'product 2', NULL, NULL, '2026-06-08', '1002', NULL, NULL, 'eccbc87e4b5ce2fe28308fd9f2a7baf3', 0, 1);

-- Dumping structure for table db_luvimar.tbl_pr_list
CREATE TABLE IF NOT EXISTS `tbl_pr_list` (
  `prl_id` int(11) NOT NULL AUTO_INCREMENT,
  `pri_id` int(11) DEFAULT NULL,
  `pr_id` int(11) DEFAULT NULL,
  `pd_id` int(11) DEFAULT NULL,
  `pr_serial` varchar(240) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `added_by` varchar(100) DEFAULT NULL,
  `pr_date_added` varchar(100) DEFAULT NULL,
  `date_deleted` varchar(100) DEFAULT NULL,
  `is_deleted` int(1) DEFAULT 0,
  `uid` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`prl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_luvimar.tbl_pr_list: ~2 rows (approximately)
INSERT INTO `tbl_pr_list` (`prl_id`, `pri_id`, `pr_id`, `pd_id`, `pr_serial`, `branch_id`, `user_id`, `added_by`, `pr_date_added`, `date_deleted`, `is_deleted`, `uid`) VALUES
	(1, 1, 1, 1, NULL, 1006, 1002, '1002', '2026-06-08', NULL, 0, NULL),
	(2, 3, 2, 17, '0000012, 0000013', 1006, 1002, '1002', '2026-06-08', NULL, 0, NULL);

-- Dumping structure for table db_luvimar.tbl_received
CREATE TABLE IF NOT EXISTS `tbl_received` (
  `rec_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sup_id` int(10) unsigned NOT NULL,
  `payment_method` varchar(17) NOT NULL,
  `or_num` varchar(70) NOT NULL,
  `dr_num` varchar(70) NOT NULL,
  `terms` int(10) NOT NULL,
  `total_cost` decimal(9,2) NOT NULL,
  `is_paid` tinyint(1) unsigned NOT NULL,
  `is_charge` tinyint(1) unsigned NOT NULL,
  `is_deleted` tinyint(1) unsigned NOT NULL,
  `added_by` int(10) unsigned NOT NULL DEFAULT 0,
  `date_added` varchar(50) DEFAULT NULL,
  `date_deleted` varchar(50) DEFAULT NULL,
  `date_added_ymd` varchar(50) DEFAULT NULL,
  `date_due` varchar(50) DEFAULT NULL,
  `paid_date` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`rec_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Dumping data for table db_luvimar.tbl_received: 0 rows
/*!40000 ALTER TABLE `tbl_received` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_received` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.tbl_received_item
CREATE TABLE IF NOT EXISTS `tbl_received_item` (
  `reci_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rec_id` int(10) unsigned NOT NULL DEFAULT 0,
  `pd_id` int(10) unsigned NOT NULL DEFAULT 0,
  `pd_qty_left` int(10) unsigned NOT NULL DEFAULT 0,
  `pd_mqty` varchar(50) DEFAULT NULL,
  `od_qty_added` int(10) unsigned NOT NULL DEFAULT 0,
  `pd_cost` decimal(9,2) unsigned NOT NULL,
  `added_by` int(10) unsigned NOT NULL DEFAULT 0,
  `date_added` varchar(50) DEFAULT NULL,
  `date_added_ymd` varchar(50) DEFAULT NULL,
  `pd_type` varchar(70) NOT NULL,
  `is_deleted` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`reci_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Dumping data for table db_luvimar.tbl_received_item: 0 rows
/*!40000 ALTER TABLE `tbl_received_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_received_item` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.tbl_returned
CREATE TABLE IF NOT EXISTS `tbl_returned` (
  `ret_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sup_id` int(10) unsigned NOT NULL,
  `cust_id` int(10) unsigned NOT NULL,
  `total_cost` decimal(9,2) NOT NULL,
  `is_deleted` tinyint(1) unsigned NOT NULL,
  `added_by` int(10) unsigned NOT NULL DEFAULT 0,
  `date_added` varchar(50) DEFAULT NULL,
  `date_deleted` varchar(50) DEFAULT NULL,
  `date_added_ymd` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ret_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Dumping data for table db_luvimar.tbl_returned: 0 rows
/*!40000 ALTER TABLE `tbl_returned` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_returned` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.tbl_returned_item
CREATE TABLE IF NOT EXISTS `tbl_returned_item` (
  `reti_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ret_id` int(10) unsigned NOT NULL DEFAULT 0,
  `pd_id` int(10) unsigned NOT NULL DEFAULT 0,
  `pd_qty_left` int(10) unsigned NOT NULL DEFAULT 0,
  `pd_mqty` varchar(50) DEFAULT NULL,
  `od_qty_added` int(10) unsigned NOT NULL DEFAULT 0,
  `pd_cost` decimal(9,2) unsigned NOT NULL,
  `added_by` int(10) unsigned NOT NULL DEFAULT 0,
  `date_added` varchar(50) DEFAULT NULL,
  `date_added_ymd` varchar(50) DEFAULT NULL,
  `pd_type` varchar(70) NOT NULL,
  PRIMARY KEY (`reti_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Dumping data for table db_luvimar.tbl_returned_item: 0 rows
/*!40000 ALTER TABLE `tbl_returned_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_returned_item` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.tbl_sms
CREATE TABLE IF NOT EXISTS `tbl_sms` (
  `id_sms` int(11) NOT NULL AUTO_INCREMENT,
  `pd_id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `is_sent` int(1) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT '',
  `exp_date` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_sms`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_luvimar.tbl_sms: ~0 rows (approximately)

-- Dumping structure for table db_luvimar.tr_expense
CREATE TABLE IF NOT EXISTS `tr_expense` (
  `exp_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ec_id` int(10) unsigned DEFAULT NULL,
  `amount` decimal(9,2) NOT NULL,
  `details` text NOT NULL,
  `vat` varchar(150) DEFAULT NULL,
  `tin_no` int(100) DEFAULT NULL,
  `or_no` int(100) NOT NULL,
  `is_deleted` tinyint(1) unsigned NOT NULL,
  `exp_date_added` varchar(50) DEFAULT NULL,
  `date_modified` varchar(50) DEFAULT NULL,
  `date_deleted` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`exp_id`),
  KEY `ec_id` (`ec_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tr_expense: 0 rows
/*!40000 ALTER TABLE `tr_expense` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_expense` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.tr_expense_category
CREATE TABLE IF NOT EXISTS `tr_expense_category` (
  `ec_id` int(11) NOT NULL AUTO_INCREMENT,
  `expense_category_name` varchar(255) DEFAULT NULL,
  `cat_details` varchar(1000) NOT NULL,
  `expense` bigint(255) NOT NULL,
  `date_added` varchar(100) NOT NULL DEFAULT '',
  `date_deleted` varchar(100) NOT NULL DEFAULT '',
  `date_modified` varchar(100) NOT NULL DEFAULT '',
  `is_deleted` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ec_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_luvimar.tr_expense_category: ~0 rows (approximately)

-- Dumping structure for table db_luvimar.tr_graph_gross_current
CREATE TABLE IF NOT EXISTS `tr_graph_gross_current` (
  `sg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `branch_id` int(10) unsigned NOT NULL,
  `date_name` varchar(100) NOT NULL,
  `total_sales` decimal(9,2) NOT NULL,
  `od_date` date DEFAULT NULL,
  PRIMARY KEY (`sg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5920 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tr_graph_gross_current: 93 rows
/*!40000 ALTER TABLE `tr_graph_gross_current` DISABLE KEYS */;
INSERT INTO `tr_graph_gross_current` (`sg_id`, `branch_id`, `date_name`, `total_sales`, `od_date`) VALUES
	(5827, 1002, 'Mar 08, 2026', 0.00, '2026-03-08'),
	(5828, 1002, 'Mar 09, 2026', 0.00, '2026-03-09'),
	(5829, 1002, 'Mar 10, 2026', 0.00, '2026-03-10'),
	(5830, 1002, 'Mar 11, 2026', 0.00, '2026-03-11'),
	(5831, 1002, 'Mar 12, 2026', 0.00, '2026-03-12'),
	(5832, 1002, 'Mar 13, 2026', 0.00, '2026-03-13'),
	(5833, 1002, 'Mar 14, 2026', 0.00, '2026-03-14'),
	(5834, 1002, 'Mar 15, 2026', 0.00, '2026-03-15'),
	(5835, 1002, 'Mar 16, 2026', 0.00, '2026-03-16'),
	(5836, 1002, 'Mar 17, 2026', 0.00, '2026-03-17'),
	(5837, 1002, 'Mar 18, 2026', 0.00, '2026-03-18'),
	(5838, 1002, 'Mar 19, 2026', 0.00, '2026-03-19'),
	(5839, 1002, 'Mar 20, 2026', 0.00, '2026-03-20'),
	(5840, 1002, 'Mar 21, 2026', 0.00, '2026-03-21'),
	(5841, 1002, 'Mar 22, 2026', 0.00, '2026-03-22'),
	(5842, 1002, 'Mar 23, 2026', 0.00, '2026-03-23'),
	(5843, 1002, 'Mar 24, 2026', 0.00, '2026-03-24'),
	(5844, 1002, 'Mar 25, 2026', 0.00, '2026-03-25'),
	(5845, 1002, 'Mar 26, 2026', 0.00, '2026-03-26'),
	(5846, 1002, 'Mar 27, 2026', 0.00, '2026-03-27'),
	(5847, 1002, 'Mar 28, 2026', 0.00, '2026-03-28'),
	(5848, 1002, 'Mar 29, 2026', 0.00, '2026-03-29'),
	(5849, 1002, 'Mar 30, 2026', 0.00, '2026-03-30'),
	(5850, 1002, 'Mar 31, 2026', 0.00, '2026-03-31'),
	(5851, 1002, 'Apr 01, 2026', 0.00, '2026-04-01'),
	(5852, 1002, 'Apr 02, 2026', 0.00, '2026-04-02'),
	(5853, 1002, 'Apr 03, 2026', 0.00, '2026-04-03'),
	(5854, 1002, 'Apr 04, 2026', 0.00, '2026-04-04'),
	(5855, 1002, 'Apr 05, 2026', 0.00, '2026-04-05'),
	(5856, 1002, 'Apr 06, 2026', 0.00, '2026-04-06'),
	(5857, 1002, 'Apr 07, 2026', 0.00, '2026-04-07'),
	(5858, 1002, 'Apr 08, 2026', 0.00, '2026-04-08'),
	(5859, 1002, 'Apr 09, 2026', 0.00, '2026-04-09'),
	(5860, 1002, 'Apr 10, 2026', 0.00, '2026-04-10'),
	(5861, 1002, 'Apr 11, 2026', 0.00, '2026-04-11'),
	(5862, 1002, 'Apr 12, 2026', 0.00, '2026-04-12'),
	(5863, 1002, 'Apr 13, 2026', 0.00, '2026-04-13'),
	(5864, 1002, 'Apr 14, 2026', 0.00, '2026-04-14'),
	(5865, 1002, 'Apr 15, 2026', 0.00, '2026-04-15'),
	(5866, 1002, 'Apr 16, 2026', 0.00, '2026-04-16'),
	(5867, 1002, 'Apr 17, 2026', 0.00, '2026-04-17'),
	(5868, 1002, 'Apr 18, 2026', 0.00, '2026-04-18'),
	(5869, 1002, 'Apr 19, 2026', 0.00, '2026-04-19'),
	(5870, 1002, 'Apr 20, 2026', 0.00, '2026-04-20'),
	(5871, 1002, 'Apr 21, 2026', 0.00, '2026-04-21'),
	(5872, 1002, 'Apr 22, 2026', 0.00, '2026-04-22'),
	(5873, 1002, 'Apr 23, 2026', 0.00, '2026-04-23'),
	(5874, 1002, 'Apr 24, 2026', 0.00, '2026-04-24'),
	(5875, 1002, 'Apr 25, 2026', 0.00, '2026-04-25'),
	(5876, 1002, 'Apr 26, 2026', 0.00, '2026-04-26'),
	(5877, 1002, 'Apr 27, 2026', 0.00, '2026-04-27'),
	(5878, 1002, 'Apr 28, 2026', 0.00, '2026-04-28'),
	(5879, 1002, 'Apr 29, 2026', 0.00, '2026-04-29'),
	(5880, 1002, 'Apr 30, 2026', 0.00, '2026-04-30'),
	(5881, 1002, 'May 01, 2026', 0.00, '2026-05-01'),
	(5882, 1002, 'May 02, 2026', 0.00, '2026-05-02'),
	(5883, 1002, 'May 03, 2026', 0.00, '2026-05-03'),
	(5884, 1002, 'May 04, 2026', 0.00, '2026-05-04'),
	(5885, 1002, 'May 05, 2026', 0.00, '2026-05-05'),
	(5886, 1002, 'May 06, 2026', 0.00, '2026-05-06'),
	(5887, 1002, 'May 07, 2026', 0.00, '2026-05-07'),
	(5888, 1002, 'May 08, 2026', 0.00, '2026-05-08'),
	(5889, 1002, 'May 09, 2026', 0.00, '2026-05-09'),
	(5890, 1002, 'May 10, 2026', 0.00, '2026-05-10'),
	(5891, 1002, 'May 11, 2026', 0.00, '2026-05-11'),
	(5892, 1002, 'May 12, 2026', 0.00, '2026-05-12'),
	(5893, 1002, 'May 13, 2026', 0.00, '2026-05-13'),
	(5894, 1002, 'May 14, 2026', 0.00, '2026-05-14'),
	(5895, 1002, 'May 15, 2026', 0.00, '2026-05-15'),
	(5896, 1002, 'May 16, 2026', 0.00, '2026-05-16'),
	(5897, 1002, 'May 17, 2026', 0.00, '2026-05-17'),
	(5898, 1002, 'May 18, 2026', 0.00, '2026-05-18'),
	(5899, 1002, 'May 19, 2026', 0.00, '2026-05-19'),
	(5900, 1002, 'May 20, 2026', 0.00, '2026-05-20'),
	(5901, 1002, 'May 21, 2026', 0.00, '2026-05-21'),
	(5902, 1002, 'May 22, 2026', 0.00, '2026-05-22'),
	(5903, 1002, 'May 23, 2026', 0.00, '2026-05-23'),
	(5904, 1002, 'May 24, 2026', 0.00, '2026-05-24'),
	(5905, 1002, 'May 25, 2026', 0.00, '2026-05-25'),
	(5906, 1002, 'May 26, 2026', 0.00, '2026-05-26'),
	(5907, 1002, 'May 27, 2026', 0.00, '2026-05-27'),
	(5908, 1002, 'May 28, 2026', 0.00, '2026-05-28'),
	(5909, 1002, 'May 29, 2026', 0.00, '2026-05-29'),
	(5910, 1002, 'May 30, 2026', 0.00, '2026-05-30'),
	(5911, 1002, 'May 31, 2026', 0.00, '2026-05-31'),
	(5912, 1002, 'Jun 01, 2026', 0.00, '2026-06-01'),
	(5913, 1002, 'Jun 02, 2026', 0.00, '2026-06-02'),
	(5914, 1002, 'Jun 03, 2026', 0.00, '2026-06-03'),
	(5915, 1002, 'Jun 04, 2026', 0.00, '2026-06-04'),
	(5916, 1002, 'Jun 05, 2026', 0.00, '2026-06-05'),
	(5917, 1002, 'Jun 06, 2026', 0.00, '2026-06-06'),
	(5918, 1002, 'Jun 07, 2026', 0.00, '2026-06-07'),
	(5919, 1002, 'Jun 08, 2026', 0.00, '2026-06-08');
/*!40000 ALTER TABLE `tr_graph_gross_current` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.tr_graph_net_current
CREATE TABLE IF NOT EXISTS `tr_graph_net_current` (
  `sg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `branch_id` int(10) unsigned NOT NULL,
  `date_name` varchar(100) NOT NULL,
  `total_sales` decimal(9,2) NOT NULL,
  `od_date` date DEFAULT NULL,
  PRIMARY KEY (`sg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=261 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tr_graph_net_current: 4 rows
/*!40000 ALTER TABLE `tr_graph_net_current` DISABLE KEYS */;
INSERT INTO `tr_graph_net_current` (`sg_id`, `branch_id`, `date_name`, `total_sales`, `od_date`) VALUES
	(257, 1002, 'Jun 05, 2026', 0.00, '2026-06-05'),
	(258, 1002, 'Jun 06, 2026', 0.00, '2026-06-06'),
	(259, 1002, 'Jun 07, 2026', 0.00, '2026-06-07'),
	(260, 1002, 'Jun 08, 2026', 0.00, '2026-06-08');
/*!40000 ALTER TABLE `tr_graph_net_current` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.tr_graph_product_current
CREATE TABLE IF NOT EXISTS `tr_graph_product_current` (
  `sg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `branch_id` int(10) unsigned NOT NULL,
  `pd_id` int(10) unsigned NOT NULL,
  `pd_name` varchar(100) NOT NULL,
  `total_qty` decimal(9,2) NOT NULL,
  `od_date` date DEFAULT NULL,
  `pd_type` varchar(70) NOT NULL,
  PRIMARY KEY (`sg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tr_graph_product_current: 1 rows
/*!40000 ALTER TABLE `tr_graph_product_current` DISABLE KEYS */;
INSERT INTO `tr_graph_product_current` (`sg_id`, `branch_id`, `pd_id`, `pd_name`, `total_qty`, `od_date`, `pd_type`) VALUES
	(1, 0, 2, 'fire ex', 1.00, '2026-04-01', 'pc');
/*!40000 ALTER TABLE `tr_graph_product_current` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.tr_log
CREATE TABLE IF NOT EXISTS `tr_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action` varchar(400) NOT NULL,
  `description` varchar(200) NOT NULL DEFAULT '',
  `category` varchar(100) NOT NULL DEFAULT '',
  `action_by` varchar(10) NOT NULL,
  `log_action_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `action_by` (`action_by`)
) ENGINE=MyISAM AUTO_INCREMENT=321 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tr_log: 320 rows
/*!40000 ALTER TABLE `tr_log` DISABLE KEYS */;
INSERT INTO `tr_log` (`id`, `action`, `description`, `category`, `action_by`, `log_action_date`) VALUES
	(1, 'Product added', '10lbs', 'product', '1002', '2025-08-21 12:04:59'),
	(2, 'Product added', 'Nozzle', 'product', '1002', '2025-08-21 12:07:17'),
	(3, 'Customer added', 'LUVIMAR', 'customer', '1002', '2025-08-21 12:11:11'),
	(4, 'job order added', '', 'product', '1002', '2025-08-21 12:12:54'),
	(5, 'Job order Item deleted', 'Job order item', 'product', '1002', '2025-08-21 12:14:35'),
	(6, 'job order added', '', 'product', '1002', '2025-08-21 12:15:23'),
	(7, 'Customer added', '', 'customer', '1002', '2025-08-21 12:28:03'),
	(8, 'Production Report added', '10lbs MAP', 'production', '1002', '2025-08-21 12:35:29'),
	(9, 'Production Report added', 'k', 'production', '1002', '2025-08-21 12:39:21'),
	(10, 'job order added', '', 'product', '1002', '2025-08-22 12:24:30'),
	(11, 'Product added', 'Cylinder', 'product', '1002', '2025-08-22 14:15:37'),
	(12, 'job order added', '', 'product', '1002', '2025-08-22 14:16:20'),
	(13, 'job order added', '', 'product', '1002', '2025-08-22 14:16:33'),
	(14, 'job order added', '', 'product', '1002', '2025-08-22 14:17:36'),
	(15, 'Image deleted', 'Admin&nbsp;Admin', 'user', '1002', '2025-08-26 09:58:18'),
	(16, 'Job order Item deleted', 'Job order item', 'product', '1002', '2025-08-26 10:03:44'),
	(17, 'Job order Item deleted', 'Job order item', 'product', '1002', '2025-08-26 10:10:17'),
	(18, 'Job order Item deleted', 'Job order item', 'product', '1002', '2025-08-26 10:10:18'),
	(19, 'Job order Item deleted', 'Job order item', 'product', '1002', '2025-08-26 10:10:19'),
	(20, 'Job order Item deleted', 'Job order item', 'product', '1002', '2025-08-26 10:21:20'),
	(21, 'Supplier added', 'Crave', 'supplier', '1002', '2025-08-27 16:20:14'),
	(22, 'Product modified', '10lbs', 'product', '1002', '2025-08-29 14:11:44'),
	(23, 'Product modified', '10lbs', 'product', '1002', '2025-08-29 14:12:02'),
	(24, 'Product modified', '10lbs', 'product', '1002', '2025-08-31 17:28:48'),
	(25, 'Product modified', '10lbs', 'product', '1002', '2025-08-31 17:31:34'),
	(26, 'job order added', '', 'product', '1002', '2025-09-05 21:30:15'),
	(27, 'Job order Item deleted', 'Job order item', 'product', '1002', '2025-09-05 21:31:35'),
	(28, 'Production modified', '', 'product', '1002', '2025-09-05 22:18:36'),
	(29, 'Production modified', '', 'product', '1002', '2025-09-05 22:20:25'),
	(30, 'Production modified', '', 'product', '1002', '2025-09-05 22:23:54'),
	(31, 'Production modified', '', 'product', '1002', '2025-09-05 22:25:27'),
	(32, 'Production modified', '', 'product', '1002', '2025-09-05 22:25:46'),
	(33, 'Production modified', '', 'product', '1002', '2025-09-05 22:27:06'),
	(34, 'Job order Item deleted', 'Job order item', 'product', '1002', '2025-09-05 22:34:29'),
	(35, 'Job order Item deleted', 'Job order item', 'product', '1002', '2025-09-05 22:34:30'),
	(36, 'Job order Item deleted', 'Job order item', 'product', '1002', '2025-09-05 22:34:31'),
	(37, 'job order added', '', 'product', '1002', '2025-09-05 22:59:15'),
	(38, 'Job order Item deleted', 'Job order item', 'product', '1002', '2025-09-05 23:07:25'),
	(39, 'job order added', '', 'product', '1002', '2025-09-05 23:07:49'),
	(40, 'job order added', '', 'product', '1002', '2025-09-05 23:08:28'),
	(41, 'Job order Item deleted', 'Job order item', 'product', '1002', '2025-09-05 23:09:03'),
	(42, 'Job order Item deleted', 'Job order item', 'product', '1002', '2025-09-05 23:09:04'),
	(43, 'Job order Item deleted', 'Job order item', 'product', '1002', '2025-09-05 23:09:05'),
	(44, 'Job order Item deleted', 'Job order item', 'product', '1002', '2025-09-06 07:35:10'),
	(45, 'Job order Item deleted', 'Job order item', 'product', '1002', '2025-09-06 07:35:17'),
	(46, 'Job order Item deleted', 'Job order item', 'product', '1002', '2025-09-06 07:35:45'),
	(47, 'Job order Item deleted', 'Job order item', 'product', '1002', '2025-09-06 07:35:46'),
	(48, 'Job order Item deleted', 'Job order item', 'product', '1002', '2025-09-06 07:35:52'),
	(49, 'job order added', '', 'product', '1002', '2025-09-06 07:38:25'),
	(50, 'job order added', '', 'product', '1002', '2025-09-06 07:39:08'),
	(51, 'Production modified', '', 'product', '1002', '2025-09-06 07:40:59'),
	(52, 'Production modified', '', 'product', '1002', '2025-09-06 07:41:11'),
	(53, 'Production modified', '', 'product', '1002', '2025-09-06 07:41:41'),
	(54, 'Production Report added', '2', 'production', '1002', '2025-09-06 09:10:14'),
	(55, 'Production Report added', '123', 'production', '1002', '2025-09-06 09:17:17'),
	(56, 'Job order Item deleted', 'Job order item', 'product', '1002', '2025-09-06 09:17:58'),
	(57, 'Production Report added', '3', 'production', '1002', '2025-09-06 09:18:14'),
	(58, 'Production Report added', '133', 'production', '1002', '2025-09-06 09:32:07'),
	(59, 'Production Report added', '1', 'production', '1002', '2025-09-06 09:36:22'),
	(60, 'Product added', 'Dry Chemical Fire Extinguisher 10lbs', 'product', '1002', '2025-09-06 14:10:55'),
	(61, 'Customer added', 'Juan De la Cruz', 'customer', '1002', '2025-09-06 14:12:38'),
	(62, 'job order added', '', 'product', '1002', '2025-09-06 14:15:29'),
	(63, 'Production modified', '', 'product', '1002', '2025-09-06 14:23:04'),
	(64, 'Product added', 'Dry Chemical Fire Extinguisher 10lbs', 'product', '1002', '2025-09-06 14:27:43'),
	(65, 'Product added', 'Emergency Light', 'product', '1002', '2025-09-06 14:43:46'),
	(66, 'Customer added', 'Walk In', 'customer', '1002', '2025-09-06 14:44:59'),
	(67, 'Beginning balance added', '2025-09-06 14:46:57 - 1000', 'beginning balance', '1002', '2025-09-06 14:46:57'),
	(68, 'Expense added', '500', 'expense', '1002', '2025-09-06 00:00:00'),
	(69, 'Product modified', 'Emergency Light', 'product', '1002', '2026-01-05 10:12:31'),
	(70, 'job order added', '', 'product', '1002', '2026-01-06 16:31:23'),
	(71, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-01-06 16:34:31'),
	(72, 'job order added', '', 'product', '1002', '2026-01-07 09:37:48'),
	(73, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-01-07 09:37:51'),
	(74, 'job order added', '', 'product', '1002', '2026-01-07 09:38:01'),
	(75, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-01-07 09:38:04'),
	(76, 'job order added', '', 'product', '1002', '2026-01-07 10:51:29'),
	(77, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-01-07 10:51:41'),
	(78, 'job order added', '', 'product', '1002', '2026-01-07 11:16:57'),
	(79, 'job order added', '', 'product', '1002', '2026-01-07 11:17:04'),
	(80, 'job order added', '', 'product', '1002', '2026-01-07 14:25:39'),
	(81, 'job order added', '', 'product', '1002', '2026-01-07 14:25:47'),
	(82, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-01-07 14:32:05'),
	(83, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-01-07 14:32:05'),
	(84, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-01-07 14:32:20'),
	(85, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-01-07 14:32:21'),
	(86, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-01-07 15:00:32'),
	(87, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-01-07 15:00:33'),
	(88, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-01-07 15:01:01'),
	(89, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-01-07 15:01:02'),
	(90, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-01-07 15:07:38'),
	(91, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-01-07 15:07:39'),
	(92, 'job order added', '', 'product', '1002', '2026-01-07 15:14:59'),
	(93, 'job order added', '', 'product', '1002', '2026-01-07 15:15:10'),
	(94, 'job order added', '', 'product', '1002', '2026-01-07 16:10:25'),
	(95, 'job order added', '', 'product', '1002', '2026-01-07 16:10:34'),
	(96, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-01-07 16:10:50'),
	(97, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-01-07 16:11:13'),
	(98, 'job order added', '', 'product', '1002', '2026-01-07 16:11:22'),
	(99, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-01-07 16:33:02'),
	(100, 'job order added', '', 'product', '1002', '2026-01-07 16:33:16'),
	(101, 'job order added', '', 'product', '1002', '2026-01-07 16:33:23'),
	(102, 'job order added', '', 'product', '1002', '2026-01-07 16:36:22'),
	(103, 'job order added', '', 'product', '1002', '2026-01-07 16:36:29'),
	(104, 'job order added', '', 'product', '1002', '2026-01-07 16:38:09'),
	(105, 'job order added', '', 'product', '1002', '2026-01-07 16:38:30'),
	(106, 'job order added', '', 'product', '1002', '2026-01-07 16:40:55'),
	(107, 'job order added', '', 'product', '1002', '2026-01-07 16:41:02'),
	(108, 'job order added', '', 'product', '1002', '2026-01-07 16:46:39'),
	(109, 'job order added', '', 'product', '1002', '2026-01-07 16:46:49'),
	(110, 'job order added', '', 'product', '1002', '2026-01-07 16:50:55'),
	(111, 'job order added', '', 'product', '1002', '2026-01-07 16:50:59'),
	(112, 'job order added', '', 'product', '1002', '2026-01-07 16:51:03'),
	(113, 'job order added', '', 'product', '1002', '2026-01-07 16:56:16'),
	(114, 'job order added', '', 'product', '1002', '2026-01-07 16:56:19'),
	(115, 'job order added', '', 'product', '1002', '2026-01-07 16:56:23'),
	(116, 'job order added', '', 'product', '1002', '2026-01-07 17:00:25'),
	(117, 'job order added', '', 'product', '1002', '2026-01-07 17:00:30'),
	(118, 'job order added', '', 'product', '1002', '2026-01-07 17:00:34'),
	(119, 'job order added', '', 'product', '1002', '2026-01-07 17:04:59'),
	(120, 'job order added', '', 'product', '1002', '2026-01-07 17:05:02'),
	(121, 'job order added', '', 'product', '1002', '2026-01-07 17:05:06'),
	(122, 'job order added', '', 'product', '1002', '2026-01-07 17:07:33'),
	(123, 'job order added', '', 'product', '1002', '2026-01-07 17:07:49'),
	(124, 'job order added', '', 'product', '1002', '2026-01-07 17:07:52'),
	(125, 'job order added', '', 'product', '1002', '2026-01-07 17:11:16'),
	(126, 'job order added', '', 'product', '1002', '2026-01-07 17:11:20'),
	(127, 'job order added', '', 'product', '1002', '2026-01-07 17:11:29'),
	(128, 'job order added', '', 'product', '1002', '2026-01-07 17:13:34'),
	(129, 'job order added', '', 'product', '1002', '2026-01-07 17:13:37'),
	(130, 'job order added', '', 'product', '1002', '2026-01-07 17:13:43'),
	(131, 'job order added', '', 'product', '1002', '2026-01-07 17:14:09'),
	(132, 'job order added', '', 'product', '1002', '2026-01-07 17:14:12'),
	(133, 'job order added', '', 'product', '1002', '2026-01-07 17:14:19'),
	(134, 'job order added', '', 'product', '1002', '2026-01-07 17:17:35'),
	(135, 'job order added', '', 'product', '1002', '2026-01-07 17:17:39'),
	(136, 'job order added', '', 'product', '1002', '2026-01-07 17:17:42'),
	(137, 'job order added', '', 'product', '1002', '2026-01-07 17:19:55'),
	(138, 'job order added', '', 'product', '1002', '2026-01-07 17:19:59'),
	(139, 'job order added', '', 'product', '1002', '2026-01-07 17:20:02'),
	(140, 'job order added', '', 'product', '1002', '2026-01-07 17:21:17'),
	(141, 'job order added', '', 'product', '1002', '2026-01-07 17:21:23'),
	(142, 'job order added', '', 'product', '1002', '2026-01-07 17:21:28'),
	(143, 'job order added', '', 'product', '1002', '2026-01-07 17:23:42'),
	(144, 'job order added', '', 'product', '1002', '2026-01-07 17:23:56'),
	(145, 'job order added', '', 'product', '1002', '2026-01-07 17:23:59'),
	(146, 'job order added', '', 'product', '1002', '2026-01-07 17:26:32'),
	(147, 'job order added', '', 'product', '1002', '2026-01-07 17:26:35'),
	(148, 'job order added', '', 'product', '1002', '2026-01-07 17:26:38'),
	(149, 'job order added', '', 'product', '1002', '2026-01-07 17:27:44'),
	(150, 'job order added', '', 'product', '1002', '2026-01-07 17:27:47'),
	(151, 'job order added', '', 'product', '1002', '2026-01-07 17:27:50'),
	(152, 'job order added', '', 'product', '1002', '2026-01-07 17:29:22'),
	(153, 'job order added', '', 'product', '1002', '2026-01-07 17:29:26'),
	(154, 'job order added', '', 'product', '1002', '2026-01-07 17:29:28'),
	(155, 'job order added', '', 'product', '1002', '2026-01-09 17:17:03'),
	(156, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-01-09 17:17:09'),
	(157, 'Expense added', '', 'expense', '1002', '2026-01-09 00:00:00'),
	(158, 'Customer added', 'Luvimar', 'customer', '1002', '2026-01-09 21:07:56'),
	(159, 'job order added', '', 'product', '1002', '2026-01-09 21:09:10'),
	(160, 'job order added', '', 'product', '1002', '2026-01-09 21:10:38'),
	(161, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-01-09 21:20:43'),
	(162, 'job order added', '', 'product', '1002', '2026-01-09 21:23:52'),
	(163, 'job order added', '', 'product', '1002', '2026-01-09 21:24:09'),
	(164, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-01-09 21:24:24'),
	(165, 'Production modified', '', 'product', '1002', '2026-01-09 21:26:31'),
	(166, 'job order added', '', 'product', '1002', '2026-01-09 21:37:45'),
	(167, 'job order added', '', 'product', '1002', '2026-01-09 21:37:55'),
	(168, 'job order added', '', 'product', '1002', '2026-01-09 21:40:40'),
	(169, 'job order added', '', 'product', '1002', '2026-01-09 21:40:46'),
	(170, 'job order added', '', 'product', '1002', '2026-01-09 21:40:52'),
	(171, 'job order added', '', 'product', '1002', '2026-01-09 21:42:20'),
	(172, 'job order added', '', 'product', '1002', '2026-01-18 11:01:46'),
	(173, 'job order added', '', 'product', '1002', '2026-01-18 11:01:53'),
	(174, 'job order added', '', 'product', '1002', '2026-01-18 11:01:58'),
	(175, 'job order added', '', 'product', '1002', '2026-01-18 11:02:45'),
	(176, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-01-18 11:04:16'),
	(177, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-01-18 11:04:24'),
	(178, 'job order added', '', 'product', '1002', '2026-01-18 11:05:33'),
	(179, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-01-18 11:05:36'),
	(180, 'Expense added', '', 'expense', '1002', '2026-01-19 00:00:00'),
	(181, 'Expense Category deleted', '2', 'expense', '1002', '2026-01-19 10:33:32'),
	(182, 'Expense Category deleted', '1', 'expense', '1002', '2026-01-19 10:52:31'),
	(183, 'Expense added', '', 'expense', '1002', '2026-01-19 00:00:00'),
	(184, 'Expense added', '', 'expense', '1002', '2026-01-19 00:00:00'),
	(185, 'Expense added', '', 'expense', '1002', '2026-01-19 00:00:00'),
	(186, 'Expense NAme', '3', 'expense', '1002', '2026-01-19 11:01:20'),
	(187, 'Expense NAme', '3', 'expense', '1002', '2026-01-19 11:01:23'),
	(188, 'Expense NAme', '3', 'expense', '1002', '2026-01-19 11:04:05'),
	(189, 'Expense NAme', '5', 'expense', '1002', '2026-01-19 11:07:06'),
	(190, 'Expense NAme', '4', 'expense', '1002', '2026-01-19 11:07:08'),
	(191, 'Expense Category deleted', '5', 'expense', '1002', '2026-01-19 11:07:14'),
	(192, 'Expense Category deleted', '4', 'expense', '1002', '2026-01-19 11:07:16'),
	(193, 'Expense Category deleted', '3', 'expense', '1002', '2026-01-19 11:07:18'),
	(194, 'Expense added', '', 'expense', '1002', '2026-01-24 00:00:00'),
	(195, 'Expense added', '1000', 'expense', '1002', '2026-01-24 00:00:00'),
	(196, 'job order added', '', 'product', '1002', '2026-01-24 11:41:02'),
	(197, 'job order added', '', 'product', '1002', '2026-01-24 11:41:18'),
	(198, 'job order added', '', 'product', '1002', '2026-01-24 11:41:29'),
	(199, 'job order added', '', 'product', '1002', '2026-01-24 12:27:21'),
	(200, 'job order added', '', 'product', '1002', '2026-01-24 12:27:35'),
	(201, 'job order added', '', 'product', '1002', '2026-01-24 12:27:48'),
	(202, 'Customer added', 'luvim', 'customer', '1002', '2026-02-01 19:31:19'),
	(203, 'job order added', '', 'product', '1002', '2026-02-01 19:32:13'),
	(204, 'Production modified', '', 'product', '1002', '2026-02-01 19:33:10'),
	(205, 'Product modified', 'Dry Chemical Fire Extinguisher 10lbs', 'product', '1002', '2026-02-01 19:35:04'),
	(206, 'Expense added', '', 'expense', '1002', '2026-02-01 00:00:00'),
	(207, 'Expense added', '155', 'expense', '1002', '2026-02-01 00:00:00'),
	(208, 'Expense added', '100', 'expense', '1002', '2026-02-01 00:00:00'),
	(209, 'Product modified', 'Dry Chemical Fire Extinguisher 10lbs', 'product', '1002', '2026-02-01 19:40:39'),
	(210, 'Expense added', '100', 'expense', '1002', '2026-02-09 00:00:00'),
	(211, 'Product modified', 'Emergency Light', 'product', '1002', '2026-02-09 22:21:57'),
	(212, 'job order added', '', 'product', '1002', '2026-02-09 22:27:17'),
	(213, 'Product added', 'sample product', 'product', '1002', '2026-02-10 12:49:58'),
	(214, 'Product added', 'Flashligh', 'product', '1002', '2026-02-13 21:23:50'),
	(215, 'Expense added', '1000', 'expense', '1002', '2026-02-13 00:00:00'),
	(216, 'Expense Category deleted', '7', 'expense', '1002', '2026-02-13 22:33:47'),
	(217, 'Expense Category deleted', '6', 'expense', '1002', '2026-02-13 22:33:51'),
	(218, 'Expense Category deleted', '2', 'expense', '1002', '2026-02-13 22:33:54'),
	(219, 'job order added', '', 'product', '1002', '2026-02-16 12:24:21'),
	(220, 'job order added', '', 'product', '1002', '2026-02-16 12:38:43'),
	(221, 'job order added', '', 'product', '1002', '2026-02-16 12:38:58'),
	(222, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-02-16 12:39:12'),
	(223, 'Production modified', '', 'product', '1002', '2026-02-16 12:47:10'),
	(224, 'Production modified', '', 'product', '1002', '2026-02-16 12:49:15'),
	(225, 'Product modified', 'Dry Chemical Fire Extinguisher 10lbs', 'product', '1002', '2026-02-16 13:32:36'),
	(226, 'Expense added', '', 'expense', '1002', '2026-02-16 00:00:00'),
	(227, 'Expense added', '100', 'expense', '1002', '2026-02-16 00:00:00'),
	(228, 'job order added', '', 'product', '1002', '2026-02-19 22:44:53'),
	(229, 'job order added', '', 'product', '1002', '2026-02-19 22:45:19'),
	(230, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-02-22 14:27:25'),
	(231, 'job order added', '', 'product', '1002', '2026-02-22 14:27:42'),
	(232, 'job order added', '', 'product', '1002', '2026-02-22 14:32:23'),
	(233, 'job order added', '', 'product', '1002', '2026-02-22 14:32:43'),
	(234, 'job order added', '', 'product', '1002', '2026-02-22 14:35:31'),
	(235, 'job order added', '', 'product', '1002', '2026-02-22 15:03:37'),
	(236, 'job order added', '', 'product', '1002', '2026-02-22 15:03:51'),
	(237, 'job order added', '', 'product', '1002', '2026-02-22 15:17:06'),
	(238, 'job order added', '', 'product', '1002', '2026-02-22 15:17:36'),
	(239, 'job order added', '', 'product', '1002', '2026-02-26 22:37:52'),
	(240, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-02-26 22:38:12'),
	(241, 'Product modified', 'Dry Chemical Fire Extinguisher 10lbs', 'product', '1002', '2026-02-26 22:38:56'),
	(242, 'Production modified', '', 'product', '1002', '2026-02-27 13:54:08'),
	(243, 'Production modified', '', 'product', '1002', '2026-02-27 13:54:12'),
	(244, 'Production modified', '', 'product', '1002', '2026-02-27 13:54:19'),
	(245, 'Production modified', '', 'product', '1002', '2026-02-27 13:54:45'),
	(246, 'job order added', '', 'product', '1002', '2026-02-27 15:26:07'),
	(247, 'job order added', '', 'product', '1002', '2026-02-27 15:26:29'),
	(248, 'job order added', '', 'product', '1002', '2026-02-27 15:30:06'),
	(249, 'job order added', '', 'product', '1002', '2026-02-27 15:30:16'),
	(250, 'job order added', '', 'product', '1002', '2026-02-27 15:52:11'),
	(251, 'job order added', '', 'product', '1002', '2026-02-27 15:52:34'),
	(252, 'job order added', '', 'product', '1002', '2026-02-27 15:58:16'),
	(253, 'job order added', '', 'product', '1002', '2026-02-27 16:01:03'),
	(254, 'job order added', '', 'product', '1002', '2026-02-27 16:01:12'),
	(255, 'job order added', '', 'product', '1002', '2026-02-27 16:04:58'),
	(256, 'job order added', '', 'product', '1002', '2026-02-27 16:05:15'),
	(257, 'job order added', '', 'product', '1002', '2026-02-27 16:07:45'),
	(258, 'job order added', '', 'product', '1002', '2026-02-27 16:08:57'),
	(259, 'job order added', '', 'product', '1002', '2026-02-27 16:09:04'),
	(260, 'job order added', '', 'product', '1002', '2026-02-27 16:22:55'),
	(261, 'job order added', '', 'product', '1002', '2026-02-28 22:41:47'),
	(262, 'job order added', '', 'product', '1002', '2026-02-28 22:42:22'),
	(263, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-02-28 22:42:26'),
	(264, 'job order added', '', 'product', '1002', '2026-02-28 22:43:02'),
	(265, 'Expense modified', '1', 'expense', '1002', '2026-03-01 19:01:38'),
	(266, 'Customer modified', 'luvim', 'customer', '1002', '2026-03-06 21:18:17'),
	(267, 'job order added', '', 'product', '1002', '2026-03-06 21:25:40'),
	(268, 'job order added', '', 'product', '1002', '2026-03-06 21:26:34'),
	(269, 'job order added', '', 'product', '1002', '2026-03-06 21:41:26'),
	(270, 'job order added', '', 'product', '1002', '2026-03-07 10:44:19'),
	(271, 'job order added', '', 'product', '1002', '2026-03-07 10:57:08'),
	(272, 'job order added', '', 'product', '1002', '2026-04-01 17:33:47'),
	(273, 'job order added', '', 'product', '1002', '2026-04-01 17:34:01'),
	(274, 'Product added', 'sample22', 'product', '1002', '2026-04-01 17:40:01'),
	(275, 'job order added', '', 'product', '1002', '2026-04-01 17:40:39'),
	(276, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-04-01 17:41:03'),
	(277, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-04-01 17:41:04'),
	(278, 'job order added', '', 'product', '1002', '2026-04-01 17:41:38'),
	(279, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-04-01 17:41:51'),
	(280, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-04-01 17:41:53'),
	(281, 'Customer modified', 'luvim', 'customer', '1002', '2026-04-01 19:07:41'),
	(282, 'Product added', 'fire ex', 'product', '1002', '2026-04-01 19:12:49'),
	(283, 'job order added', '', 'product', '1002', '2026-04-01 19:13:08'),
	(284, 'Product modified', 'fire ex', 'product', '1002', '2026-04-01 19:15:59'),
	(285, 'job order added', '', 'product', '1002', '2026-04-01 19:16:36'),
	(286, 'Product added', 'Fire Extinguisher 5lbs', 'product', '1002', '2026-04-01 19:22:31'),
	(287, 'Customer deleted', 'Juan De la Cruz', 'customer', '1002', '2026-04-01 19:22:39'),
	(288, 'Customer deleted', 'luvim', 'customer', '1002', '2026-04-01 19:22:43'),
	(289, 'Customer added', 'Bacolod', 'customer', '1002', '2026-04-01 19:23:47'),
	(290, 'job order added', '', 'product', '1002', '2026-04-01 19:24:22'),
	(291, 'job order added', '', 'product', '1002', '2026-04-01 19:29:50'),
	(292, 'Product added', 'Raw mats', 'product', '1002', '2026-04-01 19:30:59'),
	(293, 'job order added', '', 'product', '1002', '2026-04-03 21:09:29'),
	(294, 'job order added', '', 'product', '1002', '2026-04-03 21:45:28'),
	(295, 'job order added', '', 'product', '1002', '2026-04-03 21:51:56'),
	(296, 'job order added', '', 'product', '1002', '2026-04-03 22:01:22'),
	(297, 'job order added', '', 'product', '1002', '2026-04-03 22:03:50'),
	(298, 'job order added', '', 'product', '1002', '2026-04-03 22:29:41'),
	(299, 'job order added', '', 'product', '1002', '2026-04-03 22:32:19'),
	(300, 'job order added', '', 'product', '1002', '2026-04-03 22:32:34'),
	(301, 'job order added', '', 'product', '1002', '2026-04-03 22:36:25'),
	(302, 'job order added', '', 'product', '1002', '2026-04-03 22:36:57'),
	(303, 'job order added', '', 'product', '1002', '2026-04-03 22:37:34'),
	(304, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-04-03 22:37:58'),
	(305, 'job order added', '', 'product', '1002', '2026-04-03 22:41:37'),
	(306, 'job order added', '', 'product', '1002', '2026-04-03 22:41:54'),
	(307, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-04-03 22:43:52'),
	(308, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-04-03 22:43:54'),
	(309, 'job order added', '', 'product', '1002', '2026-04-03 22:44:25'),
	(310, 'job order added', '', 'product', '1002', '2026-04-03 22:44:43'),
	(311, 'Product added', 'sample', 'product', '1002', '2026-04-06 17:40:36'),
	(312, 'job order added', '', 'product', '1002', '2026-04-06 17:40:54'),
	(313, 'job order added', '', 'product', '1002', '2026-04-06 17:49:58'),
	(314, 'job order added', '', 'product', '1002', '2026-04-06 17:54:24'),
	(315, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-04-06 17:55:45'),
	(316, 'job order added', '', 'product', '1002', '2026-04-06 17:55:58'),
	(317, 'Product added', 'product 2', 'product', '1002', '2026-06-08 10:17:58'),
	(318, 'Product added', 'product 4', 'product', '1002', '2026-06-08 10:18:54'),
	(319, 'job order added', '', 'product', '1002', '2026-06-08 10:36:29'),
	(320, 'Job order Item deleted', 'Job order item', 'product', '1002', '2026-06-08 10:39:10');
/*!40000 ALTER TABLE `tr_log` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.tr_login_attempt
CREATE TABLE IF NOT EXISTS `tr_login_attempt` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `rand` int(10) NOT NULL,
  `ip` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `status` int(10) NOT NULL,
  `auth` int(10) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `idnumber` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tr_login_attempt: 54 rows
/*!40000 ALTER TABLE `tr_login_attempt` DISABLE KEYS */;
INSERT INTO `tr_login_attempt` (`id`, `rand`, `ip`, `username`, `password`, `status`, `auth`, `datetime`, `idnumber`) VALUES
	(1, 3877, '::1', 'admin', '1234', 0, 0, '2025-08-21 11:56:55', ''),
	(2, 7277, '::1', 'admin', '1234', 0, 0, '2025-08-22 10:56:23', ''),
	(3, 2821, '::1', 'admin', '1234', 0, 0, '2025-08-26 09:51:42', ''),
	(4, 1791, '::1', 'admin', '1234', 0, 0, '2025-08-27 09:57:35', ''),
	(5, 6558, '::1', 'admin', '1234', 0, 0, '2025-08-27 09:59:05', ''),
	(6, 3347, '::1', 'admin', '11234', 0, 1, '2025-08-27 16:19:16', ''),
	(7, 2404, '::1', 'admin', 'admin', 0, 1, '2025-08-27 16:19:20', ''),
	(8, 8648, '::1', 'admin', '1234', 0, 0, '2025-08-27 16:19:24', ''),
	(9, 5753, '::1', 'admin', '1234', 0, 0, '2025-08-28 10:28:40', ''),
	(10, 8113, '::1', 'admin', '1234', 0, 0, '2025-08-28 14:19:11', ''),
	(11, 5218, '::1', 'admin', '1234', 0, 0, '2025-08-29 10:04:18', ''),
	(12, 6965, '::1', 'admin', '1234', 0, 0, '2025-08-31 17:22:29', ''),
	(13, 7327, '::1', 'admin', '1234', 0, 0, '2025-09-03 11:31:00', ''),
	(14, 2390, '::1', 'admin', '1234', 0, 0, '2025-09-04 16:16:01', ''),
	(15, 5984, '::1', 'admin', '1234', 0, 0, '2025-09-05 21:12:53', ''),
	(16, 8153, '::1', 'admin', '1234', 0, 0, '2025-09-06 07:29:04', ''),
	(17, 5726, '::1', 'admin', '1234', 0, 0, '2025-09-06 09:09:25', ''),
	(18, 6724, '::1', 'admin', '1234', 0, 0, '2025-09-06 14:06:11', ''),
	(19, 8848, '::1', 'admin', '1234', 0, 0, '2025-09-09 13:16:29', ''),
	(20, 7422, '::1', 'admin', '1234', 0, 0, '2026-01-02 17:42:01', ''),
	(21, 6337, '::1', 'admin', '1234', 0, 0, '2026-01-05 10:00:51', ''),
	(22, 4625, '::1', 'admin', '1234', 0, 0, '2026-01-06 09:28:22', ''),
	(23, 7996, '::1', 'admin', '1234', 0, 0, '2026-01-07 09:37:13', ''),
	(24, 7938, '::1', 'admin', '1234', 0, 0, '2026-01-09 17:00:15', ''),
	(25, 5395, '::1', 'admin', '1234', 0, 0, '2026-01-09 21:02:34', ''),
	(26, 6363, '::1', 'admin', '1234', 0, 0, '2026-01-18 10:55:37', ''),
	(27, 1052, '::1', 'admin', '1234', 0, 0, '2026-01-19 09:38:02', ''),
	(28, 2914, '::1', 'admin', '1234', 0, 0, '2026-01-24 11:06:38', ''),
	(29, 3594, '::1', 'admin', '1234', 0, 0, '2026-02-01 19:26:21', ''),
	(30, 2878, '::1', 'admin', '1234', 0, 0, '2026-02-01 19:29:20', ''),
	(31, 5350, '::1', 'admin', '1234', 0, 0, '2026-02-09 22:20:29', ''),
	(32, 5890, '::1', 'admin', '1234', 0, 0, '2026-02-10 11:43:09', ''),
	(33, 8016, '::1', 'admin', '1234', 0, 0, '2026-02-13 21:10:48', ''),
	(34, 5043, '::1', 'admin', '1234', 0, 0, '2026-02-13 21:31:57', ''),
	(35, 3192, '::1', 'admin', '1234', 0, 0, '2026-02-16 12:18:44', ''),
	(36, 8796, '::1', 'admin', '12344', 0, 1, '2026-02-19 22:07:29', ''),
	(37, 2218, '::1', 'admin', '1234', 0, 0, '2026-02-19 22:07:35', ''),
	(38, 3090, '::1', 'admin', '1234', 0, 0, '2026-02-22 11:08:37', ''),
	(39, 6364, '::1', 'admin ', '1234', 0, 0, '2026-02-26 19:47:44', ''),
	(40, 5288, '::1', 'admin', '1234', 0, 0, '2026-02-26 21:57:22', ''),
	(41, 2136, '::1', 'admin', '1234', 0, 0, '2026-02-26 22:04:42', ''),
	(42, 6552, '::1', 'admin', '1234', 0, 0, '2026-02-26 22:05:18', ''),
	(43, 4323, '::1', 'admin', '1234', 0, 0, '2026-02-26 22:06:14', ''),
	(44, 1314, '::1', 'admin', '1234', 0, 0, '2026-02-26 22:12:34', ''),
	(45, 3537, '::1', 'admin', '1234', 0, 0, '2026-02-27 13:43:13', ''),
	(46, 1097, '::1', 'admin', '1234', 0, 0, '2026-02-27 13:43:45', ''),
	(47, 5137, '::1', 'admin', '1234', 0, 0, '2026-02-27 13:43:59', ''),
	(48, 5153, '::1', 'admin', '1234', 0, 0, '2026-03-03 14:11:48', ''),
	(49, 4374, '::1', 'admin', '1234', 0, 0, '2026-03-06 21:16:23', ''),
	(50, 7943, '::1', 'admin', '1234', 0, 0, '2026-03-18 13:33:42', ''),
	(51, 6569, '::1', 'admin', '1234', 0, 0, '2026-04-01 17:33:17', ''),
	(52, 5237, '::1', 'admin', '1234', 0, 0, '2026-04-06 10:44:06', ''),
	(53, 2648, '::1', 'admin', 'admin', 0, 1, '2026-06-08 10:12:45', ''),
	(54, 3246, '::1', 'admin', '1234', 0, 0, '2026-06-08 10:12:48', '');
/*!40000 ALTER TABLE `tr_login_attempt` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.tr_payment
CREATE TABLE IF NOT EXISTS `tr_payment` (
  `pay_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cust_id` int(10) unsigned NOT NULL,
  `od_id` int(10) unsigned NOT NULL,
  `or_number` varchar(50) NOT NULL,
  `amount_due` decimal(9,2) NOT NULL,
  `amount_paid` decimal(9,2) NOT NULL,
  `balance` decimal(9,2) NOT NULL,
  `payment_method` varchar(17) NOT NULL,
  `check_no` varchar(17) NOT NULL,
  `check_date` date NOT NULL DEFAULT '0000-00-00',
  `bank` varchar(70) NOT NULL,
  `action_by` int(10) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `date_paid` date NOT NULL DEFAULT '0000-00-00',
  `date_time_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_time_deleted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`pay_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tr_payment: 0 rows
/*!40000 ALTER TABLE `tr_payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_payment` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.tr_payment_supplier
CREATE TABLE IF NOT EXISTS `tr_payment_supplier` (
  `pays_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sup_id` int(10) unsigned NOT NULL,
  `rec_id` int(10) unsigned NOT NULL,
  `or_number` varchar(50) NOT NULL,
  `amount_due` decimal(9,2) NOT NULL,
  `amount_paid` decimal(9,2) NOT NULL,
  `balance` decimal(9,2) NOT NULL,
  `payment_method` varchar(17) NOT NULL,
  `check_no` varchar(17) NOT NULL,
  `check_date` date NOT NULL DEFAULT '0000-00-00',
  `bank` varchar(70) NOT NULL,
  `action_by` int(10) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL,
  `date_paid` date NOT NULL DEFAULT '0000-00-00',
  `date_time_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_time_deleted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`pays_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tr_payment_supplier: 0 rows
/*!40000 ALTER TABLE `tr_payment_supplier` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_payment_supplier` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.tr_sales_graph
CREATE TABLE IF NOT EXISTS `tr_sales_graph` (
  `sg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `branch_id` int(10) unsigned NOT NULL,
  `date_name` varchar(100) NOT NULL,
  `total_sales` decimal(9,2) NOT NULL,
  `od_date` date DEFAULT NULL,
  PRIMARY KEY (`sg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tr_sales_graph: 0 rows
/*!40000 ALTER TABLE `tr_sales_graph` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_sales_graph` ENABLE KEYS */;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
