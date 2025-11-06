-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2025 at 06:46 AM
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
-- Database: `m_e`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_use
create database m_e;
use m_e;

CREATE TABLE `admin_user` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `role` enum('admin','manager','staff') NOT NULL DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`admin_id`, `username`, `email`, `password_hash`, `first_name`, `last_name`, `role`, `created_at`, `is_active`) VALUES
(1, 'JoshuaLapitan', 'lapitanjoshua2005@gmail.com', '$2y$10$MjY5MmY2MmY2YTJkMDk2Nzg3OWFkY2IwM2MyY2Q2MzI0MjgxOWVlY', 'Joshua', 'lapitan', 'admin', '2025-10-29 13:57:56', 1),
(2, 'Sungjinwoo', 'lienkyut27@gmail.com', '$2y$10$YzZjMDFjZWUyMjcyYzYyNTU0ZmI3Zjk4MzExMGExNjZjZTg2MjU4Y', 'lien', 'muhi', '', '2025-10-29 14:56:45', 1),
(3, 'admin', 'admin@gmail.com', '$2y$10$K5X61xc58I.Rbtl0lD4Sz.jt6yKkPUJoiRiO0W5FkCuqYvAtiUZoi', 'admin', 'admin', 'admin', '2025-11-06 04:38:46', 1);

-- --------------------------------------------------------

--
-- Table structure for table `barangays`
--

