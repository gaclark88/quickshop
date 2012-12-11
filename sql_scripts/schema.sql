-- Quickshop database schema initialization script
-- Run this script using the database you wish to store
--   your shop's inventory and user account information
--
-- --------------------------------------------------------

-- 
-- Table structure for table `accounts`
-- 

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(750) NOT NULL COMMENT 'customers first name',
  `last_name` varchar(750) NOT NULL COMMENT 'customers first name',
  `shipping_address` varchar(750) DEFAULT NULL COMMENT 'defualt shipping address',
  `shipping_city` varchar(500) DEFAULT NULL COMMENT 'defualt shipping address',
  `shipping_zip` int(5) DEFAULT NULL COMMENT 'defualt shipping address',
  `phone` varchar(10) DEFAULT NULL,
  `email` varchar(100) NOT NULL COMMENT 'email will be used for login',
  `password` varchar(500) NOT NULL,
  `billing_address` varchar(750) DEFAULT NULL COMMENT 'default billing address',
  `billing_city` varchar(750) DEFAULT NULL COMMENT 'default billing address',
  `billing_zip` int(5) DEFAULT NULL COMMENT 'default billing address',
  `billing_state` varchar(2) DEFAULT NULL COMMENT 'default billing address',
  `shipping_state` varchar(2) DEFAULT NULL COMMENT 'default shipping address',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='customer accounts';

-- --------------------------------------------------------

-- 
-- Table structure for table `admins`
-- 

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `email` varchar(512) NOT NULL COMMENT 'users email / login',
  `password` varchar(512) NOT NULL COMMENT 'users hashed password',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- Insert an admin account
INSERT INTO `admins` (email, password) VALUES("admin1", "$1$RTgw0BFl$rDLq1E25wjwPEnZQTxkL11");

-- --------------------------------------------------------

-- 
-- Table structure for table `cart_items`
-- 

