-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2025 at 03:30 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `graphio_dbv2`
--

-- --------------------------------------------------------

--
-- Table structure for table `career`
--

CREATE TABLE `career` (
  `Career_ID` int(11) NOT NULL,
  `Career_Name` varchar(255) NOT NULL,
  `Career_Description` varchar(10000) NOT NULL,
  `Career_Status` tinyint(1) NOT NULL,
  `Career_Photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `Company_ID` int(11) NOT NULL,
  `Company_Name` varchar(255) NOT NULL,
  `Company_Email` varchar(255) NOT NULL,
  `Company_Pin` varchar(255) NOT NULL,
  `Company_Bio` varchar(255) NOT NULL,
  `Company_Photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_career`
--

CREATE TABLE `company_career` (
  `Company_Career_ID` int(11) NOT NULL,
  `Company_ID` int(11) NOT NULL,
  `Career_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `design`
--

CREATE TABLE `design` (
  `Design_ID` int(11) NOT NULL,
  `Rating_ID` int(11) NOT NULL,
  `Design_Name` varchar(255) NOT NULL,
  `Design_Description` varchar(10000) NOT NULL,
  `Design_Price` decimal(10,2) NOT NULL,
  `Design_Photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `Payment_ID` int(11) NOT NULL,
  `Transaction_ID` int(11) NOT NULL,
  `Payment_Amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `Rating_ID` int(11) NOT NULL,
  `Design_Rate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `Sales_ID` int(11) NOT NULL,
  `Payment_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Sales_Amount` decimal(10,2) NOT NULL,
  `Sales_Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `Transaction_ID` int(11) NOT NULL,
  `Design_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Transaction_Total` decimal(10,2) NOT NULL,
  `Transaction_Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `User_ID` int(11) NOT NULL,
  `User_FirstName` varchar(255) NOT NULL,
  `User_LastName` varchar(255) NOT NULL,
  `User_Email` varchar(255) NOT NULL,
  `User_Password` varchar(255) NOT NULL,
  `User_ContactNo` varchar(255) NOT NULL,
  `User_Photo` varchar(255) NOT NULL,
  `User_CoverPhoto` varchar(255) NOT NULL,
  `User_Bio` varchar(255) NOT NULL,
  `User_Introduction` varchar(10000) NOT NULL,
  `User_Facebook` varchar(255) NOT NULL,
  `User_Instagram` varchar(255) NOT NULL,
  `User_LinkedIn` varchar(255) NOT NULL,
  `User_Type` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`User_ID`, `User_FirstName`, `User_LastName`, `User_Email`, `User_Password`, `User_ContactNo`, `User_Photo`, `User_CoverPhoto`, `User_Bio`, `User_Introduction`, `User_Facebook`, `User_Instagram`, `User_LinkedIn`, `User_Type`) VALUES
(1, 'Johannes Emmanuel', 'Claus', 'johannclaus30@gmail.com', 'jeaCLS1900_', '', '', '', '', '', '', '', '', 1),
(2, 'Jade Ahrens', 'Caponpon', 'jadecp@nu-lipa.edu.ph', 'abc123$', '', '', '', '', '', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_company`
--

CREATE TABLE `user_company` (
  `User_Company_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Company_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_design`
--

CREATE TABLE `user_design` (
  `User_Design_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Design_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `career`
--
ALTER TABLE `career`
  ADD PRIMARY KEY (`Career_ID`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`Company_ID`);

--
-- Indexes for table `company_career`
--
ALTER TABLE `company_career`
  ADD PRIMARY KEY (`Company_Career_ID`),
  ADD KEY `Career_ID` (`Career_ID`),
  ADD KEY `Company_ID` (`Company_ID`);

--
-- Indexes for table `design`
--
ALTER TABLE `design`
  ADD PRIMARY KEY (`Design_ID`),
  ADD KEY `Rating_ID` (`Rating_ID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`Payment_ID`),
  ADD KEY `Transaction_ID` (`Transaction_ID`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`Rating_ID`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`Sales_ID`),
  ADD KEY `Payment_ID` (`Payment_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`Transaction_ID`),
  ADD KEY `Design_ID` (`Design_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_ID`);

--
-- Indexes for table `user_company`
--
ALTER TABLE `user_company`
  ADD PRIMARY KEY (`User_Company_ID`),
  ADD KEY `Company_ID` (`Company_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `user_design`
--
ALTER TABLE `user_design`
  ADD PRIMARY KEY (`User_Design_ID`),
  ADD KEY `User_ID` (`User_ID`),
  ADD KEY `Design_ID` (`Design_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `career`
--
ALTER TABLE `career`
  MODIFY `Career_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `Company_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_career`
--
ALTER TABLE `company_career`
  MODIFY `Company_Career_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `design`
--
ALTER TABLE `design`
  MODIFY `Design_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `Payment_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `Rating_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `Sales_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `Transaction_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_company`
--
ALTER TABLE `user_company`
  MODIFY `User_Company_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_design`
--
ALTER TABLE `user_design`
  MODIFY `User_Design_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `company_career`
--
ALTER TABLE `company_career`
  ADD CONSTRAINT `company_career_ibfk_1` FOREIGN KEY (`Career_ID`) REFERENCES `career` (`Career_ID`),
  ADD CONSTRAINT `company_career_ibfk_2` FOREIGN KEY (`Company_ID`) REFERENCES `company` (`Company_ID`);

--
-- Constraints for table `design`
--
ALTER TABLE `design`
  ADD CONSTRAINT `design_ibfk_1` FOREIGN KEY (`Rating_ID`) REFERENCES `rating` (`Rating_ID`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`Transaction_ID`) REFERENCES `transaction` (`Transaction_ID`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`Payment_ID`) REFERENCES `payment` (`Payment_ID`),
  ADD CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`Design_ID`) REFERENCES `design` (`Design_ID`),
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`);

--
-- Constraints for table `user_company`
--
ALTER TABLE `user_company`
  ADD CONSTRAINT `user_company_ibfk_1` FOREIGN KEY (`Company_ID`) REFERENCES `company` (`Company_ID`),
  ADD CONSTRAINT `user_company_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`);

--
-- Constraints for table `user_design`
--
ALTER TABLE `user_design`
  ADD CONSTRAINT `user_design_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_ID`),
  ADD CONSTRAINT `user_design_ibfk_2` FOREIGN KEY (`Design_ID`) REFERENCES `design` (`Design_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
