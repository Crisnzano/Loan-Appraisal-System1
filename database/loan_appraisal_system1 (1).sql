-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2023 at 09:44 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loan appraisal system1`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `DepositVsGoal` (IN `currentYear` INT)   BEGIN
SELECT 
    YEAR(`loans`.`application_date`) AS 'applicationYear',
    MONTHNAME(`loans`.`application_date`) AS 'applicationMonth',
    SUM(`loan_repayment`.`monthly_repayment_amount`) AS 'expenseRevenue'
FROM
    `loans`
    INNER JOIN
    `loan_repayment` ON `loan_repayment`.`planID`
WHERE
    YEAR(`loan_repayment`.`repayment_start_date`) = 2022
        AND (`loans`.`loan_status` = '0'
        OR `loans`.`loan_status` = '1')

GROUP BY MONTHNAME(`loan_repayment`.`repayment_start_date`) , YEAR(`loan_repayment`.`repayment_start_date`)
ORDER BY YEAR(`loan_repayment`.`repayment_start_date`) , MONTH(`loan_repayment`.`repayment_start_date`);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ExpectedLossPerMonth` (IN `currentYear` INT)   BEGIN
SELECT 
    YEAR(`loans`.`application_date`) AS 'paymentYear',
    MONTHNAME(`loans`.`application_date`) AS 'paymentMonth',
    SUM(`loans`.`loan_amount`) AS 'salesRevenue'
FROM
    `loans`
WHERE
    YEAR(`loans`.`application_date`) IN (currentYear , currentYear - 1)
GROUP BY MONTHNAME(`loans`.`application_date`) , YEAR(`loans`.`application_date`)
ORDER BY YEAR(`loans`.`application_date`) , MONTH(`loans`.`application_date`);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ExpectedProfitPerMonth` (IN `currentYear` INT)   BEGIN
SELECT 
    YEAR(`loan_repayment`.`repayment_start_date`) AS 'paymentYear',
    MONTHNAME(`loan_repayment`.`repayment_start_date`) AS 'paymentMonth',
    SUM(`loan_repayment`.`monthly_repayment_amount`) AS 'salesRevenue'
FROM
    `loan_repayment`
WHERE
    YEAR(`loan_repayment`.`repayment_start_date`) IN (currentYear , currentYear - 1)
GROUP BY MONTHNAME(`loan_repayment`.`repayment_start_date`) , YEAR(`loan_repayment`.`repayment_start_date`)
ORDER BY YEAR(`loan_repayment`.`repayment_start_date`) , MONTH(`loan_repayment`.`repayment_start_date`);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ExpensesVsRevenue` (IN `currentYear` INT)   BEGIN
SELECT 
    ROW_NUMBER() OVER (
          -- PARTITION BY `products`.`productLine`
          ORDER BY SUM(`loan_amount`) DESC) row_num,
    `loans`.`planID`,
    `loan_repayment`.`monthly_repayment_amount`,
    COUNT(`loans`.`planID`) AS countPlanID,
    SUM(`monthly_repayment_amount`) AS sumRepaymentAmount,
    CONCAT(
            `loans`.`loan_amount`, ": ", `loan_repayment`.`monthly_repayment_amount`) AS fullPlanDetails,
    SUM(`loan_amount`) AS sumExpenseEach
FROM
    `loans`
        INNER JOIN
    `loan_repayment` ON `loan_repayment`.`loanID` = `loans`.`loanID`
WHERE
    YEAR(`loan_repayment`.`repayment_start_date`) = currentYear
        AND (`loans`.`loan_status` = '0'
        OR `loans`.`loan_status` = '2')
