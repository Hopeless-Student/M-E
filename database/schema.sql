-- M & E Interior Supplies Trading Database Schema
-- University of Caloocan City - Computer Studies Department
-- Project: Web Development for M & E Interior Supplies Trading

-- Create database
CREATE DATABASE me_interior_supplies;
USE me_interior_supplies;

-- Table: USERS (Customer accounts)
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    contact_number VARCHAR(20),
    address TEXT,
    city VARCHAR(50),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table: ADMIN_USERS (Administrative accounts)
CREATE TABLE admin_users (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    role ENUM('admin', 'manager', 'staff') DEFAULT 'staff',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_by INT,
    FOREIGN KEY (created_by) REFERENCES admin_users(admin_id)
);

-- Table: CATEGORIES (Product categories)
CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL,
    category_slug VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: PRODUCTS (Product catalog)
CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    product_name VARCHAR(200) NOT NULL,
    product_code VARCHAR(50) UNIQUE,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock_quantity INT DEFAULT 0,
    min_stock_level INT DEFAULT 0,
    product_image VARCHAR(255),
    is_featured BOOLEAN DEFAULT FALSE,
    is_top_order BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(category_id)
);

-- Table: SHOPPING_CART (Temporary cart storage)
CREATE TABLE shopping_cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_product (user_id, product_id)
);

