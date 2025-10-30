-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2025 at 03:35 AM
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
-- Table structure for table `admin_user`
--

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
(1, 104, 'regular', 0.00, 0.00, 'immediate', NULL, 1, 0, 0, 0, 1, 0, 0.00, 0.00, NULL, '2025-10-27 06:26:54', '2025-10-27 06:26:54'),
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
  `user_seen_reply` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_request`
--

INSERT INTO `customer_request` (`request_id`, `user_id`, `request_type`, `subject`, `message`, `status`, `priority`, `admin_response`, `responded_by`, `created_at`, `responded_at`, `user_seen_reply`) VALUES
(2, 100, 'custom_order', 'Custom Order Request', 'Can you pack 2 boxes of RJ45', 'pending', 'medium', NULL, NULL, '2025-10-29 20:02:06', NULL, 1),
(3, 100, 'inquiry', 'Product Availability Inquiry', 'Do you sell Arduino Uno?', 'pending', 'medium', NULL, NULL, '2025-10-29 20:09:35', NULL, 1);

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
  `payment_method` enum('COD','Bank Transfer','GCash','Other') NOT NULL DEFAULT 'COD',
  `order_status` enum('Pending','Confirmed','Shipped','Delivered','Cancelled') NOT NULL DEFAULT 'Pending',
  `delivery_address` text NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `special_instructions` text DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `cod_token` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_number`, `total_amount`, `shipping_fee`, `final_amount`, `payment_method`, `order_status`, `delivery_address`, `contact_number`, `special_instructions`, `order_date`, `confirmed_at`, `delivered_at`, `admin_notes`, `cod_token`) VALUES
(1, 104, 'ORD-20250917094204', 2200.00, 75.00, 2275.00, 'COD', 'Delivered', 'Caloocan High School 10th ave', '09164485649', 'None', '2025-09-17 07:42:04', NULL, NULL, 'Testing checkout order', NULL),
(2, 100, 'ORD-20250921143558', 68.00, 75.00, 143.00, 'COD', 'Delivered', '759 lot 26 blk 4 Tupda Village', '09279754520', 'None', '2025-09-21 12:35:58', NULL, NULL, 'Testing checkout order', NULL),
(4, 111, 'ORD-251030-4a7', 357.00, 75.00, 432.00, 'COD', 'Shipped', '8th ave purok dos', '09123456789', '', '2025-10-29 18:47:44', NULL, NULL, 'Checkout created', NULL),
(5, 111, 'ORD-251030-63e', 1750.00, 75.00, 1825.00, 'COD', 'Pending', '8th ave purok dos', '09123456789', 'Palagay lang sa labas, wag ako videohan pag nakitang tulog nakahubad', '2025-10-29 19:32:24', NULL, NULL, 'Checkout created', NULL);

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
(1, 1, 6, 'Alcohol 70% Solution 500ml', 95.00, 20),
(2, 1, 4, 'Notebook Spiral 100 Pages', 60.00, 5),
(3, 2, 2, 'Ballpen Black', 12.00, 5),
(4, 2, 9, 'Eraser White', 8.00, 1),
(7, 4, 1, 'Bond Paper A4 80gsm', 250.00, 1),
(8, 4, 2, 'Ballpen Black', 12.00, 1),
(9, 4, 6, 'Alcohol 70% Solution 500ml', 95.00, 1),
(10, 5, 1, 'Bond Paper A4 80gsm', 250.00, 3),
(11, 5, 14, 'Kalapati', 200.00, 5);

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
  `min_stock_level` int(11) UNSIGNED DEFAULT 0,
  `product_image` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `is_top_order` tinyint(1) DEFAULT 0,
  `isActive` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `unit` varchar(50) NOT NULL DEFAULT 'piece'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `product_code`, `description`, `price`, `stock_quantity`, `min_stock_level`, `product_image`, `is_featured`, `is_top_order`, `isActive`, `created_at`, `updated_at`, `unit`) VALUES
