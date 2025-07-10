-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2025 at 07:39 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inspection_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_branch`
--

CREATE TABLE `t_branch` (
  `BranchId` smallint(6) NOT NULL,
  `ClientId` smallint(6) NOT NULL,
  `BranchName` varchar(50) NOT NULL,
  `PhoneNo` varchar(30) NOT NULL,
  `Email` varchar(30) DEFAULT NULL,
  `BranchAddress` varchar(250) DEFAULT NULL,
  `CreateTs` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdateTs` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_branch`
--

INSERT INTO `t_branch` (`BranchId`, `ClientId`, `BranchName`, `PhoneNo`, `Email`, `BranchAddress`, `CreateTs`, `UpdateTs`) VALUES
(1, 1, 'Intertek', '', NULL, NULL, '2023-08-10 00:14:16', '2023-08-10 00:14:16');

-- --------------------------------------------------------

--
-- Table structure for table `t_checklist`
--

CREATE TABLE `t_checklist` (
  `CheckId` smallint(3) NOT NULL,
  `CheckName` varchar(50) NOT NULL,
  `CreateTs` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdateTs` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_checklist`
--

INSERT INTO `t_checklist` (`CheckId`, `CheckName`, `CreateTs`, `UpdateTs`) VALUES
(1, 'Shade check', '2025-06-09 06:14:16', '2023-08-09 06:14:16'),
(2, 'Fabric hole at neck (M)', '2025-06-15 07:55:39', NULL),
(3, 'Broken stitch (M)', '2025-06-15 07:55:39', NULL),
(4, 'Barcode check', '2025-06-15 07:55:39', NULL),
(5, 'Shipping mark sticker', '2025-06-15 07:55:39', NULL),
(6, 'Shipping mark', '2025-06-15 07:55:39', NULL),
(7, 'Open carton', '2025-06-15 07:55:39', NULL),
(8, 'View of pack', '2025-06-15 07:55:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_client`
--

