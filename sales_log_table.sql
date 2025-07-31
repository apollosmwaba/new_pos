CREATE TABLE IF NOT EXISTS `sales_log` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `sale_time` DATETIME NOT NULL,
  `total_amount` DECIMAL(10,2) NOT NULL,
  `details` TEXT,
  PRIMARY KEY (`id`)
);
