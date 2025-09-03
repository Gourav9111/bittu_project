-- phpMyAdmin SQL Dump - Updated for DSA Application System
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 03, 2025 at 06:45 PM (Updated)
-- Server version: 10.11.10-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u900473099_gourav`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('super','admin') DEFAULT 'admin',
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `email`, `role`, `status`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$EUIKgzpE7P4Y8GQwnGn.kuIxKBFnLgJcwjJxP9vKh4oHGY8KQpj/6', 'admin@jsmf.in', 'super', 'Active', NULL, '2025-09-02 21:52:41', '2025-09-02 21:52:41'),
(8, 'gourav', 'gourav9111', 'gourav@jsmf.in', 'super', 'Active', '2025-09-03 16:30:24', '2025-09-03 13:50:04', '2025-09-03 16:30:24');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `message` text NOT NULL,
  `status` enum('New','Read','Replied') DEFAULT 'New',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dsa_users` - UPDATED WITH DSA_ID
--

CREATE TABLE `dsa_users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `experience` varchar(50) NOT NULL,
  `previous_experience` text DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dsa_id` varchar(50) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `kyc_status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dsa_users`
--

INSERT INTO `dsa_users` (`id`, `name`, `mobile`, `email`, `experience`, `previous_experience`, `username`, `password`, `dsa_id`, `profile_pic`, `address`, `kyc_status`, `status`, `created_at`) VALUES
(1, 'HARSH SAHU', '8131703768', 'jsmfbhopal@gmail.com', '1-3 years', '1e2qwrty', 'namo', '$2y$10$4VIRZL5x40qF8QjGsltfAefy2ILK8dt/L2NKoFzZ8AWB30huvalqS', 'DSA0001', NULL, 'Shop No 2, Near Mittal College, Karond', 'Pending', 'Active', '2025-09-02 21:56:56'),
(2, 'HARSH SAHU', '0913703767', 'jsmfbh4fopal@gmail.com', '5-10 years', 'qadsfg', 'aaaa', '$2y$10$IvFd6YBuDDVfp4Fm6S0ZkenePnHZaag6epbrEHCnAlujVMI9mUxwS', 'DSA0002', NULL, 'Shop No 2, Near Mittal College, Karond', 'Approved', 'Active', '2025-09-02 22:00:38'),
(3, 'gourav', '9111968788', 'gourav9111@gmail.com', '1-3 years', 'i am demo user for check server working', 'gourav9111', '$2y$10$JZz7XXhDH2d7tAFtS9cWOuhYDOYaLJOJub32Lg4f17n8jKT18stTi', 'DSA0003', NULL, 'gourav9111', 'Approved', 'Active', '2025-09-02 22:31:21');

-- --------------------------------------------------------

--
-- NEW TABLE: DSA Applications - Main feature for DSA loan submissions
--