-- Table: ORDERS (Customer orders)
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    shipping_fee DECIMAL(10,2) DEFAULT 70.00,
    final_amount DECIMAL(10,2) NOT NULL,
    payment_method ENUM('cod', 'cash_on_delivery') DEFAULT 'cod',
    order_status ENUM('pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    delivery_address TEXT NOT NULL,
    contact_number VARCHAR(20) NOT NULL,
    special_instructions TEXT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    confirmed_at TIMESTAMP NULL,
    delivered_at TIMESTAMP NULL,
    admin_notes TEXT,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Table: ORDER_ITEMS (Items within each order)
CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    product_name VARCHAR(200) NOT NULL, -- Store product name at time of order
    product_price DECIMAL(10,2) NOT NULL, -- Store price at time of order
    quantity INT NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- Table: CUSTOMER_REQUESTS (Custom orders and inquiries)
CREATE TABLE customer_requests (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    request_type ENUM('custom_order', 'inquiry', 'complaint', 'feedback') NOT NULL,
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('pending', 'in_progress', 'responded', 'closed') DEFAULT 'pending',
    priority ENUM('low', 'medium', 'high', 'urgent') DEFAULT 'medium',
    admin_response TEXT,
    responded_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    responded_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (responded_by) REFERENCES admin_users(admin_id)
);

-- Table: INVENTORY_MOVEMENTS (Stock tracking)
CREATE TABLE inventory_movements (
    movement_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    movement_type ENUM('in', 'out', 'adjustment', 'return') NOT NULL,
    quantity_change INT NOT NULL, -- Positive for additions, negative for subtractions
    previous_stock INT NOT NULL,
    new_stock INT NOT NULL,
    reference_type ENUM('purchase', 'sale', 'adjustment', 'return', 'initial') NOT NULL,
    reference_id INT, -- Could reference order_id or other relevant IDs
    notes TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (created_by) REFERENCES admin_users(admin_id)
);

-- Table: SYSTEM_SETTINGS (Application configuration)
CREATE TABLE system_settings (
    setting_id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    setting_description TEXT,
    updated_by INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (updated_by) REFERENCES admin_users(admin_id)
);

-- Insert default categories
INSERT INTO categories (category_name, category_slug, description) VALUES
('School Supplies', 'school-supplies', 'Educational materials and school essentials'),
('Office Supplies', 'office-supplies', 'Professional office equipment and materials'),
('Sanitary Supplies', 'sanitary-supplies', 'Cleaning and hygiene products');

-- Insert default admin user (password should be hashed in real implementation)
INSERT INTO admin_users (username, email, password_hash, first_name, last_name, role) VALUES
('admin', 'admin@meinterior.com', '$2y$10$example_hashed_password', 'System', 'Administrator', 'admin');

-- Insert default system settings
INSERT INTO system_settings (setting_key, setting_value, setting_description) VALUES
('site_name', 'M & E Interior Supplies Trading', 'Website name'),
('contact_email', 'info@meinterior.com', 'Primary contact email'),
('contact_phone', '+63-XXX-XXX-XXXX', 'Primary contact phone'),
('delivery_fee_olongapo', '70.00', 'Standard delivery fee for Olongapo area'),
('delivery_fee_extended', '100.00', 'Extended delivery fee for farther areas'),
('business_address', 'Olongapo City, Philippines', 'Business address'),
('order_prefix', 'ME', 'Order number prefix'),
('min_order_amount', '500.00', 'Minimum order amount'),
('featured_products_limit', '6', 'Number of featured products to display'),
('top_products_limit', '8', 'Number of top products to display on homepage');

-- Create indexes for better performance
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_active ON users(is_active);
CREATE INDEX idx_products_category ON products(category_id);
CREATE INDEX idx_products_active ON products(is_active);
CREATE INDEX idx_products_featured ON products(is_featured);
CREATE INDEX idx_products_top_order ON products(is_top_order);
CREATE INDEX idx_orders_user ON orders(user_id);
CREATE INDEX idx_orders_status ON orders(order_status);
CREATE INDEX idx_orders_date ON orders(order_date);
CREATE INDEX idx_cart_user ON shopping_cart(user_id);
CREATE INDEX idx_requests_user ON customer_requests(user_id);
CREATE INDEX idx_requests_status ON customer_requests(status);
CREATE INDEX idx_inventory_product ON inventory_movements(product_id);

-- Create triggers for inventory management
DELIMITER //

-- Trigger to update product stock when order is confirmed
CREATE TRIGGER update_stock_on_order_confirm
AFTER UPDATE ON orders
FOR EACH ROW
BEGIN
    IF NEW.order_status = 'confirmed' AND OLD.order_status = 'pending' THEN
        -- Decrease stock for all items in the order
        UPDATE products p
        INNER JOIN order_items oi ON p.product_id = oi.product_id
        SET p.stock_quantity = p.stock_quantity - oi.quantity
        WHERE oi.order_id = NEW.order_id;

        -- Log inventory movements
        INSERT INTO inventory_movements (product_id, movement_type, quantity_change, previous_stock, new_stock, reference_type, reference_id, notes)
        SELECT
            p.product_id,
            'out',
            -oi.quantity,
            p.stock_quantity + oi.quantity,
            p.stock_quantity,
            'sale',
            NEW.order_id,
            CONCAT('Order confirmed: ', NEW.order_number)
        FROM products p
        INNER JOIN order_items oi ON p.product_id = oi.product_id
        WHERE oi.order_id = NEW.order_id;
    END IF;
END//

-- Trigger to log inventory changes when stock is manually updated
CREATE TRIGGER log_manual_stock_update
AFTER UPDATE ON products
FOR EACH ROW
BEGIN
    IF NEW.stock_quantity != OLD.stock_quantity THEN
        INSERT INTO inventory_movements (
            product_id,
            movement_type,
            quantity_change,
            previous_stock,
            new_stock,
            reference_type,
            notes
        ) VALUES (
            NEW.product_id,
            CASE
                WHEN NEW.stock_quantity > OLD.stock_quantity THEN 'in'
                ELSE 'out'
            END,
            NEW.stock_quantity - OLD.stock_quantity,
            OLD.stock_quantity,
            NEW.stock_quantity,
            'adjustment',
            'Manual stock adjustment'
        );
    END IF;
END//

DELIMITER ;

-- Sample data for testing (optional)
-- Insert sample products
INSERT INTO products (category_id, product_name, product_code, description, price, stock_quantity, is_featured) VALUES
(1, 'Ballpen Set (12 pieces)', 'SCH-BP-001', 'High-quality ballpen set for students', 150.00, 50, TRUE),
(1, 'Notebook A4 Ruled', 'SCH-NB-001', '100-page ruled notebook for school use', 45.00, 100, FALSE),
(1, 'Pencil Case', 'SCH-PC-001', 'Durable pencil case with multiple compartments', 120.00, 30, TRUE),
(2, 'Manila Folders (50 pieces)', 'OFF-MF-001', 'Standard manila folders for office filing', 250.00, 25, FALSE),
(2, 'Stapler Heavy Duty', 'OFF-ST-001', 'Heavy duty stapler for office use', 450.00, 15, TRUE),
(2, 'Bond Paper A4 (500 sheets)', 'OFF-BP-001', 'Premium white bond paper', 320.00, 40, FALSE),
(3, 'Toilet Paper 12 Rolls', 'SAN-TP-001', 'Soft toilet paper 12-roll pack', 180.00, 60, FALSE),
(3, 'Hand Sanitizer 500ml', 'SAN-HS-001', 'Alcohol-based hand sanitizer', 85.00, 80, TRUE),
(3, 'Dishwashing Liquid 1L', 'SAN-DL-001', 'Concentrated dishwashing liquid', 95.00, 45, FALSE);

-- Show database structure
SHOW TABLES;