GROUP BY `loans`.`loanID`
ORDER BY SUM(`loan_amount`) DESC
LIMIT 0 , 5;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `LoanPlanbyRepaymentAmount` (IN `currentYear` INT)   BEGIN
SELECT 
    ROW_NUMBER() OVER (
          -- PARTITION BY `products`.`productLine`
          ORDER BY SUM(`monthly_repayment_amount`) DESC) row_num,
    `loan_repayment`.`planID`,
    `loan_plan`.`interest_percentage`,
    `loan_plan`.`loan_tenure`,
    `loan_plan`.`penalty_rate`,
    `loan_repayment`.`monthly_repayment_amount`,
    COUNT(`loan_plan`.`planID`) AS countPlanID,
    SUM(`monthly_repayment_amount`) AS sumRepaymentAmount,
    CONCAT(
            `loan_plan`.`planID`, ": ", `loan_plan`.`interest_percentage`,": ",`loan_repayment`.`monthly_repayment_amount`) AS fullPlanDetails,
    SUM(`monthly_repayment_amount`) AS sumRepaymentEach
FROM
    `loan_plan`
        INNER JOIN
    `loan_repayment` ON `loan_repayment`.`planID` = `loan_plan`.`planID`
WHERE
    YEAR(`loan_repayment`.`repayment_start_date`) = 2022
        AND (`loan_repayment`.`penalty_amount` = '0')
    
GROUP BY `loan_plan`.`planID`
ORDER BY SUM(`monthly_repayment_amount`) DESC
LIMIT 0 , 5;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ProfitTrend` (IN `currentYear` INT)   BEGIN
SELECT 
    COUNT(`loan_repayment`.`monthly_repayment_amount`) AS 'RepaymentID',
    YEAR(`loan_repayment`.`repayment_start_date`) AS 'paymentYear',
    MONTHNAME(`loan_repayment`.`repayment_start_date`) AS 'paymentMonth',
    SUM(`loan_repayment`.`monthly_repayment_amount`) AS 'salesRevenue'
FROM
    `loan_repayment`
WHERE
    YEAR(`loan_repayment`.`repayment_start_date`) IN (currentYear)

GROUP BY MONTHNAME(`loan_repayment`.`repayment_start_date`) , YEAR(`loan_repayment`.`repayment_start_date`)
ORDER BY YEAR(`loan_repayment`.`repayment_start_date`) , MONTH(`loan_repayment`.`repayment_start_date`);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Top5LoanPlansofTheYear` (IN `currentYear` INT)   BEGIN
SELECT 
    ROW_NUMBER() OVER (
          -- PARTITION BY `products`.`productLine`
          ORDER BY SUM(`loan_amount`) DESC) row_num,
    `loans`.`planID`,
    `loan_plan`.`interest_percentage`,
    `loan_plan`.`loan_tenure`,
    `loan_plan`.`penalty_rate`,
    `loan_repayment`.`monthly_repayment_amount`,
    COUNT(`loans`.`planID`) AS countPlanID,
    SUM(`monthly_repayment_amount`) AS sumRepaymentAmount,
    CONCAT(
            `loans`.`planID`, ": ", `loan_plan`.`interest_percentage`) AS fullPlanDetails,
    SUM(`monthly_repayment_amount`) AS sumRepaymentEach
FROM
    `loans`
        INNER JOIN
    `loan_plan` ON `loans`.`planID` = `loan_plan`.`planID`
        INNER JOIN
    `loan_repayment` ON `loan_repayment`.`planID` = `loans`.`planID`
WHERE
    YEAR(`loan_repayment`.`repayment_start_date`) = currentYear
        AND (`loans`.`loan_status` = '0'
        OR `loans`.`loan_status` = '2')
GROUP BY `loans`.`loanID`
ORDER BY SUM(`loan_amount`) DESC
LIMIT 0 , 5;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `TopPerformingLoanType` (IN `currentYear` INT)   BEGIN
SELECT 
    ROW_NUMBER() OVER (
          -- PARTITION BY `products`.`productLine`
          ORDER BY SUM(`loan_typeID`) DESC) row_num,
    `loans`.`loan_status`,
    `loan_types`.`type_name`,
    `loans`.`loan_amount`,
    `loans`.`loan_type_id`,
    `loan_repayment`.`monthly_repayment_amount`,
    COUNT(`loan_types`.`loan_typeID`) AS countTypeID,
    SUM(`monthly_repayment_amount`) AS sumRepaymentAmount,
    CONCAT(
            `loans`.`loan_type_id`, ": ", `loan_types`.`type_name`) AS fullTypeDetails,
    SUM(`monthly_repayment_amount`) AS sumRepaymentEach
