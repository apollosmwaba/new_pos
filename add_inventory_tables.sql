-- Add inventory tables from Point of Sale 2 to Point of Sale 1

-- Create suppliers table
CREATE TABLE IF NOT EXISTS suppliers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    contact_info TEXT,
    address TEXT,
    phone VARCHAR(50),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create inventory table
CREATE TABLE IF NOT EXISTS inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT(11) NOT NULL,
    quantity INT(11) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Create stock_movements table
CREATE TABLE IF NOT EXISTS stock_movements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT(11) NOT NULL,
    user_id INT(11) NOT NULL,
    type ENUM('in', 'out') NOT NULL,
    quantity INT(11) NOT NULL,
    reason VARCHAR(255),
    supplier_id INT(11) DEFAULT NULL,
    cost DECIMAL(10,2) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE SET NULL
);

-- Add new columns to products table (if they don't exist)
ALTER TABLE products ADD COLUMN IF NOT EXISTS sku VARCHAR(100) DEFAULT NULL AFTER barcode;
ALTER TABLE products ADD COLUMN IF NOT EXISTS category VARCHAR(100) DEFAULT NULL AFTER sku;
ALTER TABLE products ADD COLUMN IF NOT EXISTS supplier_id INT(11) DEFAULT NULL AFTER category;
ALTER TABLE products ADD COLUMN IF NOT EXISTS min_stock INT(11) DEFAULT 0 AFTER supplier_id;
ALTER TABLE products ADD COLUMN IF NOT EXISTS cost_price DECIMAL(10,2) DEFAULT 0.00 AFTER min_stock;
ALTER TABLE products ADD COLUMN IF NOT EXISTS selling_price DECIMAL(10,2) DEFAULT 0.00 AFTER cost_price;
ALTER TABLE products ADD COLUMN IF NOT EXISTS created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER selling_price;
ALTER TABLE products ADD COLUMN IF NOT EXISTS updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER created_at;

-- Add discount fields to products table
ALTER TABLE products 
ADD COLUMN discount_type VARCHAR(20) DEFAULT NULL,
ADD COLUMN discount_value DECIMAL(10,2) DEFAULT 0,
ADD COLUMN promo_text VARCHAR(255) DEFAULT NULL;

-- Add indexes for better performance
ALTER TABLE products ADD INDEX IF NOT EXISTS idx_sku (sku);
ALTER TABLE products ADD INDEX IF NOT EXISTS idx_category (category);
ALTER TABLE products ADD INDEX IF NOT EXISTS idx_supplier_id (supplier_id);
ALTER TABLE inventory ADD INDEX IF NOT EXISTS idx_product_id (product_id);
ALTER TABLE stock_movements ADD INDEX IF NOT EXISTS idx_product_id (product_id);
ALTER TABLE stock_movements ADD INDEX IF NOT EXISTS idx_user_id (user_id);
ALTER TABLE stock_movements ADD INDEX IF NOT EXISTS idx_created_at (created_at); 

-- Session Log Table
CREATE TABLE IF NOT EXISTS session_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    role VARCHAR(50) NOT NULL,
    login_time DATETIME NOT NULL,
    logout_time DATETIME,
    session_duration INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Sales Log Table
CREATE TABLE IF NOT EXISTS sales_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    sale_time DATETIME NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    details TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Audit Log Table
CREATE TABLE IF NOT EXISTS audit_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    action_type ENUM('cancel', 'refund', 'void', 'discount', 'other') NOT NULL,
    action_time DATETIME NOT NULL,
    description TEXT,
    related_sale_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (related_sale_id) REFERENCES sales_log(id)
); 