CREATE TABLE `barangays` (
  `barangay_id` int(11) NOT NULL,
  `barangay_name` varchar(100) NOT NULL,
  `city_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangays`
--

INSERT INTO `barangays` (`barangay_id`, `barangay_name`, `city_id`) VALUES
(1, 'Barretto', 1),
(2, 'Gordon Heights', 1),
(3, 'East Tapinac', 1),
(4, 'West Bajac-Bajac', 1),
(5, 'Kalaklan', 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `category_slug` varchar(100) NOT NULL,
  `isActive` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_slug`, `isActive`, `created_at`) VALUES
(1, 'School Supplies', 'school-supplies', 1, '2025-09-12 23:56:37'),
(2, 'Office Supplies', 'office-supplies', 1, '2025-09-12 23:56:37'),
(3, 'Sanitary', 'sanitary', 1, '2025-09-12 23:56:37');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(100) NOT NULL,
  `province_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`city_id`, `city_name`, `province_id`) VALUES
(1, 'Olongapo', 1),
(2, 'Subic', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer_activity_log`
--

CREATE TABLE `customer_activity_log` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `activity_type` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `old_value` text DEFAULT NULL,
  `new_value` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_admin_settings`
--

CREATE TABLE `customer_admin_settings` (
  `setting_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_type` enum('regular','vip','wholesale','corporate') DEFAULT 'regular',
  `credit_limit` decimal(10,2) DEFAULT 0.00,
  `discount_rate` decimal(5,2) DEFAULT 0.00,
  `payment_terms` enum('immediate','net7','net15','net30','net60') DEFAULT 'immediate',
  `sales_rep_id` int(11) DEFAULT NULL,
  `allow_bulk_orders` tinyint(1) DEFAULT 1,
  `allow_credit_purchases` tinyint(1) DEFAULT 0,
  `require_order_approval` tinyint(1) DEFAULT 0,
  `block_new_orders` tinyint(1) DEFAULT 0,
  `receive_marketing_emails` tinyint(1) DEFAULT 1,
  `access_wholesale_prices` tinyint(1) DEFAULT 0,
  `outstanding_balance` decimal(10,2) DEFAULT 0.00,
  `available_credit` decimal(10,2) DEFAULT 0.00,
  `admin_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_admin_settings`
--

INSERT INTO `customer_admin_settings` (`setting_id`, `user_id`, `customer_type`, `credit_limit`, `discount_rate`, `payment_terms`, `sales_rep_id`, `allow_bulk_orders`, `allow_credit_purchases`, `require_order_approval`, `block_new_orders`, `receive_marketing_emails`, `access_wholesale_prices`, `outstanding_balance`, `available_credit`, `admin_notes`, `created_at`, `updated_at`) VALUES
(3, 100, 'regular', 0.00, 0.00, 'immediate', NULL, 1, 0, 0, 0, 1, 0, 0.00, 0.00, NULL, '2025-10-27 06:26:54', '2025-10-27 06:26:54'),
(4, 111, 'regular', 0.00, 0.00, 'immediate', NULL, 1, 0, 0, 0, 1, 0, 0.00, 0.00, NULL, '2025-10-27 06:26:54', '2025-10-27 06:26:54');

-- --------------------------------------------------------

--
-- Table structure for table `customer_request`
--

CREATE TABLE `customer_request` (
  `request_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `request_type` enum('inquiry','complaint','custom_order','other') NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('pending','in-progress','resolved','closed') DEFAULT 'pending',
  `priority` enum('low','medium','high','urgent') DEFAULT 'medium',
  `admin_response` text DEFAULT NULL,
  `responded_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `responded_at` timestamp NULL DEFAULT NULL,
  `user_seen_reply` tinyint(4) NOT NULL,
  `admin_seen_request` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_request`
--

INSERT INTO `customer_request` (`request_id`, `user_id`, `request_type`, `subject`, `message`, `status`, `priority`, `admin_response`, `responded_by`, `created_at`, `responded_at`, `user_seen_reply`, `admin_seen_request`) VALUES
(1, 111, 'complaint', 'Mali ang order', 'Mali yung dumating na order please fix it', 'in-progress', 'medium', 'Dear Jeremiah Bert Deplomo,\n\nThank you for your custom order inquiry for . Based on your requirements, here\'s our detailed quote:\n\n\n\nTimeline: \nMinimum order quantity: \nUnit price: ₱\nTotal estimated cost: ₱\n\nPlease note that final pricing may vary based on exact specifications and quantities.\n\nWould you like to proceed with this quotation?\n\nBest regards,\nM & E Team', 1, '2025-10-29 05:06:10', '2025-10-29 13:58:11', 1, 0),
(2, 111, 'custom_order', 'custom', 'penge brief', 'in-progress', '', 'Dear Jeremiah Bert Deplomo,\n\nThank you for your order #. We have received your order and it is being processed.\n\nYour order details:\n\n\nEstimated delivery: \nDelivery address: \n\nYou can track your order status through our website using your order number.\n\nThank you for choosing M & E!\n\nBest regards,\nM & E Team', 1, '2025-10-29 06:40:25', '2025-10-29 13:58:03', 1, 0),
(5, 111, 'inquiry', 'Asking Question', 'Do you sell Asteroids?', 'in-progress', '', 'Dear Jeremiah Bert Deplomo,\n\nWe sincerely apologize for the inconvenience you\'ve experienced with {{issue_description}}. We take all customer concerns seriously and will investigate this matter immediately.\n\nWe will:\n1. {{action_step_1}}\n2. {{action_step_2}}\n3. Provide you with an update within {{response_time}}\n\nYour satisfaction is our priority. We appreciate your patience as we work to resolve this issue.\n\nThank you for bringing this to our attention.\n\nBest regards,\nM & E Team', 3, '2025-11-05 10:39:59', '2025-11-06 04:59:46', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer_request_archive`
--

CREATE TABLE `customer_request_archive` (
  `archive_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `request_type` enum('inquiry','complaint','custom_order','other') NOT NULL DEFAULT 'inquiry',
  `subject` varchar(500) NOT NULL,
  `message` text NOT NULL,
  `status` enum('pending','in-progress','resolved','closed') NOT NULL DEFAULT 'pending',
  `priority` enum('low','medium','high','urgent') NOT NULL DEFAULT 'medium',
  `admin_response` text DEFAULT NULL,
  `responded_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `responded_at` timestamp NULL DEFAULT NULL,
  `archived_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `archived_by` int(11) DEFAULT NULL,
  `archive_reason` enum('resolved','auto','manual','expired','spam') NOT NULL DEFAULT 'manual',
  `archive_notes` text DEFAULT NULL,
  `customer_name` varchar(500) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_contact` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_request_archive`
--

INSERT INTO `customer_request_archive` (`archive_id`, `request_id`, `user_id`, `request_type`, `subject`, `message`, `status`, `priority`, `admin_response`, `responded_by`, `created_at`, `responded_at`, `archived_at`, `archived_by`, `archive_reason`, `archive_notes`, `customer_name`, `customer_email`, `customer_contact`) VALUES
(5, 7, 100, 'inquiry', 'Product Availability Inquiry', 'Heyhey pabili ng yelo', 'closed', '', 'a', 3, '2025-11-05 12:36:11', '2025-11-06 04:54:57', '2025-11-06 05:08:41', 3, 'manual', '', 'C-jay Bazar Gonzales', 'cjaygonzales1006@gmail.com', '+639279754520');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `final_amount` decimal(10,2) NOT NULL,
  `payment_method` enum('COD','Bank Transfer','GCash','Other') NOT NULL,
  `order_status` enum('Pending','Confirmed','Shipped','Delivered','Cancelled') NOT NULL DEFAULT 'Pending',
  `delivery_address` text NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `special_instructions` text DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `cod_token` varchar(64) DEFAULT NULL,
  `payment_status` enum('Pending','Paid','Failed') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_number`, `total_amount`, `shipping_fee`, `final_amount`, `payment_method`, `order_status`, `delivery_address`, `contact_number`, `special_instructions`, `order_date`, `confirmed_at`, `delivered_at`, `admin_notes`, `cod_token`, `payment_status`) VALUES
(2, 100, 'ORD-20250921143558', 68.00, 75.00, 143.00, 'COD', 'Delivered', '759 lot 26 blk 4 Tupda Village', '09279754520', 'None', '2025-09-21 12:35:58', NULL, NULL, 'Testing checkout order', NULL, 'Pending'),
(10, 100, 'ORD-251105-da8', 45.00, 75.00, 120.00, 'GCash', 'Pending', '759 lot 26 blk 4 Tupda Village', '+639279754520', '', '2025-11-05 09:08:33', NULL, NULL, 'Checkout created', NULL, 'Pending'),
(11, 100, 'ORD-251105-c5e', 2242.00, 75.00, 2317.00, 'COD', 'Pending', '759 lot 26 blk 4 Tupda Village', '+639279754520', '', '2025-11-05 09:17:08', NULL, NULL, 'Checkout created', NULL, 'Pending'),
(13, 100, 'ORD-251105-836', 59.00, 75.00, 134.00, 'COD', 'Pending', '759 lot 26 blk 4 Tupda Village', '+639279754520', '', '2025-11-05 09:18:04', NULL, NULL, 'Checkout created', NULL, 'Pending'),
(14, 100, 'ORD-251105-bde', 182.00, 75.00, 257.00, 'GCash', 'Pending', '759 lot 26 blk 4 Tupda Village', '+639279754520', '', '2025-11-05 09:19:09', NULL, NULL, 'Checkout created', NULL, 'Pending'),
(15, 100, 'ORD-251105-cc0', 182.00, 75.00, 257.00, 'GCash', 'Pending', '759 lot 26 blk 4 Tupda Village', '+639279754520', '', '2025-11-05 09:28:12', NULL, NULL, 'Checkout created', NULL, 'Pending'),
(18, 100, 'ORD-251105-f30', 295.00, 75.00, 370.00, 'COD', 'Pending', '759 lot 26 blk 4 Tupda Village', '+639279754520', '', '2025-11-05 10:07:46', NULL, NULL, 'Checkout created', NULL, 'Pending'),
(19, 100, 'ORD-251105-a5c', 177.00, 75.00, 252.00, 'COD', 'Pending', '759 lot 26 blk 4 Tupda Village', '+639279754520', '', '2025-11-05 10:13:36', NULL, NULL, 'Checkout created', NULL, 'Pending'),
(20, 100, 'ORD-251105-148', 59.00, 75.00, 134.00, 'COD', 'Pending', '759 lot 26 blk 4 Tupda Village', '+639279754520', '', '2025-11-05 10:18:25', NULL, NULL, 'Checkout created', NULL, 'Pending'),
(21, 100, 'ORD-251105-efa', 312.00, 75.00, 387.00, 'COD', 'Pending', '759 lot 26 blk 4 Tupda Village', '+639279754520', '', '2025-11-05 10:23:06', NULL, NULL, 'Checkout created', NULL, 'Pending'),
(22, 100, 'ORD-251105-f70', 180.00, 75.00, 255.00, 'COD', 'Pending', '759 lot 26 blk 4 Tupda Village', '+639279754520', '', '2025-11-05 10:28:40', NULL, NULL, 'Checkout created', NULL, 'Pending'),
(23, 100, 'ORD-251105-e25', 156.00, 75.00, 231.00, 'COD', 'Pending', '759 lot 26 blk 4 Tupda Village', '+639279754520', '', '2025-11-05 10:29:46', NULL, NULL, 'Checkout created', NULL, 'Pending'),
(24, 100, 'ORD-251106-88f', 326.00, 75.00, 401.00, 'COD', 'Pending', '759 lot 26 blk 4 Tupda Village', '+639279754520', '', '2025-11-06 04:42:43', NULL, NULL, 'Checkout created', NULL, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) GENERATED ALWAYS AS (`product_price` * `quantity`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `product_name`, `product_price`, `quantity`) VALUES
(1, 24, 1, 'Bond Paper A4 80gsm', 250.00, 1),
(2, 24, 109, 'Plastic Folder Jacket Long', 17.00, 1),
(3, 24, 116, 'Air Freshener', 59.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `product_code` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) UNSIGNED NOT NULL,
  `unit` varchar(20) NOT NULL DEFAULT 'pieces' COMMENT 'Unit of measurement: box, pieces, reams, rolls, gallon, pack, pads',
  `min_stock_level` int(11) UNSIGNED DEFAULT 0,
  `product_image` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `is_top_order` tinyint(1) DEFAULT 0,
  `isActive` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `product_code`, `description`, `price`, `stock_quantity`, `unit`, `min_stock_level`, `product_image`, `is_featured`, `is_top_order`, `isActive`, `created_at`, `updated_at`) VALUES
(1, 1, 'Bond Paper A4 80gsm', '', 'High quality bond paper for school and office use', 250.00, 99, 'pieces', 20, 'bond_a4.jpg', 1, 1, 1, '2025-09-12 23:58:03', '2025-11-06 04:42:43'),
(2, 1, 'Ballpen Black', 'BP-BLK01', 'Smooth writing ballpen with black ink', 12.00, 200, 'pieces', 50, 'ballpen_black.jpg', 1, 0, 1, '2025-09-12 23:58:03', '2025-10-30 00:12:36'),
(3, 1, 'Yellow Pad Paper', 'YPP-01', 'Standard yellow pad paper, 80 sheets', 45.00, 149, 'pieces', 30, 'prod_1760709796_4759.jpg', 1, 0, 1, '2025-09-12 23:58:03', '2025-11-05 09:08:33'),
(4, 2, 'Notebook Spiral 100 Pages', 'NB-SP100', 'Spiral notebook for note-taking', 60.00, 180, 'pieces', 40, 'notebook_spiral.jpg', 0, 1, 1, '2025-09-12 23:58:03', '2025-10-30 00:10:13'),
(5, 2, 'Whiteboard Marker Blue', 'WM-BLU', 'Erasable blue whiteboard marker', 35.00, 120, 'pieces', 25, 'marker_blue.jpg', 0, 0, 1, '2025-09-12 23:58:03', '2025-10-30 00:10:13'),
(6, 3, 'Alcohol 70% Solution 500ml', 'ALC-500', 'Sanitary alcohol for disinfection', 95.00, 10, 'pieces', 15, 'prod_1761624864_1201.jpg', 1, 1, 0, '2025-09-12 23:58:03', '2025-10-28 23:59:30'),
(7, 3, 'Face Mask Box (50pcs)', 'FM-50', 'Disposable face masks for sanitary use', 120.00, 80, 'pieces', 10, 'facemask.jpg', 0, 0, 1, '2025-09-12 23:58:03', '2025-10-30 00:09:09'),
(8, 1, 'Pencil No.2', 'PN-02', 'Standard HB pencil for writing and drawing', 10.00, 250, 'pieces', 60, 'pencil.jpg', 1, 0, 1, '2025-09-12 23:58:03', '2025-10-30 00:12:36'),
(9, 2, 'Eraser White', 'ER-WHT', 'High quality eraser for clean erasing', 8.00, 300, 'pieces', 70, 'eraser.jpg', 0, 0, 1, '2025-09-12 23:58:03', '2025-10-30 00:10:13'),
(10, 3, 'Hand Sanitizer 250ml', 'HS-250', 'Instant hand sanitizer gel', 75.00, 85, 'pieces', 15, 'handsanitizer.jpg', 0, 1, 1, '2025-09-12 23:58:03', '2025-10-30 00:09:09'),
(14, 1, 'Kalapati', 'Klpt-02', 'lumilipad na ibon', 200.00, 99, 'pieces', 0, 'prod_1761623578_6256.png', 1, 0, 1, '2025-10-28 11:52:58', '2025-11-05 09:02:12'),
(19, 2, 'cp', 'X7-101', 'cellphone na maangas', 20000.00, 50, 'pieces', 0, 'prod_1761810814_6788.jpg', 0, 0, 1, '2025-10-30 15:53:34', '2025-10-30 00:10:13'),
(20, 1, 'poco', 'CP-01', 'cp', 10000.00, 50, 'box', 0, 'prod_1761812540_5825.jpg', 0, 0, 1, '2025-10-30 16:22:20', '2025-10-30 00:22:20'),
(21, 1, 'Cellphone', 'CP-02', 'asdawda', 100.00, 100, 'reams', 0, 'prod_1761812675_1213.png', 0, 0, 1, '2025-10-30 16:24:35', '2025-10-30 00:24:35'),
(23, 2, 'Stapler Wire', 'ST-W', 'Staple wire for office use.', 78.00, 50, 'box', 0, 'prod_1762105142_8158.png', 0, 0, 1, '2025-11-03 01:39:02', '2025-11-02 09:39:02'),
(24, 2, 'Paper Clip Med', 'PC-M', 'Paper clip for organizing paper works at office.', 46.00, 90, 'box', 0, 'prod_1762115668_5251.png', 0, 0, 1, '2025-11-03 04:34:28', '2025-11-02 12:34:28'),
(25, 1, 'Highlighter', 'HL-01', 'Highlighter for students\' note taking.', 37.00, 70, 'pieces', 0, 'prod_1762116082_5094.png', 0, 0, 1, '2025-11-03 04:41:22', '2025-11-02 12:41:22'),
(26, 2, 'Panda Ballpen', 'PB-01', 'Smooth writing ballpoint pen for school and office use.', 195.00, 60, 'box', 0, 'prod_1762116268_2749.png', 0, 0, 1, '2025-11-03 04:44:28', '2025-11-02 12:44:28'),
(27, 1, 'Sticky Notes', 'SN-01', 'Sticky notes, design your workflow in your own way.', 34.00, 90, 'pieces', 0, 'prod_1762116623_2666.png', 0, 0, 1, '2025-11-03 04:50:23', '2025-11-02 12:50:23'),
(28, 1, 'Folder Long', 'FL-01', 'Folder file organizer', 11.00, 50, 'pieces', 0, 'prod_1762116829_5340.png', 0, 0, 1, '2025-11-03 04:53:49', '2025-11-02 12:53:49'),
(29, 2, 'Tape 1x50mm', 'TP-150', 'Daily use tape for office works.', 36.00, 90, 'pieces', 0, 'prod_1762116993_7833.png', 0, 0, 1, '2025-11-03 04:56:33', '2025-11-02 12:56:33'),
(31, 2, 'Copy One A4 Bond Paper', 'CO-A480R', 'Office use bond paper', 228.00, 60, 'reams', 0, 'prod_1762117327_3916.png', 0, 0, 1, '2025-11-03 05:02:07', '2025-11-02 13:04:32'),
(32, 2, 'Copy One A4 Bond Paper', 'CO-A480B', 'A4 sized bond paper for office use, larger quantity', 875.00, 80, 'box', 0, 'prod_1762117746_3457.png', 0, 0, 1, '2025-11-03 05:09:06', '2025-11-02 13:09:06'),
(33, 2, 'Copy One Short Bond Paper', 'CO-S', 'Short sized bond paper for office and school use.', 214.00, 100, 'reams', 0, 'prod_1762118857_5791.png', 0, 0, 1, '2025-11-03 05:27:37', '2025-11-02 13:27:37'),
(34, 2, 'Copy One Long Bond Paper', 'CO-L', 'Long sized bond paper for office and school use.', 250.00, 100, 'reams', 0, 'prod_1762118942_4922.png', 0, 0, 1, '2025-11-03 05:29:02', '2025-11-02 13:29:02'),
(35, 2, 'Brown Envelope Long', 'BE-L', 'File keeper brown envelope for office and school use.', 6.00, 50, 'pieces', 0, 'prod_1762119208_9269.png', 0, 0, 1, '2025-11-03 05:33:28', '2025-11-02 13:33:28'),
(36, 2, 'Hard Copy A4 Bond Paper', 'HCB-A480', 'A4 sized bond paper for daily demanding office usage.', 1203.00, 100, 'box', 0, 'prod_1762264515_4348.png', 0, 0, 1, '2025-11-04 21:55:15', '2025-11-04 05:55:15'),
(37, 3, 'Tissue Roll', 'TR-01', '2 ply tissue roll for sanitary purposes, in any setting.', 38.00, 90, 'rolls', 0, 'prod_1762264713_8113.png', 0, 0, 1, '2025-11-04 21:58:33', '2025-11-04 05:58:33'),
(38, 3, 'Alcohol', 'AL-01', '1 Gallon of alcohol for wider office or school demand, best as a refill.', 787.00, 50, 'gallon', 0, 'prod_1762264865_5485.png', 0, 0, 1, '2025-11-04 22:01:05', '2025-11-04 06:01:05'),
(39, 3, 'Garbage Bag S', 'GB-S', 'Small sized garbage bag, best for office and school sanitary purpose.', 65.00, 80, 'rolls', 0, 'prod_1762264985_3305.png', 0, 0, 1, '2025-11-04 22:03:05', '2025-11-04 06:03:05'),
(40, 3, 'Zonrox', 'ZR-01', 'Zonrox for sanitary purposes.', 68.00, 100, 'pieces', 0, 'prod_1762265197_3925.png', 0, 0, 1, '2025-11-04 22:06:37', '2025-11-04 06:06:37'),
(42, 3, 'Downy', 'DN-01', 'Downy Garden Bloom Fabric Conditioner', 221.00, 60, 'pack', 0, 'prod_1762265553_2055.png', 0, 0, 1, '2025-11-04 22:12:33', '2025-11-04 06:12:33'),
(43, 2, 'Carbon Black', 'CB-01', 'Carbon Paper Black for office use.', 592.00, 70, 'pack', 0, 'prod_1762265722_8107.png', 0, 0, 1, '2025-11-04 22:15:22', '2025-11-04 06:15:22'),
(44, 1, 'White Board Marker', 'WBM-01', 'Pilot Wyteboard Marker for school use, perfect for teaching and students\' activity purposes.', 39.00, 90, 'pieces', 0, 'prod_1762265949_5423.png', 0, 0, 1, '2025-11-04 22:19:09', '2025-11-04 06:19:09'),
(45, 1, 'Permanent Marker', 'MP-01', 'Permanent Marker for office and school use.', 59.00, 100, 'pieces', 0, 'prod_1762266029_1443.png', 0, 0, 1, '2025-11-04 22:20:29', '2025-11-04 06:20:29'),
(46, 3, 'Hand Soap', 'HS-01', 'Safeguard Liquid Hand Soap Lemon Fresh for sanitary purposes.', 156.00, 100, 'pieces', 0, 'prod_1762266176_3947.png', 0, 0, 1, '2025-11-04 22:22:56', '2025-11-04 06:22:56'),
(47, 3, 'Garbage Bag Jumbo', 'GB-J', 'Jumbo sized garbage bag, for larger use of garbage container.', 201.00, 100, 'rolls', 0, 'prod_1762266336_4876.png', 0, 0, 1, '2025-11-04 22:25:36', '2025-11-04 06:25:36'),
(48, 2, 'Rubber Band', 'RB-01', 'All Purpose Everlasting Rubber Band', 467.00, 50, 'box', 0, 'prod_1762266443_9792.png', 0, 0, 1, '2025-11-04 22:27:23', '2025-11-04 06:27:23'),
(49, 3, 'Dishwashing Liquid Champ', 'DLC-01', 'Champion Active Clean Dishwashing Liquid Antibacterial, Lemon Fresh', 364.00, 80, 'gallon', 0, 'prod_1762266567_7946.png', 0, 0, 1, '2025-11-04 22:29:27', '2025-11-04 06:29:27'),
(50, 1, 'Folder Short', 'FS-01', 'Short sized folder file organizer, for office and school paper tasks.', 10.00, 90, 'pieces', 0, 'prod_1762266696_2613.png', 0, 0, 1, '2025-11-04 22:31:36', '2025-11-04 06:31:36'),
(51, 1, 'Sticky Notes 3x3', 'SN-33', 'Sticky Notes for multiple stationery uses, notes, reminders.', 34.00, 130, 'pads', 0, 'prod_1762266829_4726.png', 0, 0, 1, '2025-11-04 22:33:49', '2025-11-04 06:33:49'),
(52, 1, 'Sticky Notes Tab', 'SN-TAB', 'Sticky Notes Tab, smaller sticky notes best for labelling and post it for more organized productivity.', 30.00, 90, 'pads', 0, 'prod_1762266987_5426.png', 0, 0, 1, '2025-11-04 22:36:27', '2025-11-04 06:36:27'),
(53, 1, 'Highlighter Yellow', 'HL-Y', 'Dataglo Highlighter Yellow variant, for note taking and other creative purposes.', 37.00, 100, 'pieces', 0, 'prod_1762267148_2223.png', 0, 0, 1, '2025-11-04 22:39:08', '2025-11-04 06:39:08'),
(54, 2, 'Stapler with Remover', 'ST-R', 'Stapler with dedicated remover, for easier staple removal, for office use.', 221.00, 50, 'pieces', 0, 'prod_1762267271_8859.png', 0, 0, 1, '2025-11-04 22:41:11', '2025-11-04 06:41:11'),
(55, 1, 'Correction Tape', 'CT-01', 'Correction Tape, remove writing or typographical mistakes, for office and school use.', 29.00, 60, 'pieces', 0, 'prod_1762267470_3333.png', 0, 0, 1, '2025-11-04 22:44:30', '2025-11-04 06:44:30'),
(56, 2, 'Calculator', 'CAL-01', 'Calculator for daily office use, business needs for faster calculation.', 260.00, 50, 'pieces', 0, 'prod_1762267630_7564.png', 0, 0, 1, '2025-11-04 22:47:10', '2025-11-04 06:47:10'),
(57, 2, 'Paper Clip Small', 'PC-S', 'Paper Clip Paper File Organizer', 26.00, 100, 'box', 0, 'prod_1762267713_3274.png', 0, 0, 1, '2025-11-04 22:48:33', '2025-11-04 06:48:33'),
(58, 2, 'Paper Clip Big', 'PC-B', 'Paper Clip Paper File Organizer', 39.00, 100, 'box', 0, 'prod_1762267750_5096.png', 0, 0, 1, '2025-11-04 22:49:10', '2025-11-04 06:49:10'),
(59, 1, 'Panda', 'PD-01', 'Panda Newmatic with Rubber Grip Water Gel Pen', 156.00, 100, 'box', 0, 'prod_1762267898_8475.png', 0, 0, 1, '2025-11-04 22:51:38', '2025-11-04 06:51:38'),
(60, 2, '2x2 Plastic', 'PL-22', '2x2 size of Plastic for daily office use.', 29.00, 100, 'pack', 0, 'prod_1762267963_8170.png', 0, 0, 1, '2025-11-04 22:52:43', '2025-11-04 06:52:43'),
(61, 1, 'Brown Envelope Short', 'BE-S', 'Short sized Brown Envelope for office and school use.', 4.00, 60, 'pieces', 0, 'prod_1762268166_1167.png', 0, 0, 1, '2025-11-04 22:56:06', '2025-11-04 06:56:06'),
(62, 1, 'White Folder Short', 'WFS-01', 'Short sized White Folder variant, for school and office use.', 6.00, 80, 'pieces', 0, 'prod_1762268261_5047.png', 0, 0, 1, '2025-11-04 22:57:41', '2025-11-04 06:57:41'),
(63, 2, 'Vellum Board A4', 'VB-01', 'A4 sized Vellum Board, ideal for: Corporate Letterheads, Business Cards, Brochures, etc.', 59.00, 50, 'pack', 0, 'prod_1762268490_2050.png', 0, 0, 1, '2025-11-04 23:01:30', '2025-11-04 07:01:30'),
(64, 2, 'Vellum Board Long', 'VB-L', 'Long sized Vellum Board 120gsm variant', 39.00, 70, 'pack', 0, 'prod_1762268581_5573.png', 0, 0, 1, '2025-11-04 23:03:01', '2025-11-04 07:03:01'),
(65, 1, 'Ring Binder L Blue', 'RBL-BL', 'Ring Binder School File Organizer, Blue variant', 195.00, 60, 'pieces', 0, 'prod_1762268830_5600.png', 0, 0, 1, '2025-11-04 23:07:10', '2025-11-04 07:07:10'),
(66, 1, 'Binder Clip 1\" 5/8\" 41mm', 'BC-158', 'Binder Clip File Clipper Organizer, 41mm variant', 45.00, 60, 'box', 0, 'prod_1762268967_9193.png', 0, 0, 1, '2025-11-04 23:09:27', '2025-11-04 07:09:27'),
(67, 1, 'Binder Clip 3/4\"', 'BC-34', 'Binder Clip File Clipper Organizer, 3/4-inch variant', 45.00, 100, 'box', 0, 'prod_1762269052_2939.png', 0, 0, 1, '2025-11-04 23:10:52', '2025-11-04 07:10:52'),
(68, 2, 'Double Sided Tape 3/4\"', 'DST-34', '3/5-inch sized Double Sided Tape, for office use.', 63.00, 50, 'pieces', 0, 'prod_1762269152_4169.png', 0, 0, 1, '2025-11-04 23:12:32', '2025-11-04 07:12:32'),
(69, 2, 'Diamond Scotch tape 1\"', 'DST-1', '1-inch sized Scotch Tape, for office use.', 50.00, 100, 'pieces', 0, 'prod_1762269260_3827.png', 0, 0, 1, '2025-11-04 23:14:20', '2025-11-04 07:14:20'),
(70, 2, 'Diamond Scotch Tape 1/2\"', 'DST-12', '1/2-inch sized Scotch Tape, for office use.', 50.00, 70, 'pieces', 0, 'prod_1762269357_1932.png', 0, 0, 1, '2025-11-04 23:15:57', '2025-11-04 07:15:57'),
(71, 2, 'Diamond Scotch Tape 3/4\"', 'DST-34D', '3/4-inch sized Scotch Tape, for office use.', 115.00, 70, 'pieces', 0, 'prod_1762269450_9390.png', 0, 0, 1, '2025-11-04 23:17:30', '2025-11-04 07:17:30'),
(72, 2, 'Masking Tape 1\"', 'MT-1', '1-inch Masking Tape, for office use.', 71.00, 80, 'pieces', 0, 'prod_1762269537_1884.png', 0, 0, 1, '2025-11-04 23:18:57', '2025-11-04 07:18:57'),
(73, 2, 'Masking Tape 3/4\"', 'MT-34', '3/4-inch sized Masking Tape, for office use.', 67.00, 80, 'pieces', 0, 'prod_1762269608_7819.png', 0, 0, 1, '2025-11-04 23:20:08', '2025-11-04 07:20:08'),
(74, 2, 'Masking Tape 1/2\"', 'MT-12', '1/2-inch sized Masking Tape, for office use.', 67.00, 80, 'pieces', 0, 'prod_1762269687_2130.png', 0, 0, 1, '2025-11-04 23:21:27', '2025-11-04 07:21:27'),
(75, 2, 'Packaging Tape CLear 2x200m', 'PTC-220', 'Packaging Tape necessary for office use.', 164.00, 90, 'pieces', 0, 'prod_1762269832_6865.png', 0, 0, 1, '2025-11-04 23:23:52', '2025-11-04 07:23:52'),
(76, 2, 'Packaging Tape Tan 2x200m', 'PTT-220', 'Packaging Tape Tan variant, for office use.', 164.00, 80, 'pieces', 0, 'prod_1762270190_1701.png', 0, 0, 1, '2025-11-04 23:29:50', '2025-11-04 07:29:50'),
(77, 2, 'Scotch Tape 12mm Small', 'ST-12S', '12mm sized Scotch Tape, for office use.', 50.00, 80, 'pieces', 0, 'prod_1762270478_2339.png', 0, 0, 1, '2025-11-04 23:34:38', '2025-11-04 07:34:38'),
(78, 2, 'Scotch Tape 12mm 50Y', 'ST-12Y', '12mm 50 Yard sized, for office use.', 110.00, 80, 'pieces', 0, 'prod_1762270616_7721.png', 0, 0, 1, '2025-11-04 23:36:56', '2025-11-04 07:36:56'),
(79, 2, 'Scotch Tape 1\" 50Y', 'ST-150', '1-inch 50 Yard sized, for office use.', 50.00, 80, 'pieces', 0, 'prod_1762270686_3738.png', 0, 0, 1, '2025-11-04 23:38:06', '2025-11-04 07:38:06'),
(80, 2, 'Fragile Tape 2x200m', 'FT-220', 'Packaging Fragile Tape, for office use.', 410.00, 100, 'pieces', 0, 'prod_1762270779_8477.png', 0, 0, 1, '2025-11-04 23:39:39', '2025-11-04 07:39:39'),
(81, 2, 'Rambo Binder Clip 1\" 1/4\"', 'RBC-114', '1 1/4-inch sized Binder Clip Paper File Organizer, for office and school use.', 23.00, 100, 'box', 0, 'prod_1762270897_7545.png', 0, 0, 1, '2025-11-04 23:41:37', '2025-11-04 07:41:37'),
(82, 2, 'Binder Clip 2\"', 'BC-2', 'Wider 2-inch Binder Clip size for wider paper clamp, for office and school use.', 59.00, 100, 'box', 0, 'prod_1762271017_4237.png', 0, 0, 1, '2025-11-04 23:43:37', '2025-11-04 07:43:37'),
(83, 1, 'Correction Tape 5mm x 12mm', 'CT-512', 'Correction Tape for school use, 5x12mm tape size variant', 56.00, 80, 'pieces', 0, 'prod_1762271126_1596.png', 0, 0, 1, '2025-11-04 23:45:26', '2025-11-04 07:45:26'),
(84, 1, 'Highlighter HBW Orange', 'HL-HO', 'HBW Highlighter, Orange variant', 172.00, 70, 'box', 0, 'prod_1762271246_4495.png', 0, 0, 1, '2025-11-04 23:47:26', '2025-11-04 07:47:26'),
(85, 1, 'Highlighter HBW Yellow', 'HL-HY', 'HBW Highlighter, Yellow variant', 172.00, 90, 'box', 0, 'prod_1762271364_6662.png', 0, 0, 1, '2025-11-04 23:49:24', '2025-11-04 07:49:24'),
(86, 1, 'Highlighter Stabilo Orange', 'HL-SO', 'Stabilo Highlighter for school use, Orange variant', 203.00, 90, 'box', 0, 'prod_1762272164_7762.png', 0, 0, 1, '2025-11-05 00:02:44', '2025-11-04 08:02:44'),
(87, 1, 'Highlighter Stabilo Yellow', 'HL-SY', 'Stabilo Highlighter for school use, Yellow variant', 203.00, 90, 'box', 0, 'prod_1762272256_1945.png', 0, 0, 1, '2025-11-05 00:04:16', '2025-11-04 08:04:16'),
(88, 1, 'Finetech 0.3 Black Ballpen', 'FT-B03', 'Finetech Ballpen, Black color, 0.3mm variant', 149.00, 90, 'box', 0, 'prod_1762272393_4477.png', 0, 0, 1, '2025-11-05 00:06:33', '2025-11-04 08:06:33'),
(89, 1, 'Finetech 0.4 Black Ballpen', 'FT-B04', 'Finetech Ballpen, Black color, 0.4mm variant', 149.00, 90, 'box', 0, 'prod_1762272528_8260.png', 0, 0, 1, '2025-11-05 00:08:48', '2025-11-04 08:08:48'),
(90, 1, 'Panda Ballpen Blue', 'PB-B', 'Panda Ballpen, Blue variant for school use.', 68.00, 90, 'box', 0, 'prod_1762272766_7976.png', 0, 0, 1, '2025-11-05 00:12:46', '2025-11-04 08:12:46'),
(91, 1, 'Panda Ballpen Red', 'PB-R', 'Panda Ballpen, Red variant, for school use.', 68.00, 80, 'box', 0, 'prod_1762272904_5518.png', 0, 0, 1, '2025-11-05 00:15:04', '2025-11-04 08:15:04'),
(92, 2, 'Pilot Marker Broad', 'PM-B', 'Pilot Marker, 1.0mm Broad tip size', 449.00, 70, 'box', 0, 'prod_1762273065_8471.png', 0, 0, 1, '2025-11-05 00:17:45', '2025-11-04 08:19:53'),
(93, 2, 'Pilot Marker Fine', 'PM-F', 'Pilot Marker, 0.5mm Fine tip size', 449.00, 90, 'box', 0, 'prod_1762273157_3279.png', 0, 0, 1, '2025-11-05 00:19:17', '2025-11-04 08:19:17'),
(94, 2, 'Whiteboard Marker Blue', 'WBM-B', 'Pilot Wyteboard Marker, Blue variant', 125.00, 70, 'box', 0, 'prod_1762273336_4700.png', 0, 0, 1, '2025-11-05 00:22:16', '2025-11-04 08:22:16'),
(95, 2, 'Whiteboard Marker Black', 'WBM-K', 'Pilot Wyteboard Marker, Black variant', 125.00, 90, 'box', 0, 'prod_1762273392_7453.png', 0, 0, 1, '2025-11-05 00:23:12', '2025-11-04 08:23:12'),
(96, 1, 'Plastic Fastener', 'PF-01', 'Fastener for folders, for school use.', 29.00, 110, 'box', 0, 'prod_1762273504_9063.png', 0, 0, 1, '2025-11-05 00:25:04', '2025-11-04 08:25:04'),
(97, 2, 'Push Pin', 'PP-01', 'Push Pin, board pin uses', 13.00, 80, 'pieces', 0, 'prod_1762273639_5378.png', 0, 0, 1, '2025-11-05 00:27:19', '2025-11-04 08:27:19'),
(98, 2, 'Rambo Paper Clip 33mm', 'RPC-33', 'Rambo Paper Clip Paper File Organizer, 33mm size variant', 91.00, 60, 'box', 0, 'prod_1762273733_1895.png', 0, 0, 1, '2025-11-05 00:28:53', '2025-11-04 08:28:53'),
(99, 2, 'Paper Clip #50', 'PC-50', 'Paper Clip File Organizer, #50 variant', 23.00, 50, 'box', 0, 'prod_1762273844_6962.png', 0, 0, 1, '2025-11-05 00:30:44', '2025-11-04 08:30:44'),
(100, 2, 'Stapler', 'ST-01', 'Regular Stapler', 34.00, 40, 'pieces', 0, 'prod_1762273900_7874.png', 0, 0, 1, '2025-11-05 00:31:40', '2025-11-04 08:31:40'),
(101, 2, 'Eveready Battery AA 4pcs', 'EB-AA4', 'Eveready Battery AA, ready to use for 3 years of shelf life. Zero added Mercury & Cadmium.', 234.00, 50, 'pieces', 0, 'prod_1762274151_7574.png', 0, 0, 1, '2025-11-05 00:35:51', '2025-11-04 08:35:51'),
(102, 2, '8 Digit Calculator', 'CAL-8', '8-digit Calculator for office purposes, item computations', 156.00, 70, 'pieces', 0, 'prod_1762274244_9984.png', 1, 0, 1, '2025-11-05 00:37:24', '2025-11-06 05:01:32'),
(103, 2, 'Hard Copy Bond Paper Short', 'HCB-S', 'Hard Copy Short (letter) sized bond paper for daily office demands.', 208.00, 90, 'reams', 0, 'prod_1762274354_9013.png', 0, 0, 1, '2025-11-05 00:39:14', '2025-11-04 08:41:41'),
(104, 2, 'Hard Copy Bond Paper Long', 'HCL-01', 'Hard Copy Long (legal) sized bond paper for daily office demands.', 233.00, 80, 'reams', 0, 'prod_1762274467_5356.png', 0, 0, 1, '2025-11-05 00:41:07', '2025-11-04 08:41:07'),
(105, 2, 'Memo Pad 3x3', 'MP-33', 'Memo Pad for efficient office organizations and productivity.', 62.00, 30, 'pads', 0, 'prod_1762274639_6160.png', 0, 0, 1, '2025-11-05 00:43:59', '2025-11-04 08:43:59'),
(106, 2, 'Colored Expanding Envelope Long', 'CE-L', 'Expanding Envelope File Organizer', 8.00, 70, 'pieces', 0, 'prod_1762274863_6418.png', 0, 0, 1, '2025-11-05 00:47:43', '2025-11-04 08:47:43'),
(107, 2, 'Colored Expanding Envelope Short', 'CE-S', 'Expanding Envelope File Organizer', 8.00, 70, 'pieces', 0, 'prod_1762274968_5780.png', 1, 0, 1, '2025-11-05 00:49:28', '2025-11-06 05:01:32'),
(108, 2, 'Colored Expanding Folder Long', 'CEF-L', 'Expanding Folder colored, long size variant', 17.00, 70, 'pieces', 0, 'prod_1762275123_4642.png', 0, 0, 1, '2025-11-05 00:52:03', '2025-11-04 08:52:03'),
(109, 2, 'Plastic Folder Jacket Long', 'PFJ-L', 'Plastic Folder Cover for Long sized folder.', 17.00, 59, 'pieces', 0, 'prod_1762275212_3500.png', 0, 0, 1, '2025-11-05 00:53:32', '2025-11-06 04:42:43'),
(110, 3, 'Garbage Bag L', 'GB-L', 'Large size Garbage Bag for large trash container.', 30.00, 60, 'rolls', 0, 'prod_1762275308_9865.png', 0, 0, 1, '2025-11-05 00:55:08', '2025-11-04 08:55:08'),
(111, 3, 'Garbage Bag M', 'GB-M', 'Medium size Garbage Bag, for medium sized trash containers.', 26.00, 26, 'rolls', 0, 'prod_1762275398_5304.png', 0, 0, 1, '2025-11-05 00:56:38', '2025-11-05 09:28:12'),
(112, 3, 'Garbage Bag XL', 'GB-XL', 'Extra Large size Garbage Bag, for larger containers.', 56.00, 50, 'rolls', 0, 'prod_1762275476_4375.png', 0, 0, 1, '2025-11-05 00:57:56', '2025-11-04 08:57:56'),
(113, 3, 'Garbage Bag XXL', 'GB-XXL', 'Double Extra Large Garbage Bag, for larger containers.', 77.00, 60, 'rolls', 0, 'prod_1762275553_4451.png', 0, 0, 1, '2025-11-05 00:59:13', '2025-11-04 08:59:13'),
(114, 3, 'Tissue Interfold', 'TI-01', 'Tissue Interfold for sanitary purposes.', 90.00, 49, 'pieces', 0, 'prod_1762275636_5200.png', 1, 0, 1, '2025-11-05 01:00:36', '2025-11-06 05:01:32'),
(115, 3, 'Hand Wash 1 Liter', 'HW-1L', 'Hand Wash, 1 Liter for refill.', 156.00, 77, 'pieces', 0, 'prod_1762275723_8960.png', 0, 0, 1, '2025-11-05 01:02:03', '2025-11-05 10:29:46'),
(116, 3, 'Air Freshener', 'AF-01', 'Glade Air Freshener for fresh smell at any area.', 59.00, 42, 'pieces', 0, 'prod_1762275823_4100.png', 0, 0, 1, '2025-11-05 01:03:43', '2025-11-06 04:42:43');

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `province_id` int(11) NOT NULL,
  `province_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`province_id`, `province_name`) VALUES
(1, 'Zambales');

-- --------------------------------------------------------

--
-- Table structure for table `request_attachments`
--

CREATE TABLE `request_attachments` (
  `attachment_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `original_filename` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_size` int(11) NOT NULL,
  `mime_type` varchar(100) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request_history`
--

CREATE TABLE `request_history` (
  `history_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `action_type` enum('created','status_changed','response_sent','customer_replied','assigned','escalated','archived') NOT NULL,
  `action_by` int(11) DEFAULT NULL,
  `action_by_type` enum('admin','customer','system') NOT NULL DEFAULT 'system',
  `old_value` text DEFAULT NULL,
  `new_value` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `request_history`
--

INSERT INTO `request_history` (`history_id`, `request_id`, `action_type`, `action_by`, `action_by_type`, `old_value`, `new_value`, `notes`, `created_at`) VALUES
(3, 2, 'response_sent', 1, 'admin', NULL, 'sdada', 'Response sent to customer via email', '2025-10-29 13:58:03'),
(4, 1, 'response_sent', 1, 'admin', NULL, 'adawd', 'Response sent to customer via email', '2025-10-29 13:58:11'),
(5, 1, 'response_sent', 1, 'admin', NULL, 'asda', 'Response sent to customer via email', '2025-10-29 13:58:14'),
(6, 2, 'response_sent', 1, 'admin', NULL, 'sige', 'Response sent to customer via email', '2025-10-29 14:03:46'),
(7, 2, 'response_sent', 1, 'admin', NULL, 'Dear Jeremiah Bert Deplomo,\n\nThank you for your order #. We have received your order and it is being processed.\n\nYour order details:\n\n\nEstimated delivery: \nDelivery address: \n\nYou can track your order status through our website using your order number.\n\nThank you for choosing M & E!\n\nBest regards,\nM & E Team', 'Response sent to customer via email', '2025-10-29 14:03:56'),
(8, 1, 'response_sent', 1, 'admin', NULL, 'pake ko', 'Response sent to customer via email', '2025-10-29 14:05:01'),
(13, 1, 'response_sent', 1, 'admin', NULL, 'Dear Jeremiah Bert Deplomo,\n\nWe sincerely apologize for the inconvenience you\'ve experienced with . We take all customer concerns seriously and will investigate this matter immediately.\n\nWe will:\n1. Make your next order free!\n2. Provide you with an update within \n\nYour satisfaction is our priority. We appreciate your patience as we work to resolve this issue.\n\nThank you for bringing this to our attention.\n\nBest regards,\nM & E Team', 'Response sent to customer via email', '2025-10-29 15:25:18'),
(14, 1, 'response_sent', 1, 'admin', NULL, 'Dear Jeremiah Bert Deplomo,\n\nWe sincerely apologize for the inconvenience you\'ve experienced with . We take all customer concerns seriously and will investigate this matter immediately.\n\nWe will:\n1. {{action_step_1}}\n2. {{action_step_2}}\n3. Provide you with an update within \n\nYour satisfaction is our priority. We appreciate your patience as we work to resolve this issue.\n\nThank you for bringing this to our attention.\n\nBest regards,\nM & E Team', 'Response sent to customer via email', '2025-10-29 15:27:07'),
(15, 1, 'response_sent', 1, 'admin', NULL, 'pake ko?', 'Response sent to customer via email', '2025-10-29 15:29:20'),
(16, 1, 'response_sent', 1, 'admin', NULL, 'Dear Jeremiah Bert Deplomo,\n\nWe sincerely apologize for the inconvenience you\'ve experienced with . We take all customer concerns seriously and will investigate this matter immediately.\n\nWe will:\n1. {{action_step_1}}\n2. {{action_step_2}}\n3. Provide you with an update within \n\nYour satisfaction is our priority. We appreciate your patience as we work to resolve this issue.\n\nThank you for bringing this to our attention.\n\nBest regards,\nM & E Team', 'Response sent to customer via email', '2025-10-30 05:27:38'),
(17, 1, 'response_sent', 1, 'admin', NULL, 'Dear Jeremiah Bert Deplomo,\n\nThank you for your custom order inquiry for . Based on your requirements, here\'s our detailed quote:\n\n\n\nTimeline: \nMinimum order quantity: \nUnit price: ₱\nTotal estimated cost: ₱\n\nPlease note that final pricing may vary based on exact specifications and quantities.\n\nWould you like to proceed with this quotation?\n\nBest regards,\nM & E Team', 'Response sent to customer via email', '2025-10-30 05:27:50'),
(21, 5, 'response_sent', 3, 'admin', NULL, 'Dear Jeremiah Bert Deplomo,\n\nWe sincerely apologize for the inconvenience you\'ve experienced with {{issue_description}}. We take all customer concerns seriously and will investigate this matter immediately.\n\nWe will:\n1. {{action_step_1}}\n2. {{action_step_2}}\n3. Provide you with an update within {{response_time}}\n\nYour satisfaction is our priority. We appreciate your patience as we work to resolve this issue.\n\nThank you for bringing this to our attention.\n\nBest regards,\nM & E Team', 'Response sent to customer via email', '2025-11-06 04:59:46');

-- --------------------------------------------------------

--
-- Table structure for table `response_templates`
--

CREATE TABLE `response_templates` (
  `template_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` enum('inquiry','orders','support','feedback','custom') NOT NULL DEFAULT 'inquiry',
  `subject` varchar(500) NOT NULL,
  `content` text NOT NULL,
  `notes` text DEFAULT NULL,
  `usage_count` int(11) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `response_templates`
--

INSERT INTO `response_templates` (`template_id`, `name`, `category`, `subject`, `content`, `notes`, `usage_count`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Product Availability', 'inquiry', 'RE: {{subject}}', 'Dear {{customer_name}},\n\nThank you for your inquiry about {{product_name}}. Yes, we have the quantity you need available in stock. For bulk orders of {{quantity}}+ pieces, we offer a {{discount}}% discount.\n\nHere are the details:\n- Regular price: ₱{{regular_price}} per pack\n- Bulk price: ₱{{bulk_price}} per pack\n- Total for {{pack_count}} packs: ₱{{total_price}}\n- Delivery to {{location}}: ₱{{delivery_fee}}\n\nWould you like to proceed with this order?\n\nBest regards,\nM & E Team', 'Use for product availability inquiries with bulk pricing', 1, NULL, '2025-10-28 17:10:26', '2025-11-06 04:54:33'),
(2, 'Order Confirmation', 'orders', 'Order Confirmation #{{order_id}}', 'Dear {{customer_name}},\n\nThank you for your order #{{order_id}}. We have received your order and it is being processed.\n\nYour order details:\n{{order_details}}\n\nEstimated delivery: {{delivery_date}}\nDelivery address: {{delivery_address}}\n\nYou can track your order status through our website using your order number.\n\nThank you for choosing M & E!\n\nBest regards,\nM & E Team', 'Order confirmation template', 1, NULL, '2025-10-28 17:10:26', '2025-10-29 14:03:52'),
(3, 'Complaint Resolution', 'support', 'RE: {{subject}}', 'Dear {{customer_name}},\n\nWe sincerely apologize for the inconvenience you\'ve experienced with {{issue_description}}. We take all customer concerns seriously and will investigate this matter immediately.\n\nWe will:\n1. {{action_step_1}}\n2. {{action_step_2}}\n3. Provide you with an update within {{response_time}}\n\nYour satisfaction is our priority. We appreciate your patience as we work to resolve this issue.\n\nThank you for bringing this to our attention.\n\nBest regards,\nM & E Team', 'Complaint handling template', 8, NULL, '2025-10-28 17:10:26', '2025-11-06 04:59:44'),
(4, 'Delivery Information', 'orders', 'Delivery Update - Order #{{order_id}}', 'Dear {{customer_name}},\n\nYour order #{{order_id}} has been shipped and is on its way to {{delivery_address}}.\n\nTracking Number: {{tracking_number}}\nEstimated Delivery: {{delivery_date}}\nCourier: {{courier_name}}\n\nYou can track your shipment using the tracking number provided.\n\nIf you have any questions, please don\'t hesitate to contact us.\n\nBest regards,\nM & E Team', 'Delivery tracking information', 4, NULL, '2025-10-28 17:10:26', '2025-10-30 05:27:25'),
(5, 'Thank You Response', 'feedback', 'Thank You for Your Feedback', 'Dear {{customer_name}},\n\nThank you so much for your positive feedback! We\'re delighted to hear that you\'re satisfied with {{product_service}}.\n\nCustomer satisfaction is our top priority, and reviews like yours motivate us to continue providing excellent service.\n\nWe look forward to serving you again!\n\nBest regards,\nM & E Team', 'Positive feedback acknowledgment', 1, NULL, '2025-10-28 17:10:26', '2025-10-29 13:58:56'),
(6, 'Custom Order Quote', 'custom', 'Custom Order Quotation - {{item_description}}', 'Dear {{customer_name}},\n\nThank you for your custom order inquiry for {{custom_item}}. Based on your requirements, here\'s our detailed quote:\n\n{{quote_details}}\n\nTimeline: {{delivery_timeline}}\nMinimum order quantity: {{min_quantity}}\nUnit price: ₱{{unit_price}}\nTotal estimated cost: ₱{{total_cost}}\n\nPlease note that final pricing may vary based on exact specifications and quantities.\n\nWould you like to proceed with this quotation?\n\nBest regards,\nM & E Team', 'Custom order quotation template', 6, NULL, '2025-10-28 17:10:26', '2025-10-30 05:27:47'),
(7, 'asdawd', 'inquiry', 'asdadwa', 'sdawdasd', 'asdawdad', 6, 1, '2025-10-29 12:39:32', '2025-10-29 14:24:45');

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shopping_cart`
--

INSERT INTO `shopping_cart` (`cart_id`, `user_id`, `product_id`, `quantity`, `added_at`) VALUES
(6, 111, 6, 2, '2025-10-02 04:47:17'),
(7, 111, 2, 2, '2025-10-02 05:02:33'),
(11, 111, 112, 5, '2025-11-05 06:30:47'),
(12, 111, 14, 5, '2025-11-05 06:34:18'),
(26, 118, 116, 1, '2025-11-05 11:38:23'),
(30, 118, 1, 3, '2025-11-05 16:07:07'),
(31, 118, 107, 6, '2025-11-06 04:42:16'),
(32, 100, 3, 1, '2025-11-06 05:01:06');

-- --------------------------------------------------------

--
-- Table structure for table `stock_movements`
--

CREATE TABLE `stock_movements` (
  `movement_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `movement_type` enum('add','remove','adjust','transfer') NOT NULL,
  `quantity` int(11) NOT NULL,
  `previous_stock` int(11) NOT NULL,
  `new_stock` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `user_name` varchar(100) NOT NULL DEFAULT 'Admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_movements`
--

INSERT INTO `stock_movements` (`movement_id`, `product_id`, `movement_type`, `quantity`, `previous_stock`, `new_stock`, `reason`, `user_name`, `created_at`) VALUES
(1, 6, 'remove', 20, 90, 70, 'expired products', 'Admin', '2025-10-28 03:24:33'),
(2, 6, '', 100, 70, 100, 'restock', 'Admin', '2025-10-28 03:25:20'),
(3, 6, 'remove', 80, 100, 20, 'expired', 'Admin', '2025-10-28 05:27:05'),
(4, 6, 'remove', 10, 20, 10, 'expired', 'Admin', '2025-10-28 05:27:20'),
(5, 7, 'add', 20, 60, 80, 'restock', 'Admin', '2025-10-28 05:48:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `gender` varchar(20) NOT NULL DEFAULT 'Prefer not to say',
  `date_of_birth` date DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `contact_number` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isActive` tinyint(1) NOT NULL,
  `verification_token` varchar(64) NOT NULL,
  `token_created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `profile_image` varchar(255) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `barangay_id` int(11) DEFAULT NULL,
  `reset_token` varchar(64) DEFAULT NULL,
  `forgot_token_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `first_name`, `middle_name`, `last_name`, `gender`, `date_of_birth`, `is_verified`, `contact_number`, `address`, `created_at`, `updated_at`, `isActive`, `verification_token`, `token_created_at`, `profile_image`, `province_id`, `city_id`, `barangay_id`, `reset_token`, `forgot_token_expires`) VALUES
(100, 'cjaygonzales', 'cjaygonzales1006@gmail.com', '$2y$10$EkFgxmD04s0tlKP.bmBbruTgMhDrKz2XXUZbWWZ/Na7Jio5f84ooW', 'C-jay', 'Bazar', 'Gonzales', 'Female', '2025-11-06', 1, '+639279754520', '759 lot 26 blk 4 Tupda Village', '2025-09-03 00:48:53', '2025-11-06 04:48:08', 1, '', '0000-00-00 00:00:00', 'user_100_1762346038.jpg', 1, 1, 5, 'd18bbb45039086123f7632324acceabff612a9cb2803c15867e6459e9dee887f', '2025-11-06 13:48:08'),
(111, 'jeremiah', 'jeremiahyee99@gmail.com', '$2y$10$JFq3x/2fEzDFzcnTrthlRev7SZZ2r4uafCo4QFF1auwG4T.pia3Vm', 'Jeremiah', 'Bert', 'Deplomo', 'Male', '0004-09-24', 1, '+639123456789', '8th ave purok dos', '2025-09-23 15:57:08', '2025-11-06 04:47:12', 1, '', '0000-00-00 00:00:00', NULL, 1, 1, 1, 'c5beb49ba7bed023a2672982579f1722dcf31f9a0c0c34d12201e84d9d18ff80', '2025-11-06 13:47:12'),
(118, NULL, 'ezratessalith@gmail.com', '$2y$10$/tvh0gzuFKs1uBudqyuSNuVryQINg43WcZbjazDC.5/ZGfBz6BHSK', 'Ezra', '', 'Tessalith', 'Prefer not to say', NULL, 1, '', '', '2025-11-05 19:30:34', '2025-11-05 11:31:03', 0, '', '0000-00-00 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `barangays`
--
ALTER TABLE `barangays`
  ADD PRIMARY KEY (`barangay_id`),
  ADD KEY `city_id` (`city_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`city_id`),
  ADD KEY `province_id` (`province_id`);

--
-- Indexes for table `customer_activity_log`
--
ALTER TABLE `customer_activity_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `idx_user_activity` (`user_id`,`created_at`),
  ADD KEY `idx_activity_type` (`activity_type`);

--
-- Indexes for table `customer_admin_settings`
--
ALTER TABLE `customer_admin_settings`
  ADD PRIMARY KEY (`setting_id`),
  ADD UNIQUE KEY `unique_user_setting` (`user_id`),
  ADD KEY `idx_customer_type` (`customer_type`),
  ADD KEY `idx_sales_rep` (`sales_rep_id`);

--
-- Indexes for table `customer_request`
--
ALTER TABLE `customer_request`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `fk_customer_request_user` (`user_id`),
  ADD KEY `fk_customer_request_admin` (`responded_by`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_priority` (`priority`),
  ADD KEY `idx_request_type` (`request_type`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `customer_request_archive`
--
ALTER TABLE `customer_request_archive`
  ADD PRIMARY KEY (`archive_id`),
  ADD KEY `idx_archived_at` (`archived_at`),
  ADD KEY `idx_archive_reason` (`archive_reason`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_code` (`product_code`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `idx_unit` (`unit`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`province_id`);

--
-- Indexes for table `request_attachments`
--
ALTER TABLE `request_attachments`
  ADD PRIMARY KEY (`attachment_id`),
  ADD KEY `idx_request_id` (`request_id`);

--
-- Indexes for table `request_history`
--
ALTER TABLE `request_history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `idx_request_id` (`request_id`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `response_templates`
--
ALTER TABLE `response_templates`
  ADD PRIMARY KEY (`template_id`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `idx_created_by` (`created_by`);

--
-- Indexes for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `fk_cart_user` (`user_id`),
  ADD KEY `fk_cart_product` (`product_id`);

--
-- Indexes for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD PRIMARY KEY (`movement_id`),
  ADD KEY `idx_product_id` (`product_id`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_movement_type` (`movement_type`),
  ADD KEY `idx_product_created` (`product_id`,`created_at`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD UNIQUE KEY `email_3` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `province_id` (`province_id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `barangay_id` (`barangay_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `barangays`
--
ALTER TABLE `barangays`
  MODIFY `barangay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customer_activity_log`
--
ALTER TABLE `customer_activity_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_admin_settings`
--
ALTER TABLE `customer_admin_settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer_request`
--
ALTER TABLE `customer_request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customer_request_archive`
--
ALTER TABLE `customer_request_archive`
  MODIFY `archive_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `province_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `request_attachments`
--
ALTER TABLE `request_attachments`
  MODIFY `attachment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_history`
--
ALTER TABLE `request_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `response_templates`
--
ALTER TABLE `response_templates`
  MODIFY `template_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `stock_movements`
--
ALTER TABLE `stock_movements`
  MODIFY `movement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barangays`
--
ALTER TABLE `barangays`
  ADD CONSTRAINT `barangays_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`);

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`province_id`);

--
-- Constraints for table `customer_activity_log`
--
ALTER TABLE `customer_activity_log`
  ADD CONSTRAINT `customer_activity_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_admin_settings`
--
ALTER TABLE `customer_admin_settings`
  ADD CONSTRAINT `customer_admin_settings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_request`
--
ALTER TABLE `customer_request`
  ADD CONSTRAINT `fk_customer_request_admin` FOREIGN KEY (`responded_by`) REFERENCES `admin_user` (`admin_id`),
  ADD CONSTRAINT `fk_customer_request_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `request_attachments`
--
ALTER TABLE `request_attachments`
  ADD CONSTRAINT `request_attachments_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `customer_request` (`request_id`) ON DELETE CASCADE;

--
-- Constraints for table `request_history`
--
ALTER TABLE `request_history`
  ADD CONSTRAINT `request_history_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `customer_request` (`request_id`) ON DELETE CASCADE;

--
-- Constraints for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD CONSTRAINT `fk_cart_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD CONSTRAINT `fk_stock_movements_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`province_id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`),
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`barangay_id`) REFERENCES `barangays` (`barangay_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