FROM
    `loans`
        INNER JOIN
    `loan_types` ON `loans`.`loan_type_id` = `loan_types`.`loan_typeID`
    INNER JOIN
    `loan_repayment` ON `loan_repayment`.`monthly_repayment_amount`

      
WHERE
    YEAR(`loans`.`application_date`) = currentYear
        AND (`loans`.`loan_status` = '0'
        OR `loans`.`loan_status` = '2')
GROUP BY `loans`.`loanID`
ORDER BY SUM(`loan_amount`) DESC
LIMIT 0 , 5;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `clientID` int(11) NOT NULL,
  `firstname` varchar(60) NOT NULL,
  `lastname` varchar(60) NOT NULL,
  `nationalID` int(25) NOT NULL,
  `phonenumber` int(25) NOT NULL,
  `address` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `role_ID` int(11) NOT NULL,
  `tax_id` int(50) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 2 COMMENT '2=client',
  `username` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`clientID`, `firstname`, `lastname`, `nationalID`, `phonenumber`, `address`, `email`, `password`, `role_ID`, `tax_id`, `type`, `username`) VALUES
(1, 'Peter', 'Nzano', 49091234, 741217070, 'Sabaki', 'pnzano@gmail.com', 'client123', 2, 56789065, 2, 'Peter'),
(2, 'Cris', 'Doe', 49091234, 745562346, 'Kilimani', 'chrisdoe@gmail.com', 'cris123', 2, 67834567, 2, 'Cris'),
(3, 'Will', 'Adams', 49091234, 786546766, 'Loresho', 'wadams@gmail.com', 'will123', 2, 78985697, 2, 'Will'),
(4, 'John', 'Zech', 8976556, 756875546, 'Karen', 'johnzech@gmail.com', 'john123', 2, 56988750, 2, 'John'),
(5, 'Cris', 'Nzano', 39091136, 741217070, 'Sabaki', 'crispus.nzano@gmail.com', '49d965a723be6463caac9c66e128e618', 0, 34567, 2, 'CrisNzano'),
(6, 'Yash', 'Hhhh', 45678754, 712345678, 'home', 'yashu@gmail.com', '$2y$10$yZsez0tgH1Bh9w2zXkL/veLG6DLHPjphjv1vf9B9iIV85q3HNgZdu', 0, 34567, 2, 'Yashu'),
(7, 'Test', 'User', 39961482, 734568998, 'Kenya', 'crispus.nzano@strathmore.edu', '01cfcd4f6b8770febfb40cb906715822', 0, 234567, 2, 'UserTest');

-- --------------------------------------------------------

--
-- Table structure for table `client_asset`
--

