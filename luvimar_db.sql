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
  `is_receivable_access` tinyint(1) NOT NULL DEFAULT 1,
  `is_receivable_paid_access` tinyint(1) NOT NULL DEFAULT 1,
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
INSERT INTO `bs_user` (`user_id`, `emp_id`, `firstname`, `lastname`, `email`, `username`, `password`, `pass_text`, `title`, `contactno`, `address`, `image`, `thumbnail`, `is_admin`, `access_level`, `is_main_access`, `is_masterfile_access`, `is_category_access`, `is_cat_a_access`, `is_cat_e_access`, `is_cat_d_access`, `is_customer_access`, `is_cust_a_access`, `is_cust_e_access`, `is_cust_d_access`, `is_supplier_access`, `is_sup_a_access`, `is_sup_e_access`, `is_sup_d_access`, `is_product_access`, `is_prod_a_access`, `is_prod_e_access`, `is_prod_d_access`, `is_receive_access`, `is_return_access`, `is_receivable_access`, `is_receivable_paid_access`, `is_sales_access`, `is_sale_v_access`, `is_sale_d_access`, `is_job_order_access`, `is_job_order_a_access`, `is_job_order_e_access`, `is_job_order_d_access`, `is_production_report_access`, `is_production_report_a_access`, `is_production_report_e_access`, `is_production_report_d_access`, `is_delivery_access`, `is_del_v_access`, `is_del_d_access`, `is_expense_access`, `is_exp_a_access`, `is_exp_e_access`, `is_exp_d_access`, `is_report_access`, `is_user_access`, `is_user_a_access`, `is_user_e_access`, `is_user_d_access`, `added_by`, `modified_by`, `deleted_by`, `is_deleted`, `date_added`, `date_modified`, `date_deleted`, `last_login`, `theme`, `branch_num`) VALUES
	(1002, '1600109', 'Admin', 'Admin', 'admin@gmail.com', 'admin', '81dc9bdb52d04dc20036dbd8313ed055', '1234', 'Senior Programmer', '123456789', 'Bacolod City', '', '', 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, '2008-08-01 19:18:51', '2022-04-20 12:56:25', '0000-00-00 00:00:00', '2026-06-24 10:22:44', 'cerulean', 0);
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
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_luvimar.tbl_job_order: ~0 rows (approximately)

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
  `pd_type` varchar(244) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_luvimar.tbl_jo_items: ~0 rows (approximately)

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_luvimar.tbl_jo_list: ~0 rows (approximately)

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
  `ref_num` varchar(100) NOT NULL,
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
  `od_status` varchar(70) DEFAULT NULL,
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
  `pd_status` varchar(100) DEFAULT NULL,
  `pd_unit` varchar(100) DEFAULT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tbl_product: 0 rows
/*!40000 ALTER TABLE `tbl_product` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_luvimar.tbl_production_report: ~0 rows (approximately)

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tbl_product_log: 0 rows
/*!40000 ALTER TABLE `tbl_product_log` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_luvimar.tbl_pr_items: ~0 rows (approximately)

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db_luvimar.tbl_pr_list: ~0 rows (approximately)

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tr_graph_gross_current: 0 rows
/*!40000 ALTER TABLE `tr_graph_gross_current` DISABLE KEYS */;
/*!40000 ALTER TABLE `tr_graph_gross_current` ENABLE KEYS */;

-- Dumping structure for table db_luvimar.tr_graph_net_current
CREATE TABLE IF NOT EXISTS `tr_graph_net_current` (
  `sg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `branch_id` int(10) unsigned NOT NULL,
  `date_name` varchar(100) NOT NULL,
  `total_sales` decimal(9,2) NOT NULL,
  `od_date` date DEFAULT NULL,
  PRIMARY KEY (`sg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tr_graph_net_current: 0 rows
/*!40000 ALTER TABLE `tr_graph_net_current` DISABLE KEYS */;
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tr_graph_product_current: 0 rows
/*!40000 ALTER TABLE `tr_graph_product_current` DISABLE KEYS */;
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tr_log: 0 rows
/*!40000 ALTER TABLE `tr_log` DISABLE KEYS */;
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Dumping data for table db_luvimar.tr_login_attempt: 0 rows
/*!40000 ALTER TABLE `tr_login_attempt` DISABLE KEYS */;
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
