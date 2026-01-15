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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Dumping data for table db_luvimar.bs_customer: ~2 rows (approximately)
INSERT INTO `bs_customer` (`cust_id`, `branch_id`, `client_name`, `address`, `customer_name`, `contact_person`, `contactno`, `email`, `image`, `thumbnail`, `is_deleted`, `is_branch`, `date_added`, `date_modified`, `date_deleted`, `last_login`) VALUES
	(1, 0, 'Juan De la Cruz', '', 'Juan De la Cruz', '', '09952681811', '', '', '', 0, 0, '2025-09-06 14:12:38', NULL, NULL, NULL),
	(2, 0, 'Walk In', '', 'Walk in', '', '', '', '', '', 0, 0, '2025-09-06 14:44:59', NULL, NULL, NULL),
	(3, 0, 'Luvimar', 'Bacolod', 'Luvi', 'Jess', '123456789', '', '', '', 0, 0, '2026-01-09 21:07:56', NULL, NULL, NULL);

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

-- Dumping data for table db_luvimar.bs_report: 8 rows
/*!40000 ALTER TABLE `bs_report` DISABLE KEYS */;
INSERT INTO `bs_report` (`report_id`, `name`, `description`, `page`, `is_deleted`, `date_added`, `date_deleted`) VALUES
	(1001, 'Released Product', 'Displays released products', 'release', 0, '2015-07-28 02:51:10', '0000-00-00 00:00:00'),
	(1013, 'Sales Detail', 'Displays total sales', 'sales', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(1014, 'Received Product', 'Displays received products', 'receive', 1, '2016-05-15 22:35:45', '0000-00-00 00:00:00'),
	(1015, 'Inventory', 'Displays inventory of products', 'inventory', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(1016, 'Sales Graph', 'Displays sales graph', 'sales_graph', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(1017, 'Accounts Receivable', 'Displays accounts receivable', 'ar_detail', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(1018, 'Returned Product', 'Displays returned products', 'returned', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(1019, 'Transfer', 'Displays transfer product', 'transfer', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Dumping data for table db_luvimar.bs_supplier: ~0 rows (approximately)
INSERT INTO `bs_supplier` (`sup_id`, `company_name`, `firstname`, `lastname`, `contactno`, `address`, `image`, `thumbnail`, `is_deleted`, `date_added`, `date_modified`, `date_deleted`, `last_login`) VALUES
	(1, 'Crave', '', '', '', '', '', '', 0, '2025-08-27 16:20:14', NULL, NULL, NULL);

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
	(1002, '1600109', 'Admin', 'Admin', 'admin@gmail.com', 'admin', '81dc9bdb52d04dc20036dbd8313ed055', '1234', 'Senior Programmer', '123456789', 'Bacolod City', '', '', 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, '2008-08-01 19:18:51', '2022-04-20 12:56:25', '0000-00-00 00:00:00', '2026-01-09 21:02:34', 'cerulean', 0);
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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tbl_category: 6 rows
/*!40000 ALTER TABLE `tbl_category` DISABLE KEYS */;
INSERT INTO `tbl_category` (`cat_id`, `cat_parent_id`, `cat_name`, `cat_description`, `cat_image`, `is_deleted`) VALUES
	(1, 0, 'Finish Product', '', '', 0),
	(2, 0, 'Raw Material', '', '', 0),
	(3, 2, 'items', '', '', 0),
	(4, 1, 'items', '', '', 0),
	(5, 0, 'Other Safety Products', '', '', 0),
	(6, 5, 'Items', '', '', 0);
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_luvimar.tbl_job_order: ~5 rows (approximately)
INSERT INTO `tbl_job_order` (`jo_id`, `branch_id`, `joi_id`, `job_order_number`, `status`, `added_by`, `date_added`, `is_deleted`, `uid`) VALUES
	(1, NULL, 0, '1', 'completed', 1002, '2026-01-09', 0, ''),
	(2, NULL, 0, '12', 'completed', 1002, '2026-01-09', 0, ''),
	(3, NULL, 0, '2', 'completed', 1002, '2026-01-09', 0, ''),
	(4, NULL, 0, '322', 'completed', 1002, '2026-01-09', 0, ''),
	(5, NULL, 0, '2', 'completed', 1002, '2026-01-09', 0, '');

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

-- Dumping data for table db_luvimar.tbl_jo_items: ~2 rows (approximately)
INSERT INTO `tbl_jo_items` (`joi_id`, `branch_id`, `cust_id`, `pd_id`, `customer_name`, `pd_name`, `qty`, `pd_price`, `pd_serial`, `description`, `job_description`, `date_needed`, `remarks`, `joi_date_added`, `added_by`, `date_modified`, `date_deleted`, `uid`, `is_deleted`, `is_submitted`) VALUES
	(2, 1006, '3', 2, 'Luvimar', 'Dry Chemical Fire Extinguisher 10lbs', 1, 200.00, '1', 'Dry Chemical Fire Extinguisher 10lbs ', 'refill', '2026-01-09', '', '2026-01-09', '1002', '', '', 'c81e728d9d4c2f636f067f89cc14862c', 0, 0),
	(3, 1006, '1', 1, 'Juan De la Cruz', 'Dry Chemical Fire Extinguisher 10lbs', 1, 100.00, '2', 'Dry Chemical Fire Extinguisher 10lbs ', 'refill', '2026-01-08', '', '2026-01-09', '1002', '', '', 'eccbc87e4b5ce2fe28308fd9f2a7baf3', 0, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_luvimar.tbl_jo_items_new: ~8 rows (approximately)
INSERT INTO `tbl_jo_items_new` (`join_id`, `branch_id`, `cust_id`, `pd_id`, `customer_name`, `pd_name`, `qty`, `pd_price`, `pd_serial`, `description`, `job_description`, `date_needed`, `remarks`, `join_date_added`, `added_by`, `date_modified`, `date_deleted`, `uid`, `is_deleted`, `is_submitted`) VALUES
	(1, 1006, '3', 3, 'Luvimar', 'Emergency Light', 5, 100.00, '0', 'Emergency Light ', 'brandnew', '2026-01-17', '', '2026-01-09', '1002', '', '', 'c4ca4238a0b923820dcc509a6f75849b', 0, 1),
	(2, 1006, '3', 2, 'Luvimar', 'Dry Chemical Fire Extinguisher 10lbs', 1, 200.00, '1', 'Dry Chemical Fire Extinguisher 10lbs ', 'brandnew', '2026-01-16', '', '2026-01-09', '1002', '', '', 'c81e728d9d4c2f636f067f89cc14862c', 0, 1),
	(3, 1006, '1', 1, 'Juan De la Cruz', 'Dry Chemical Fire Extinguisher 10lbs', 1, 100.00, '1000001', 'Dry Chemical Fire Extinguisher 10lbs ', 'brandnew', '2026-01-30', '', '2026-01-09', '1002', '', '', 'eccbc87e4b5ce2fe28308fd9f2a7baf3', 0, 1),
	(4, 1006, '1', 2, 'Juan De la Cruz', 'Dry Chemical Fire Extinguisher 10lbs', 1, 200.00, '1000002', 'Dry Chemical Fire Extinguisher 10lbs ', 'brandnew', '2026-01-08', '', '2026-01-09', '1002', '', '', 'a87ff679a2f3e71d9181a67b7542122c', 0, 1),
	(5, 1006, '1', 2, 'Juan De la Cruz', 'Dry Chemical Fire Extinguisher 10lbs', 1, 200.00, '2026002', 'Dry Chemical Fire Extinguisher 10lbs ', 'brandnew', '', '', '2026-01-09', '1002', '', '', 'e4da3b7fbbce2345d7772b0674a318d5', 0, 1),
	(6, 1006, '1', 1, 'Juan De la Cruz', 'Dry Chemical Fire Extinguisher 10lbs', 1, 100.00, '2026001', 'Dry Chemical Fire Extinguisher 10lbs ', 'brandnew', '', '', '2026-01-09', '1002', '', '', '1679091c5a880faf6fb5e6087eb1b2dc', 0, 1),
	(7, 1006, '1', 3, 'Juan De la Cruz', 'Emergency Light', 1, 100.00, '2026003', 'Emergency Light ', 'brandnew', '', '', '2026-01-09', '1002', '', '', '8f14e45fceea167a5a36dedd4bea2543', 0, 1),
	(8, 1006, '1', 2, 'Juan De la Cruz', 'Dry Chemical Fire Extinguisher 10lbs', 1, 200.00, '2026', 'Dry Chemical Fire Extinguisher 10lbs ', 'brandnew', '', '', '2026-01-09', '1002', '', '', 'c9f0f895fb98ab9159f51fd0297e236d', 0, 1);

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

-- Dumping data for table db_luvimar.tbl_jo_list: ~2 rows (approximately)
INSERT INTO `tbl_jo_list` (`jol_id`, `joi_id`, `jo_id`, `pd_id`, `cust_id`, `branch_id`, `user_id`, `added_by`, `is_deleted`, `uid`) VALUES
	(1, 2, 1, 2, 3, 1006, 1002, '1002', 0, NULL),
	(2, 3, 1, 1, 1, 1006, 1002, '1002', 0, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_luvimar.tbl_jo_list_new: ~8 rows (approximately)
INSERT INTO `tbl_jo_list_new` (`joln_id`, `join_id`, `jo_id`, `pd_id`, `cust_id`, `branch_id`, `user_id`, `added_by`, `is_deleted`, `uid`) VALUES
	(1, 1, 2, 3, 3, 1006, 1002, '1002', 0, NULL),
	(2, 2, 2, 2, 3, 1006, 1002, '1002', 0, NULL),
	(3, 3, 3, 1, 1, 1006, 1002, '1002', 0, NULL),
	(4, 4, 3, 2, 1, 1006, 1002, '1002', 0, NULL),
	(5, 5, 4, 2, 1, 1006, 1002, '1002', 0, NULL),
	(6, 6, 4, 1, 1, 1006, 1002, '1002', 0, NULL),
	(7, 7, 4, 3, 1, 1006, 1002, '1002', 0, NULL),
	(8, 8, 5, 2, 1, 1006, 1002, '1002', 0, NULL);

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
  `pc_qty` decimal(9,2) DEFAULT 0.00,
  `ib_qty` decimal(9,2) DEFAULT 0.00,
  `bx_qty` decimal(9,2) DEFAULT 0.00,
  `pd_qty` decimal(9,2) DEFAULT NULL,
  `pd_mqty` decimal(9,2) DEFAULT NULL,
  `pd_expiration` varchar(100) DEFAULT NULL,
  `pd_image` varchar(200) DEFAULT NULL,
  `pd_thumbnail` varchar(200) DEFAULT NULL,
  `is_deleted` int(1) NOT NULL,
  `is_added` int(1) NOT NULL,
  `date_added` varchar(50) DEFAULT NULL,
  `date_modified` varchar(50) DEFAULT NULL,
  `date_deleted` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`pd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tbl_product: 3 rows
/*!40000 ALTER TABLE `tbl_product` DISABLE KEYS */;
INSERT INTO `tbl_product` (`pd_id`, `cat_id`, `cat_parent_id`, `pd_barcode`, `pd_name`, `pd_name7`, `pd_description`, `pd_keyword`, `pd_cost`, `pc_formula`, `ib_formula`, `bx_formula`, `pc_price`, `ib_price`, `bx_price`, `pc_qty`, `ib_qty`, `bx_qty`, `pd_qty`, `pd_mqty`, `pd_expiration`, `pd_image`, `pd_thumbnail`, `is_deleted`, `is_added`, `date_added`, `date_modified`, `date_deleted`) VALUES
	(1, 4, 1, '2026', 'Dry Chemical Fire Extinguisher 10lbs', 'Dry Chemical Fire Extinguisher 10lbs', '', 'Finish Product', 100.00, 0.00, 0.00, 0.00, 100.00, 0.00, 0.00, 124.00, 0.00, 0.00, NULL, 0.00, 'January 5, 2026', '', '', 0, 0, '2025-09-06 14:10:55', NULL, NULL),
	(2, 4, 1, '2026', 'Dry Chemical Fire Extinguisher 10lbs', 'Dry Chemical Fire Extinguisher 10lbs', '', 'Finish Product', 10.00, 0.00, 0.00, 0.00, 200.00, 0.00, 0.00, 18.00, 0.00, 0.00, NULL, 0.00, 'September 6, 2025', '', '', 0, 0, '2025-09-06 14:27:43', NULL, NULL),
	(3, 4, 1, '2026', 'Emergency Light', 'Emergency Light', '', 'Finish Product', 100.00, 0.00, 0.00, 0.00, 100.00, 0.00, 0.00, 114.00, 0.00, 0.00, NULL, 0.00, 'September 6, 2025', '', '', 0, 0, '2025-09-06 14:43:46', '2026-01-05 10:12:31', NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_luvimar.tbl_production_report: ~5 rows (approximately)
INSERT INTO `tbl_production_report` (`pr_id`, `jo_id`, `pr_num`, `added_by`, `status`, `date_added`, `is_deleted`, `uid`) VALUES
	(1, 2, '456', '1002', 'completed', '2026-01-09', '', 'c4ca4238a0b923820dcc509a6f75849b'),
	(2, 1, '3', '1002', 'completed', '2026-01-09', '', 'c81e728d9d4c2f636f067f89cc14862c'),
	(3, 3, '32', '1002', 'completed', '2026-01-09', '', 'eccbc87e4b5ce2fe28308fd9f2a7baf3'),
	(4, 4, '22', '1002', 'completed', '2026-01-09', '', 'a87ff679a2f3e71d9181a67b7542122c'),
	(5, 5, '32', '1002', 'completed', '2026-01-09', '', 'e4da3b7fbbce2345d7772b0674a318d5');

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
  `pr_serial` varchar(240) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_luvimar.tbl_pr_items: ~8 rows (approximately)
INSERT INTO `tbl_pr_items` (`pri_id`, `jo_id`, `cust_id`, `branch_id`, `pd_id`, `pr_qty`, `pr_serial`, `pr_price`, `pr_description`, `part_replacement`, `pr_remarks`, `pr_date_added`, `added_by`, `date_modified`, `date_deleted`, `uid`, `is_deleted`, `is_submitted`) VALUES
	(3, 2, 3, 1006, 3, 5, '0', '100.00', 'Emergency Light', NULL, NULL, '2026-01-09', '1002', NULL, NULL, 'eccbc87e4b5ce2fe28308fd9f2a7baf3', 0, 1),
	(4, 2, 3, 1006, 2, 1, '1', '200.00', '<p>Dry Chemical Fire Extinguisher 10lbs</p>', '', '', '2026-01-09', '1002', NULL, NULL, 'a87ff679a2f3e71d9181a67b7542122c', 0, 1),
	(5, 1, 1, 1006, 1, 1, '2', '100.00', 'Dry Chemical Fire Extinguisher 10lbs', NULL, NULL, '2026-01-09', '1002', NULL, NULL, 'e4da3b7fbbce2345d7772b0674a318d5', 0, 1),
	(6, 3, 1, 1006, 1, 1, '1000001', '100.00', 'Dry Chemical Fire Extinguisher 10lbs', NULL, NULL, '2026-01-09', '1002', NULL, NULL, '1679091c5a880faf6fb5e6087eb1b2dc', 0, 1),
	(7, 3, 1, 1006, 2, 1, '1000002', '200.00', 'Dry Chemical Fire Extinguisher 10lbs', NULL, NULL, '2026-01-09', '1002', NULL, NULL, '8f14e45fceea167a5a36dedd4bea2543', 0, 1),
	(8, 4, 1, 1006, 2, 1, '2026002', '200.00', 'Dry Chemical Fire Extinguisher 10lbs', NULL, NULL, '2026-01-09', '1002', NULL, NULL, 'c9f0f895fb98ab9159f51fd0297e236d', 0, 1),
	(9, 4, 1, 1006, 1, 1, '2026001', '100.00', 'Dry Chemical Fire Extinguisher 10lbs', NULL, NULL, '2026-01-09', '1002', NULL, NULL, '45c48cce2e2d7fbdea1afc51c7c6ad26', 0, 1),
	(10, 4, 1, 1006, 3, 1, '2026003', '100.00', 'Emergency Light', NULL, NULL, '2026-01-09', '1002', NULL, NULL, 'd3d9446802a44259755d38e6d163e820', 0, 1),
	(11, 5, 1, 1006, 2, 1, '2026', '200.00', 'Dry Chemical Fire Extinguisher 10lbs', NULL, NULL, '2026-01-09', '1002', NULL, NULL, '6512bd43d9caa6e02c990b0a82652dca', 0, 1);

-- Dumping structure for table db_luvimar.tbl_pr_list
CREATE TABLE IF NOT EXISTS `tbl_pr_list` (
  `prl_id` int(11) NOT NULL AUTO_INCREMENT,
  `pri_id` int(11) DEFAULT NULL,
  `pr_id` int(11) DEFAULT NULL,
  `pd_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `added_by` varchar(100) DEFAULT NULL,
  `pr_date_added` varchar(100) DEFAULT NULL,
  `date_deleted` varchar(100) DEFAULT NULL,
  `is_deleted` int(1) DEFAULT 0,
  `uid` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`prl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_luvimar.tbl_pr_list: ~8 rows (approximately)
INSERT INTO `tbl_pr_list` (`prl_id`, `pri_id`, `pr_id`, `pd_id`, `branch_id`, `user_id`, `added_by`, `pr_date_added`, `date_deleted`, `is_deleted`, `uid`) VALUES
	(1, 3, 1, 3, 1006, 1002, '1002', '2026-01-09', NULL, 0, NULL),
	(2, 4, 1, 2, 1006, 1002, '1002', '2026-01-09', NULL, 0, NULL),
	(3, 5, 2, 1, 1006, 1002, '1002', '2026-01-09', NULL, 0, NULL),
	(4, 6, 3, 1, 1006, 1002, '1002', '2026-01-09', NULL, 0, NULL),
	(5, 7, 3, 2, 1006, 1002, '1002', '2026-01-09', NULL, 0, NULL),
	(6, 8, 4, 2, 1006, 1002, '1002', '2026-01-09', NULL, 0, NULL),
	(7, 9, 4, 1, 1006, 1002, '1002', '2026-01-09', NULL, 0, NULL),
	(8, 10, 4, 3, 1006, 1002, '1002', '2026-01-09', NULL, 0, NULL),
	(9, 11, 5, 2, 1006, 1002, '1002', '2026-01-09', NULL, 0, NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Dumping data for table db_luvimar.tbl_received: 3 rows
/*!40000 ALTER TABLE `tbl_received` DISABLE KEYS */;
INSERT INTO `tbl_received` (`rec_id`, `sup_id`, `payment_method`, `or_num`, `dr_num`, `terms`, `total_cost`, `is_paid`, `is_charge`, `is_deleted`, `added_by`, `date_added`, `date_deleted`, `date_added_ymd`, `date_due`, `paid_date`) VALUES
	(1, 2, 'Cash', '', '', 0, 110.00, 1, 0, 0, 1002, '2025-08-08 10:26:05', NULL, '2025-08-08', '0000-00-00', '2025-08-08'),
	(2, 1, 'Cash', '', '', 0, 0.00, 1, 0, 0, 1002, '2025-08-27 16:20:33', NULL, '2025-08-27', '0000-00-00', '2025-08-27'),
	(3, 1, 'Cash', '', '', 0, 143000.00, 1, 0, 0, 1002, '2025-08-27 16:21:41', NULL, '2025-08-27', '0000-00-00', '2025-08-27');
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Dumping data for table db_luvimar.tbl_received_item: 2 rows
/*!40000 ALTER TABLE `tbl_received_item` DISABLE KEYS */;
INSERT INTO `tbl_received_item` (`reci_id`, `rec_id`, `pd_id`, `pd_qty_left`, `pd_mqty`, `od_qty_added`, `pd_cost`, `added_by`, `date_added`, `date_added_ymd`, `pd_type`, `is_deleted`) VALUES
	(1, 3, 2, 50, '0.00', 1000, 20.00, 1002, '2025-08-27 16:21:41', '2025-08-27', 'pc', 0),
	(2, 3, 3, 123, '0.00', 1000, 123.00, 1002, '2025-08-27 16:21:41', '2025-08-27', 'pc', 0);
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
  `ec_id` int(10) unsigned NOT NULL,
  `amount` decimal(9,2) NOT NULL,
  `details` text NOT NULL,
  `is_deleted` tinyint(1) unsigned NOT NULL,
  `date_added` varchar(50) DEFAULT NULL,
  `date_modified` varchar(50) DEFAULT NULL,
  `date_deleted` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`exp_id`),
  KEY `ec_id` (`ec_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tr_expense: 1 rows
/*!40000 ALTER TABLE `tr_expense` DISABLE KEYS */;
INSERT INTO `tr_expense` (`exp_id`, `ec_id`, `amount`, `details`, `is_deleted`, `date_added`, `date_modified`, `date_deleted`) VALUES
	(1, 0, 500.00, '<p>Food Allowance</p>', 0, '2025-09-06', NULL, NULL);
/*!40000 ALTER TABLE `tr_expense` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.tr_expense_category
CREATE TABLE IF NOT EXISTS `tr_expense_category` (
  `ec_id` int(11) NOT NULL AUTO_INCREMENT,
  `expense_category_name` varchar(255) NOT NULL,
  `details` varchar(1000) NOT NULL,
  `expense` bigint(255) NOT NULL,
  `date_added` varchar(100) NOT NULL DEFAULT '',
  `is_deleted` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ec_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_luvimar.tr_expense_category: ~0 rows (approximately)
INSERT INTO `tr_expense_category` (`ec_id`, `expense_category_name`, `details`, `expense`, `date_added`, `is_deleted`) VALUES
	(1, 'SAmple', '', 0, '2026-01-09', 0);

-- Dumping structure for table db_luvimar.tr_graph_gross_current
CREATE TABLE IF NOT EXISTS `tr_graph_gross_current` (
  `sg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `branch_id` int(10) unsigned NOT NULL,
  `date_name` varchar(100) NOT NULL,
  `total_sales` decimal(9,2) NOT NULL,
  `od_date` date DEFAULT NULL,
  PRIMARY KEY (`sg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29946 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tr_graph_gross_current: 93 rows
/*!40000 ALTER TABLE `tr_graph_gross_current` DISABLE KEYS */;
INSERT INTO `tr_graph_gross_current` (`sg_id`, `branch_id`, `date_name`, `total_sales`, `od_date`) VALUES
	(29853, 1002, 'Oct 09, 2025', 0.00, '2025-10-09'),
	(29854, 1002, 'Oct 10, 2025', 0.00, '2025-10-10'),
	(29855, 1002, 'Oct 11, 2025', 0.00, '2025-10-11'),
	(29856, 1002, 'Oct 12, 2025', 0.00, '2025-10-12'),
	(29857, 1002, 'Oct 13, 2025', 0.00, '2025-10-13'),
	(29858, 1002, 'Oct 14, 2025', 0.00, '2025-10-14'),
	(29859, 1002, 'Oct 15, 2025', 0.00, '2025-10-15'),
	(29860, 1002, 'Oct 16, 2025', 0.00, '2025-10-16'),
	(29861, 1002, 'Oct 17, 2025', 0.00, '2025-10-17'),
	(29862, 1002, 'Oct 18, 2025', 0.00, '2025-10-18'),
	(29863, 1002, 'Oct 19, 2025', 0.00, '2025-10-19'),
	(29864, 1002, 'Oct 20, 2025', 0.00, '2025-10-20'),
	(29865, 1002, 'Oct 21, 2025', 0.00, '2025-10-21'),
	(29866, 1002, 'Oct 22, 2025', 0.00, '2025-10-22'),
	(29867, 1002, 'Oct 23, 2025', 0.00, '2025-10-23'),
	(29868, 1002, 'Oct 24, 2025', 0.00, '2025-10-24'),
	(29869, 1002, 'Oct 25, 2025', 0.00, '2025-10-25'),
	(29870, 1002, 'Oct 26, 2025', 0.00, '2025-10-26'),
	(29871, 1002, 'Oct 27, 2025', 0.00, '2025-10-27'),
	(29872, 1002, 'Oct 28, 2025', 0.00, '2025-10-28'),
	(29873, 1002, 'Oct 29, 2025', 0.00, '2025-10-29'),
	(29874, 1002, 'Oct 30, 2025', 0.00, '2025-10-30'),
	(29875, 1002, 'Oct 31, 2025', 0.00, '2025-10-31'),
	(29876, 1002, 'Nov 01, 2025', 0.00, '2025-11-01'),
	(29877, 1002, 'Nov 02, 2025', 0.00, '2025-11-02'),
	(29878, 1002, 'Nov 03, 2025', 0.00, '2025-11-03'),
	(29879, 1002, 'Nov 04, 2025', 0.00, '2025-11-04'),
	(29880, 1002, 'Nov 05, 2025', 0.00, '2025-11-05'),
	(29881, 1002, 'Nov 06, 2025', 0.00, '2025-11-06'),
	(29882, 1002, 'Nov 07, 2025', 0.00, '2025-11-07'),
	(29883, 1002, 'Nov 08, 2025', 0.00, '2025-11-08'),
	(29884, 1002, 'Nov 09, 2025', 0.00, '2025-11-09'),
	(29885, 1002, 'Nov 10, 2025', 0.00, '2025-11-10'),
	(29886, 1002, 'Nov 11, 2025', 0.00, '2025-11-11'),
	(29887, 1002, 'Nov 12, 2025', 0.00, '2025-11-12'),
	(29888, 1002, 'Nov 13, 2025', 0.00, '2025-11-13'),
	(29889, 1002, 'Nov 14, 2025', 0.00, '2025-11-14'),
	(29890, 1002, 'Nov 15, 2025', 0.00, '2025-11-15'),
	(29891, 1002, 'Nov 16, 2025', 0.00, '2025-11-16'),
	(29892, 1002, 'Nov 17, 2025', 0.00, '2025-11-17'),
	(29893, 1002, 'Nov 18, 2025', 0.00, '2025-11-18'),
	(29894, 1002, 'Nov 19, 2025', 0.00, '2025-11-19'),
	(29895, 1002, 'Nov 20, 2025', 0.00, '2025-11-20'),
	(29896, 1002, 'Nov 21, 2025', 0.00, '2025-11-21'),
	(29897, 1002, 'Nov 22, 2025', 0.00, '2025-11-22'),
	(29898, 1002, 'Nov 23, 2025', 0.00, '2025-11-23'),
	(29899, 1002, 'Nov 24, 2025', 0.00, '2025-11-24'),
	(29900, 1002, 'Nov 25, 2025', 0.00, '2025-11-25'),
	(29901, 1002, 'Nov 26, 2025', 0.00, '2025-11-26'),
	(29902, 1002, 'Nov 27, 2025', 0.00, '2025-11-27'),
	(29903, 1002, 'Nov 28, 2025', 0.00, '2025-11-28'),
	(29904, 1002, 'Nov 29, 2025', 0.00, '2025-11-29'),
	(29905, 1002, 'Nov 30, 2025', 0.00, '2025-11-30'),
	(29906, 1002, 'Dec 01, 2025', 0.00, '2025-12-01'),
	(29907, 1002, 'Dec 02, 2025', 0.00, '2025-12-02'),
	(29908, 1002, 'Dec 03, 2025', 0.00, '2025-12-03'),
	(29909, 1002, 'Dec 04, 2025', 0.00, '2025-12-04'),
	(29910, 1002, 'Dec 05, 2025', 0.00, '2025-12-05'),
	(29911, 1002, 'Dec 06, 2025', 0.00, '2025-12-06'),
	(29912, 1002, 'Dec 07, 2025', 0.00, '2025-12-07'),
	(29913, 1002, 'Dec 08, 2025', 0.00, '2025-12-08'),
	(29914, 1002, 'Dec 09, 2025', 0.00, '2025-12-09'),
	(29915, 1002, 'Dec 10, 2025', 0.00, '2025-12-10'),
	(29916, 1002, 'Dec 11, 2025', 0.00, '2025-12-11'),
	(29917, 1002, 'Dec 12, 2025', 0.00, '2025-12-12'),
	(29918, 1002, 'Dec 13, 2025', 0.00, '2025-12-13'),
	(29919, 1002, 'Dec 14, 2025', 0.00, '2025-12-14'),
	(29920, 1002, 'Dec 15, 2025', 0.00, '2025-12-15'),
	(29921, 1002, 'Dec 16, 2025', 0.00, '2025-12-16'),
	(29922, 1002, 'Dec 17, 2025', 0.00, '2025-12-17'),
	(29923, 1002, 'Dec 18, 2025', 0.00, '2025-12-18'),
	(29924, 1002, 'Dec 19, 2025', 0.00, '2025-12-19'),
	(29925, 1002, 'Dec 20, 2025', 0.00, '2025-12-20'),
	(29926, 1002, 'Dec 21, 2025', 0.00, '2025-12-21'),
	(29927, 1002, 'Dec 22, 2025', 0.00, '2025-12-22'),
	(29928, 1002, 'Dec 23, 2025', 0.00, '2025-12-23'),
	(29929, 1002, 'Dec 24, 2025', 0.00, '2025-12-24'),
	(29930, 1002, 'Dec 25, 2025', 0.00, '2025-12-25'),
	(29931, 1002, 'Dec 26, 2025', 0.00, '2025-12-26'),
	(29932, 1002, 'Dec 27, 2025', 0.00, '2025-12-27'),
	(29933, 1002, 'Dec 28, 2025', 0.00, '2025-12-28'),
	(29934, 1002, 'Dec 29, 2025', 0.00, '2025-12-29'),
	(29935, 1002, 'Dec 30, 2025', 0.00, '2025-12-30'),
	(29936, 1002, 'Dec 31, 2025', 0.00, '2025-12-31'),
	(29937, 1002, 'Jan 01, 2026', 0.00, '2026-01-01'),
	(29938, 1002, 'Jan 02, 2026', 0.00, '2026-01-02'),
	(29939, 1002, 'Jan 03, 2026', 0.00, '2026-01-03'),
	(29940, 1002, 'Jan 04, 2026', 0.00, '2026-01-04'),
	(29941, 1002, 'Jan 05, 2026', 0.00, '2026-01-05'),
	(29942, 1002, 'Jan 06, 2026', 0.00, '2026-01-06'),
	(29943, 1002, 'Jan 07, 2026', 0.00, '2026-01-07'),
	(29944, 1002, 'Jan 08, 2026', 0.00, '2026-01-08'),
	(29945, 1002, 'Jan 09, 2026', 0.00, '2026-01-09');
/*!40000 ALTER TABLE `tr_graph_gross_current` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.tr_graph_net_current
CREATE TABLE IF NOT EXISTS `tr_graph_net_current` (
  `sg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `branch_id` int(10) unsigned NOT NULL,
  `date_name` varchar(100) NOT NULL,
  `total_sales` decimal(9,2) NOT NULL,
  `od_date` date DEFAULT NULL,
  PRIMARY KEY (`sg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1289 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tr_graph_net_current: 4 rows
/*!40000 ALTER TABLE `tr_graph_net_current` DISABLE KEYS */;
INSERT INTO `tr_graph_net_current` (`sg_id`, `branch_id`, `date_name`, `total_sales`, `od_date`) VALUES
	(1285, 1002, 'Jan 06, 2026', 0.00, '2026-01-06'),
	(1286, 1002, 'Jan 07, 2026', 0.00, '2026-01-07'),
	(1287, 1002, 'Jan 08, 2026', 0.00, '2026-01-08'),
	(1288, 1002, 'Jan 09, 2026', 0.00, '2026-01-09');
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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tr_graph_product_current: 3 rows
/*!40000 ALTER TABLE `tr_graph_product_current` DISABLE KEYS */;
INSERT INTO `tr_graph_product_current` (`sg_id`, `branch_id`, `pd_id`, `pd_name`, `total_qty`, `od_date`, `pd_type`) VALUES
	(1, 0, 1, '10lbs', 10.00, '2026-01-05', 'pc'),
	(2, 0, 2, 'Dry Chemical Fire Extinguisher 10lbs', 1.00, '2025-09-06', 'pc'),
	(3, 0, 3, 'Emergency Light', 5.00, '2025-09-06', 'pc');
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
) ENGINE=MyISAM AUTO_INCREMENT=172 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tr_log: 171 rows
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
	(171, 'job order added', '', 'product', '1002', '2026-01-09 21:42:20');
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
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tr_login_attempt: 25 rows
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
	(25, 5395, '::1', 'admin', '1234', 0, 0, '2026-01-09 21:02:34', '');
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