CREATE TABLE `dsa_applications` (
  `id` int(11) NOT NULL,
  `application_id` varchar(50) NOT NULL,
  `dsa_user_id` int(11) NOT NULL,
  `loan_type` enum('Personal Loan','Business Loan','Home Loan','Car Loan','Gold Loan','Plot Loan') NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_mobile` varchar(15) NOT NULL,
  `customer_email` varchar(100) DEFAULT NULL,
  `mother_name` varchar(100) DEFAULT NULL,
  `office_address` text DEFAULT NULL,
  `address_proof` text DEFAULT NULL,
  `salary_amount` decimal(10,2) DEFAULT NULL,
  `aadhar_card_file` varchar(255) DEFAULT NULL,
  `aadhar_card_number` varchar(20) DEFAULT NULL,
  `pan_card_file` varchar(255) DEFAULT NULL,
  `pan_card_number` varchar(15) DEFAULT NULL,
  `salary_slip_files` text DEFAULT NULL,
  `bank_statement_file` varchar(255) DEFAULT NULL,
  `other_documents` text DEFAULT NULL,
  `gumasta_udhyam_file` varchar(255) DEFAULT NULL,
  `itr_files` text DEFAULT NULL,
  `income_type` enum('Self Employed','Salaried - Cash','Salaried - Account') DEFAULT NULL,
  `electricity_bill_file` varchar(255) DEFAULT NULL,
  `property_papers` text DEFAULT NULL,
  `reference_details` text DEFAULT NULL,
  `status` enum('Pending','In Progress','Approved','Rejected') DEFAULT 'Pending',
  `admin_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lead_assignments` - KEPT FOR BACKWARD COMPATIBILITY
--

CREATE TABLE `lead_assignments` (
  `id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `dsa_id` int(11) NOT NULL,
  `assigned_by` int(11) NOT NULL,
  `status` enum('Assigned','In Progress','Follow-Up','Submitted','Completed') DEFAULT 'Assigned',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lead_assignments`
--

INSERT INTO `lead_assignments` (`id`, `application_id`, `dsa_id`, `assigned_by`, `status`, `notes`, `created_at`) VALUES
(7, 1, 3, 1, 'Assigned', NULL, '2025-09-02 22:48:54');

-- --------------------------------------------------------

--
-- Table structure for table `loan_applications` - EXISTING CUSTOMER APPLICATIONS
--

CREATE TABLE `loan_applications` (
  `id` int(11) NOT NULL,
  `applicant_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `application_id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `city` varchar(50) NOT NULL,
  `loan_type` varchar(50) NOT NULL,
  `loan_amount` decimal(12,2) NOT NULL,
  `monthly_income` decimal(10,2) NOT NULL,
  `pan_aadhar` varchar(50) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected','Processing') DEFAULT 'Pending',
  `assigned_dsa` int(11) DEFAULT NULL,
  `assigned_dsa_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_applications`
--

INSERT INTO `loan_applications` (`id`, `applicant_name`, `email`, `application_id`, `name`, `mobile`, `city`, `loan_type`, `loan_amount`, `monthly_income`, `pan_aadhar`, `status`, `assigned_dsa`, `assigned_dsa_id`, `created_at`, `updated_at`) VALUES
(1, '', '', 'JSMA2HG5KFQZ', 'ghh', '8978866688', 'bhopal', 'Home Loan', 60899.00, 500000.00, 'qdwsfdgbnhmj', 'Processing', 3, 3, '2025-09-02 22:24:00', '2025-09-02 22:46:54'),
(2, '', '', 'JSMA1YSZ4YCG', 'Harsh', '9131703768', 'Bhopal', 'Home Loan', 500000.00, 35000.00, 'Mvvvps9476a', 'Pending', NULL, NULL, '2025-09-03 03:51:46', '2025-09-03 03:51:46'),
(3, '', '', 'JSMA6OYYBNP8', 'Harsh', '9131703768', 'Bhopal', 'Home Loan', 500000.00, 35000.00, 'Mvvvps9476a', 'Pending', NULL, NULL, '2025-09-03 03:52:03', '2025-09-03 15:01:35'),
(4, '', '', 'JSMAUHA048O7', 'manu sharma', '8785767546', 'mumbai', 'LAP (Loan Against Property)', 6000000.00, 50000.00, 'PSE456PF', 'Pending', NULL, NULL, '2025-09-03 14:37:25', '2025-09-03 14:37:25'),
(5, '', '', 'JSMAX7ZNDNS8', 'Rohit', '9568000624', 'Bhopal', 'Personal Loan', 500000.00, 65000.00, 'HKTIY9582A', 'Rejected', 3, 3, '2025-09-03 15:11:50', '2025-09-03 15:18:06'),
(6, '', '', 'JSMAOVK8HZKU', 'Ygsu', '8465455468', 'Hsygd', 'Home Loan', 9999999999.99, 99999999.99, 'Hdisggeodb', 'Pending', 1, 1, '2025-09-03 16:31:42', '2025-09-03 16:32:24');

-- --------------------------------------------------------

--
-- Table structure for table `loan_categories`
--

CREATE TABLE `loan_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `key_point_1` varchar(200) DEFAULT NULL,
  `key_point_2` varchar(200) DEFAULT NULL,
  `key_point_3` varchar(200) DEFAULT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `min_amount` decimal(12,2) DEFAULT 10000.00,
  `max_amount` decimal(12,2) DEFAULT 5000000.00,
  `interest_rate` varchar(50) DEFAULT '7% onwards',
  `is_featured` tinyint(1) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_types`
--

CREATE TABLE `loan_types` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `min_amount` decimal(12,2) DEFAULT 10000.00,
  `max_amount` decimal(12,2) DEFAULT 5000000.00,
  `min_interest_rate` decimal(5,2) DEFAULT 7.00,
  `max_interest_rate` decimal(5,2) DEFAULT 24.00,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_types`
--

INSERT INTO `loan_types` (`id`, `name`, `description`, `min_amount`, `max_amount`, `min_interest_rate`, `max_interest_rate`, `is_active`) VALUES
(1, 'Personal Loan', 'Quick personal loans for immediate needs', 10000.00, 1000000.00, 10.50, 18.00, 1),
(2, 'Home Loan', 'Affordable home loans with competitive rates', 500000.00, 50000000.00, 7.00, 12.00, 1),
(3, 'Education Loan', 'Fund your education dreams', 50000.00, 2000000.00, 8.50, 15.00, 1),
(4, 'Car Loan', 'Drive your dream car today', 100000.00, 2000000.00, 8.00, 14.00, 1),
(5, 'Business Loan', 'Grow your business with our support', 100000.00, 5000000.00, 11.00, 20.00, 1),
(6, 'Plot Purchase', 'Buy your dream plot', 200000.00, 10000000.00, 9.00, 15.00, 1),
(8, 'Renovation Loan', 'Renovate and upgrade your home', 50000.00, 1000000.00, 10.00, 17.00, 1),
(9, 'Balance Transfer', 'Transfer and save on interest', 100000.00, 5000000.00, 8.50, 15.00, 1),
(10, 'LAP (Loan Against Property)', 'Leverage your property value', 500000.00, 10000000.00, 9.00, 16.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `target` enum('dsa','all') DEFAULT 'all',
  `target_user_id` int(11) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dsa_users`
--
ALTER TABLE `dsa_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `dsa_id` (`dsa_id`);

--
-- NEW: Indexes for table `dsa_applications`
--
ALTER TABLE `dsa_applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `application_id` (`application_id`),
  ADD KEY `dsa_user_id` (`dsa_user_id`),
  ADD KEY `loan_type` (`loan_type`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `lead_assignments`
--
ALTER TABLE `lead_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_id` (`application_id`),
  ADD KEY `dsa_id` (`dsa_id`),
  ADD KEY `assigned_by` (`assigned_by`);

--
-- Indexes for table `loan_applications`
--
ALTER TABLE `loan_applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `application_id` (`application_id`);

--
-- Indexes for table `loan_categories`
--
ALTER TABLE `loan_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_types`
--
ALTER TABLE `loan_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_name` (`name`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dsa_users`
--
ALTER TABLE `dsa_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- NEW: AUTO_INCREMENT for table `dsa_applications`
--
ALTER TABLE `dsa_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lead_assignments`
--
ALTER TABLE `lead_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `loan_applications`
--
ALTER TABLE `loan_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `loan_categories`
--
ALTER TABLE `loan_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_types`
--
ALTER TABLE `loan_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- NEW: Constraints for table `dsa_applications`
--
ALTER TABLE `dsa_applications`
  ADD CONSTRAINT `fk_dsa_applications_user` FOREIGN KEY (`dsa_user_id`) REFERENCES `dsa_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lead_assignments`
--
ALTER TABLE `lead_assignments`
  ADD CONSTRAINT `lead_assignments_ibfk_1` FOREIGN KEY (`application_id`) REFERENCES `loan_applications` (`id`),
  ADD CONSTRAINT `lead_assignments_ibfk_2` FOREIGN KEY (`dsa_id`) REFERENCES `dsa_users` (`id`),
  ADD CONSTRAINT `lead_assignments_ibfk_3` FOREIGN KEY (`assigned_by`) REFERENCES `admin_users` (`id`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;