CREATE TABLE `t_client` (
  `ClientId` smallint(6) NOT NULL,
  `ClientName` varchar(50) NOT NULL,
  `ClientCode` varchar(20) CHARACTER SET utf8 NOT NULL,
  `AppName` varchar(50) NOT NULL,
  `PoweredBy` varchar(50) NOT NULL,
  `DevelopmentBy` varchar(50) NOT NULL,
  `DevelopmentByWebsite` varchar(50) DEFAULT NULL,
  `PhoneNo` varchar(30) DEFAULT NULL,
  `Email` varchar(30) DEFAULT NULL,
  `ClientAddress` varchar(250) DEFAULT NULL,
  `ClientLogo` varchar(100) DEFAULT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `CreateTs` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdateTs` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_client`
--

INSERT INTO `t_client` (`ClientId`, `ClientName`, `ClientCode`, `AppName`, `PoweredBy`, `DevelopmentBy`, `DevelopmentByWebsite`, `PhoneNo`, `Email`, `ClientAddress`, `ClientLogo`, `IsActive`, `CreateTs`, `UpdateTs`) VALUES
(1, 'Intertek', 'Intertek', 'Intertek', 'Intertek', 'Intertek', 'https://www.xxxx.com', '', NULL, '', NULL, 1, '2023-08-10 00:14:16', '2023-08-10 00:14:16');

-- --------------------------------------------------------

--
-- Table structure for table `t_customer`
--

CREATE TABLE `t_customer` (
  `CustomerId` int(11) NOT NULL,
  `ClientId` smallint(6) NOT NULL,
  `CustomerCode` varchar(30) NOT NULL,
  `CustomerName` varchar(100) NOT NULL,
  `Designation` varchar(50) DEFAULT NULL COMMENT 'Customer Designation',
  `ContactPhone` varchar(50) DEFAULT NULL,
  `CompanyName` varchar(50) DEFAULT NULL COMMENT 'Contact Person',
  `NatureOfBusiness` varchar(50) DEFAULT NULL,
  `CompanyEmail` varchar(50) DEFAULT NULL,
  `CompanyAddress` varchar(150) DEFAULT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 1,
  `UserId` int(11) NOT NULL COMMENT 'Entry bu User Id',
  `UpdateTs` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CreateTs` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_customer`
--

INSERT INTO `t_customer` (`CustomerId`, `ClientId`, `CustomerCode`, `CustomerName`, `Designation`, `ContactPhone`, `CompanyName`, `NatureOfBusiness`, `CompanyEmail`, `CompanyAddress`, `IsActive`, `UserId`, `UpdateTs`, `CreateTs`) VALUES
(1, 1, '2', '[Other]', NULL, 'NA', NULL, NULL, NULL, NULL, 1, 1, '2024-09-25 16:56:51', '2023-08-13 05:00:46');

-- --------------------------------------------------------

--
-- Table structure for table `t_department`
--

CREATE TABLE `t_department` (
  `DepartmentId` smallint(3) NOT NULL,
  `DepartmentName` varchar(50) NOT NULL,
  `CreateTs` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdateTs` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_department`
--

INSERT INTO `t_department` (`DepartmentId`, `DepartmentName`, `CreateTs`, `UpdateTs`) VALUES
(1, 'NA', '2024-10-20 16:12:15', '2024-10-20 16:12:15'),
(2, 'Admin', '2023-08-09 18:14:16', '2024-10-20 16:12:15'),
(3, 'HR', '2023-08-09 18:14:16', '2024-10-20 16:12:15'),
(4, 'Audit', '2024-10-20 16:12:15', '2024-10-20 16:12:15'),
(5, 'Delivery', '2024-10-20 16:12:15', '2024-10-20 16:12:15'),
(6, 'IT Team', '2024-10-20 16:12:15', '2024-10-20 16:12:15'),
(7, 'Accounts', '2024-10-20 16:12:15', '2024-10-20 16:12:15'),
(8, 'MIS', '2024-10-20 16:12:15', '2024-10-20 16:12:15'),
(9, 'Maintenance', '2024-10-20 16:12:15', '2024-10-20 16:12:15');

-- --------------------------------------------------------

--
-- Table structure for table `t_designation`
--

CREATE TABLE `t_designation` (
  `DesignationId` smallint(3) NOT NULL,
  `ClientId` smallint(6) NOT NULL,
  `DesignationName` varchar(50) NOT NULL,
  `CreateTs` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdateTs` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_designation`
--

INSERT INTO `t_designation` (`DesignationId`, `ClientId`, `DesignationName`, `CreateTs`, `UpdateTs`) VALUES
(1, 1, 'Chairman', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(2, 1, 'Managing Director', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(3, 1, 'Director', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(4, 1, 'Assistant General Manager', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(5, 1, 'Assistant Manager', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(6, 1, 'Assistant Officer', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(7, 1, 'Assistant Operator', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(8, 1, 'Data Entry Officer', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(9, 1, 'Delivery Man', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(10, 1, 'Deputy General Manager', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(11, 1, 'Deputy Manager', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(12, 1, 'Driver', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(13, 1, 'Electrician', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(14, 1, 'Engineer', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(15, 1, 'Executive', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(16, 1, 'General Manager', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(17, 1, 'Junior Engineer', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(18, 1, 'Junior Technician', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(19, 1, 'Manager', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(20, 1, 'Operator', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(21, 1, 'Security Guard', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(22, 1, 'Senior Electrician', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(23, 1, 'Senior General Manager', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(24, 1, 'Senior Manager', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(25, 1, 'Senior Officer', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(26, 1, 'Senior Operator', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(27, 1, 'Service Engineer', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(28, 1, 'Supervisor', '2024-10-24 16:35:56', '2024-10-24 16:35:56'),
(29, 1, 'Merchandiser', '2025-04-28 03:43:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_errorlog`
--

CREATE TABLE `t_errorlog` (
  `LogId` int(11) NOT NULL,
  `LogDate` datetime NOT NULL,
  `RemoteIP` varchar(100) NOT NULL,
  `UserId` int(11) NOT NULL COMMENT 'In user table has Client and Branch',
  `Query` text NOT NULL,
  `QueryType` varchar(30) NOT NULL,
  `ErrorNo` varchar(30) NOT NULL,
  `ErrorMsg` text NOT NULL,
  `SqlParams` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_errorlog`
--

INSERT INTO `t_errorlog` (`LogId`, `LogDate`, `RemoteIP`, `UserId`, `Query`, `QueryType`, `ErrorNo`, `ErrorMsg`, `SqlParams`) VALUES
(1, '2025-07-03 22:28:34', '127.0.0.1', 1, 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', 'INSERT', '1452', 'Cannot add or update a child row: a foreign key constraint fails (`inspection_db`.`t_transaction_items`, CONSTRAINT `FK_t_transaction_items_t_transaction` FOREIGN KEY (`TransactionId`) REFERENCES `t_transaction` (`TransactionId`))', '{\"values\":{\"TransactionId\":\"8\",\"CheckId\":5,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"placeholder.jpg\",\"SortOrder\":2}}'),
(2, '2025-07-03 22:30:17', '127.0.0.1', 1, 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', 'INSERT', '1452', 'Cannot add or update a child row: a foreign key constraint fails (`inspection_db`.`t_transaction_items`, CONSTRAINT `FK_t_transaction_items_t_transaction` FOREIGN KEY (`TransactionId`) REFERENCES `t_transaction` (`TransactionId`))', '{\"values\":{\"TransactionId\":\"10\",\"CheckId\":5,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"placeholder.jpg\",\"SortOrder\":2}}'),
(3, '2025-07-03 22:31:10', '127.0.0.1', 1, 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', 'INSERT', '1452', 'Cannot add or update a child row: a foreign key constraint fails (`inspection_db`.`t_transaction_items`, CONSTRAINT `FK_t_transaction_items_t_transaction` FOREIGN KEY (`TransactionId`) REFERENCES `t_transaction` (`TransactionId`))', '{\"values\":{\"TransactionId\":\"12\",\"CheckId\":5,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"placeholder.jpg\",\"SortOrder\":2}}'),
(4, '2025-07-03 23:08:53', '127.0.0.1', 1, 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', 'INSERT', '1452', 'Cannot add or update a child row: a foreign key constraint fails (`inspection_db`.`t_transaction_items`, CONSTRAINT `FK_t_transaction_items_t_checklist` FOREIGN KEY (`CheckId`) REFERENCES `t_checklist` (`CheckId`))', '{\"values\":{\"TransactionId\":\"30607\",\"CheckId\":0,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"placeholder.jpg\",\"SortOrder\":1}}'),
(5, '2025-07-03 23:20:11', '127.0.0.1', 1, 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', 'INSERT', '1452', 'Cannot add or update a child row: a foreign key constraint fails (`inspection_db`.`t_transaction_items`, CONSTRAINT `FK_t_transaction_items_t_checklist` FOREIGN KEY (`CheckId`) REFERENCES `t_checklist` (`CheckId`))', '{\"values\":{\"TransactionId\":\"5\",\"CheckId\":0,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"placeholder.jpg\",\"SortOrder\":1}}'),
(6, '2025-07-03 23:22:04', '127.0.0.1', 1, 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', 'INSERT', '1452', 'Cannot add or update a child row: a foreign key constraint fails (`inspection_db`.`t_transaction_items`, CONSTRAINT `FK_t_transaction_items_t_checklist` FOREIGN KEY (`CheckId`) REFERENCES `t_checklist` (`CheckId`))', '{\"values\":{\"TransactionId\":\"6\",\"CheckId\":0,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"placeholder.jpg\",\"SortOrder\":1}}'),
(7, '2025-07-05 00:05:46', '127.0.0.1', 1, 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', 'INSERT', '1452', 'Cannot add or update a child row: a foreign key constraint fails (`inspection_db`.`t_transaction_items`, CONSTRAINT `FK_t_transaction_items_t_transaction` FOREIGN KEY (`TransactionId`) REFERENCES `t_transaction` (`TransactionId`))', '{\"values\":{\"TransactionId\":1751652330083,\"CheckId\":2,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"2025_07_05_00_05_46_1287.png\",\"SortOrder\":3}}'),
(8, '2025-07-06 11:30:04', '127.0.0.1', 1, 'INSERT INTO t_designation (ClientId,DesignationName) values (:ClientId,:DesignationName)', 'INSERT', '1062', 'Duplicate entry \'1-Assistant Manager\' for key \'UK_t_designation_Client_Designation\'', '{\"values\":{\"ClientId\":\"1\",\"DesignationName\":\"Assistant Manager\"}}'),
(9, '2025-07-06 21:57:21', '127.0.0.1', 1, 'INSERT INTO t_transaction (ClientId,TransactionTypeId,TransactionDate,InvoiceNo,CoverFilePages,CoverFileUrl,UserId,StatusId,ManyImgPrefix) values (:ClientId,:TransactionTypeId,:TransactionDate,:InvoiceNo,:CoverFilePages,:CoverFileUrl,:UserId,:StatusId,:ManyImgPrefix)', 'INSERT', '1048', 'Column \'TransactionTypeId\' cannot be null', '{\"values\":{\"ClientId\":\"1\",\"TransactionTypeId\":null,\"TransactionDate\":null,\"InvoiceNo\":null,\"CoverFilePages\":null,\"CoverFileUrl\":null,\"UserId\":\"1\",\"StatusId\":null,\"ManyImgPrefix\":null}}');

-- --------------------------------------------------------

--
-- Table structure for table `t_menu`
--

CREATE TABLE `t_menu` (
  `MenuId` smallint(6) NOT NULL,
  `MenuKey` varchar(50) NOT NULL,
  `MenuTitle` varchar(150) NOT NULL,
  `Url` varchar(150) NOT NULL,
  `ParentId` int(11) DEFAULT NULL,
  `MenuLevel` varchar(30) DEFAULT NULL,
  `SortOrder` int(11) DEFAULT NULL,
  `MenuType` varchar(10) NOT NULL DEFAULT 'WEB' COMMENT 'WEB/APP',
  `CategoryName` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `ICONURL` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `CreateTs` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdateTs` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_menu`
--

INSERT INTO `t_menu` (`MenuId`, `MenuKey`, `MenuTitle`, `Url`, `ParentId`, `MenuLevel`, `SortOrder`, `MenuType`, `CategoryName`, `ICONURL`, `CreateTs`, `UpdateTs`) VALUES
(1, 'home', 'Home', '/home', 0, 'menu_level_1', 1, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(3, 'reports', 'Reports', '#', 0, 'menu_level_1', 145, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(4, 'settings', 'Settings', '#', 0, 'menu_level_1', 4, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(26, 'customerweb', 'Customer Web', '/customerweb', 4, 'menu_level_2', 15, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(53, 'userrole', 'User Role', '/userrole', 4, 'menu_level_2', 25, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(56, 'roletomenupermission', 'Role to Menu Permission', '/roletomenupermission', 4, 'menu_level_2', 35, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(59, 'userentry', 'User Entry', '/userentry', 4, 'menu_level_2', 30, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(60, 'myprofileweb', 'My Profile Web', '/myprofileweb', 0, 'menu_level_1', 250, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(63, 'auditlog', 'Audit Log', '/auditlog', 0, 'menu_level_2', 40, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(64, 'errorlog', 'Error Log', '/errorlog', 0, 'menu_level_2', 45, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(90, 'MyProfileActivity', 'My Profile', '/myprofile', 0, 'menu_level_1', 600, 'APP', 'Dashboard', 'my_profile.png', '2024-07-04 21:14:16', '2024-07-04 21:14:16'),
(91, 'MyTaskActivity', 'My Task', '/mytask', 0, 'menu_level_1', 610, 'APP', 'Dashboard', 'my_task.png', '2024-07-04 21:14:16', '2024-07-04 21:14:16'),
(92, 'MyVisitActivity', 'Visit', '/visit', 0, 'menu_level_1', 630, 'APP', 'Dashboard', 'visit.png', '2024-07-04 21:14:16', '2024-07-04 21:14:16'),
(93, 'SampleActivity', 'Sample', '/sample', 0, 'menu_level_1', 650, 'APP', 'Dashboard', 'sample.png', '2024-07-04 21:14:16', '2024-07-04 21:14:16'),
(94, 'OrderSalesActivity', 'Phone Visit', '/phonevisit', 0, 'menu_level_1', 655, 'APP', 'Dashboard', 'order_sell.png', '2024-07-04 21:14:16', '2024-07-04 21:14:16'),
(95, 'VisitPlanActivity', 'Visit Plan', '/visitplan', 0, 'menu_level_1', 660, 'APP', 'Dashboard', 'visit_plan.png', '2024-07-04 21:14:16', '2024-07-04 21:14:16'),
(96, 'CustomerActivity', 'Customer', '/customer', 0, 'menu_level_1', 665, 'APP', 'Dashboard', 'customer.png', '2024-07-04 21:14:16', '2024-07-04 21:14:16'),
(97, 'EmployeeDirectoryActivity', 'Employee Directory', '/employeedirectory', 0, 'menu_level_1', 670, 'APP', 'Dashboard', 'EmployeeDirectory.png', '2024-07-04 21:14:16', '2024-07-04 21:14:16'),
(98, 'ReportsActivity', 'Report', '/report', 0, 'menu_level_1', 670, 'APP', 'Dashboard', 'Report-Main.png', '2024-07-04 21:14:16', '2024-07-04 21:14:16'),
(99, 'SalesFunnelActivity', 'Sales Funnel', '/salesfunnel', 0, 'menu_level_1', 695, 'APP', 'Dashboard', 'SalesFunnel-01.png', '2024-07-04 21:14:16', '2024-07-04 21:14:16'),
(102, 'VisitPunchActivity', 'Physical Visit', '/physicalvisit', 0, 'menu_level_2', 635, 'APP', 'Visit', 'visit_now.png', '2024-07-04 21:14:16', '2024-07-04 21:14:16'),
(104, 'MyVisitActivity', 'View My Visit', '/viewmyvisit', 0, 'menu_level_2', 640, 'APP', 'Visit', 'visit.png', '2024-07-04 21:14:16', '2024-07-04 21:14:16'),
(105, 'MyApprovedVisitActivity', 'Approved Visit', '/approvedvisit', 0, 'menu_level_2', 645, 'APP', 'Visit', 'visit.png', '2024-07-04 21:14:16', '2024-07-04 21:14:16'),
(106, 'machine', 'Machine', '/machine', 4, 'menu_level_2', 100, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(107, 'designation', 'Designation', '/designation', 4, 'menu_level_2', 5, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(108, 'department', 'Department', '/department', 4, 'menu_level_2', 10, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(109, 'ConveyanceActivity', 'Conveyance', '/conveyance', 0, 'menu_level_2', 680, 'APP', 'ReportsActivity', 'Conveyance-Report.png', '2024-07-04 21:14:16', '2024-07-04 21:14:16'),
(110, 'MachineryServiceActivity', 'Machinery Service', '/machineryserviceactivity', 0, 'menu_level_2', 685, 'APP', 'ReportsActivity', 'Machinery-Service-Report.png', '2024-07-04 21:14:16', '2024-07-04 21:14:16'),
(111, 'CustomerVisitPunchActivity', 'Customer Visit Punch', '/customervisitpunchactivity', 0, 'menu_level_2', 690, 'APP', 'ReportsActivity', 'Customer-Visit-Punch-Report.png', '2024-07-04 21:14:16', '2024-07-04 21:14:16'),
(112, 'machineparts', 'Machine Parts', '/machineparts', 4, 'menu_level_2', 105, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(113, 'machinemodel', 'Machine Model', '/machinemodel', 4, 'menu_level_2', 110, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(114, 'machineserial', 'Machine Serial', '/machineserial', 4, 'menu_level_2', 115, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(115, 'LMFeedbackActivity', 'Feedback', '/feedback', 0, 'menu_level_2', 615, 'APP', 'MyTaskActivity', 'my_task.png', '2024-07-04 21:14:16', '2024-07-04 21:14:16'),
(116, 'SalesForceTrailActivity', 'Sales Force Movement', '/salesforcetrailactivity', 0, 'menu_level_2', 620, 'APP', 'MyTaskActivity', 'visit_plan.png', '2024-07-04 21:14:16', '2024-07-04 21:14:16'),
(119, 'businessline', 'Business Line', '/businessline', 4, 'menu_level_2', 20, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(120, 'machinerysetup', 'Machinery Setup', '#', 0, 'menu_level_1', 95, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(121, 'customervisitpunchledger', 'Visit Punch Ledger', '/customervisitpunchledger', 3, 'menu_level_2', 150, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(122, 'customervisitpunchsummary', 'Visit Punch Summary', '/customervisitpunchsummary', 3, 'menu_level_2', 155, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(123, 'visitplan', 'Visit Plan', '/visitplan', 3, 'menu_level_2', 160, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(124, 'conveyancereport', 'Conveyance Report', '/conveyancereport', 3, 'menu_level_2', 165, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(125, 'localconveyance', 'Self Conveyance Report', '/localconveyance', 3, 'menu_level_2', 170, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(126, 'visitsummaryreport', 'Visit Summary Report', '/visitsummaryreport', 3, 'menu_level_2', 175, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(127, 'machineryservicereport', 'Machinery Service Report', '/machineryservicereport', 3, 'menu_level_2', 180, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(128, 'VisitPunchServiceActivity', 'Service Visit Punch', '/visitpunchserviceactivity', 0, 'menu_level_2', 647, 'APP', 'Visit', 'visit_now.png', '2024-07-04 21:14:16', '2024-07-04 21:14:16'),
(129, 'machineryinstallationreport', 'Machinery Installation Report', '/machineryinstallationreport', 3, 'menu_level_2', 185, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(130, 'VisitPunchInstallationActivity', 'Visit Punch Installation', '/VisitPunchInstallationActivity', 0, 'menu_level_2', 648, 'APP', 'Visit', 'visit_now.png', '2024-07-04 21:14:16', '2024-07-04 21:14:16'),
(131, 'mytask', 'My Task', '#', 0, 'menu_level_1', 125, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(132, 'feedback', 'Feedback', '/feedback', 131, 'menu_level_2', 128, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(133, 'DepartmentWiseVisitReportActivity', 'Department Wise Visit', '/DepartmentWiseVisitReportActivity', 0, 'menu_level_2', 692, 'APP', 'ReportsActivity', 'Customer-Visit-Punch-Report.png', '2024-07-04 21:14:16', '2024-07-04 21:14:16'),
(134, 'inspectionreportentry', 'Inspection Report Entry', '/inspectionreportentry', 4, 'menu_level_2', 101, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16'),
(135, 'checklist', 'CheckList', '/checklist', 4, 'menu_level_2', 4, 'WEB', NULL, NULL, '2023-08-09 06:14:16', '2023-08-09 06:14:16');

-- --------------------------------------------------------

--
-- Table structure for table `t_month`
--

CREATE TABLE `t_month` (
  `MonthId` int(11) NOT NULL,
  `MonthName` varchar(25) NOT NULL,
  `UpdateTs` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CreateTs` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_month`
--

INSERT INTO `t_month` (`MonthId`, `MonthName`, `UpdateTs`, `CreateTs`) VALUES
(1, 'January', '2024-04-16 18:20:35', '2024-04-16 18:20:35'),
(2, 'February', '2024-04-16 18:20:35', '2024-04-16 18:20:35'),
(3, 'March', '2024-04-16 18:20:35', '2024-04-16 18:20:35'),
(4, 'April', '2024-04-16 18:20:35', '2024-04-16 18:20:35'),
(5, 'May', '2024-04-16 18:20:35', '2024-04-16 18:20:35'),
(6, 'June', '2024-04-16 18:20:35', '2024-04-16 18:20:35'),
(7, 'July', '2024-04-16 18:20:35', '2024-04-16 18:20:35'),
(8, 'August', '2024-04-16 18:20:35', '2024-04-16 18:20:35'),
(9, 'September', '2024-04-16 18:20:35', '2024-04-16 18:20:35'),
(10, 'October', '2024-04-16 18:20:35', '2024-04-16 18:20:35'),
(11, 'November', '2024-04-16 18:20:35', '2024-04-16 18:20:35'),
(12, 'December', '2024-04-16 18:20:35', '2024-04-16 18:20:35');

-- --------------------------------------------------------

--
-- Table structure for table `t_roles`
--

CREATE TABLE `t_roles` (
  `RoleId` smallint(3) NOT NULL,
  `RoleName` varchar(50) NOT NULL,
  `DefaultRedirect` varchar(150) NOT NULL,
  `CreateTs` timestamp NULL DEFAULT NULL,
  `UpdateTs` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_roles`
--

INSERT INTO `t_roles` (`RoleId`, `RoleName`, `DefaultRedirect`, `CreateTs`, `UpdateTs`) VALUES
(1, 'Super Admin', '/home', '2023-08-10 00:14:16', '2023-08-10 00:14:16');

-- --------------------------------------------------------

--
-- Table structure for table `t_role_menu_map`
--

CREATE TABLE `t_role_menu_map` (
  `RoleMenuId` int(11) NOT NULL,
  `ClientId` smallint(6) NOT NULL,
  `BranchId` smallint(6) NOT NULL,
  `RoleId` smallint(3) NOT NULL,
  `MenuId` smallint(6) NOT NULL,
  `PermissionType` tinyint(1) NOT NULL COMMENT '1=View,2=Edit',
  `CreateTs` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdateTs` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_role_menu_map`
--

INSERT INTO `t_role_menu_map` (`RoleMenuId`, `ClientId`, `BranchId`, `RoleId`, `MenuId`, `PermissionType`, `CreateTs`, `UpdateTs`) VALUES
(3, 1, 1, 1, 3, 2, '2023-08-09 06:14:16', '2024-10-21 09:04:27'),
(12, 1, 1, 1, 26, 2, '2023-08-09 06:14:16', '2024-10-21 09:04:27'),
(19, 1, 1, 1, 53, 2, '2023-08-09 06:14:16', '2024-10-21 09:04:27'),
(29, 1, 1, 1, 56, 2, '2023-09-08 23:04:48', '2024-10-21 09:04:27'),
(36, 1, 1, 1, 60, 2, '2023-10-07 05:47:34', '2024-10-21 09:04:27'),
(39, 1, 1, 1, 63, 2, '2023-10-31 04:47:03', '2024-10-21 09:04:27'),
(40, 1, 1, 1, 64, 2, '2023-10-31 04:47:03', '2024-10-21 09:04:27'),
(44, 1, 1, 1, 59, 2, '2023-12-22 16:52:12', '2024-10-21 09:04:27'),
(84, 1, 1, 1, 93, 2, '2024-09-06 06:13:31', '2024-10-21 09:04:27'),
(85, 1, 1, 1, 94, 2, '2024-09-06 06:13:33', '2024-10-21 09:04:27'),
(86, 1, 1, 1, 95, 2, '2024-09-06 06:13:33', '2024-10-21 09:04:27'),
(87, 1, 1, 1, 96, 2, '2024-09-06 06:13:34', '2024-10-21 09:04:27'),
(89, 1, 1, 1, 98, 2, '2024-09-06 06:13:35', '2024-10-21 09:04:27'),
(90, 1, 1, 1, 92, 1, '2024-09-06 06:13:36', '2024-10-21 09:04:27'),
(91, 1, 1, 1, 91, 2, '2024-09-06 06:13:37', '2024-10-21 09:04:27'),
(92, 1, 1, 1, 90, 2, '2024-09-06 06:13:37', '2024-10-21 09:04:27'),
(93, 1, 1, 1, 99, 2, '2024-09-06 06:13:38', '2024-10-21 09:04:27'),
(97, 1, 1, 1, 105, 2, '2024-09-06 06:29:25', '2024-10-21 09:04:27'),
(98, 1, 1, 1, 104, 2, '2024-09-06 06:29:27', '2024-10-21 09:04:27'),
(99, 1, 1, 1, 102, 2, '2024-09-06 06:29:28', '2024-10-21 09:04:27'),
(102, 1, 1, 1, 109, 2, '2024-09-06 06:29:25', '2024-10-21 09:04:27'),
(103, 1, 1, 1, 110, 2, '2024-09-06 06:29:25', '2024-10-21 09:04:27'),
(104, 1, 1, 1, 111, 2, '2024-09-06 06:29:25', '2024-10-21 09:04:27'),
(105, 1, 1, 1, 106, 2, '2024-09-06 06:29:25', '2024-10-21 09:04:27'),
(106, 1, 1, 1, 107, 2, '2024-09-06 06:29:25', '2024-10-21 09:04:27'),
(108, 1, 1, 1, 112, 2, '2024-09-06 06:29:25', '2024-10-21 09:04:27'),
(109, 1, 1, 1, 113, 2, '2024-09-06 06:29:25', '2024-10-21 09:04:27'),
(110, 1, 1, 1, 114, 2, '2024-09-06 06:29:25', '2024-10-21 09:04:27'),
(111, 1, 1, 1, 115, 2, '2024-09-06 06:29:25', '2024-10-21 09:04:27'),
(112, 1, 1, 1, 116, 2, '2024-09-06 06:29:25', '2024-10-21 09:04:27'),
(114, 1, 1, 1, 119, 2, '2024-10-19 03:34:38', '2024-10-21 09:04:27'),
(118, 1, 1, 1, 121, 2, '2024-10-21 09:04:23', '2024-10-21 09:04:27'),
(119, 1, 1, 1, 122, 2, '2024-10-21 09:04:24', '2024-10-21 09:04:27'),
(120, 1, 1, 1, 123, 2, '2024-10-21 09:04:24', '2024-10-21 09:04:27'),
(121, 1, 1, 1, 124, 2, '2024-10-21 09:04:25', '2024-10-21 09:04:27'),
(122, 1, 1, 1, 125, 2, '2024-10-21 09:04:26', '2024-10-21 09:04:27'),
(123, 1, 1, 1, 126, 2, '2024-10-21 09:04:26', '2024-10-21 09:04:27'),
(124, 1, 1, 1, 127, 2, '2024-10-21 09:04:27', '2024-10-21 09:04:27'),
(160, 1, 1, 1, 120, 1, '2024-10-21 18:41:34', '2024-10-21 09:04:27'),
(161, 1, 1, 1, 97, 2, '2024-10-21 18:42:15', '2024-10-21 09:04:27'),
(314, 1, 1, 1, 108, 2, '2024-10-26 05:05:00', NULL),
(315, 1, 1, 1, 1, 1, '2024-10-26 05:05:51', NULL),
(317, 1, 1, 1, 4, 2, '2024-10-27 03:35:15', NULL),
(318, 1, 1, 1, 128, 2, '2024-11-06 10:49:54', NULL),
(366, 1, 1, 1, 130, 2, '2024-12-19 17:22:59', NULL),
(370, 1, 1, 1, 129, 2, '2024-12-26 17:41:24', NULL),
(371, 1, 1, 1, 131, 2, '2024-12-31 18:41:09', NULL),
(372, 1, 1, 1, 132, 2, '2024-12-31 18:41:17', NULL),
(394, 1, 1, 1, 133, 2, '2025-04-08 03:51:01', NULL),
(398, 1, 1, 1, 134, 2, '2025-06-14 17:30:02', NULL),
(399, 1, 1, 1, 135, 2, '2025-07-08 17:00:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_sqllog`
--

CREATE TABLE `t_sqllog` (
  `LogId` int(11) NOT NULL,
  `LogDate` datetime NOT NULL,
  `RemoteIP` varchar(100) NOT NULL,
  `UserId` int(11) NOT NULL COMMENT 'In user table has Client and Branch',
  `QueryType` varchar(30) NOT NULL,
  `TableName` varchar(30) NOT NULL,
  `JsonText` longtext NOT NULL,
  `SqlText` longtext NOT NULL,
  `SqlParams` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_sqllog`
--

INSERT INTO `t_sqllog` (`LogId`, `LogDate`, `RemoteIP`, `UserId`, `QueryType`, `TableName`, `JsonText`, `SqlText`, `SqlParams`) VALUES
(6, '2025-06-14 23:30:02', '127.0.0.1', 1, 'INSERT', 't_role_menu_map', '[[\"RoleMenuId\",\"\",398],[\"ClientId\",\"\",1],[\"BranchId\",\"\",1],[\"RoleId\",\"\",1],[\"MenuId\",\"\",134],[\"PermissionType\",\"\",1],[\"CreateTs\",\"\",\"2025-06-14 23:30:02\"]]', 'INSERT INTO t_role_menu_map (ClientId,BranchId,RoleId,MenuId,PermissionType) values (:ClientId,:BranchId,:RoleId,:MenuId,:PermissionType)', '{\"values\":{\"ClientId\":\"1\",\"BranchId\":\"1\",\"RoleId\":\"1\",\"MenuId\":134,\"PermissionType\":1}}'),
(7, '2025-06-14 23:30:04', '127.0.0.1', 1, 'UPDATE', 't_role_menu_map', '[[\"PermissionType\",1,2]]', 'UPDATE t_role_menu_map SET PermissionType = :PermissionType  WHERE RoleMenuId = :RoleMenuId', '{\"values\":{\"PermissionType\":2,\"RoleMenuId\":398}}'),
(8, '2025-07-03 22:03:11', '127.0.0.1', 1, 'UPDATE', 't_transaction', '[[\"TransactionDate\",\"2025-06-04 18:53:25\",\"2025-07-03 00:00:00\"],[\"UpdateTs\",\"2025-06-14 21:45:49\",\"2025-07-03 22:03:11\"]]', 'UPDATE t_transaction SET TransactionDate = :TransactionDate, InvoiceNo = :InvoiceNo, PageNumberStart = :PageNumberStart, CoverFileUrl = :CoverFileUrl, StatusId = :StatusId  WHERE TransactionId = :TransactionId', '{\"values\":{\"TransactionDate\":\"2025-07-03\",\"InvoiceNo\":\"INS-421186\",\"PageNumberStart\":5,\"CoverFileUrl\":null,\"StatusId\":1,\"TransactionId\":1}}'),
(9, '2025-07-03 22:03:34', '127.0.0.1', 1, 'UPDATE', 't_transaction', '[[\"PageNumberStart\",5,3],[\"UpdateTs\",\"2025-07-03 22:03:11\",\"2025-07-03 22:03:34\"]]', 'UPDATE t_transaction SET TransactionDate = :TransactionDate, InvoiceNo = :InvoiceNo, PageNumberStart = :PageNumberStart, CoverFileUrl = :CoverFileUrl, StatusId = :StatusId  WHERE TransactionId = :TransactionId', '{\"values\":{\"TransactionDate\":\"2025-07-03 00:00:00\",\"InvoiceNo\":\"INS-421186\",\"PageNumberStart\":\"3\",\"CoverFileUrl\":null,\"StatusId\":1,\"TransactionId\":1}}'),
(10, '2025-07-03 22:21:46', '127.0.0.1', 1, 'INSERT', 't_transaction', '[[\"TransactionId\",\"\",30600],[\"ClientId\",\"\",1],[\"TransactionTypeId\",\"\",1],[\"TransactionDate\",\"\",\"2025-07-03 00:00:00\"],[\"InvoiceNo\",\"\",\"34\"],[\"PageNumberStart\",\"\",3],[\"UserId\",\"\",1],[\"StatusId\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-03 22:21:46\"],[\"CreateTs\",\"\",\"2025-07-03 22:21:46\"]]', 'INSERT INTO t_transaction (ClientId,TransactionTypeId,TransactionDate,InvoiceNo,PageNumberStart,CoverFileUrl,UserId,StatusId) values (:ClientId,:TransactionTypeId,:TransactionDate,:InvoiceNo,:PageNumberStart,:CoverFileUrl,:UserId,:StatusId)', '{\"values\":{\"ClientId\":\"1\",\"TransactionTypeId\":1,\"TransactionDate\":\"2025-07-03\",\"InvoiceNo\":\"34\",\"PageNumberStart\":\"3\",\"CoverFileUrl\":null,\"UserId\":\"1\",\"StatusId\":1}}'),
(11, '2025-07-03 22:22:26', '127.0.0.1', 1, 'INSERT', 't_transaction', '[[\"TransactionId\",\"\",30601],[\"ClientId\",\"\",1],[\"TransactionTypeId\",\"\",1],[\"TransactionDate\",\"\",\"2025-07-03 00:00:00\"],[\"InvoiceNo\",\"\",\"3\"],[\"PageNumberStart\",\"\",4],[\"UserId\",\"\",1],[\"StatusId\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-03 22:22:26\"],[\"CreateTs\",\"\",\"2025-07-03 22:22:26\"]]', 'INSERT INTO t_transaction (ClientId,TransactionTypeId,TransactionDate,InvoiceNo,PageNumberStart,CoverFileUrl,UserId,StatusId) values (:ClientId,:TransactionTypeId,:TransactionDate,:InvoiceNo,:PageNumberStart,:CoverFileUrl,:UserId,:StatusId)', '{\"values\":{\"ClientId\":\"1\",\"TransactionTypeId\":1,\"TransactionDate\":\"2025-07-03\",\"InvoiceNo\":\"3\",\"PageNumberStart\":\"4\",\"CoverFileUrl\":null,\"UserId\":\"1\",\"StatusId\":1}}'),
(20, '2025-07-03 22:31:27', '127.0.0.1', 1, 'INSERT', 't_transaction', '[[\"TransactionId\",\"\",30606],[\"ClientId\",\"\",1],[\"TransactionTypeId\",\"\",1],[\"TransactionDate\",\"\",\"2025-07-03 00:00:00\"],[\"InvoiceNo\",\"\",\"1212\"],[\"PageNumberStart\",\"\",5],[\"UserId\",\"\",1],[\"StatusId\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-03 22:31:27\"],[\"CreateTs\",\"\",\"2025-07-03 22:31:27\"]]', 'INSERT INTO t_transaction (ClientId,TransactionTypeId,TransactionDate,InvoiceNo,PageNumberStart,CoverFileUrl,UserId,StatusId) values (:ClientId,:TransactionTypeId,:TransactionDate,:InvoiceNo,:PageNumberStart,:CoverFileUrl,:UserId,:StatusId)', '{\"values\":{\"ClientId\":\"1\",\"TransactionTypeId\":1,\"TransactionDate\":\"2025-07-03\",\"InvoiceNo\":\"1212\",\"PageNumberStart\":\"5\",\"CoverFileUrl\":null,\"UserId\":\"1\",\"StatusId\":1}}'),
(21, '2025-07-03 22:31:27', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",14],[\"TransactionId\",\"\",30606],[\"CheckId\",\"\",3],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-onethird\"],[\"PhotoUrl\",\"\",\"placeholder.jpg\"],[\"SortOrder\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-03 22:31:27\"],[\"CreateTs\",\"\",\"2025-07-03 22:31:27\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":\"30606\",\"CheckId\":3,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"placeholder.jpg\",\"SortOrder\":1}}'),
(22, '2025-07-03 22:31:27', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",15],[\"TransactionId\",\"\",30606],[\"CheckId\",\"\",5],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-onethird\"],[\"PhotoUrl\",\"\",\"placeholder.jpg\"],[\"SortOrder\",\"\",2],[\"UpdateTs\",\"\",\"2025-07-03 22:31:27\"],[\"CreateTs\",\"\",\"2025-07-03 22:31:27\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":\"30606\",\"CheckId\":5,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"placeholder.jpg\",\"SortOrder\":2}}'),
(24, '2025-07-03 23:09:00', '127.0.0.1', 1, 'INSERT', 't_transaction', '[[\"TransactionId\",\"\",30608],[\"ClientId\",\"\",1],[\"TransactionTypeId\",\"\",1],[\"TransactionDate\",\"\",\"2025-07-03 00:00:00\"],[\"InvoiceNo\",\"\",\"2\"],[\"PageNumberStart\",\"\",3],[\"UserId\",\"\",1],[\"StatusId\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-03 23:09:00\"],[\"CreateTs\",\"\",\"2025-07-03 23:09:00\"]]', 'INSERT INTO t_transaction (ClientId,TransactionTypeId,TransactionDate,InvoiceNo,PageNumberStart,CoverFileUrl,UserId,StatusId) values (:ClientId,:TransactionTypeId,:TransactionDate,:InvoiceNo,:PageNumberStart,:CoverFileUrl,:UserId,:StatusId)', '{\"values\":{\"ClientId\":\"1\",\"TransactionTypeId\":1,\"TransactionDate\":\"2025-07-03\",\"InvoiceNo\":\"2\",\"PageNumberStart\":\"3\",\"CoverFileUrl\":null,\"UserId\":\"1\",\"StatusId\":1}}'),
(25, '2025-07-03 23:09:00', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",17],[\"TransactionId\",\"\",30608],[\"CheckId\",\"\",4],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-onethird\"],[\"PhotoUrl\",\"\",\"placeholder.jpg\"],[\"SortOrder\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-03 23:09:00\"],[\"CreateTs\",\"\",\"2025-07-03 23:09:00\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":\"30608\",\"CheckId\":4,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"placeholder.jpg\",\"SortOrder\":1}}'),
(26, '2025-07-03 23:09:00', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",18],[\"TransactionId\",\"\",30608],[\"CheckId\",\"\",6],[\"RowNo\",\"\",\"reportcheckblock-width-full\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-half\"],[\"PhotoUrl\",\"\",\"placeholder.jpg\"],[\"SortOrder\",\"\",2],[\"UpdateTs\",\"\",\"2025-07-03 23:09:00\"],[\"CreateTs\",\"\",\"2025-07-03 23:09:00\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":\"30608\",\"CheckId\":6,\"RowNo\":\"reportcheckblock-width-full\",\"ColumnNo\":\"reportcheckblock-height-half\",\"PhotoUrl\":\"placeholder.jpg\",\"SortOrder\":2}}'),
(27, '2025-07-03 23:10:36', '127.0.0.1', 1, 'DELETE', 't_transaction_items', '[[\"TransactionItemId\",14,\"\"],[\"TransactionId\",30606,\"\"],[\"CheckId\",3,\"\"],[\"RowNo\",\"reportcheckblock-width-half\",\"\"],[\"ColumnNo\",\"reportcheckblock-height-onethird\",\"\"],[\"PhotoUrl\",\"placeholder.jpg\",\"\"],[\"SortOrder\",1,\"\"],[\"UpdateTs\",\"2025-07-03 22:31:27\",\"\"],[\"CreateTs\",\"2025-07-03 22:31:27\",\"\"],[\"TransactionItemId\",15,\"\"],[\"TransactionId\",30606,\"\"],[\"CheckId\",5,\"\"],[\"RowNo\",\"reportcheckblock-width-half\",\"\"],[\"ColumnNo\",\"reportcheckblock-height-onethird\",\"\"],[\"PhotoUrl\",\"placeholder.jpg\",\"\"],[\"SortOrder\",2,\"\"],[\"UpdateTs\",\"2025-07-03 22:31:27\",\"\"],[\"CreateTs\",\"2025-07-03 22:31:27\",\"\"]]', 'DELETE FROM t_transaction_items  WHERE TransactionId = :TransactionId', '{\"values\":{\"TransactionId\":30606}}'),
(28, '2025-07-03 23:10:36', '127.0.0.1', 1, 'DELETE', 't_transaction', '[[\"TransactionId\",30606,\"\"],[\"ClientId\",1,\"\"],[\"TransactionTypeId\",1,\"\"],[\"TransactionDate\",\"2025-07-03 00:00:00\",\"\"],[\"InvoiceNo\",\"1212\",\"\"],[\"PageNumberStart\",5,\"\"],[\"CoverFileUrl\",null,\"\"],[\"UserId\",1,\"\"],[\"StatusId\",1,\"\"],[\"UpdateTs\",\"2025-07-03 22:31:27\",\"\"],[\"CreateTs\",\"2025-07-03 22:31:27\",\"\"]]', 'DELETE FROM t_transaction  WHERE TransactionId = :TransactionId', '{\"values\":{\"TransactionId\":30606}}'),
(29, '2025-07-03 23:10:38', '127.0.0.1', 1, 'DELETE', 't_transaction_items', '[[\"TransactionItemId\",17,\"\"],[\"TransactionId\",30608,\"\"],[\"CheckId\",4,\"\"],[\"RowNo\",\"reportcheckblock-width-half\",\"\"],[\"ColumnNo\",\"reportcheckblock-height-onethird\",\"\"],[\"PhotoUrl\",\"placeholder.jpg\",\"\"],[\"SortOrder\",1,\"\"],[\"UpdateTs\",\"2025-07-03 23:09:00\",\"\"],[\"CreateTs\",\"2025-07-03 23:09:00\",\"\"],[\"TransactionItemId\",18,\"\"],[\"TransactionId\",30608,\"\"],[\"CheckId\",6,\"\"],[\"RowNo\",\"reportcheckblock-width-full\",\"\"],[\"ColumnNo\",\"reportcheckblock-height-half\",\"\"],[\"PhotoUrl\",\"placeholder.jpg\",\"\"],[\"SortOrder\",2,\"\"],[\"UpdateTs\",\"2025-07-03 23:09:00\",\"\"],[\"CreateTs\",\"2025-07-03 23:09:00\",\"\"]]', 'DELETE FROM t_transaction_items  WHERE TransactionId = :TransactionId', '{\"values\":{\"TransactionId\":30608}}'),
(30, '2025-07-03 23:10:38', '127.0.0.1', 1, 'DELETE', 't_transaction', '[[\"TransactionId\",30608,\"\"],[\"ClientId\",1,\"\"],[\"TransactionTypeId\",1,\"\"],[\"TransactionDate\",\"2025-07-03 00:00:00\",\"\"],[\"InvoiceNo\",\"2\",\"\"],[\"PageNumberStart\",3,\"\"],[\"CoverFileUrl\",null,\"\"],[\"UserId\",1,\"\"],[\"StatusId\",1,\"\"],[\"UpdateTs\",\"2025-07-03 23:09:00\",\"\"],[\"CreateTs\",\"2025-07-03 23:09:00\",\"\"]]', 'DELETE FROM t_transaction  WHERE TransactionId = :TransactionId', '{\"values\":{\"TransactionId\":30608}}'),
(31, '2025-07-03 23:10:41', '127.0.0.1', 1, 'DELETE', 't_transaction', '[[\"TransactionId\",30601,\"\"],[\"ClientId\",1,\"\"],[\"TransactionTypeId\",1,\"\"],[\"TransactionDate\",\"2025-07-03 00:00:00\",\"\"],[\"InvoiceNo\",\"3\",\"\"],[\"PageNumberStart\",4,\"\"],[\"CoverFileUrl\",null,\"\"],[\"UserId\",1,\"\"],[\"StatusId\",1,\"\"],[\"UpdateTs\",\"2025-07-03 22:22:26\",\"\"],[\"CreateTs\",\"2025-07-03 22:22:26\",\"\"]]', 'DELETE FROM t_transaction  WHERE TransactionId = :TransactionId', '{\"values\":{\"TransactionId\":30601}}'),
(32, '2025-07-03 23:14:28', '127.0.0.1', 1, 'INSERT', 't_transaction', '[[\"TransactionId\",\"\",4],[\"ClientId\",\"\",1],[\"TransactionTypeId\",\"\",1],[\"TransactionDate\",\"\",\"2025-07-03 00:00:00\"],[\"InvoiceNo\",\"\",\"2\"],[\"PageNumberStart\",\"\",3],[\"UserId\",\"\",1],[\"StatusId\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-03 23:14:28\"],[\"CreateTs\",\"\",\"2025-07-03 23:14:28\"]]', 'INSERT INTO t_transaction (ClientId,TransactionTypeId,TransactionDate,InvoiceNo,PageNumberStart,CoverFileUrl,UserId,StatusId) values (:ClientId,:TransactionTypeId,:TransactionDate,:InvoiceNo,:PageNumberStart,:CoverFileUrl,:UserId,:StatusId)', '{\"values\":{\"ClientId\":\"1\",\"TransactionTypeId\":1,\"TransactionDate\":\"2025-07-03\",\"InvoiceNo\":\"2\",\"PageNumberStart\":\"3\",\"CoverFileUrl\":null,\"UserId\":\"1\",\"StatusId\":1}}'),
(33, '2025-07-03 23:14:28', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",6],[\"TransactionId\",\"\",4],[\"CheckId\",\"\",1],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-onethird\"],[\"PhotoUrl\",\"\",\"placeholder.jpg\"],[\"SortOrder\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-03 23:14:28\"],[\"CreateTs\",\"\",\"2025-07-03 23:14:28\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":\"4\",\"CheckId\":1,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"placeholder.jpg\",\"SortOrder\":1}}'),
(34, '2025-07-03 23:14:28', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",7],[\"TransactionId\",\"\",4],[\"CheckId\",\"\",4],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-onethird\"],[\"PhotoUrl\",\"\",\"placeholder.jpg\"],[\"SortOrder\",\"\",2],[\"UpdateTs\",\"\",\"2025-07-03 23:14:28\"],[\"CreateTs\",\"\",\"2025-07-03 23:14:28\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":\"4\",\"CheckId\":4,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"placeholder.jpg\",\"SortOrder\":2}}'),
(37, '2025-07-03 23:22:12', '127.0.0.1', 1, 'INSERT', 't_transaction', '[[\"TransactionId\",\"\",7],[\"ClientId\",\"\",1],[\"TransactionTypeId\",\"\",1],[\"TransactionDate\",\"\",\"2025-07-03 00:00:00\"],[\"InvoiceNo\",\"\",\"3\"],[\"PageNumberStart\",\"\",2],[\"UserId\",\"\",1],[\"StatusId\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-03 23:22:12\"],[\"CreateTs\",\"\",\"2025-07-03 23:22:12\"]]', 'INSERT INTO t_transaction (ClientId,TransactionTypeId,TransactionDate,InvoiceNo,PageNumberStart,CoverFileUrl,UserId,StatusId) values (:ClientId,:TransactionTypeId,:TransactionDate,:InvoiceNo,:PageNumberStart,:CoverFileUrl,:UserId,:StatusId)', '{\"values\":{\"ClientId\":\"1\",\"TransactionTypeId\":1,\"TransactionDate\":\"2025-07-03\",\"InvoiceNo\":\"3\",\"PageNumberStart\":\"2\",\"CoverFileUrl\":null,\"UserId\":\"1\",\"StatusId\":1}}'),
(38, '2025-07-03 23:22:12', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",10],[\"TransactionId\",\"\",7],[\"CheckId\",\"\",2],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-onethird\"],[\"PhotoUrl\",\"\",\"placeholder.jpg\"],[\"SortOrder\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-03 23:22:12\"],[\"CreateTs\",\"\",\"2025-07-03 23:22:12\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":\"7\",\"CheckId\":2,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"placeholder.jpg\",\"SortOrder\":1}}'),
(39, '2025-07-03 23:22:12', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",11],[\"TransactionId\",\"\",7],[\"CheckId\",\"\",4],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-onethird\"],[\"PhotoUrl\",\"\",\"placeholder.jpg\"],[\"SortOrder\",\"\",2],[\"UpdateTs\",\"\",\"2025-07-03 23:22:12\"],[\"CreateTs\",\"\",\"2025-07-03 23:22:12\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":\"7\",\"CheckId\":4,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"placeholder.jpg\",\"SortOrder\":2}}'),
(40, '2025-07-03 23:23:33', '127.0.0.1', 1, 'DELETE', 't_transaction_items', '[[\"TransactionItemId\",6,\"\"],[\"TransactionId\",4,\"\"],[\"CheckId\",1,\"\"],[\"RowNo\",\"reportcheckblock-width-half\",\"\"],[\"ColumnNo\",\"reportcheckblock-height-onethird\",\"\"],[\"PhotoUrl\",\"placeholder.jpg\",\"\"],[\"SortOrder\",1,\"\"],[\"UpdateTs\",\"2025-07-03 23:14:28\",\"\"],[\"CreateTs\",\"2025-07-03 23:14:28\",\"\"],[\"TransactionItemId\",7,\"\"],[\"TransactionId\",4,\"\"],[\"CheckId\",4,\"\"],[\"RowNo\",\"reportcheckblock-width-half\",\"\"],[\"ColumnNo\",\"reportcheckblock-height-onethird\",\"\"],[\"PhotoUrl\",\"placeholder.jpg\",\"\"],[\"SortOrder\",2,\"\"],[\"UpdateTs\",\"2025-07-03 23:14:28\",\"\"],[\"CreateTs\",\"2025-07-03 23:14:28\",\"\"]]', 'DELETE FROM t_transaction_items  WHERE TransactionId = :TransactionId', '{\"values\":{\"TransactionId\":4}}'),
(41, '2025-07-03 23:23:33', '127.0.0.1', 1, 'DELETE', 't_transaction', '[[\"TransactionId\",4,\"\"],[\"ClientId\",1,\"\"],[\"TransactionTypeId\",1,\"\"],[\"TransactionDate\",\"2025-07-03 00:00:00\",\"\"],[\"InvoiceNo\",\"2\",\"\"],[\"PageNumberStart\",3,\"\"],[\"CoverFileUrl\",null,\"\"],[\"UserId\",1,\"\"],[\"StatusId\",1,\"\"],[\"UpdateTs\",\"2025-07-03 23:14:28\",\"\"],[\"CreateTs\",\"2025-07-03 23:14:28\",\"\"]]', 'DELETE FROM t_transaction  WHERE TransactionId = :TransactionId', '{\"values\":{\"TransactionId\":4}}'),
(42, '2025-07-03 23:23:36', '127.0.0.1', 1, 'DELETE', 't_transaction_items', '[[\"TransactionItemId\",10,\"\"],[\"TransactionId\",7,\"\"],[\"CheckId\",2,\"\"],[\"RowNo\",\"reportcheckblock-width-half\",\"\"],[\"ColumnNo\",\"reportcheckblock-height-onethird\",\"\"],[\"PhotoUrl\",\"placeholder.jpg\",\"\"],[\"SortOrder\",1,\"\"],[\"UpdateTs\",\"2025-07-03 23:22:12\",\"\"],[\"CreateTs\",\"2025-07-03 23:22:12\",\"\"],[\"TransactionItemId\",11,\"\"],[\"TransactionId\",7,\"\"],[\"CheckId\",4,\"\"],[\"RowNo\",\"reportcheckblock-width-half\",\"\"],[\"ColumnNo\",\"reportcheckblock-height-onethird\",\"\"],[\"PhotoUrl\",\"placeholder.jpg\",\"\"],[\"SortOrder\",2,\"\"],[\"UpdateTs\",\"2025-07-03 23:22:12\",\"\"],[\"CreateTs\",\"2025-07-03 23:22:12\",\"\"]]', 'DELETE FROM t_transaction_items  WHERE TransactionId = :TransactionId', '{\"values\":{\"TransactionId\":7}}'),
(43, '2025-07-03 23:23:36', '127.0.0.1', 1, 'DELETE', 't_transaction', '[[\"TransactionId\",7,\"\"],[\"ClientId\",1,\"\"],[\"TransactionTypeId\",1,\"\"],[\"TransactionDate\",\"2025-07-03 00:00:00\",\"\"],[\"InvoiceNo\",\"3\",\"\"],[\"PageNumberStart\",2,\"\"],[\"CoverFileUrl\",null,\"\"],[\"UserId\",1,\"\"],[\"StatusId\",1,\"\"],[\"UpdateTs\",\"2025-07-03 23:22:12\",\"\"],[\"CreateTs\",\"2025-07-03 23:22:12\",\"\"]]', 'DELETE FROM t_transaction  WHERE TransactionId = :TransactionId', '{\"values\":{\"TransactionId\":7}}'),
(44, '2025-07-03 23:23:57', '127.0.0.1', 1, 'INSERT', 't_transaction', '[[\"TransactionId\",\"\",8],[\"ClientId\",\"\",1],[\"TransactionTypeId\",\"\",1],[\"TransactionDate\",\"\",\"2025-07-03 00:00:00\"],[\"InvoiceNo\",\"\",\"3\"],[\"PageNumberStart\",\"\",4],[\"UserId\",\"\",1],[\"StatusId\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-03 23:23:57\"],[\"CreateTs\",\"\",\"2025-07-03 23:23:57\"]]', 'INSERT INTO t_transaction (ClientId,TransactionTypeId,TransactionDate,InvoiceNo,PageNumberStart,CoverFileUrl,UserId,StatusId) values (:ClientId,:TransactionTypeId,:TransactionDate,:InvoiceNo,:PageNumberStart,:CoverFileUrl,:UserId,:StatusId)', '{\"values\":{\"ClientId\":\"1\",\"TransactionTypeId\":1,\"TransactionDate\":\"2025-07-03\",\"InvoiceNo\":\"3\",\"PageNumberStart\":\"4\",\"CoverFileUrl\":null,\"UserId\":\"1\",\"StatusId\":1}}'),
(45, '2025-07-03 23:23:57', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",12],[\"TransactionId\",\"\",8],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-onethird\"],[\"PhotoUrl\",\"\",\"placeholder.jpg\"],[\"SortOrder\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-03 23:23:57\"],[\"CreateTs\",\"\",\"2025-07-03 23:23:57\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":\"8\",\"CheckId\":null,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"placeholder.jpg\",\"SortOrder\":1}}'),
(46, '2025-07-03 23:23:57', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",13],[\"TransactionId\",\"\",8],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-onethird\"],[\"PhotoUrl\",\"\",\"placeholder.jpg\"],[\"SortOrder\",\"\",2],[\"UpdateTs\",\"\",\"2025-07-03 23:23:57\"],[\"CreateTs\",\"\",\"2025-07-03 23:23:57\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":\"8\",\"CheckId\":null,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"placeholder.jpg\",\"SortOrder\":2}}'),
(47, '2025-07-03 23:23:57', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",14],[\"TransactionId\",\"\",8],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-onethird\"],[\"PhotoUrl\",\"\",\"placeholder.jpg\"],[\"SortOrder\",\"\",3],[\"UpdateTs\",\"\",\"2025-07-03 23:23:57\"],[\"CreateTs\",\"\",\"2025-07-03 23:23:57\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":\"8\",\"CheckId\":null,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"placeholder.jpg\",\"SortOrder\":3}}'),
(48, '2025-07-03 23:28:56', '127.0.0.1', 1, 'INSERT', 't_transaction', '[[\"TransactionId\",\"\",9],[\"ClientId\",\"\",1],[\"TransactionTypeId\",\"\",1],[\"TransactionDate\",\"\",\"2025-07-03 00:00:00\"],[\"InvoiceNo\",\"\",\"2\"],[\"PageNumberStart\",\"\",3],[\"UserId\",\"\",1],[\"StatusId\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-03 23:28:56\"],[\"CreateTs\",\"\",\"2025-07-03 23:28:56\"]]', 'INSERT INTO t_transaction (ClientId,TransactionTypeId,TransactionDate,InvoiceNo,PageNumberStart,CoverFileUrl,UserId,StatusId) values (:ClientId,:TransactionTypeId,:TransactionDate,:InvoiceNo,:PageNumberStart,:CoverFileUrl,:UserId,:StatusId)', '{\"values\":{\"ClientId\":\"1\",\"TransactionTypeId\":1,\"TransactionDate\":\"2025-07-03\",\"InvoiceNo\":\"2\",\"PageNumberStart\":\"3\",\"CoverFileUrl\":null,\"UserId\":\"1\",\"StatusId\":1}}'),
(49, '2025-07-03 23:28:56', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",15],[\"TransactionId\",\"\",9],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-onethird\"],[\"PhotoUrl\",\"\",\"placeholder.jpg\"],[\"SortOrder\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-03 23:28:56\"],[\"CreateTs\",\"\",\"2025-07-03 23:28:56\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":\"9\",\"CheckId\":null,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"placeholder.jpg\",\"SortOrder\":1}}'),
(50, '2025-07-03 23:28:56', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",16],[\"TransactionId\",\"\",9],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-half\"],[\"PhotoUrl\",\"\",\"placeholder.jpg\"],[\"SortOrder\",\"\",2],[\"UpdateTs\",\"\",\"2025-07-03 23:28:56\"],[\"CreateTs\",\"\",\"2025-07-03 23:28:56\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":\"9\",\"CheckId\":null,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-half\",\"PhotoUrl\":\"placeholder.jpg\",\"SortOrder\":2}}'),
(51, '2025-07-03 23:40:07', '127.0.0.1', 1, 'INSERT', 't_transaction', '[[\"TransactionId\",\"\",10],[\"ClientId\",\"\",1],[\"TransactionTypeId\",\"\",1],[\"TransactionDate\",\"\",\"2025-07-03 00:00:00\"],[\"InvoiceNo\",\"\",\"11\"],[\"PageNumberStart\",\"\",23],[\"UserId\",\"\",1],[\"StatusId\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-03 23:40:07\"],[\"CreateTs\",\"\",\"2025-07-03 23:40:07\"]]', 'INSERT INTO t_transaction (ClientId,TransactionTypeId,TransactionDate,InvoiceNo,PageNumberStart,CoverFileUrl,UserId,StatusId) values (:ClientId,:TransactionTypeId,:TransactionDate,:InvoiceNo,:PageNumberStart,:CoverFileUrl,:UserId,:StatusId)', '{\"values\":{\"ClientId\":\"1\",\"TransactionTypeId\":1,\"TransactionDate\":\"2025-07-03\",\"InvoiceNo\":\"11\",\"PageNumberStart\":\"23\",\"CoverFileUrl\":null,\"UserId\":\"1\",\"StatusId\":1}}'),
(52, '2025-07-03 23:40:07', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",17],[\"TransactionId\",\"\",10],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-onethird\"],[\"PhotoUrl\",\"\",\"undefined_Selected photo.jpg\"],[\"SortOrder\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-03 23:40:07\"],[\"CreateTs\",\"\",\"2025-07-03 23:40:07\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":\"10\",\"CheckId\":null,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"undefined_Selected photo.jpg\",\"SortOrder\":1}}'),
(53, '2025-07-03 23:40:07', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",18],[\"TransactionId\",\"\",10],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-onethird\"],[\"PhotoUrl\",\"\",\"undefined_a9.png\"],[\"SortOrder\",\"\",2],[\"UpdateTs\",\"\",\"2025-07-03 23:40:07\"],[\"CreateTs\",\"\",\"2025-07-03 23:40:07\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":\"10\",\"CheckId\":null,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"undefined_a9.png\",\"SortOrder\":2}}'),
(54, '2025-07-03 23:41:45', '127.0.0.1', 1, 'INSERT', 't_transaction', '[[\"TransactionId\",\"\",11],[\"ClientId\",\"\",1],[\"TransactionTypeId\",\"\",1],[\"TransactionDate\",\"\",\"2025-07-03 00:00:00\"],[\"InvoiceNo\",\"\",\"6\"],[\"PageNumberStart\",\"\",7],[\"UserId\",\"\",1],[\"StatusId\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-03 23:41:45\"],[\"CreateTs\",\"\",\"2025-07-03 23:41:45\"]]', 'INSERT INTO t_transaction (ClientId,TransactionTypeId,TransactionDate,InvoiceNo,PageNumberStart,CoverFileUrl,UserId,StatusId) values (:ClientId,:TransactionTypeId,:TransactionDate,:InvoiceNo,:PageNumberStart,:CoverFileUrl,:UserId,:StatusId)', '{\"values\":{\"ClientId\":\"1\",\"TransactionTypeId\":1,\"TransactionDate\":\"2025-07-03\",\"InvoiceNo\":\"6\",\"PageNumberStart\":\"7\",\"CoverFileUrl\":null,\"UserId\":\"1\",\"StatusId\":1}}'),
(55, '2025-07-03 23:41:45', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",19],[\"TransactionId\",\"\",11],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-onethird\"],[\"PhotoUrl\",\"\",\"1751564492751_a10.png\"],[\"SortOrder\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-03 23:41:45\"],[\"CreateTs\",\"\",\"2025-07-03 23:41:45\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":\"11\",\"CheckId\":null,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"1751564492751_a10.png\",\"SortOrder\":1}}'),
(56, '2025-07-03 23:41:45', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",20],[\"TransactionId\",\"\",11],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-onethird\"],[\"PhotoUrl\",\"\",\"1751564498686_shared image.jpg\"],[\"SortOrder\",\"\",2],[\"UpdateTs\",\"\",\"2025-07-03 23:41:45\"],[\"CreateTs\",\"\",\"2025-07-03 23:41:45\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":\"11\",\"CheckId\":null,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"1751564498686_shared image.jpg\",\"SortOrder\":2}}'),
(57, '2025-07-03 23:47:24', '127.0.0.1', 1, 'DELETE', 't_transaction_items', '[[\"TransactionItemId\",17,\"\"],[\"TransactionId\",10,\"\"],[\"CheckId\",null,\"\"],[\"RowNo\",\"reportcheckblock-width-half\",\"\"],[\"ColumnNo\",\"reportcheckblock-height-onethird\",\"\"],[\"PhotoUrl\",\"undefined_Selected photo.jpg\",\"\"],[\"SortOrder\",1,\"\"],[\"UpdateTs\",\"2025-07-03 23:40:07\",\"\"],[\"CreateTs\",\"2025-07-03 23:40:07\",\"\"],[\"TransactionItemId\",18,\"\"],[\"TransactionId\",10,\"\"],[\"CheckId\",null,\"\"],[\"RowNo\",\"reportcheckblock-width-half\",\"\"],[\"ColumnNo\",\"reportcheckblock-height-onethird\",\"\"],[\"PhotoUrl\",\"undefined_a9.png\",\"\"],[\"SortOrder\",2,\"\"],[\"UpdateTs\",\"2025-07-03 23:40:07\",\"\"],[\"CreateTs\",\"2025-07-03 23:40:07\",\"\"]]', 'DELETE FROM t_transaction_items  WHERE TransactionId = :TransactionId', '{\"values\":{\"TransactionId\":10}}'),
(58, '2025-07-03 23:47:24', '127.0.0.1', 1, 'DELETE', 't_transaction', '[[\"TransactionId\",10,\"\"],[\"ClientId\",1,\"\"],[\"TransactionTypeId\",1,\"\"],[\"TransactionDate\",\"2025-07-03 00:00:00\",\"\"],[\"InvoiceNo\",\"11\",\"\"],[\"PageNumberStart\",23,\"\"],[\"CoverFileUrl\",null,\"\"],[\"UserId\",1,\"\"],[\"StatusId\",1,\"\"],[\"UpdateTs\",\"2025-07-03 23:40:07\",\"\"],[\"CreateTs\",\"2025-07-03 23:40:07\",\"\"]]', 'DELETE FROM t_transaction  WHERE TransactionId = :TransactionId', '{\"values\":{\"TransactionId\":10}}'),
(59, '2025-07-04 23:58:55', '127.0.0.1', 1, 'UPDATE', 't_transaction_items', '[[\"PhotoUrl\",\"placeholder.jpg\",\"2025_07_04_23_58_55_7475.jpeg\"],[\"UpdateTs\",\"2025-07-03 23:28:56\",\"2025-07-04 23:58:55\"]]', 'UPDATE t_transaction_items SET CheckId = :CheckId, RowNo = :RowNo, ColumnNo = :ColumnNo, PhotoUrl = :PhotoUrl, SortOrder = :SortOrder  WHERE TransactionItemId = :TransactionItemId', '{\"values\":{\"CheckId\":null,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"2025_07_04_23_58_55_7475.jpeg\",\"SortOrder\":1,\"TransactionItemId\":15}}'),
(60, '2025-07-04 23:58:55', '127.0.0.1', 1, 'UPDATE', 't_transaction_items', '[[\"ColumnNo\",\"reportcheckblock-height-half\",\"reportcheckblock-height-full\"],[\"PhotoUrl\",\"placeholder.jpg\",\"2025_07_04_23_58_55_2354.png\"],[\"UpdateTs\",\"2025-07-03 23:28:56\",\"2025-07-04 23:58:55\"]]', 'UPDATE t_transaction_items SET CheckId = :CheckId, RowNo = :RowNo, ColumnNo = :ColumnNo, PhotoUrl = :PhotoUrl, SortOrder = :SortOrder  WHERE TransactionItemId = :TransactionItemId', '{\"values\":{\"CheckId\":null,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-full\",\"PhotoUrl\":\"2025_07_04_23_58_55_2354.png\",\"SortOrder\":2,\"TransactionItemId\":16}}'),
(61, '2025-07-05 00:00:41', '127.0.0.1', 1, 'UPDATE', 't_transaction_items', '[[\"PhotoUrl\",\"2025_07_04_23_58_55_7475.jpeg\",\"2025_07_05_00_00_41_6620.png\"],[\"UpdateTs\",\"2025-07-04 23:58:55\",\"2025-07-05 00:00:41\"]]', 'UPDATE t_transaction_items SET CheckId = :CheckId, RowNo = :RowNo, ColumnNo = :ColumnNo, PhotoUrl = :PhotoUrl, SortOrder = :SortOrder  WHERE TransactionItemId = :TransactionItemId', '{\"values\":{\"CheckId\":null,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"2025_07_05_00_00_41_6620.png\",\"SortOrder\":1,\"TransactionItemId\":15}}'),
(62, '2025-07-05 00:00:41', '127.0.0.1', 1, 'UPDATE', 't_transaction_items', '[[\"PhotoUrl\",\"2025_07_04_23_58_55_2354.png\",\"2025_07_05_00_00_41_2268.png\"],[\"UpdateTs\",\"2025-07-04 23:58:55\",\"2025-07-05 00:00:41\"]]', 'UPDATE t_transaction_items SET CheckId = :CheckId, RowNo = :RowNo, ColumnNo = :ColumnNo, PhotoUrl = :PhotoUrl, SortOrder = :SortOrder  WHERE TransactionItemId = :TransactionItemId', '{\"values\":{\"CheckId\":null,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-full\",\"PhotoUrl\":\"2025_07_05_00_00_41_2268.png\",\"SortOrder\":2,\"TransactionItemId\":16}}'),
(63, '2025-07-05 00:01:23', '127.0.0.1', 1, 'UPDATE', 't_transaction_items', '[[\"CheckId\",null,4],[\"UpdateTs\",\"2025-07-05 00:00:41\",\"2025-07-05 00:01:23\"]]', 'UPDATE t_transaction_items SET CheckId = :CheckId, RowNo = :RowNo, ColumnNo = :ColumnNo, PhotoUrl = :PhotoUrl, SortOrder = :SortOrder  WHERE TransactionItemId = :TransactionItemId', '{\"values\":{\"CheckId\":4,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"2025_07_05_00_00_41_6620.png\",\"SortOrder\":1,\"TransactionItemId\":15}}'),
(64, '2025-07-05 00:01:23', '127.0.0.1', 1, 'UPDATE', 't_transaction_items', '[[\"CheckId\",null,7],[\"UpdateTs\",\"2025-07-05 00:00:41\",\"2025-07-05 00:01:23\"]]', 'UPDATE t_transaction_items SET CheckId = :CheckId, RowNo = :RowNo, ColumnNo = :ColumnNo, PhotoUrl = :PhotoUrl, SortOrder = :SortOrder  WHERE TransactionItemId = :TransactionItemId', '{\"values\":{\"CheckId\":7,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-full\",\"PhotoUrl\":\"2025_07_05_00_00_41_2268.png\",\"SortOrder\":2,\"TransactionItemId\":16}}'),
(66, '2025-07-05 00:15:36', '127.0.0.1', 1, 'UPDATE', 't_transaction_items', '[[\"CheckId\",7,8],[\"UpdateTs\",\"2025-07-05 00:01:23\",\"2025-07-05 00:15:36\"]]', 'UPDATE t_transaction_items SET CheckId = :CheckId, RowNo = :RowNo, ColumnNo = :ColumnNo, PhotoUrl = :PhotoUrl, SortOrder = :SortOrder  WHERE TransactionItemId = :TransactionItemId', '{\"values\":{\"CheckId\":8,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-full\",\"PhotoUrl\":\"2025_07_05_00_00_41_2268.png\",\"SortOrder\":2,\"TransactionItemId\":16}}'),
(67, '2025-07-05 00:15:36', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",22],[\"TransactionId\",\"\",9],[\"CheckId\",\"\",2],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-onethird\"],[\"PhotoUrl\",\"\",\"2025_07_05_00_15_36_8118.png\"],[\"SortOrder\",\"\",3],[\"UpdateTs\",\"\",\"2025-07-05 00:15:36\"],[\"CreateTs\",\"\",\"2025-07-05 00:15:36\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":9,\"CheckId\":2,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"2025_07_05_00_15_36_8118.png\",\"SortOrder\":3}}'),
(68, '2025-07-05 00:18:37', '127.0.0.1', 1, 'INSERT', 't_transaction', '[[\"TransactionId\",\"\",12],[\"ClientId\",\"\",1],[\"TransactionTypeId\",\"\",1],[\"TransactionDate\",\"\",\"2025-07-05 00:00:00\"],[\"InvoiceNo\",\"\",\"555\"],[\"PageNumberStart\",\"\",3],[\"UserId\",\"\",1],[\"StatusId\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-05 00:18:37\"],[\"CreateTs\",\"\",\"2025-07-05 00:18:37\"]]', 'INSERT INTO t_transaction (ClientId,TransactionTypeId,TransactionDate,InvoiceNo,PageNumberStart,CoverFileUrl,UserId,StatusId) values (:ClientId,:TransactionTypeId,:TransactionDate,:InvoiceNo,:PageNumberStart,:CoverFileUrl,:UserId,:StatusId)', '{\"values\":{\"ClientId\":\"1\",\"TransactionTypeId\":1,\"TransactionDate\":\"2025-07-05\",\"InvoiceNo\":\"555\",\"PageNumberStart\":\"3\",\"CoverFileUrl\":null,\"UserId\":\"1\",\"StatusId\":1}}'),
(69, '2025-07-05 00:18:37', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",23],[\"TransactionId\",\"\",12],[\"CheckId\",\"\",3],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-onethird\"],[\"PhotoUrl\",\"\",\"1751653102491_a8.png\"],[\"SortOrder\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-05 00:18:37\"],[\"CreateTs\",\"\",\"2025-07-05 00:18:37\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":\"12\",\"CheckId\":3,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"1751653102491_a8.png\",\"SortOrder\":1}}'),
(70, '2025-07-05 00:20:17', '127.0.0.1', 1, 'INSERT', 't_transaction', '[[\"TransactionId\",\"\",13],[\"ClientId\",\"\",1],[\"TransactionTypeId\",\"\",1],[\"TransactionDate\",\"\",\"2025-07-05 00:00:00\"],[\"InvoiceNo\",\"\",\"112\"],[\"PageNumberStart\",\"\",4],[\"UserId\",\"\",1],[\"StatusId\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-05 00:20:17\"],[\"CreateTs\",\"\",\"2025-07-05 00:20:17\"]]', 'INSERT INTO t_transaction (ClientId,TransactionTypeId,TransactionDate,InvoiceNo,PageNumberStart,CoverFileUrl,UserId,StatusId) values (:ClientId,:TransactionTypeId,:TransactionDate,:InvoiceNo,:PageNumberStart,:CoverFileUrl,:UserId,:StatusId)', '{\"values\":{\"ClientId\":\"1\",\"TransactionTypeId\":1,\"TransactionDate\":\"2025-07-05\",\"InvoiceNo\":\"112\",\"PageNumberStart\":\"4\",\"CoverFileUrl\":null,\"UserId\":\"1\",\"StatusId\":1}}'),
(71, '2025-07-05 00:20:17', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",24],[\"TransactionId\",\"\",13],[\"CheckId\",\"\",2],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-onethird\"],[\"PhotoUrl\",\"\",\"1751653194348_CbPCVaOn.jpg\"],[\"SortOrder\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-05 00:20:17\"],[\"CreateTs\",\"\",\"2025-07-05 00:20:17\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":\"13\",\"CheckId\":2,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"1751653194348_CbPCVaOn.jpg\",\"SortOrder\":1}}'),
(72, '2025-07-05 00:21:48', '127.0.0.1', 1, 'INSERT', 't_transaction', '[[\"TransactionId\",\"\",14],[\"ClientId\",\"\",1],[\"TransactionTypeId\",\"\",1],[\"TransactionDate\",\"\",\"2025-07-05 00:00:00\"],[\"InvoiceNo\",\"\",\"88\"],[\"PageNumberStart\",\"\",7],[\"UserId\",\"\",1],[\"StatusId\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-05 00:21:48\"],[\"CreateTs\",\"\",\"2025-07-05 00:21:48\"]]', 'INSERT INTO t_transaction (ClientId,TransactionTypeId,TransactionDate,InvoiceNo,PageNumberStart,CoverFileUrl,UserId,StatusId) values (:ClientId,:TransactionTypeId,:TransactionDate,:InvoiceNo,:PageNumberStart,:CoverFileUrl,:UserId,:StatusId)', '{\"values\":{\"ClientId\":\"1\",\"TransactionTypeId\":1,\"TransactionDate\":\"2025-07-05\",\"InvoiceNo\":\"88\",\"PageNumberStart\":\"7\",\"CoverFileUrl\":null,\"UserId\":\"1\",\"StatusId\":1}}'),
(73, '2025-07-05 00:21:48', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",25],[\"TransactionId\",\"\",14],[\"CheckId\",\"\",8],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-onethird\"],[\"PhotoUrl\",\"\",\"2025_07_05_00_21_48_3018.png\"],[\"SortOrder\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-05 00:21:48\"],[\"CreateTs\",\"\",\"2025-07-05 00:21:48\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":\"14\",\"CheckId\":8,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"2025_07_05_00_21_48_3018.png\",\"SortOrder\":1}}'),
(74, '2025-07-05 00:33:58', '127.0.0.1', 1, 'UPDATE', 't_transaction_items', '[[\"PhotoUrl\",\"1751653194348_CbPCVaOn.jpg\",\"111_2025_07_05_00_33_58__4993.jpeg\"],[\"UpdateTs\",\"2025-07-05 00:20:17\",\"2025-07-05 00:33:58\"]]', 'UPDATE t_transaction_items SET CheckId = :CheckId, RowNo = :RowNo, ColumnNo = :ColumnNo, PhotoUrl = :PhotoUrl, SortOrder = :SortOrder  WHERE TransactionItemId = :TransactionItemId', '{\"values\":{\"CheckId\":2,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"111_2025_07_05_00_33_58__4993.jpeg\",\"SortOrder\":1,\"TransactionItemId\":24}}'),
(75, '2025-07-05 00:34:52', '127.0.0.1', 1, 'INSERT', 't_transaction', '[[\"TransactionId\",\"\",15],[\"ClientId\",\"\",1],[\"TransactionTypeId\",\"\",1],[\"TransactionDate\",\"\",\"2025-07-05 00:00:00\"],[\"InvoiceNo\",\"\",\"63\"],[\"PageNumberStart\",\"\",2],[\"ManyImgPrefix\",\"\",\"1751654068715\"],[\"UserId\",\"\",1],[\"StatusId\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-05 00:34:52\"],[\"CreateTs\",\"\",\"2025-07-05 00:34:52\"]]', 'INSERT INTO t_transaction (ClientId,TransactionTypeId,TransactionDate,InvoiceNo,PageNumberStart,CoverFileUrl,UserId,StatusId,ManyImgPrefix) values (:ClientId,:TransactionTypeId,:TransactionDate,:InvoiceNo,:PageNumberStart,:CoverFileUrl,:UserId,:StatusId,:ManyImgPrefix)', '{\"values\":{\"ClientId\":\"1\",\"TransactionTypeId\":1,\"TransactionDate\":\"2025-07-05\",\"InvoiceNo\":\"63\",\"PageNumberStart\":\"2\",\"CoverFileUrl\":null,\"UserId\":\"1\",\"StatusId\":1,\"ManyImgPrefix\":1751654068715}}'),
(76, '2025-07-05 00:34:52', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",26],[\"TransactionId\",\"\",15],[\"CheckId\",\"\",2],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-half\"],[\"PhotoUrl\",\"\",\"1751654068715_2025_07_05_00_34_52__2503.jpeg\"],[\"SortOrder\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-05 00:34:52\"],[\"CreateTs\",\"\",\"2025-07-05 00:34:52\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":\"15\",\"CheckId\":2,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-half\",\"PhotoUrl\":\"1751654068715_2025_07_05_00_34_52__2503.jpeg\",\"SortOrder\":1}}'),
(77, '2025-07-05 00:34:52', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",27],[\"TransactionId\",\"\",15],[\"CheckId\",\"\",3],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-full\"],[\"PhotoUrl\",\"\",\"1751654068715_2025_07_05_00_34_52__7143.png\"],[\"SortOrder\",\"\",2],[\"UpdateTs\",\"\",\"2025-07-05 00:34:52\"],[\"CreateTs\",\"\",\"2025-07-05 00:34:52\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":\"15\",\"CheckId\":3,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-full\",\"PhotoUrl\":\"1751654068715_2025_07_05_00_34_52__7143.png\",\"SortOrder\":2}}'),
(78, '2025-07-05 00:36:14', '127.0.0.1', 1, 'DELETE', 't_transaction_items', '[[\"TransactionItemId\",24,\"\"],[\"TransactionId\",13,\"\"],[\"CheckId\",2,\"\"],[\"RowNo\",\"reportcheckblock-width-half\",\"\"],[\"ColumnNo\",\"reportcheckblock-height-onethird\",\"\"],[\"PhotoUrl\",\"111_2025_07_05_00_33_58__4993.jpeg\",\"\"],[\"SortOrder\",1,\"\"],[\"UpdateTs\",\"2025-07-05 00:33:58\",\"\"],[\"CreateTs\",\"2025-07-05 00:20:17\",\"\"]]', 'DELETE FROM t_transaction_items  WHERE TransactionId = :TransactionId', '{\"values\":{\"TransactionId\":13}}'),
(79, '2025-07-05 00:36:14', '127.0.0.1', 1, 'DELETE', 't_transaction', '[[\"TransactionId\",13,\"\"],[\"ClientId\",1,\"\"],[\"TransactionTypeId\",1,\"\"],[\"TransactionDate\",\"2025-07-05 00:00:00\",\"\"],[\"InvoiceNo\",\"112\",\"\"],[\"PageNumberStart\",4,\"\"],[\"CoverFileUrl\",null,\"\"],[\"ManyImgPrefix\",\"111\",\"\"],[\"UserId\",1,\"\"],[\"StatusId\",1,\"\"],[\"UpdateTs\",\"2025-07-05 00:33:37\",\"\"],[\"CreateTs\",\"2025-07-05 00:20:17\",\"\"]]', 'DELETE FROM t_transaction  WHERE TransactionId = :TransactionId', '{\"values\":{\"TransactionId\":13}}'),
(80, '2025-07-05 12:05:17', '127.0.0.1', 1, 'UPDATE', 't_transaction_items', '[[\"PhotoUrl\",\"1751653102491_a8.png\",\"987_2025_07_05_12_05_17__1462.jpeg\"],[\"UpdateTs\",\"2025-07-05 00:18:37\",\"2025-07-05 12:05:17\"]]', 'UPDATE t_transaction_items SET CheckId = :CheckId, RowNo = :RowNo, ColumnNo = :ColumnNo, PhotoUrl = :PhotoUrl, SortOrder = :SortOrder  WHERE TransactionItemId = :TransactionItemId', '{\"values\":{\"CheckId\":3,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"987_2025_07_05_12_05_17__1462.jpeg\",\"SortOrder\":1,\"TransactionItemId\":23}}'),
(81, '2025-07-06 23:29:57', '127.0.0.1', 1, 'INSERT', 't_transaction', '[[\"TransactionId\",\"\",16],[\"ClientId\",\"\",1],[\"TransactionTypeId\",\"\",1],[\"TransactionDate\",\"\",\"2025-07-06 00:00:00\"],[\"InvoiceNo\",\"\",\"23\"],[\"CoverFilePages\",\"\",4],[\"ManyImgPrefix\",\"\",\"1751822985938\"],[\"UserId\",\"\",1],[\"StatusId\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-06 23:29:57\"],[\"CreateTs\",\"\",\"2025-07-06 23:29:57\"]]', 'INSERT INTO t_transaction (ClientId,TransactionTypeId,TransactionDate,InvoiceNo,CoverFilePages,CoverFileUrl,UserId,StatusId,ManyImgPrefix) values (:ClientId,:TransactionTypeId,:TransactionDate,:InvoiceNo,:CoverFilePages,:CoverFileUrl,:UserId,:StatusId,:ManyImgPrefix)', '{\"values\":{\"ClientId\":\"1\",\"TransactionTypeId\":1,\"TransactionDate\":\"2025-07-06\",\"InvoiceNo\":\"23\",\"CoverFilePages\":\"4\",\"CoverFileUrl\":null,\"UserId\":\"1\",\"StatusId\":1,\"ManyImgPrefix\":1751822985938}}'),
(82, '2025-07-06 23:30:49', '127.0.0.1', 1, 'DELETE', 't_transaction', '[[\"TransactionId\",16,\"\"],[\"ClientId\",1,\"\"],[\"TransactionTypeId\",1,\"\"],[\"TransactionDate\",\"2025-07-06 00:00:00\",\"\"],[\"InvoiceNo\",\"23\",\"\"],[\"CoverFilePages\",4,\"\"],[\"CoverFileUrl\",null,\"\"],[\"ManyImgPrefix\",\"1751822985938\",\"\"],[\"UserId\",1,\"\"],[\"StatusId\",1,\"\"],[\"UpdateTs\",\"2025-07-06 23:29:57\",\"\"],[\"CreateTs\",\"2025-07-06 23:29:57\",\"\"]]', 'DELETE FROM t_transaction  WHERE TransactionId = :TransactionId', '{\"values\":{\"TransactionId\":16}}'),
(83, '2025-07-06 23:34:00', '127.0.0.1', 1, 'UPDATE', 't_transaction', '[[\"InvoiceNo\",\"555\",\"4343\"],[\"CoverFilePages\",3,312],[\"UpdateTs\",\"2025-07-05 00:33:32\",\"2025-07-06 23:34:00\"]]', 'UPDATE t_transaction SET TransactionDate = :TransactionDate, InvoiceNo = :InvoiceNo, CoverFilePages = :CoverFilePages, CoverFileUrl = :CoverFileUrl, StatusId = :StatusId  WHERE TransactionId = :TransactionId', '{\"values\":{\"TransactionDate\":\"2025-07-05\",\"InvoiceNo\":\"4343\",\"CoverFilePages\":\"312\",\"CoverFileUrl\":null,\"StatusId\":1,\"TransactionId\":12}}'),
(84, '2025-07-06 23:34:45', '127.0.0.1', 1, 'UPDATE', 't_transaction', '[[\"TransactionDate\",\"2025-07-05 00:00:00\",\"2025-07-01 00:00:00\"],[\"UpdateTs\",\"2025-07-06 23:34:00\",\"2025-07-06 23:34:45\"]]', 'UPDATE t_transaction SET TransactionDate = :TransactionDate, InvoiceNo = :InvoiceNo, CoverFilePages = :CoverFilePages, CoverFileUrl = :CoverFileUrl, StatusId = :StatusId  WHERE TransactionId = :TransactionId', '{\"values\":{\"TransactionDate\":\"2025-07-01\",\"InvoiceNo\":\"4343\",\"CoverFilePages\":312,\"CoverFileUrl\":null,\"StatusId\":1,\"TransactionId\":12}}'),
(85, '2025-07-07 00:06:55', '127.0.0.1', 1, 'UPDATE', 't_transaction', '[[\"TransactionDate\",\"2025-06-04 18:53:25\",\"2025-06-04 00:00:00\"],[\"UpdateTs\",\"2025-07-05 00:33:12\",\"2025-07-07 00:06:55\"]]', 'UPDATE t_transaction SET TransactionDate = :TransactionDate, InvoiceNo = :InvoiceNo, CoverFilePages = :CoverFilePages, CoverFileUrl = :CoverFileUrl, StatusId = :StatusId  WHERE TransactionId = :TransactionId', '{\"values\":{\"TransactionDate\":\"2025-06-04\",\"InvoiceNo\":\"INS-421274\",\"CoverFilePages\":6,\"CoverFileUrl\":null,\"StatusId\":5,\"TransactionId\":2}}');
INSERT INTO `t_sqllog` (`LogId`, `LogDate`, `RemoteIP`, `UserId`, `QueryType`, `TableName`, `JsonText`, `SqlText`, `SqlParams`) VALUES
(86, '2025-07-07 00:13:31', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",28],[\"TransactionId\",\"\",15],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-onethird\"],[\"PhotoUrl\",\"\",\"1751654068715_2025_07_07_00_13_31__4840.png\"],[\"SortOrder\",\"\",3],[\"UpdateTs\",\"\",\"2025-07-07 00:13:31\"],[\"CreateTs\",\"\",\"2025-07-07 00:13:31\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":15,\"CheckId\":null,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"1751654068715_2025_07_07_00_13_31__4840.png\",\"SortOrder\":3}}'),
(87, '2025-07-07 00:16:23', '127.0.0.1', 1, 'INSERT', 't_transaction', '[[\"TransactionId\",\"\",17],[\"ClientId\",\"\",1],[\"TransactionTypeId\",\"\",1],[\"TransactionDate\",\"\",\"2025-07-06 00:00:00\"],[\"InvoiceNo\",\"\",\"A01\"],[\"CoverFilePages\",\"\",3],[\"ManyImgPrefix\",\"\",\"1751825769466\"],[\"UserId\",\"\",1],[\"StatusId\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-07 00:16:23\"],[\"CreateTs\",\"\",\"2025-07-07 00:16:23\"]]', 'INSERT INTO t_transaction (ClientId,TransactionTypeId,TransactionDate,InvoiceNo,CoverFilePages,CoverFileUrl,UserId,StatusId,ManyImgPrefix) values (:ClientId,:TransactionTypeId,:TransactionDate,:InvoiceNo,:CoverFilePages,:CoverFileUrl,:UserId,:StatusId,:ManyImgPrefix)', '{\"values\":{\"ClientId\":\"1\",\"TransactionTypeId\":1,\"TransactionDate\":\"2025-07-06\",\"InvoiceNo\":\"A01\",\"CoverFilePages\":\"3\",\"CoverFileUrl\":null,\"UserId\":\"1\",\"StatusId\":1,\"ManyImgPrefix\":1751825769466}}'),
(88, '2025-07-07 00:17:12', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",29],[\"TransactionId\",\"\",17],[\"CheckId\",\"\",1],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-half\"],[\"PhotoUrl\",\"\",\"1751825769466_2025_07_07_00_17_11__4277.jpeg\"],[\"SortOrder\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-07 00:17:12\"],[\"CreateTs\",\"\",\"2025-07-07 00:17:12\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":17,\"CheckId\":1,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-half\",\"PhotoUrl\":\"1751825769466_2025_07_07_00_17_11__4277.jpeg\",\"SortOrder\":1}}'),
(89, '2025-07-07 00:17:12', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",30],[\"TransactionId\",\"\",17],[\"CheckId\",\"\",8],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-onethird\"],[\"PhotoUrl\",\"\",\"1751825769466_2025_07_07_00_17_12__146.jpeg\"],[\"SortOrder\",\"\",2],[\"UpdateTs\",\"\",\"2025-07-07 00:17:12\"],[\"CreateTs\",\"\",\"2025-07-07 00:17:12\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":17,\"CheckId\":8,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"1751825769466_2025_07_07_00_17_12__146.jpeg\",\"SortOrder\":2}}'),
(90, '2025-07-07 00:18:07', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",31],[\"TransactionId\",\"\",17],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-onethird\"],[\"PhotoUrl\",\"\",\"placeholder.jpg\"],[\"SortOrder\",\"\",3],[\"UpdateTs\",\"\",\"2025-07-07 00:18:07\"],[\"CreateTs\",\"\",\"2025-07-07 00:18:07\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":17,\"CheckId\":null,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"placeholder.jpg\",\"SortOrder\":3}}'),
(91, '2025-07-07 00:18:20', '127.0.0.1', 1, 'UPDATE', 't_transaction_items', '[[\"CheckId\",null,5],[\"PhotoUrl\",\"placeholder.jpg\",\"1751825769466_2025_07_07_00_18_20__7545.png\"],[\"UpdateTs\",\"2025-07-07 00:18:07\",\"2025-07-07 00:18:20\"]]', 'UPDATE t_transaction_items SET CheckId = :CheckId, RowNo = :RowNo, ColumnNo = :ColumnNo, PhotoUrl = :PhotoUrl, SortOrder = :SortOrder  WHERE TransactionItemId = :TransactionItemId', '{\"values\":{\"CheckId\":5,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"1751825769466_2025_07_07_00_18_20__7545.png\",\"SortOrder\":3,\"TransactionItemId\":31}}'),
(92, '2025-07-07 21:12:09', '127.0.0.1', 1, 'UPDATE', 't_transaction_items', '[[\"RowNo\",\"reportcheckblock-width-half\",\"reportcheckblock-width-full\"],[\"ColumnNo\",\"reportcheckblock-height-onethird\",\"reportcheckblock-height-full\"],[\"PhotoUrl\",\"placeholder.jpg\",\"789_2025_07_07_21_12_09__7546.png\"],[\"UpdateTs\",\"2025-07-03 23:23:57\",\"2025-07-07 21:12:09\"]]', 'UPDATE t_transaction_items SET CheckId = :CheckId, RowNo = :RowNo, ColumnNo = :ColumnNo, PhotoUrl = :PhotoUrl, SortOrder = :SortOrder  WHERE TransactionItemId = :TransactionItemId', '{\"values\":{\"CheckId\":null,\"RowNo\":\"reportcheckblock-width-full\",\"ColumnNo\":\"reportcheckblock-height-full\",\"PhotoUrl\":\"789_2025_07_07_21_12_09__7546.png\",\"SortOrder\":1,\"TransactionItemId\":12}}'),
(93, '2025-07-07 21:12:09', '127.0.0.1', 1, 'UPDATE', 't_transaction_items', '[[\"ColumnNo\",\"reportcheckblock-height-onethird\",\"reportcheckblock-height-half\"],[\"PhotoUrl\",\"placeholder.jpg\",\"789_2025_07_07_21_12_09__4454.png\"],[\"UpdateTs\",\"2025-07-03 23:23:57\",\"2025-07-07 21:12:09\"]]', 'UPDATE t_transaction_items SET CheckId = :CheckId, RowNo = :RowNo, ColumnNo = :ColumnNo, PhotoUrl = :PhotoUrl, SortOrder = :SortOrder  WHERE TransactionItemId = :TransactionItemId', '{\"values\":{\"CheckId\":null,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-half\",\"PhotoUrl\":\"789_2025_07_07_21_12_09__4454.png\",\"SortOrder\":2,\"TransactionItemId\":13}}'),
(94, '2025-07-07 21:12:09', '127.0.0.1', 1, 'UPDATE', 't_transaction_items', '[[\"PhotoUrl\",\"placeholder.jpg\",\"789_2025_07_07_21_12_09__7603.png\"],[\"UpdateTs\",\"2025-07-03 23:23:57\",\"2025-07-07 21:12:09\"]]', 'UPDATE t_transaction_items SET CheckId = :CheckId, RowNo = :RowNo, ColumnNo = :ColumnNo, PhotoUrl = :PhotoUrl, SortOrder = :SortOrder  WHERE TransactionItemId = :TransactionItemId', '{\"values\":{\"CheckId\":null,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"789_2025_07_07_21_12_09__7603.png\",\"SortOrder\":3,\"TransactionItemId\":14}}'),
(95, '2025-07-07 21:12:30', '127.0.0.1', 1, 'UPDATE', 't_transaction_items', '[[\"CheckId\",null,2],[\"UpdateTs\",\"2025-07-07 21:12:09\",\"2025-07-07 21:12:30\"]]', 'UPDATE t_transaction_items SET CheckId = :CheckId, RowNo = :RowNo, ColumnNo = :ColumnNo, PhotoUrl = :PhotoUrl, SortOrder = :SortOrder  WHERE TransactionItemId = :TransactionItemId', '{\"values\":{\"CheckId\":2,\"RowNo\":\"reportcheckblock-width-full\",\"ColumnNo\":\"reportcheckblock-height-full\",\"PhotoUrl\":\"789_2025_07_07_21_12_09__7546.png\",\"SortOrder\":1,\"TransactionItemId\":12}}'),
(96, '2025-07-07 21:12:30', '127.0.0.1', 1, 'UPDATE', 't_transaction_items', '[[\"CheckId\",null,7],[\"UpdateTs\",\"2025-07-07 21:12:09\",\"2025-07-07 21:12:31\"]]', 'UPDATE t_transaction_items SET CheckId = :CheckId, RowNo = :RowNo, ColumnNo = :ColumnNo, PhotoUrl = :PhotoUrl, SortOrder = :SortOrder  WHERE TransactionItemId = :TransactionItemId', '{\"values\":{\"CheckId\":7,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-half\",\"PhotoUrl\":\"789_2025_07_07_21_12_09__4454.png\",\"SortOrder\":2,\"TransactionItemId\":13}}'),
(97, '2025-07-07 21:12:30', '127.0.0.1', 1, 'UPDATE', 't_transaction_items', '[[\"CheckId\",null,5],[\"UpdateTs\",\"2025-07-07 21:12:09\",\"2025-07-07 21:12:31\"]]', 'UPDATE t_transaction_items SET CheckId = :CheckId, RowNo = :RowNo, ColumnNo = :ColumnNo, PhotoUrl = :PhotoUrl, SortOrder = :SortOrder  WHERE TransactionItemId = :TransactionItemId', '{\"values\":{\"CheckId\":5,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"789_2025_07_07_21_12_09__7603.png\",\"SortOrder\":3,\"TransactionItemId\":14}}'),
(98, '2025-07-07 21:14:31', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",32],[\"TransactionId\",\"\",8],[\"RowNo\",\"\",\"reportcheckblock-width-full\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-onethird\"],[\"PhotoUrl\",\"\",\"789_2025_07_07_21_14_31__659.png\"],[\"SortOrder\",\"\",4],[\"UpdateTs\",\"\",\"2025-07-07 21:14:31\"],[\"CreateTs\",\"\",\"2025-07-07 21:14:31\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":8,\"CheckId\":null,\"RowNo\":\"reportcheckblock-width-full\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"789_2025_07_07_21_14_31__659.png\",\"SortOrder\":4}}'),
(99, '2025-07-07 21:14:54', '127.0.0.1', 1, 'UPDATE', 't_transaction_items', '[[\"CheckId\",null,4],[\"UpdateTs\",\"2025-07-07 21:14:31\",\"2025-07-07 21:14:54\"]]', 'UPDATE t_transaction_items SET CheckId = :CheckId, RowNo = :RowNo, ColumnNo = :ColumnNo, PhotoUrl = :PhotoUrl, SortOrder = :SortOrder  WHERE TransactionItemId = :TransactionItemId', '{\"values\":{\"CheckId\":4,\"RowNo\":\"reportcheckblock-width-full\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"789_2025_07_07_21_14_31__659.png\",\"SortOrder\":4,\"TransactionItemId\":32}}'),
(100, '2025-07-07 21:15:02', '127.0.0.1', 1, 'UPDATE', 't_transaction_items', '[[\"CheckId\",8,null],[\"UpdateTs\",\"2025-07-07 00:17:12\",\"2025-07-07 21:15:02\"]]', 'UPDATE t_transaction_items SET CheckId = :CheckId, RowNo = :RowNo, ColumnNo = :ColumnNo, PhotoUrl = :PhotoUrl, SortOrder = :SortOrder  WHERE TransactionItemId = :TransactionItemId', '{\"values\":{\"CheckId\":null,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"1751825769466_2025_07_07_00_17_12__146.jpeg\",\"SortOrder\":2,\"TransactionItemId\":30}}'),
(101, '2025-07-07 22:54:40', '127.0.0.1', 1, 'DELETE', 't_transaction_items', '[[\"TransactionItemId\",30,\"\"],[\"TransactionId\",17,\"\"],[\"CheckId\",null,\"\"],[\"RowNo\",\"reportcheckblock-width-half\",\"\"],[\"ColumnNo\",\"reportcheckblock-height-onethird\",\"\"],[\"PhotoUrl\",\"1751825769466_2025_07_07_00_17_12__146.jpeg\",\"\"],[\"SortOrder\",2,\"\"],[\"UpdateTs\",\"2025-07-07 21:15:02\",\"\"],[\"CreateTs\",\"2025-07-07 00:17:12\",\"\"]]', 'DELETE FROM t_transaction_items  WHERE TransactionItemId = :TransactionItemId', '{\"values\":{\"TransactionItemId\":30}}'),
(102, '2025-07-07 23:24:41', '127.0.0.1', 1, 'UPDATE', 't_transaction_items', '[[\"RowNo\",\"reportcheckblock-width-half\",\"reportcheckblock-width-full\"],[\"ColumnNo\",\"reportcheckblock-height-half\",\"reportcheckblock-height-full\"],[\"UpdateTs\",\"2025-07-07 00:17:12\",\"2025-07-07 23:24:41\"]]', 'UPDATE t_transaction_items SET CheckId = :CheckId, RowNo = :RowNo, ColumnNo = :ColumnNo, PhotoUrl = :PhotoUrl, SortOrder = :SortOrder  WHERE TransactionItemId = :TransactionItemId', '{\"values\":{\"CheckId\":1,\"RowNo\":\"reportcheckblock-width-full\",\"ColumnNo\":\"reportcheckblock-height-full\",\"PhotoUrl\":\"1751825769466_2025_07_07_00_17_11__4277.jpeg\",\"SortOrder\":1,\"TransactionItemId\":29}}'),
(103, '2025-07-07 23:24:52', '127.0.0.1', 1, 'UPDATE', 't_transaction_items', '[[\"ColumnNo\",\"reportcheckblock-height-full\",\"reportcheckblock-height-half\"],[\"UpdateTs\",\"2025-07-07 23:24:41\",\"2025-07-07 23:24:52\"]]', 'UPDATE t_transaction_items SET CheckId = :CheckId, RowNo = :RowNo, ColumnNo = :ColumnNo, PhotoUrl = :PhotoUrl, SortOrder = :SortOrder  WHERE TransactionItemId = :TransactionItemId', '{\"values\":{\"CheckId\":1,\"RowNo\":\"reportcheckblock-width-full\",\"ColumnNo\":\"reportcheckblock-height-half\",\"PhotoUrl\":\"1751825769466_2025_07_07_00_17_11__4277.jpeg\",\"SortOrder\":1,\"TransactionItemId\":29}}'),
(104, '2025-07-07 23:24:52', '127.0.0.1', 1, 'UPDATE', 't_transaction_items', '[[\"ColumnNo\",\"reportcheckblock-height-onethird\",\"reportcheckblock-height-full\"],[\"UpdateTs\",\"2025-07-07 00:18:20\",\"2025-07-07 23:24:52\"]]', 'UPDATE t_transaction_items SET CheckId = :CheckId, RowNo = :RowNo, ColumnNo = :ColumnNo, PhotoUrl = :PhotoUrl, SortOrder = :SortOrder  WHERE TransactionItemId = :TransactionItemId', '{\"values\":{\"CheckId\":5,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-full\",\"PhotoUrl\":\"1751825769466_2025_07_07_00_18_20__7545.png\",\"SortOrder\":3,\"TransactionItemId\":31}}'),
(105, '2025-07-08 23:00:53', '127.0.0.1', 1, 'INSERT', 't_role_menu_map', '[[\"RoleMenuId\",\"\",399],[\"ClientId\",\"\",1],[\"BranchId\",\"\",1],[\"RoleId\",\"\",1],[\"MenuId\",\"\",135],[\"PermissionType\",\"\",1],[\"CreateTs\",\"\",\"2025-07-08 23:00:53\"]]', 'INSERT INTO t_role_menu_map (ClientId,BranchId,RoleId,MenuId,PermissionType) values (:ClientId,:BranchId,:RoleId,:MenuId,:PermissionType)', '{\"values\":{\"ClientId\":\"1\",\"BranchId\":\"1\",\"RoleId\":\"1\",\"MenuId\":135,\"PermissionType\":1}}'),
(106, '2025-07-08 23:00:53', '127.0.0.1', 1, 'UPDATE', 't_role_menu_map', '[[\"PermissionType\",1,2]]', 'UPDATE t_role_menu_map SET PermissionType = :PermissionType  WHERE RoleMenuId = :RoleMenuId', '{\"values\":{\"PermissionType\":2,\"RoleMenuId\":399}}'),
(107, '2025-07-08 23:06:33', '127.0.0.1', 1, 'INSERT', 't_checklist', '[[\"CheckId\",\"\",9],[\"CheckName\",\"\",\"ffffff\"],[\"CreateTs\",\"\",\"2025-07-08 23:06:33\"]]', 'INSERT INTO t_checklist (CheckName) values (:CheckName)', '{\"values\":{\"CheckName\":\"ffffff\"}}'),
(108, '2025-07-08 23:06:37', '127.0.0.1', 1, 'UPDATE', 't_checklist', '[[\"CheckName\",\"ffffff\",\"ffffffs\"]]', 'UPDATE t_checklist SET CheckName = :CheckName  WHERE CheckId = :CheckId', '{\"values\":{\"CheckName\":\"ffffffs\",\"CheckId\":9}}'),
(109, '2025-07-08 23:06:41', '127.0.0.1', 1, 'DELETE', 't_checklist', '[[\"CheckId\",9,\"\"],[\"CheckName\",\"ffffffs\",\"\"],[\"CreateTs\",\"2025-07-08 23:06:33\",\"\"],[\"UpdateTs\",null,\"\"]]', 'DELETE FROM t_checklist  WHERE CheckId = :CheckId', '{\"values\":{\"CheckId\":9}}'),
(110, '2025-07-08 23:07:43', '127.0.0.1', 1, 'INSERT', 't_transaction', '[[\"TransactionId\",\"\",18],[\"ClientId\",\"\",1],[\"TransactionTypeId\",\"\",1],[\"TransactionDate\",\"\",\"2025-07-08 00:00:00\"],[\"InvoiceNo\",\"\",\"B12\"],[\"CoverFilePages\",\"\",5],[\"ManyImgPrefix\",\"\",\"1751994414177\"],[\"UserId\",\"\",1],[\"StatusId\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-08 23:07:43\"],[\"CreateTs\",\"\",\"2025-07-08 23:07:43\"]]', 'INSERT INTO t_transaction (ClientId,TransactionTypeId,TransactionDate,InvoiceNo,CoverFilePages,CoverFileUrl,UserId,StatusId,ManyImgPrefix) values (:ClientId,:TransactionTypeId,:TransactionDate,:InvoiceNo,:CoverFilePages,:CoverFileUrl,:UserId,:StatusId,:ManyImgPrefix)', '{\"values\":{\"ClientId\":\"1\",\"TransactionTypeId\":1,\"TransactionDate\":\"2025-07-08\",\"InvoiceNo\":\"B12\",\"CoverFilePages\":\"5\",\"CoverFileUrl\":null,\"UserId\":\"1\",\"StatusId\":1,\"ManyImgPrefix\":1751994414177}}'),
(111, '2025-07-08 23:08:24', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",33],[\"TransactionId\",\"\",18],[\"CheckId\",\"\",5],[\"RowNo\",\"\",\"reportcheckblock-width-full\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-onethird\"],[\"PhotoUrl\",\"\",\"1751994414177_2025_07_08_23_08_24__8601.jpeg\"],[\"SortOrder\",\"\",1],[\"UpdateTs\",\"\",\"2025-07-08 23:08:24\"],[\"CreateTs\",\"\",\"2025-07-08 23:08:24\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":18,\"CheckId\":5,\"RowNo\":\"reportcheckblock-width-full\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"1751994414177_2025_07_08_23_08_24__8601.jpeg\",\"SortOrder\":1}}'),
(112, '2025-07-08 23:08:24', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",34],[\"TransactionId\",\"\",18],[\"CheckId\",\"\",3],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-onethird\"],[\"PhotoUrl\",\"\",\"1751994414177_2025_07_08_23_08_24__5174.jpeg\"],[\"SortOrder\",\"\",2],[\"UpdateTs\",\"\",\"2025-07-08 23:08:24\"],[\"CreateTs\",\"\",\"2025-07-08 23:08:24\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":18,\"CheckId\":3,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"1751994414177_2025_07_08_23_08_24__5174.jpeg\",\"SortOrder\":2}}'),
(113, '2025-07-08 23:08:24', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",35],[\"TransactionId\",\"\",18],[\"CheckId\",\"\",8],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-onethird\"],[\"PhotoUrl\",\"\",\"1751994414177_2025_07_08_23_08_24__7446.jpeg\"],[\"SortOrder\",\"\",3],[\"UpdateTs\",\"\",\"2025-07-08 23:08:24\"],[\"CreateTs\",\"\",\"2025-07-08 23:08:24\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":18,\"CheckId\":8,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-onethird\",\"PhotoUrl\":\"1751994414177_2025_07_08_23_08_24__7446.jpeg\",\"SortOrder\":3}}'),
(114, '2025-07-09 00:01:51', '127.0.0.1', 1, 'UPDATE', 't_transaction', '[[\"CoverFileUrl\",null,\"1751994414177_2025_07_09_00_01_51__4350.pdf\"],[\"UpdateTs\",\"2025-07-08 23:07:43\",\"2025-07-09 00:01:51\"]]', 'UPDATE t_transaction SET TransactionDate = :TransactionDate, InvoiceNo = :InvoiceNo, CoverFilePages = :CoverFilePages, CoverFileUrl = :CoverFileUrl, StatusId = :StatusId  WHERE TransactionId = :TransactionId', '{\"values\":{\"TransactionDate\":\"2025-07-08\",\"InvoiceNo\":\"B12\",\"CoverFilePages\":5,\"CoverFileUrl\":\"1751994414177_2025_07_09_00_01_51__4350.pdf\",\"StatusId\":1,\"TransactionId\":18}}'),
(115, '2025-07-09 00:03:23', '127.0.0.1', 1, 'UPDATE', 't_transaction', '[[\"CoverFileUrl\",\"1751994414177_2025_07_09_00_01_51__4350.pdf\",\"1751994414177_2025_07_09_00_03_23__3790.pdf\"],[\"UpdateTs\",\"2025-07-09 00:01:51\",\"2025-07-09 00:03:23\"]]', 'UPDATE t_transaction SET TransactionDate = :TransactionDate, InvoiceNo = :InvoiceNo, CoverFilePages = :CoverFilePages, CoverFileUrl = :CoverFileUrl, StatusId = :StatusId  WHERE TransactionId = :TransactionId', '{\"values\":{\"TransactionDate\":\"2025-07-08\",\"InvoiceNo\":\"B12\",\"CoverFilePages\":5,\"CoverFileUrl\":\"1751994414177_2025_07_09_00_03_23__3790.pdf\",\"StatusId\":1,\"TransactionId\":18}}'),
(116, '2025-07-09 20:44:52', '127.0.0.1', 1, 'INSERT', 't_transaction_items', '[[\"TransactionItemId\",\"\",36],[\"TransactionId\",\"\",18],[\"RowNo\",\"\",\"reportcheckblock-width-half\"],[\"ColumnNo\",\"\",\"reportcheckblock-height-full\"],[\"PhotoUrl\",\"\",\"1751994414177_2025_07_09_20_44_52__5404.jpeg\"],[\"SortOrder\",\"\",4],[\"UpdateTs\",\"\",\"2025-07-09 20:44:52\"],[\"CreateTs\",\"\",\"2025-07-09 20:44:52\"]]', 'INSERT INTO t_transaction_items (TransactionId,CheckId,RowNo,ColumnNo,PhotoUrl,SortOrder) values (:TransactionId,:CheckId,:RowNo,:ColumnNo,:PhotoUrl,:SortOrder)', '{\"values\":{\"TransactionId\":18,\"CheckId\":null,\"RowNo\":\"reportcheckblock-width-half\",\"ColumnNo\":\"reportcheckblock-height-full\",\"PhotoUrl\":\"1751994414177_2025_07_09_20_44_52__5404.jpeg\",\"SortOrder\":4}}'),
(117, '2025-07-09 20:45:10', '127.0.0.1', 1, 'UPDATE', 't_transaction', '[[\"CoverFileUrl\",\"1751994414177_2025_07_09_00_03_23__3790.pdf\",\"1751994414177_2025_07_09_20_45_10__7093.pdf\"],[\"UpdateTs\",\"2025-07-09 00:03:23\",\"2025-07-09 20:45:10\"]]', 'UPDATE t_transaction SET TransactionDate = :TransactionDate, InvoiceNo = :InvoiceNo, CoverFilePages = :CoverFilePages, CoverFileUrl = :CoverFileUrl, StatusId = :StatusId  WHERE TransactionId = :TransactionId', '{\"values\":{\"TransactionDate\":\"2025-07-08\",\"InvoiceNo\":\"B12\",\"CoverFilePages\":5,\"CoverFileUrl\":\"1751994414177_2025_07_09_20_45_10__7093.pdf\",\"StatusId\":1,\"TransactionId\":18}}'),
(118, '2025-07-09 20:52:46', '127.0.0.1', 1, 'UPDATE', 't_transaction', '[[\"CoverFileUrl\",\"1751994414177_2025_07_09_20_45_10__7093.pdf\",\"1751994414177_2025_07_09_20_52_46__952.pdf\"],[\"UpdateTs\",\"2025-07-09 20:45:10\",\"2025-07-09 20:52:46\"]]', 'UPDATE t_transaction SET TransactionDate = :TransactionDate, InvoiceNo = :InvoiceNo, CoverFilePages = :CoverFilePages, CoverFileUrl = :CoverFileUrl, StatusId = :StatusId  WHERE TransactionId = :TransactionId', '{\"values\":{\"TransactionDate\":\"2025-07-08\",\"InvoiceNo\":\"B12\",\"CoverFilePages\":5,\"CoverFileUrl\":\"1751994414177_2025_07_09_20_52_46__952.pdf\",\"StatusId\":1,\"TransactionId\":18}}');

-- --------------------------------------------------------

--
-- Table structure for table `t_status`
--

CREATE TABLE `t_status` (
  `StatusId` smallint(3) NOT NULL,
  `StatusName` varchar(50) NOT NULL,
  `CreateTs` timestamp NULL DEFAULT NULL,
  `UpdateTs` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_status`
--

INSERT INTO `t_status` (`StatusId`, `StatusName`, `CreateTs`, `UpdateTs`) VALUES
(1, 'Draft', '2024-08-09 18:14:16', '2024-08-09 18:14:16'),
(5, 'Post', '2024-08-09 18:14:16', '2024-08-09 18:14:16');

-- --------------------------------------------------------

--
-- Table structure for table `t_team`
--

CREATE TABLE `t_team` (
  `TeamId` smallint(3) NOT NULL,
  `TeamName` varchar(50) NOT NULL,
  `CreateTs` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdateTs` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_team`
--

INSERT INTO `t_team` (`TeamId`, `TeamName`, `CreateTs`, `UpdateTs`) VALUES
(1, '[NA]', '2024-08-09 12:14:16', '2024-08-09 12:14:16'),
(2, 'Team 1', '2024-08-09 12:14:16', '2024-08-09 12:14:16'),
(3, 'Team 2', '2024-08-09 12:14:16', '2024-08-09 12:14:16');

-- --------------------------------------------------------

--
-- Table structure for table `t_transaction`
--

CREATE TABLE `t_transaction` (
  `TransactionId` int(11) NOT NULL,
  `ClientId` smallint(6) NOT NULL,
  `TransactionTypeId` smallint(3) NOT NULL,
  `TransactionDate` datetime NOT NULL,
  `InvoiceNo` varchar(20) NOT NULL,
  `CoverFilePages` smallint(3) NOT NULL DEFAULT 1,
  `CoverFileUrl` varchar(200) DEFAULT NULL,
  `ManyImgPrefix` varchar(50) DEFAULT NULL,
  `UserId` int(11) NOT NULL COMMENT 'Entry By',
  `StatusId` smallint(3) NOT NULL,
  `UpdateTs` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CreateTs` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_transaction`
--

INSERT INTO `t_transaction` (`TransactionId`, `ClientId`, `TransactionTypeId`, `TransactionDate`, `InvoiceNo`, `CoverFilePages`, `CoverFileUrl`, `ManyImgPrefix`, `UserId`, `StatusId`, `UpdateTs`, `CreateTs`) VALUES
(1, 1, 1, '2025-07-03 00:00:00', 'INS-421186', 3, 'd', '123', 1, 1, '2025-07-08 17:15:40', '2025-06-04 16:55:25'),
(2, 1, 1, '2025-06-04 00:00:00', 'INS-421274', 6, NULL, '456', 1, 5, '2025-07-06 18:06:55', '2025-06-04 16:55:47'),
(8, 1, 1, '2025-07-03 00:00:00', '3', 4, NULL, '789', 1, 1, '2025-07-04 18:33:16', '2025-07-03 17:23:57'),
(9, 1, 1, '2025-07-03 00:00:00', '2', 3, NULL, '321', 1, 1, '2025-07-04 18:33:21', '2025-07-03 17:28:56'),
(11, 1, 1, '2025-07-03 00:00:00', '6', 7, NULL, '654', 1, 1, '2025-07-04 18:33:26', '2025-07-03 17:41:45'),
(12, 1, 1, '2025-07-01 00:00:00', '4343', 312, NULL, '987', 1, 1, '2025-07-06 17:34:45', '2025-07-04 18:18:37'),
(14, 1, 1, '2025-07-05 00:00:00', '88', 7, NULL, '222', 1, 1, '2025-07-04 18:33:40', '2025-07-04 18:21:48'),
(15, 1, 1, '2025-07-05 00:00:00', '63', 2, NULL, '1751654068715', 1, 1, '2025-07-04 18:34:52', '2025-07-04 18:34:52'),
(17, 1, 1, '2025-07-06 00:00:00', 'A01', 3, NULL, '1751825769466', 1, 1, '2025-07-06 18:16:23', '2025-07-06 18:16:23'),
(18, 1, 1, '2025-07-08 00:00:00', 'B12', 5, '1751994414177_2025_07_09_20_52_46__952.pdf', '1751994414177', 1, 1, '2025-07-09 14:52:46', '2025-07-08 17:07:43');

-- --------------------------------------------------------

--
-- Table structure for table `t_transaction_items`
--

CREATE TABLE `t_transaction_items` (
  `TransactionItemId` int(11) NOT NULL,
  `TransactionId` int(11) NOT NULL,
  `CheckId` smallint(3) DEFAULT NULL,
  `RowNo` varchar(100) DEFAULT NULL COMMENT 'Row width css=reportcheckblock-width-half,reportcheckblock-width-full',
  `ColumnNo` varchar(100) DEFAULT NULL COMMENT 'Column width css=reportcheckblock-height-onethird,reportcheckblock-height-half,reportcheckblock-height-full',
  `PhotoUrl` varchar(200) NOT NULL,
  `SortOrder` smallint(3) NOT NULL COMMENT 'Report image sort order',
  `UpdateTs` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CreateTs` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_transaction_items`
--

INSERT INTO `t_transaction_items` (`TransactionItemId`, `TransactionId`, `CheckId`, `RowNo`, `ColumnNo`, `PhotoUrl`, `SortOrder`, `UpdateTs`, `CreateTs`) VALUES
(1, 1, 1, 'reportcheckblock-width-half', 'reportcheckblock-height-onethird', 'Weightcheck.jpg', 1, '2025-06-24 16:45:39', '2025-06-04 16:57:25'),
(2, 1, 2, 'reportcheckblock-width-half', 'reportcheckblock-height-onethird', 'Picture1.jpg', 2, '2025-06-24 16:54:14', '2025-06-04 16:57:25'),
(3, 1, 3, 'reportcheckblock-width-half', 'reportcheckblock-height-onethird', 'Weightcheck.jpg', 3, '2025-06-24 16:45:51', '2025-06-04 16:57:25'),
(4, 1, 4, 'reportcheckblock-width-half', 'reportcheckblock-height-onethird', 'Picture2.jpg', 4, '2025-06-24 16:45:51', '2025-06-04 16:57:25'),
(5, 2, 2, 'reportcheckblock-width-half', 'reportcheckblock-height-onethird', 'Picture3.jpg', 1, '2025-06-24 16:45:51', '2025-06-04 16:57:25'),
(12, 8, 2, 'reportcheckblock-width-full', 'reportcheckblock-height-full', '789_2025_07_07_21_12_09__7546.png', 1, '2025-07-07 15:12:30', '2025-07-03 17:23:57'),
(13, 8, 7, 'reportcheckblock-width-half', 'reportcheckblock-height-half', '789_2025_07_07_21_12_09__4454.png', 2, '2025-07-07 15:12:31', '2025-07-03 17:23:57'),
(14, 8, 5, 'reportcheckblock-width-half', 'reportcheckblock-height-onethird', '789_2025_07_07_21_12_09__7603.png', 3, '2025-07-07 15:12:31', '2025-07-03 17:23:57'),
(15, 9, 4, 'reportcheckblock-width-half', 'reportcheckblock-height-onethird', '2025_07_05_00_00_41_6620.png', 1, '2025-07-04 18:01:23', '2025-07-03 17:28:56'),
(16, 9, 8, 'reportcheckblock-width-half', 'reportcheckblock-height-full', '2025_07_05_00_00_41_2268.png', 2, '2025-07-04 18:15:36', '2025-07-03 17:28:56'),
(19, 11, NULL, 'reportcheckblock-width-half', 'reportcheckblock-height-onethird', '1751564492751_a10.png', 1, '2025-07-03 17:41:45', '2025-07-03 17:41:45'),
(20, 11, NULL, 'reportcheckblock-width-half', 'reportcheckblock-height-onethird', '1751564498686_shared image.jpg', 2, '2025-07-03 17:41:45', '2025-07-03 17:41:45'),
(22, 9, 2, 'reportcheckblock-width-half', 'reportcheckblock-height-onethird', '2025_07_05_00_15_36_8118.png', 3, '2025-07-04 18:15:36', '2025-07-04 18:15:36'),
(23, 12, 3, 'reportcheckblock-width-half', 'reportcheckblock-height-onethird', '987_2025_07_05_12_05_17__1462.jpeg', 1, '2025-07-05 06:05:17', '2025-07-04 18:18:37'),
(25, 14, 8, 'reportcheckblock-width-half', 'reportcheckblock-height-onethird', '2025_07_05_00_21_48_3018.png', 1, '2025-07-04 18:21:48', '2025-07-04 18:21:48'),
(26, 15, 2, 'reportcheckblock-width-half', 'reportcheckblock-height-half', '1751654068715_2025_07_05_00_34_52__2503.jpeg', 1, '2025-07-04 18:34:52', '2025-07-04 18:34:52'),
(27, 15, 3, 'reportcheckblock-width-half', 'reportcheckblock-height-full', '1751654068715_2025_07_05_00_34_52__7143.png', 2, '2025-07-04 18:34:52', '2025-07-04 18:34:52'),
(28, 15, NULL, 'reportcheckblock-width-half', 'reportcheckblock-height-onethird', '1751654068715_2025_07_07_00_13_31__4840.png', 3, '2025-07-06 18:13:31', '2025-07-06 18:13:31'),
(29, 17, 1, 'reportcheckblock-width-full', 'reportcheckblock-height-half', '1751825769466_2025_07_07_00_17_11__4277.jpeg', 1, '2025-07-07 17:24:52', '2025-07-06 18:17:12'),
(31, 17, 5, 'reportcheckblock-width-half', 'reportcheckblock-height-full', '1751825769466_2025_07_07_00_18_20__7545.png', 3, '2025-07-07 17:24:52', '2025-07-06 18:18:07'),
(32, 8, 4, 'reportcheckblock-width-full', 'reportcheckblock-height-onethird', '789_2025_07_07_21_14_31__659.png', 4, '2025-07-07 15:14:54', '2025-07-07 15:14:31'),
(33, 18, 5, 'reportcheckblock-width-full', 'reportcheckblock-height-onethird', '1751994414177_2025_07_08_23_08_24__8601.jpeg', 1, '2025-07-08 17:08:24', '2025-07-08 17:08:24'),
(34, 18, 3, 'reportcheckblock-width-half', 'reportcheckblock-height-onethird', '1751994414177_2025_07_08_23_08_24__5174.jpeg', 2, '2025-07-08 17:08:24', '2025-07-08 17:08:24'),
(35, 18, 8, 'reportcheckblock-width-half', 'reportcheckblock-height-onethird', '1751994414177_2025_07_08_23_08_24__7446.jpeg', 3, '2025-07-08 17:08:24', '2025-07-08 17:08:24'),
(36, 18, NULL, 'reportcheckblock-width-half', 'reportcheckblock-height-full', '1751994414177_2025_07_09_20_44_52__5404.jpeg', 4, '2025-07-09 14:44:52', '2025-07-09 14:44:52');

-- --------------------------------------------------------

--
-- Table structure for table `t_transaction_type`
--

CREATE TABLE `t_transaction_type` (
  `TransactionTypeId` smallint(3) NOT NULL,
  `ClientId` smallint(6) NOT NULL COMMENT 'Will not use',
  `TransactionType` varchar(50) NOT NULL,
  `IsPositive` tinyint(1) NOT NULL DEFAULT 1,
  `UpdateTs` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CreateTs` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_transaction_type`
--

INSERT INTO `t_transaction_type` (`TransactionTypeId`, `ClientId`, `TransactionType`, `IsPositive`, `UpdateTs`, `CreateTs`) VALUES
(1, 1, 'Inspection', 0, '2025-06-03 18:32:55', '2023-08-09 18:14:16');

-- --------------------------------------------------------

--
-- Table structure for table `t_users`
--

CREATE TABLE `t_users` (
  `UserId` int(11) NOT NULL,
  `ClientId` smallint(6) NOT NULL,
  `BranchId` smallint(6) NOT NULL,
  `UserCode` varchar(50) CHARACTER SET utf8 NOT NULL,
  `UserName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `LoginName` varchar(50) CHARACTER SET utf8 NOT NULL,
  `Email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `DesignationId` smallint(3) NOT NULL,
  `DepartmentId` smallint(3) NOT NULL,
  `Address` varchar(200) DEFAULT NULL,
  `TeamId` smallint(3) DEFAULT NULL,
  `LinemanUserId` int(11) DEFAULT NULL COMMENT 'This is for team leader',
  `BusinessLineId` smallint(3) DEFAULT NULL,
  `PhoneNo` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `IsActive` tinyint(1) NOT NULL DEFAULT 0,
  `PhotoUrl` varchar(200) DEFAULT NULL,
  `CreateTs` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdateTs` timestamp NULL DEFAULT NULL,
  `LinemanUserIdTxt` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_users`
--

INSERT INTO `t_users` (`UserId`, `ClientId`, `BranchId`, `UserCode`, `UserName`, `LoginName`, `Email`, `Password`, `DesignationId`, `DepartmentId`, `Address`, `TeamId`, `LinemanUserId`, `BusinessLineId`, `PhoneNo`, `IsActive`, `PhotoUrl`, `CreateTs`, `UpdateTs`, `LinemanUserIdTxt`) VALUES
(1, 1, 1, 'admin', 'Admin User', 'admin', 'admin@gmail.com', '$2y$10$gLjCIc3IjTZPr7YkYsi2Ruqo2A8gxRoC8C2DO30wula7Lbphxuaam', 1, 2, NULL, NULL, NULL, NULL, NULL, 1, 'user.jpg', '2023-08-10 00:14:16', '2024-02-04 05:23:00', NULL),
(438, 1, 1, 'admins', 'Admin User', 'admins', 'admin@gmail.com', '$2y$10$gLjCIc3IjTZPr7YkYsi2Ruqo2A8gxRoC8C2DO30wula7Lbphxuaam', 1, 2, NULL, NULL, NULL, NULL, NULL, 1, 'user.jpg', '2023-08-10 00:14:16', '2024-02-04 05:23:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `t_user_role_map`
--

CREATE TABLE `t_user_role_map` (
  `UserRoleId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `RoleId` smallint(11) NOT NULL,
  `CreateTs` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdateTs` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_user_role_map`
--

INSERT INTO `t_user_role_map` (`UserRoleId`, `UserId`, `RoleId`, `CreateTs`, `UpdateTs`) VALUES
(1, 1, 1, '2023-08-10 00:14:16', '2024-02-04 05:23:00');

-- --------------------------------------------------------

--
-- Table structure for table `t_year`
--

CREATE TABLE `t_year` (
  `YearId` int(11) NOT NULL,
  `ClientId` smallint(6) NOT NULL,
  `YearName` varchar(10) NOT NULL,
  `UpdateTs` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `CreateTs` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_year`
--

INSERT INTO `t_year` (`YearId`, `ClientId`, `YearName`, `UpdateTs`, `CreateTs`) VALUES
(1, 1, '2025', '2025-06-04 17:08:55', '2024-04-26 18:25:59'),
(2, 1, '2026', '2025-06-04 17:09:18', '2024-04-26 18:25:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_branch`
--
ALTER TABLE `t_branch`
  ADD PRIMARY KEY (`BranchId`),
  ADD UNIQUE KEY `UK_t_branch_ClientId_BranchName` (`ClientId`,`BranchName`);

--
-- Indexes for table `t_checklist`
--
ALTER TABLE `t_checklist`
  ADD PRIMARY KEY (`CheckId`),
  ADD UNIQUE KEY `UK_t_checklist_CheckName` (`CheckName`) USING BTREE;

--
-- Indexes for table `t_client`
--
ALTER TABLE `t_client`
  ADD PRIMARY KEY (`ClientId`),
  ADD UNIQUE KEY `UK_t_client_ClientName` (`ClientName`),
  ADD UNIQUE KEY `UK_t_client_ClientCode` (`ClientCode`);

--
-- Indexes for table `t_customer`
--
ALTER TABLE `t_customer`
  ADD PRIMARY KEY (`CustomerId`),
  ADD KEY `FK_t_customer_t_users` (`UserId`),
  ADD KEY `FK_t_customer_t_client` (`ClientId`);

--
-- Indexes for table `t_department`
--
ALTER TABLE `t_department`
  ADD PRIMARY KEY (`DepartmentId`),
  ADD UNIQUE KEY `UK_t_designation_Client_Designation` (`DepartmentName`) USING BTREE;

--
-- Indexes for table `t_designation`
--
ALTER TABLE `t_designation`
  ADD PRIMARY KEY (`DesignationId`),
  ADD UNIQUE KEY `UK_t_designation_Client_Designation` (`ClientId`,`DesignationName`) USING BTREE;

--
-- Indexes for table `t_errorlog`
--
ALTER TABLE `t_errorlog`
  ADD PRIMARY KEY (`LogId`),
  ADD KEY `FK_t_errorlog_t_users` (`UserId`);

--
-- Indexes for table `t_menu`
--
ALTER TABLE `t_menu`
  ADD PRIMARY KEY (`MenuId`);

--
-- Indexes for table `t_month`
--
ALTER TABLE `t_month`
  ADD PRIMARY KEY (`MonthId`),
  ADD UNIQUE KEY `UK_t_month_MonthName` (`MonthName`);

--
-- Indexes for table `t_roles`
--
ALTER TABLE `t_roles`
  ADD PRIMARY KEY (`RoleId`),
  ADD UNIQUE KEY `UK_t_roles_RoleName` (`RoleName`);

--
-- Indexes for table `t_role_menu_map`
--
ALTER TABLE `t_role_menu_map`
  ADD PRIMARY KEY (`RoleMenuId`),
  ADD UNIQUE KEY `UK_t_role_menu_map_ClientBranchRoleMenu` (`ClientId`,`BranchId`,`RoleId`,`MenuId`),
  ADD KEY `FK_t_role_menu_map_t_branch` (`BranchId`),
  ADD KEY `FK_t_role_menu_map_t_roles` (`RoleId`),
  ADD KEY `FK_t_role_menu_map_t_menu` (`MenuId`);

--
-- Indexes for table `t_sqllog`
--
ALTER TABLE `t_sqllog`
  ADD PRIMARY KEY (`LogId`),
  ADD KEY `FK_t_sqllog_t_users` (`UserId`);

--
-- Indexes for table `t_status`
--
ALTER TABLE `t_status`
  ADD PRIMARY KEY (`StatusId`),
  ADD UNIQUE KEY `UK_t_status_StatusName` (`StatusName`);

--
-- Indexes for table `t_team`
--
ALTER TABLE `t_team`
  ADD PRIMARY KEY (`TeamId`),
  ADD UNIQUE KEY `UK_t_team_TeamName` (`TeamName`) USING BTREE;

--
-- Indexes for table `t_transaction`
--
ALTER TABLE `t_transaction`
  ADD PRIMARY KEY (`TransactionId`),
  ADD KEY `FK_t_transaction_t_client` (`ClientId`),
  ADD KEY `FK_t_transaction_t_transaction_type` (`TransactionTypeId`),
  ADD KEY `FK_t_transaction_t_users` (`UserId`),
  ADD KEY `FK_t_transaction_t_status` (`StatusId`);

--
-- Indexes for table `t_transaction_items`
--
ALTER TABLE `t_transaction_items`
  ADD PRIMARY KEY (`TransactionItemId`),
  ADD KEY `FK_t_transaction_items_t_transaction` (`TransactionId`),
  ADD KEY `FK_t_transaction_items_t_checklist` (`CheckId`);

--
-- Indexes for table `t_transaction_type`
--
ALTER TABLE `t_transaction_type`
  ADD PRIMARY KEY (`TransactionTypeId`),
  ADD UNIQUE KEY `UK_t_transaction_type_ClientTransType` (`ClientId`,`TransactionType`);

--
-- Indexes for table `t_users`
--
ALTER TABLE `t_users`
  ADD PRIMARY KEY (`UserId`),
  ADD UNIQUE KEY `UK_t_users_LoginName` (`LoginName`),
  ADD KEY `FK_t_users_t_branch` (`BranchId`),
  ADD KEY `FK_t_users_t_designation` (`DesignationId`),
  ADD KEY `FK_t_users_t_client` (`ClientId`),
  ADD KEY `FK_t_users_t_department` (`DepartmentId`),
  ADD KEY `FK_t_users_t_team` (`TeamId`),
  ADD KEY `FK_t_users_t_businessline` (`BusinessLineId`);

--
-- Indexes for table `t_user_role_map`
--
ALTER TABLE `t_user_role_map`
  ADD PRIMARY KEY (`UserRoleId`),
  ADD UNIQUE KEY `UK_t_role_menu_map_UserRole` (`UserId`,`RoleId`),
  ADD KEY `FK_t_user_role_map_t_roles` (`RoleId`);

--
-- Indexes for table `t_year`
--
ALTER TABLE `t_year`
  ADD PRIMARY KEY (`YearId`),
  ADD UNIQUE KEY `UK_t_year_ClientIdYearName` (`ClientId`,`YearName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_branch`
--
ALTER TABLE `t_branch`
  MODIFY `BranchId` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_checklist`
--
ALTER TABLE `t_checklist`
  MODIFY `CheckId` smallint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `t_client`
--
ALTER TABLE `t_client`
  MODIFY `ClientId` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_customer`
--
ALTER TABLE `t_customer`
  MODIFY `CustomerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39371;

--
-- AUTO_INCREMENT for table `t_department`
--
ALTER TABLE `t_department`
  MODIFY `DepartmentId` smallint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `t_designation`
--
ALTER TABLE `t_designation`
  MODIFY `DesignationId` smallint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `t_errorlog`
--
ALTER TABLE `t_errorlog`
  MODIFY `LogId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `t_menu`
--
ALTER TABLE `t_menu`
  MODIFY `MenuId` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `t_month`
--
ALTER TABLE `t_month`
  MODIFY `MonthId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `t_roles`
--
ALTER TABLE `t_roles`
  MODIFY `RoleId` smallint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `t_role_menu_map`
--
ALTER TABLE `t_role_menu_map`
  MODIFY `RoleMenuId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=400;

--
-- AUTO_INCREMENT for table `t_sqllog`
--
ALTER TABLE `t_sqllog`
  MODIFY `LogId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `t_status`
--
ALTER TABLE `t_status`
  MODIFY `StatusId` smallint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `t_team`
--
ALTER TABLE `t_team`
  MODIFY `TeamId` smallint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t_transaction`
--
ALTER TABLE `t_transaction`
  MODIFY `TransactionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `t_transaction_items`
--
ALTER TABLE `t_transaction_items`
  MODIFY `TransactionItemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `t_transaction_type`
--
ALTER TABLE `t_transaction_type`
  MODIFY `TransactionTypeId` smallint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `t_users`
--
ALTER TABLE `t_users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=439;

--
-- AUTO_INCREMENT for table `t_user_role_map`
--
ALTER TABLE `t_user_role_map`
  MODIFY `UserRoleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=422;

--
-- AUTO_INCREMENT for table `t_year`
--
ALTER TABLE `t_year`
  MODIFY `YearId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_branch`
--
ALTER TABLE `t_branch`
  ADD CONSTRAINT `FK_t_branch_t_client` FOREIGN KEY (`ClientId`) REFERENCES `t_client` (`ClientId`);

--
-- Constraints for table `t_customer`
--
ALTER TABLE `t_customer`
  ADD CONSTRAINT `FK_t_customer_t_client` FOREIGN KEY (`ClientId`) REFERENCES `t_client` (`ClientId`),
  ADD CONSTRAINT `FK_t_customer_t_users` FOREIGN KEY (`UserId`) REFERENCES `t_users` (`UserId`);

--
-- Constraints for table `t_designation`
--
ALTER TABLE `t_designation`
  ADD CONSTRAINT `FK_t_designation_t_client` FOREIGN KEY (`ClientId`) REFERENCES `t_client` (`ClientId`);

--
-- Constraints for table `t_errorlog`
--
ALTER TABLE `t_errorlog`
  ADD CONSTRAINT `FK_t_errorlog_t_users` FOREIGN KEY (`UserId`) REFERENCES `t_users` (`UserId`);

--
-- Constraints for table `t_role_menu_map`
--
ALTER TABLE `t_role_menu_map`
  ADD CONSTRAINT `FK_t_role_menu_map_t_branch` FOREIGN KEY (`BranchId`) REFERENCES `t_branch` (`BranchId`),
  ADD CONSTRAINT `FK_t_role_menu_map_t_client` FOREIGN KEY (`ClientId`) REFERENCES `t_client` (`ClientId`),
  ADD CONSTRAINT `FK_t_role_menu_map_t_menu` FOREIGN KEY (`MenuId`) REFERENCES `t_menu` (`MenuId`),
  ADD CONSTRAINT `FK_t_role_menu_map_t_roles` FOREIGN KEY (`RoleId`) REFERENCES `t_roles` (`RoleId`);

--
-- Constraints for table `t_sqllog`
--
ALTER TABLE `t_sqllog`
  ADD CONSTRAINT `FK_t_sqllog_t_users` FOREIGN KEY (`UserId`) REFERENCES `t_users` (`UserId`);

--
-- Constraints for table `t_transaction`
--
ALTER TABLE `t_transaction`
  ADD CONSTRAINT `FK_t_transaction_t_client` FOREIGN KEY (`ClientId`) REFERENCES `t_client` (`ClientId`),
  ADD CONSTRAINT `FK_t_transaction_t_status` FOREIGN KEY (`StatusId`) REFERENCES `t_status` (`StatusId`),
  ADD CONSTRAINT `FK_t_transaction_t_transaction_type` FOREIGN KEY (`TransactionTypeId`) REFERENCES `t_transaction_type` (`TransactionTypeId`),
  ADD CONSTRAINT `FK_t_transaction_t_users` FOREIGN KEY (`UserId`) REFERENCES `t_users` (`UserId`);

--
-- Constraints for table `t_transaction_items`
--
ALTER TABLE `t_transaction_items`
  ADD CONSTRAINT `FK_t_transaction_items_t_checklist` FOREIGN KEY (`CheckId`) REFERENCES `t_checklist` (`CheckId`),
  ADD CONSTRAINT `FK_t_transaction_items_t_transaction` FOREIGN KEY (`TransactionId`) REFERENCES `t_transaction` (`TransactionId`);

--
-- Constraints for table `t_transaction_type`
--
ALTER TABLE `t_transaction_type`
  ADD CONSTRAINT `FK_t_transaction_type_t_client` FOREIGN KEY (`ClientId`) REFERENCES `t_client` (`ClientId`);

--
-- Constraints for table `t_users`
--
ALTER TABLE `t_users`
  ADD CONSTRAINT `FK_t_users_t_branch` FOREIGN KEY (`BranchId`) REFERENCES `t_branch` (`BranchId`),
  ADD CONSTRAINT `FK_t_users_t_client` FOREIGN KEY (`ClientId`) REFERENCES `t_client` (`ClientId`),
  ADD CONSTRAINT `FK_t_users_t_department` FOREIGN KEY (`DepartmentId`) REFERENCES `t_department` (`DepartmentId`),
  ADD CONSTRAINT `FK_t_users_t_designation` FOREIGN KEY (`DesignationId`) REFERENCES `t_designation` (`DesignationId`),
  ADD CONSTRAINT `FK_t_users_t_team` FOREIGN KEY (`TeamId`) REFERENCES `t_team` (`TeamId`);

--
-- Constraints for table `t_user_role_map`
--
ALTER TABLE `t_user_role_map`
  ADD CONSTRAINT `FK_t_user_role_map_t_roles` FOREIGN KEY (`RoleId`) REFERENCES `t_roles` (`RoleId`),
  ADD CONSTRAINT `FK_t_user_role_map_t_users` FOREIGN KEY (`UserId`) REFERENCES `t_users` (`UserId`);

--
-- Constraints for table `t_year`
--
ALTER TABLE `t_year`
  ADD CONSTRAINT `FK_t_year_t_client` FOREIGN KEY (`ClientId`) REFERENCES `t_client` (`ClientId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