(1, 1, 'Bond Paper A4 80gsm', 'BP-A480', 'High quality bond paper for school and office use', 250.00, 100, 20, 'bond_a4.jpg', 1, 1, 1, '2025-09-12 23:58:03', '2025-09-12 15:58:03', 'piece'),
(2, 1, 'Ballpen Black', 'BP-BLK01', 'Smooth writing ballpen with black ink', 12.00, 200, 50, 'ballpen_black.jpg', 1, 0, 1, '2025-09-12 23:58:03', '2025-09-12 15:58:03', 'piece'),
(3, 1, 'Yellow Pad Paper', 'YPP-01', 'Standard yellow pad paper, 80 sheets', 45.00, 150, 30, 'prod_1760709796_4759.jpg', 0, 0, 1, '2025-09-12 23:58:03', '2025-10-17 14:03:16', 'piece'),
(4, 2, 'Notebook Spiral 100 Pages', 'NB-SP100', 'Spiral notebook for note-taking', 60.00, 180, 40, 'notebook_spiral.jpg', 0, 1, 1, '2025-09-12 23:58:03', '2025-09-12 15:58:03', 'piece'),
(5, 2, 'Whiteboard Marker Blue', 'WM-BLU', 'Erasable blue whiteboard marker', 35.00, 120, 25, 'marker_blue.jpg', 0, 0, 1, '2025-09-12 23:58:03', '2025-09-12 15:58:03', 'piece'),
(6, 3, 'Alcohol 70% Solution 500ml', 'ALC-500', 'Sanitary alcohol for disinfection', 95.00, 12, 15, 'prod_1761624864_1201.jpg', 1, 1, 1, '2025-09-12 23:58:03', '2025-10-29 19:56:24', 'piece'),
(7, 3, 'Face Mask Box (50pcs)', 'FM-50', 'Disposable face masks for sanitary use', 120.00, 77, 10, 'facemask.jpg', 1, 0, 1, '2025-09-12 23:58:03', '2025-10-29 19:56:24', 'piece'),
(8, 1, 'Pencil No.2', 'PN-02', 'Standard HB pencil for writing and drawing', 10.00, 250, 60, 'pencil.jpg', 0, 0, 1, '2025-09-12 23:58:03', '2025-09-12 15:58:03', 'piece'),
(9, 2, 'Eraser White', 'ER-WHT', 'High quality eraser for clean erasing', 8.00, 300, 70, 'eraser.jpg', 0, 0, 1, '2025-09-12 23:58:03', '2025-09-12 15:58:03', 'piece'),
(10, 3, 'Hand Sanitizer 250ml', 'HS-250', 'Instant hand sanitizer gel', 75.00, 82, 15, 'handsanitizer.jpg', 1, 1, 1, '2025-09-12 23:58:03', '2025-10-29 19:56:24', 'piece'),
(14, 1, 'Kalapati', NULL, 'lumilipad na ibon', 200.00, 100, 0, 'prod_1761623578_6256.png', 0, 0, 0, '2025-10-28 11:52:58', '2025-10-29 19:59:40', 'piece');

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
(1, 'Product Availability', 'inquiry', 'RE: {{subject}}', 'Dear {{customer_name}},\n\nThank you for your inquiry about {{product_name}}. Yes, we have the quantity you need available in stock. For bulk orders of {{quantity}}+ pieces, we offer a {{discount}}% discount.\n\nHere are the details:\n- Regular price: ₱{{regular_price}} per pack\n- Bulk price: ₱{{bulk_price}} per pack\n- Total for {{pack_count}} packs: ₱{{total_price}}\n- Delivery to {{location}}: ₱{{delivery_fee}}\n\nWould you like to proceed with this order?\n\nBest regards,\nM & E Team', 'Use for product availability inquiries with bulk pricing', 0, NULL, '2025-10-28 17:10:26', '2025-10-28 17:10:26'),
(2, 'Order Confirmation', 'orders', 'Order Confirmation #{{order_id}}', 'Dear {{customer_name}},\n\nThank you for your order #{{order_id}}. We have received your order and it is being processed.\n\nYour order details:\n{{order_details}}\n\nEstimated delivery: {{delivery_date}}\nDelivery address: {{delivery_address}}\n\nYou can track your order status through our website using your order number.\n\nThank you for choosing M & E!\n\nBest regards,\nM & E Team', 'Order confirmation template', 0, NULL, '2025-10-28 17:10:26', '2025-10-28 17:10:26'),
(3, 'Complaint Resolution', 'support', 'RE: {{subject}}', 'Dear {{customer_name}},\n\nWe sincerely apologize for the inconvenience you\'ve experienced with {{issue_description}}. We take all customer concerns seriously and will investigate this matter immediately.\n\nWe will:\n1. {{action_step_1}}\n2. {{action_step_2}}\n3. Provide you with an update within {{response_time}}\n\nYour satisfaction is our priority. We appreciate your patience as we work to resolve this issue.\n\nThank you for bringing this to our attention.\n\nBest regards,\nM & E Team', 'Complaint handling template', 1, NULL, '2025-10-28 17:10:26', '2025-10-29 20:18:14'),
(4, 'Delivery Information', 'orders', 'Delivery Update - Order #{{order_id}}', 'Dear {{customer_name}},\n\nYour order #{{order_id}} has been shipped and is on its way to {{delivery_address}}.\n\nTracking Number: {{tracking_number}}\nEstimated Delivery: {{delivery_date}}\nCourier: {{courier_name}}\n\nYou can track your shipment using the tracking number provided.\n\nIf you have any questions, please don\'t hesitate to contact us.\n\nBest regards,\nM & E Team', 'Delivery tracking information', 0, NULL, '2025-10-28 17:10:26', '2025-10-28 17:10:26'),
(5, 'Thank You Response', 'feedback', 'Thank You for Your Feedback', 'Dear {{customer_name}},\n\nThank you so much for your positive feedback! We\'re delighted to hear that you\'re satisfied with {{product_service}}.\n\nCustomer satisfaction is our top priority, and reviews like yours motivate us to continue providing excellent service.\n\nWe look forward to serving you again!\n\nBest regards,\nM & E Team', 'Positive feedback acknowledgment', 0, NULL, '2025-10-28 17:10:26', '2025-10-28 17:10:26'),
(6, 'Custom Order Quote', 'custom', 'Custom Order Quotation - {{item_description}}', 'Dear {{customer_name}},\n\nThank you for your custom order inquiry for {{custom_item}}. Based on your requirements, here\'s our detailed quote:\n\n{{quote_details}}\n\nTimeline: {{delivery_timeline}}\nMinimum order quantity: {{min_quantity}}\nUnit price: ₱{{unit_price}}\nTotal estimated cost: ₱{{total_cost}}\n\nPlease note that final pricing may vary based on exact specifications and quantities.\n\nWould you like to proceed with this quotation?\n\nBest regards,\nM & E Team', 'Custom order quotation template', 3, NULL, '2025-10-28 17:10:26', '2025-10-30 02:26:51'),
(7, 'Crash out mechanics', 'support', 'Lakas mo eh no', 'Malakas ata tama mo {{customer_name}}\nPresyo: {{price}}', 'Testing lang', 9, 1, '2025-10-29 20:14:42', '2025-10-30 02:34:20');

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
(1, 100, 6, 12, '2025-09-21 12:40:16'),
(2, 100, 5, 10, '2025-09-21 12:40:16'),
(3, 100, 10, 15, '2025-09-21 13:21:41'),
(4, 100, 3, 20, '2025-09-21 13:32:33'),
(8, 104, 1, 1, '2025-10-02 05:15:11');

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
(5, 7, 'add', 20, 60, 80, 'restock', 'Admin', '2025-10-28 05:48:58'),
(6, 6, 'add', 20, 10, 30, 'Restock request - high priority', 'Admin', '2025-10-29 19:47:37'),
(7, 6, '', 10, 30, 10, 'restock', 'Admin', '2025-10-29 19:48:21'),
(8, 6, 'add', 3, 10, 13, 'recount - Testing', 'Admin', '2025-10-29 19:48:46'),
(9, 6, 'add', 0, 13, 13, 'Bulk increase by 2%', 'Admin', '2025-10-29 19:54:08'),
(10, 7, 'add', 2, 80, 82, 'Bulk increase by 2%', 'Admin', '2025-10-29 19:54:08'),
(11, 10, 'add', 2, 85, 87, 'Bulk increase by 2%', 'Admin', '2025-10-29 19:54:08'),
(12, 6, 'add', 0, 13, 13, 'Bulk increase by 3%', 'Admin', '2025-10-29 19:54:50'),
(13, 7, 'add', 2, 82, 84, 'Bulk increase by 3%', 'Admin', '2025-10-29 19:54:50'),
(14, 10, 'add', 3, 87, 90, 'Bulk increase by 3%', 'Admin', '2025-10-29 19:54:50'),
(15, 6, 'add', 1, 13, 14, 'Bulk increase by 5%', 'Admin', '2025-10-29 19:55:25'),
(16, 7, 'add', 4, 84, 88, 'Bulk increase by 5%', 'Admin', '2025-10-29 19:55:25'),
(17, 10, 'add', 5, 90, 95, 'Bulk increase by 5%', 'Admin', '2025-10-29 19:55:25'),
(18, 6, 'add', 0, 14, 14, 'Bulk increase by 2%', 'Admin', '2025-10-29 19:55:55'),
(19, 7, 'add', 2, 88, 90, 'Bulk increase by 2%', 'Admin', '2025-10-29 19:55:55'),
(20, 10, 'add', 2, 95, 97, 'Bulk increase by 2%', 'Admin', '2025-10-29 19:55:55'),
(21, 6, 'remove', 2, 14, 12, 'Bulk decrease by 15%', 'Admin', '2025-10-29 19:56:24'),
(22, 7, 'remove', 13, 90, 77, 'Bulk decrease by 15%', 'Admin', '2025-10-29 19:56:24'),
(23, 10, 'remove', 15, 97, 82, 'Bulk decrease by 15%', 'Admin', '2025-10-29 19:56:24');

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
  `barangay_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `first_name`, `middle_name`, `last_name`, `gender`, `date_of_birth`, `is_verified`, `contact_number`, `address`, `created_at`, `updated_at`, `isActive`, `verification_token`, `token_created_at`, `profile_image`, `province_id`, `city_id`, `barangay_id`) VALUES
(100, 'cjaygonzales', 'cjaygonzales1006@gmail.com', '$2y$10$EkFgxmD04s0tlKP.bmBbruTgMhDrKz2XXUZbWWZ/Na7Jio5f84ooW', 'C-jay', 'Bazar', 'Gonzales', 'Female', '2003-10-06', 1, '+639279754520', '759 lot 26 blk 4 Tupda Village', '2025-09-03 00:48:53', '2025-09-24 09:49:42', 1, '', '0000-00-00 00:00:00', 'user_100_1757265993.jpg', 1, 1, 5),
(104, 'ezratess', 'ezratessalith@gmail.com', '$2y$10$BEAFEB.x93H4ATKg.2.5teNrLpCFHGAdEFVGO/ez1oSHT0X8A42aG', 'Ezra', '', 'Tessalith', 'Prefer not to say', NULL, 1, '09164485649', 'Caloocan High School 10th ave', '2025-09-04 00:43:41', '2025-09-07 11:51:54', 1, '', '0000-00-00 00:00:00', '', NULL, NULL, NULL),
(111, 'jeremiah', 'jeremiahyee99@gmail.com', '$2y$10$TTv6/Vv9D5DICJ0vx9hXHuoZ.ZEHxnaOEp9oX8KqNJqF/h2GhgvBy', 'Jeremiah', 'Bert', 'Deplomo', 'Male', '0004-09-24', 1, '09123456789', '8th ave purok dos', '2025-09-23 15:57:08', '2025-09-24 08:17:34', 1, '', '0000-00-00 00:00:00', NULL, 1, 1, 1);

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
  ADD KEY `category_id` (`category_id`);

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
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer_request_archive`
--
ALTER TABLE `customer_request_archive`
  MODIFY `archive_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `response_templates`
--
ALTER TABLE `response_templates`
  MODIFY `template_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `stock_movements`
--
ALTER TABLE `stock_movements`
  MODIFY `movement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

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
