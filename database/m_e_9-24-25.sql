-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2025 at 12:27 PM
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
-- Database: `m&e`
--

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
  `admin_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_number`, `total_amount`, `shipping_fee`, `final_amount`, `payment_method`, `order_status`, `delivery_address`, `contact_number`, `special_instructions`, `order_date`, `confirmed_at`, `delivered_at`, `admin_notes`) VALUES
(1, 104, 'ORD-20250917094204', 2200.00, 75.00, 2275.00, 'COD', 'Pending', 'Caloocan High School 10th ave', '09164485649', 'None', '2025-09-17 07:42:04', NULL, NULL, 'Testing checkout order'),
(2, 100, 'ORD-20250921143558', 68.00, 75.00, 143.00, 'COD', 'Pending', '759 lot 26 blk 4 Tupda Village', '09279754520', 'None', '2025-09-21 12:35:58', NULL, NULL, 'Testing checkout order');

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
(4, 2, 9, 'Eraser White', 8.00, 1);

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `product_code`, `description`, `price`, `stock_quantity`, `min_stock_level`, `product_image`, `is_featured`, `is_top_order`, `isActive`, `created_at`, `updated_at`) VALUES
(1, 1, 'Bond Paper A4 80gsm', 'BP-A480', 'High quality bond paper for school and office use', 250.00, 100, 20, 'bond_a4.jpg', 1, 1, 1, '2025-09-12 23:58:03', '2025-09-12 15:58:03'),
(2, 1, 'Ballpen Black', 'BP-BLK01', 'Smooth writing ballpen with black ink', 12.00, 200, 50, 'ballpen_black.jpg', 1, 0, 1, '2025-09-12 23:58:03', '2025-09-12 15:58:03'),
(3, 1, 'Yellow Pad Paper', 'YPP-01', 'Standard yellow pad paper, 80 sheets', 45.00, 150, 30, 'yellowpad.jpg', 0, 0, 1, '2025-09-12 23:58:03', '2025-09-12 15:58:03'),
(4, 2, 'Notebook Spiral 100 Pages', 'NB-SP100', 'Spiral notebook for note-taking', 60.00, 180, 40, 'notebook_spiral.jpg', 0, 1, 1, '2025-09-12 23:58:03', '2025-09-12 15:58:03'),
(5, 2, 'Whiteboard Marker Blue', 'WM-BLU', 'Erasable blue whiteboard marker', 35.00, 120, 25, 'marker_blue.jpg', 0, 0, 1, '2025-09-12 23:58:03', '2025-09-12 15:58:03'),
(6, 3, 'Alcohol 70% Solution 500ml', 'ALC-500', 'Sanitary alcohol for disinfection', 95.00, 90, 15, 'alcohol500.jpg', 1, 1, 1, '2025-09-12 23:58:03', '2025-09-12 15:58:03'),
(7, 3, 'Face Mask Box (50pcs)', 'FM-50', 'Disposable face masks for sanitary use', 120.00, 60, 10, 'facemask.jpg', 1, 0, 1, '2025-09-12 23:58:03', '2025-09-12 15:58:03'),
(8, 1, 'Pencil No.2', 'PN-02', 'Standard HB pencil for writing and drawing', 10.00, 250, 60, 'pencil.jpg', 0, 0, 1, '2025-09-12 23:58:03', '2025-09-12 15:58:03'),
(9, 2, 'Eraser White', 'ER-WHT', 'High quality eraser for clean erasing', 8.00, 300, 70, 'eraser.jpg', 0, 0, 1, '2025-09-12 23:58:03', '2025-09-12 15:58:03'),
(10, 3, 'Hand Sanitizer 250ml', 'HS-250', 'Instant hand sanitizer gel', 75.00, 85, 15, 'handsanitizer.jpg', 1, 1, 1, '2025-09-12 23:58:03', '2025-09-12 15:58:03');

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
(4, 100, 3, 20, '2025-09-21 13:32:33');

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
-- Indexes for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `fk_cart_user` (`user_id`),
  ADD KEY `fk_cart_product` (`product_id`);

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
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `province_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

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
-- Constraints for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD CONSTRAINT `fk_cart_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

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
