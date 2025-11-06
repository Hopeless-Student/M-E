-- Create system_settings table
CREATE TABLE IF NOT EXISTS `system_settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_category` varchar(50) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text,
  `setting_type` enum('string','number','boolean','json') DEFAULT 'string',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`setting_id`),
  UNIQUE KEY `unique_setting` (`setting_category`,`setting_key`),
  KEY `idx_category` (`setting_category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default settings
INSERT INTO `system_settings` (`setting_category`, `setting_key`, `setting_value`, `setting_type`) VALUES
-- Business Info
('business', 'business_name', 'M & E Interior Supplies Trading', 'string'),
('business', 'contact_email', 'info@me-supplies.com', 'string'),
('business', 'contact_phone', '+63 47 222 3456', 'string'),
('business', 'business_address', '123 Rizal Avenue, Olongapo City, Zambales, Philippines', 'string'),
('business', 'business_description', 'Your trusted supplier for office, school, and sanitary supplies in Olongapo City. We provide quality products with fast and reliable delivery service.', 'string'),

-- Shipping & Delivery
('shipping', 'primary_delivery_area', 'Olongapo City, Zambales', 'string'),
('shipping', 'standard_delivery_fee', '70', 'number'),
('shipping', 'extended_area_fee', '100', 'number'),
('shipping', 'processing_time_hours', '24', 'number'),
('shipping', 'delivery_time_hours', '48', 'number'),
('shipping', 'auto_confirm_orders', '1', 'boolean'),

-- Notifications
('notifications', 'email_new_orders', '1', 'boolean'),
('notifications', 'email_low_stock', '1', 'boolean'),
('notifications', 'email_new_messages', '1', 'boolean'),
('notifications', 'system_order_updates', '0', 'boolean'),
('notifications', 'system_daily_reports', '1', 'boolean'),

-- Security
('security', 'session_timeout_minutes', '60', 'number'),
('security', 'allow_remember_me', '0', 'boolean'),
('security', 'encrypt_customer_data', '1', 'boolean'),
('security', 'log_admin_activities', '1', 'boolean'),

-- Backup
('backup', 'auto_backup_frequency', 'daily', 'string'),
('backup', 'last_backup_date', NULL, 'string');

-- Create backup_logs table
CREATE TABLE IF NOT EXISTS `backup_logs` (
  `backup_id` int(11) NOT NULL AUTO_INCREMENT,
  `backup_file` varchar(255) NOT NULL,
  `backup_size` bigint(20) DEFAULT NULL,
  `backup_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('success','failed') DEFAULT 'success',
  `error_message` text,
  PRIMARY KEY (`backup_id`),
  KEY `idx_backup_date` (`backup_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