DROP TABLE IF EXISTS `cart_items`;
CREATE TABLE IF NOT EXISTS `cart_items` (
  `product_id` int(11) NOT NULL COMMENT 'the product in the cart',
  `account_id` varchar(1024) NOT NULL COMMENT 'the customer who''s cart it is',
  `amount` int(11) NOT NULL COMMENT 'the number of unit of this product in the cart',
  KEY `fk_cart_items_products1` (`product_id`),
  KEY `fk_cart_items_accounts1` (`account_id`(333))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `categories`
-- 

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL COMMENT 'the name of the category',
  `parent_id` int(11) DEFAULT NULL COMMENT 'a foriegn id to the categories table.  This points to this categories super category.',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='product categories and sub categories';

-- --------------------------------------------------------

-- 
-- Table structure for table `images`
-- 

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(512) NOT NULL,
  `mime_type` varchar(256) NOT NULL,
  `size` int(11) NOT NULL,
  `file_data` longblob NOT NULL,
  `product_id` int(11) DEFAULT NULL COMMENT 'the associated product',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='images for products';

-- --------------------------------------------------------

-- 
-- Table structure for table `order_products`
-- 

DROP TABLE IF EXISTS `order_products`;
CREATE TABLE IF NOT EXISTS `order_products` (
  `order_id` int(11) NOT NULL COMMENT 'the associated order',
  `product_id` int(11) NOT NULL COMMENT 'the associated product',
  `amount` int(11) NOT NULL COMMENT 'the number of units of this product ordered',
  KEY `fk_order_products_orders1` (`order_id`),
  KEY `fk_order_products_products1` (`product_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Join table to link products with an order.';

-- --------------------------------------------------------

-- 
-- Table structure for table `order_status`
-- 

DROP TABLE IF EXISTS `order_status`;
CREATE TABLE IF NOT EXISTS `order_status` (
  `id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `orders`
-- 

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` varchar(1024) DEFAULT NULL COMMENT 'the associated account',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'the date and time the order was created',
  `shipping_address` varchar(750) NOT NULL COMMENT 'the address to which the order was shipped',
  `shipping_city` varchar(750) NOT NULL COMMENT 'associated',
  `shipping_zip` int(5) NOT NULL COMMENT 'associated',
  `shipping_state` varchar(2) NOT NULL COMMENT 'associated',
  `credit_num` varchar(16) NOT NULL COMMENT 'credit card number',
  `credit_sec` int(3) NOT NULL COMMENT 'credit card security code',
  `credit_name` varchar(256) NOT NULL COMMENT 'name on credit card',
  `credit_exp` varchar(5) NOT NULL COMMENT 'credit card exparation date',
  `phone` int(10) DEFAULT NULL COMMENT 'the associated phone number',
  `billing_address` varchar(750) NOT NULL COMMENT 'the associated billing address',
  `billing_city` varchar(750) NOT NULL COMMENT 'the associated billing address',
  `billing_zip` varchar(750) NOT NULL COMMENT 'the associated billing address',
  `billing_state` varchar(2) NOT NULL COMMENT 'associated bulling address',
  `billing_phone` int(10) DEFAULT NULL COMMENT 'the billing phone number',
  `shipping_name` varchar(750) NOT NULL COMMENT 'the name associated with the shipping address',
  `billing_name` varchar(750) NOT NULL COMMENT 'the name associated with the shipping address',
  `status` varchar(1) NOT NULL COMMENT 'shipping / not shipped / etc.',
  `subtotal` double(10,2) NOT NULL COMMENT 'price before shipping',
  `shipping_price` double(10,2) NOT NULL COMMENT 'shipping price',
  `total_amount` double(10,2) NOT NULL COMMENT 'total price',
  `tracking_num` varchar(100) NOT NULL DEFAULT 'Not available',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `fk_orders_accounts1` (`account_id`(333))
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='customer orders';

-- --------------------------------------------------------

-- 
-- Table structure for table `product_reviews`
-- 

DROP TABLE IF EXISTS `product_reviews`;
CREATE TABLE IF NOT EXISTS `product_reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `product_id` int(11) NOT NULL COMMENT 'associated product',
  `account_id` int(11) NOT NULL COMMENT 'associated account',
  `rating` int(10) unsigned NOT NULL COMMENT 'rating',
  `review` text NOT NULL COMMENT 'comment',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`,`account_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='product reviews';

-- --------------------------------------------------------

-- 
-- Table structure for table `products`
-- 

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL COMMENT 'the product name',
  `description` text COMMENT 'the product description.  All information about the product will go here.',
  `price` double(10,2) NOT NULL,
  `inventory` int(11) NOT NULL COMMENT 'the number of units of this product in inventory.  -1 = backorder.',
  `image_id` int(11) DEFAULT NULL COMMENT 'an image for the product page',
  `thumbnail_id` int(11) DEFAULT NULL COMMENT 'an thumbnail of r product lists',
  `category_id` int(11) NOT NULL COMMENT 'the products category',
  `manufacturer_id` int(11) DEFAULT NULL COMMENT 'not implemented',
  PRIMARY KEY (`id`),
  KEY `fk_products_images` (`image_id`,`thumbnail_id`),
  KEY `fk_products_categories1` (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='products in the system inventory';

-- --------------------------------------------------------

-- 
-- Table structure for table `client_orders`
-- 

DROP VIEW IF EXISTS `client_orders`;
CREATE VIEW `client_orders` AS select `o`.`id` AS `id`,substr(`o`.`credit_num`,13,16) AS `credit_4`,`o`.`shipping_name` AS `shipping_name`,`oi`.`quantity` AS `quantity`,`o`.`subtotal` AS `subtotal`,`o`.`shipping_price` AS `shipping_price`,`o`.`total_amount` AS `total_amount`,`os`.`name` AS `status`,`os`.`id` AS `status_id`,`o`.`shipping_address` AS `shipping_address`,`o`.`shipping_city` AS `shipping_city`,`o`.`shipping_zip` AS `shipping_zip`,`o`.`shipping_state` AS `shipping_state`,`o`.`tracking_num` AS `tracking_num` from (`orders` `o` join `order_status` `os`) join `order_items` `oi`) where ((`o`.`id` = `oi`.`order_id`) and (`o`.`status` = `os`.`id`));

-- --------------------------------------------------------

-- 
-- Table structure for table `order_items`
-- 

DROP VIEW IF EXISTS `order_items`;
CREATE VIEW `order_items` AS select `order_products`.`order_id` AS `order_id`,sum(`order_products`.`amount`) AS `quantity` from `order_products` group by `order_products`.`order_id`;

-- --------------------------------------------------------

-- 
-- Table structure for table `order_items_details`
-- 

DROP VIEW IF EXISTS `order_items_details`;
CREATE VIEW `order_items_details` AS select `op`.`order_id` AS `order_id`,`p`.`name` AS `name`,`op`.`amount` AS `quantity`,`p`.`price` AS `price` from (`order_products` `op` join `products` `p`) where (`op`.`product_id` = `p`.`id`);

-- --------------------------------------------------------

-- 
-- Table structure for table `products_details`
-- 

DROP VIEW IF EXISTS `products_details`;
CREATE VIEW `products_details` AS select `a`.`id` AS `id`,`a`.`name` AS `name`,`b`.`name` AS `category`,`a`.`price` AS `price`,`a`.`inventory` AS `inventory`,`a`.`description` AS `description` from (`products` `a` join `categories` `b`) where (`a`.`category_id` = `b`.`id`);
