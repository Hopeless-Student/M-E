-- Add backup_logs table for settings module
-- Run this in phpMyAdmin to enable backup logging

USE m_e;

CREATE TABLE IF NOT EXISTS `backup_logs` (
  `backup_id` int(11) NOT NULL AUTO_INCREMENT,
  `backup_file` varchar(255) NOT NULL,
  `backup_size` bigint(20) DEFAULT NULL,
  `backup_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('success','failed') DEFAULT 'success',
  `error_message` text,
  PRIMARY KEY (`backup_id`),
  KEY `idx_backup_date` (`backup_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
