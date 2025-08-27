-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2025 at 10:21 AM
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
-- Database: `practicedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `users` varchar(25) NOT NULL,
  `password` char(255) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `users`, `password`, `reg_date`) VALUES
(3, 'Megamind', 'megamindisgenius', '2025-08-20 15:34:34'),
(4, 'mobpsycho100', 'mobmob1006', '2025-08-20 15:45:48'),
(5, 'cjaygonzales', '$2y$10$y6RHUqaBIuDZpMAYpKOA3ee9p3DW3g8A23YkRpsBBBeUkLXURHU82', '2025-08-20 16:08:16'),
(6, 'mobytesting', '$2y$10$EyrdUdcwUGBzH8Mp4NJv5OnawVULWKzR5kshQdjQw.HUT/40UyzE.', '2025-08-20 16:09:24'),
(7, 'gillianpogi', '$2y$10$qkvGE2gQl58ccOqGqhZohuivcer0J8ilttnYxnp6c2HQ684E.P9q.', '2025-08-20 19:39:51'),
(13, 'joshualapitan', '$2y$10$iTk8yNRmDFyCR.8HFwxmqOsf0MBUQNiwLEYnlEn8WnWajesZUagM2', '2025-08-20 20:18:48'),
(15, 'ivanmejorada', '$2y$10$Fdv/ZmxQskPkwXlhwGDg5uky7funo/k7y2fYlsDrpj3fSJPbhB.NG', '2025-08-20 20:20:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users` (`users`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
