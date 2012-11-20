-- phpMyAdmin SQL Dump
-- version 2.9.1
-- http://www.phpmyadmin.net
-- 
-- Host: studentdb.gl.umbc.edu
-- Generation Time: Nov 18, 2012 at 02:44 PM
-- Server version: 5.5.13
-- PHP Version: 4.4.4
-- 
-- Database: `clargr1`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `accounts`
-- 

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
  `shipping_id` int(11) DEFAULT NULL COMMENT 'default shipping address',
  `billing_id` int(11) DEFAULT NULL COMMENT 'default billing address',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_accounts_addresses1` (`shipping_id`,`billing_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='customer accounts' AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `addresses`
-- 

CREATE TABLE IF NOT EXISTS `addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL COMMENT 'the associated account',
  `address` varchar(750) NOT NULL,
  `city` varchar(750) NOT NULL,
  `state` varchar(2) NOT NULL,
  `zip` int(5) NOT NULL,
  `phone` int(10) DEFAULT NULL,
  `name` varchar(500) DEFAULT NULL COMMENT 'the name associated with this address',
  PRIMARY KEY (`id`),
  KEY `fk_addresses_accounts1` (`account_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='customers'' addresses' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `cart_items`
-- 

CREATE TABLE IF NOT EXISTS `cart_items` (
  `product_id` int(11) NOT NULL COMMENT 'the product in the cart',
  `account_id` int(11) NOT NULL COMMENT 'the customer who''s cart it is',
  `amount` int(11) NOT NULL COMMENT 'the number of unit of this product in the cart',
  KEY `fk_cart_items_products1` (`product_id`),
  KEY `fk_cart_items_accounts1` (`account_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `categories`
-- 

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL COMMENT 'the name of the category',
  `parent_id` int(11) DEFAULT NULL COMMENT 'a foriegn id to the categories table.  This points to this categories super category.',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='product categories and sub categories' AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `images`
-- 

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(512) NOT NULL,
  `mime_type` varchar(256) NOT NULL,
  `size` int(11) NOT NULL,
  `file_data` longblob NOT NULL,
  `product_id` int(11) DEFAULT NULL COMMENT 'the associated product',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='images for products' AUTO_INCREMENT=66 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `order_products`
-- 

CREATE TABLE IF NOT EXISTS `order_products` (
  `order_id` int(11) NOT NULL COMMENT 'the associated order',
  `product_id` int(11) NOT NULL COMMENT 'the associated product',
  `amount` int(11) NOT NULL COMMENT 'the number of units of this product ordered',
  KEY `fk_order_products_orders1` (`order_id`),
  KEY `fk_order_products_products1` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Join table to link products with an order.';

-- --------------------------------------------------------

-- 
-- Table structure for table `orders`
-- 

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) DEFAULT NULL COMMENT 'the associated account',
  `shipping_address` varchar(750) NOT NULL COMMENT 'the address to which the order was shipped',
  `shipping_city` varchar(750) NOT NULL COMMENT 'associated',
  `shipping_zip` int(5) NOT NULL COMMENT 'associated',
  `credit_4` int(4) DEFAULT NULL COMMENT 'last four digits of the credit card used',
  `phone` int(10) NOT NULL COMMENT 'the associated phone number',
  `billing_address` varchar(750) NOT NULL COMMENT 'the associated billing address',
  `billing_city` varchar(750) NOT NULL COMMENT 'the associated billing address',
  `billing_zip` varchar(750) NOT NULL COMMENT 'the associated billing address',
  `shipping_name` varchar(750) NOT NULL COMMENT 'the name associated with the shipping address',
  `billing_name` varchar(750) NOT NULL COMMENT 'the name associated with the shipping address',
  `status` varchar(1) NOT NULL COMMENT 'shipping / not shipped / etc.',
  PRIMARY KEY (`id`),
  KEY `fk_orders_accounts1` (`account_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='customer orders' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `products`
-- 

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL COMMENT 'the product name',
  `description` text COMMENT 'the product description.  All information about the product will go here.',
  `price` float NOT NULL,
  `inventory` int(11) NOT NULL COMMENT 'the number of units of this product in inventory.  -1 = backorder.',
  `image_id` int(11) DEFAULT NULL COMMENT 'an image for the product page',
  `thumbnail_id` int(11) DEFAULT NULL COMMENT 'an thumbnail of r product lists',
  `category_id` int(11) NOT NULL COMMENT 'the products category',
  `manufacturer_id` int(11) DEFAULT NULL COMMENT 'not implemented',
  PRIMARY KEY (`id`),
  KEY `fk_products_images` (`image_id`,`thumbnail_id`),
  KEY `fk_products_categories1` (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='products in the system inventory' AUTO_INCREMENT=46 ;