CREATE TABLE `client_asset` (
  `assetID` int(11) NOT NULL,
  `asset_name` varchar(60) NOT NULL,
  `asset_amount` int(60) NOT NULL,
  `ownership_percentage` int(60) NOT NULL,
  `owned_since` datetime(6) NOT NULL,
  `loanID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_employment`
--

CREATE TABLE `client_employment` (
  `employmentID` int(11) NOT NULL,
  `employment_type` varchar(255) NOT NULL,
  `profession_type` varchar(60) NOT NULL,
  `experience_description` varchar(255) NOT NULL,
  `experience_in_current_profession` varchar(255) NOT NULL,
  `income_per_month` int(11) NOT NULL,
  `clientID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `loanID` int(11) NOT NULL,
  `clientID` int(11) NOT NULL,
  `loan_status` tinyint(4) NOT NULL DEFAULT 2 COMMENT '0= pending, 1= accepted, 2=pending loan, 3=completed, 4=rejected',
  `application_date` datetime NOT NULL DEFAULT current_timestamp(),
  `purpose` text NOT NULL,
  `loan_amount` double NOT NULL,
  `planID` tinyint(1) NOT NULL,
  `date_released` datetime(6) NOT NULL,
  `ref_number` int(11) NOT NULL,
  `loan_type_id` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`loanID`, `clientID`, `loan_status`, `application_date`, `purpose`, `loan_amount`, `planID`, `date_released`, `ref_number`, `loan_type_id`) VALUES
(1, 1, 2, '2022-07-17 13:00:58', 'Sample Loan', 60000, 2, '0000-00-00 00:00:00.000000', 345678, 1),
(2, 2, 0, '2022-07-17 14:06:53', 'Student Loan', 30000, 2, '0000-00-00 00:00:00.000000', 875645, 3),
(3, 3, 1, '2022-07-21 15:30:54', 'Mortgage', 20000, 2, '0000-00-00 00:00:00.000000', 678987, 2),
(4, 4, 2, '2022-07-22 21:55:34', 'Personal loan', 70000, 2, '0000-00-00 00:00:00.000000', 329800, 2),
(5, 5, 2, '2022-07-22 21:58:05', 'Student loan', 65000, 2, '0000-00-00 00:00:00.000000', 549321, 1),
(6, 2, 2, '2022-07-25 10:51:50', 'Personal Loan', 75000, 2, '0000-00-00 00:00:00.000000', 183205, 2),
(7, 7, 0, '2023-11-28 23:27:46', 'Test', 345600, 2, '0000-00-00 00:00:00.000000', 59172, 2),
(8, 0, 0, '2023-11-28 23:56:57', 'Personal', 65700, 1, '0000-00-00 00:00:00.000000', 461702, 3),
(9, 0, 0, '2023-11-28 23:44:00', 'Personal', 56789, 1, '0000-00-00 00:00:00.000000', 817602, 2);

-- --------------------------------------------------------

--
-- Table structure for table `loan_plan`
--

CREATE TABLE `loan_plan` (
  `planID` int(30) NOT NULL,
  `loan_tenure` int(11) NOT NULL,
  `interest_percentage` float NOT NULL,
  `penalty_rate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loan_plan`
--

INSERT INTO `loan_plan` (`planID`, `loan_tenure`, `interest_percentage`, `penalty_rate`) VALUES
(1, 36, 8, 3),
(2, 24, 5, 2),
(3, 27, 6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `loan_repayment`
--

CREATE TABLE `loan_repayment` (
  `re_paymentID` int(11) NOT NULL,
  `monthly_repayment_amount` int(255) NOT NULL,
  `repayment_start_date` datetime NOT NULL DEFAULT current_timestamp(),
  `penalty_amount` int(255) NOT NULL,
  `roleID` int(11) NOT NULL,
  `overdue` int(11) NOT NULL DEFAULT 0 COMMENT '0= no, 1= yes',
  `payee` text NOT NULL,
  `loanID` int(11) NOT NULL,
  `defaults_number` int(11) NOT NULL,
  `planID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loan_repayment`
--

INSERT INTO `loan_repayment` (`re_paymentID`, `monthly_repayment_amount`, `repayment_start_date`, `penalty_amount`, `roleID`, `overdue`, `payee`, `loanID`, `defaults_number`, `planID`) VALUES
(3, 2000, '2022-07-22 00:59:09', 0, 2, 0, 'Will,Adams', 3, 0, 2),
(4, 3000, '2022-07-22 14:54:28', 0, 2, 0, 'Peter,Nzano', 2, 0, 2),
(5, 1500, '2022-07-22 14:57:25', 0, 2, 0, 'Cris,Doe', 1, 0, 2),
(6, 2345, '2023-11-28 23:27:46', 0, 0, 0, 'Yashu', 7, 0, 2),
(8, 3456, '2023-11-28 23:44:00', 0, 0, 0, 'TestUser', 9, 0, 0),
(12, 5678, '2023-11-28 23:56:57', 0, 0, 0, 'TestUser', 8, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `loan_schedules`
--

CREATE TABLE `loan_schedules` (
  `scheduleID` int(11) NOT NULL,
  `loan_ID` int(11) NOT NULL,
  `repayment_end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loan_schedules`
--

INSERT INTO `loan_schedules` (`scheduleID`, `loan_ID`, `repayment_end_date`) VALUES
(2, 3, '2020-10-26'),
(3, 3, '2020-11-26'),
(4, 3, '2020-12-26'),
(5, 3, '2021-01-26'),
(6, 3, '2021-02-26'),
(7, 3, '2021-03-26'),
(8, 3, '2021-04-26'),
(9, 3, '2021-05-26'),
(10, 3, '2021-06-26'),
(11, 3, '2021-07-26'),
(12, 3, '2021-08-26'),
(13, 3, '2021-09-26'),
(14, 3, '2021-10-26'),
(15, 3, '2021-11-26'),
(16, 3, '2021-12-26'),
(17, 3, '2022-01-26'),
(18, 3, '2022-02-26'),
(19, 3, '2022-03-26'),
(20, 3, '2022-04-26'),
(21, 3, '2022-05-26'),
(22, 3, '2022-06-26'),
(23, 3, '2022-07-26'),
(24, 3, '2022-08-26'),
(25, 3, '2022-09-26'),
(26, 3, '2022-10-26'),
(27, 3, '2022-11-26'),
(28, 3, '2022-12-26'),
(29, 3, '2023-01-26'),
(30, 3, '2023-02-26'),
(31, 3, '2023-03-26'),
(32, 3, '2023-04-26'),
(33, 3, '2023-05-26'),
(34, 3, '2023-06-26'),
(35, 3, '2023-07-26'),
(36, 3, '2023-08-26'),
(37, 3, '2023-09-26');

-- --------------------------------------------------------

--
-- Table structure for table `loan_types`
--

CREATE TABLE `loan_types` (
  `loan_typeID` int(11) NOT NULL,
  `type_name` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loan_types`
--

INSERT INTO `loan_types` (`loan_typeID`, `type_name`, `description`) VALUES
(1, 'Student Loan', 'Student Loan'),
(2, 'Personal Loan', 'Personal Loans'),
(3, 'Mortgage', 'Mortgage');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `roleID` int(11) NOT NULL,
  `role_name` varchar(25) NOT NULL,
  `isdeleted` datetime(6) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 3 COMMENT '1= staff, 2=client,3=manager',
  `firstname` varchar(60) NOT NULL,
  `lastname` varchar(60) NOT NULL,
  `phonenumber` int(25) NOT NULL,
  `email` varchar(60) NOT NULL,
  `address` varchar(60) NOT NULL,
  `tax_id` int(50) NOT NULL,
  `code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`roleID`, `role_name`, `isdeleted`, `username`, `password`, `type`, `firstname`, `lastname`, `phonenumber`, `email`, `address`, `tax_id`, `code`) VALUES
(1, 'staffadmin', '0000-00-00 00:00:00.000000', 'staffadmin', 'staffadmin123', 1, 'Joseph', 'Nzano', 0, '', '', 11256786, 0),
(2, 'client1', '0000-00-00 00:00:00.000000', 'Peter', 'client123', 2, 'Peter', 'Nzano', 745562346, 'pnzano@gmail.com', 'Kilimani', 39091136, 0),
(3, 'Manager1', '0000-00-00 00:00:00.000000', 'John', 'manager123', 3, 'John', '', 0, '', '', 0, 0),
(5, '', '0000-00-00 00:00:00.000000', 'AyanAhmed', 'Ayan321', 1, 'Ayan', '', 0, '', '', 0, 0),
(6, '', '0000-00-00 00:00:00.000000', 'Brian', 'brian123', 2, 'Brian', '', 722346989, 'Brian@gmail.com', 'none', 45678445, 0),
(7, '', '0000-00-00 00:00:00.000000', 'Beula', 'milk123', 3, 'Beula ', '', 0, '', '', 0, 0),
(8, '', '0000-00-00 00:00:00.000000', 'username', 'username123', 2, 'Username ', '', 787477648, 'username@gmail.com', 'none', 23326325, 0),
(9, '', '0000-00-00 00:00:00.000000', 'Muema_826', '1234', 2, 'Ian', '', 706939989, 'ian.muema@strathmore.edu', '12409-3842658', 12345678, 0),
(10, '', '0000-00-00 00:00:00.000000', 'tavaz', 'trapqueen', 2, 'Samuel', '', 795122504, 'sammymtenga88@gmail.com', 'sabaki', 39961482, 0),
(11, '', '0000-00-00 00:00:00.000000', 'Mary', 'mary123', 2, 'Mary', '', 712471007, 'mary@gmail.com', 'Parkroad', 45986546, 0),
(12, '', '0000-00-00 00:00:00.000000', 'CrisNzano', '49d965a723be6463caac9c66e128e618', 1, 'Cris', 'Nzano', 741217070, 'crispus.nzano@gmail.com', 'Sabaki', 34567, 0),
(13, '', '0000-00-00 00:00:00.000000', 'Yashu', '$2y$10$yZsez0tgH1Bh9w2zXkL/veLG6DLHPjphjv1vf9B9iIV85q3HNgZdu', 2, 'Yash', 'Hhhh', 712345678, 'yashu@gmail.com', 'home', 34567, 0),
(14, '', '0000-00-00 00:00:00.000000', 'UserTest', '01cfcd4f6b8770febfb40cb906715822', 2, 'Test', 'User', 734568998, 'crispus.nzano@strathmore.edu', 'Kenya', 234567, 0);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffID` int(11) NOT NULL,
  `firstname` varchar(60) NOT NULL,
  `lastname` varchar(60) NOT NULL,
  `nationalID` int(25) NOT NULL,
  `phonenumber` int(11) NOT NULL,
  `address` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `roleID` int(11) NOT NULL,
  `type` int(11) NOT NULL DEFAULT 1 COMMENT '1= staffadmin',
  `tax_id` int(50) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffID`, `firstname`, `lastname`, `nationalID`, `phonenumber`, `address`, `email`, `password`, `roleID`, `type`, `tax_id`, `role_name`) VALUES
(1, 'Joseph', 'Nzano', 49091234, 741217070, 'Sabaki', 'jnzano@gmail.com', 'staffadmin123', 1, 1, 11256786, 'staffadmin'),
(19, 'Charles', 'Doe', 45576565, 745562346, 'Kilimani', 'charlesdoe@gmail.com', 'Charles123', 2, 1, 6783456, 'staffadmin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`clientID`),
  ADD KEY `role_ID` (`role_ID`);

--
-- Indexes for table `client_asset`
--
ALTER TABLE `client_asset`
  ADD PRIMARY KEY (`assetID`),
  ADD KEY `loanID` (`loanID`);

--
-- Indexes for table `client_employment`
--
ALTER TABLE `client_employment`
  ADD PRIMARY KEY (`employmentID`),
  ADD KEY `clientID` (`clientID`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`loanID`),
  ADD KEY `clientID` (`clientID`);

--
-- Indexes for table `loan_plan`
--
ALTER TABLE `loan_plan`
  ADD PRIMARY KEY (`planID`);

--
-- Indexes for table `loan_repayment`
--
ALTER TABLE `loan_repayment`
  ADD PRIMARY KEY (`re_paymentID`);

--
-- Indexes for table `loan_schedules`
--
ALTER TABLE `loan_schedules`
  ADD PRIMARY KEY (`scheduleID`);

--
-- Indexes for table `loan_types`
--
ALTER TABLE `loan_types`
  ADD PRIMARY KEY (`loan_typeID`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`roleID`),
  ADD KEY `roleID` (`roleID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffID`),
  ADD UNIQUE KEY `roleID` (`roleID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `clientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `client_asset`
--
ALTER TABLE `client_asset`
  MODIFY `assetID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_employment`
--
ALTER TABLE `client_employment`
  MODIFY `employmentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `loanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `loan_plan`
--
ALTER TABLE `loan_plan`
  MODIFY `planID` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `loan_repayment`
--
ALTER TABLE `loan_repayment`
  MODIFY `re_paymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `loan_schedules`
--
ALTER TABLE `loan_schedules`
  MODIFY `scheduleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `loan_types`
--
ALTER TABLE `loan_types`
  MODIFY `loan_typeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `roleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
