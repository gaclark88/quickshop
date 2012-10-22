SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `quickshop` DEFAULT CHARACTER SET utf8 ;
USE `quickshop` ;

-- -----------------------------------------------------
-- Table `quickshop`.`addresses`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `quickshop`.`addresses` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `account_id` INT(11) NOT NULL COMMENT 'the associated account' ,
  `address` VARCHAR(750) NOT NULL ,
  `city` VARCHAR(750) NOT NULL ,
  `state` VARCHAR(2) NOT NULL ,
  `zip` INT(5) NOT NULL ,
  `phone` INT(10) NULL DEFAULT NULL ,
  `name` VARCHAR(500) NULL DEFAULT NULL COMMENT 'the name associated with this address' ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_addresses_accounts1` (`account_id` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COMMENT = 'customers\' addresses';


-- -----------------------------------------------------
-- Table `quickshop`.`accounts`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `quickshop`.`accounts` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `first_name` VARCHAR(750) NOT NULL COMMENT 'customers first name' ,
  `last_name` VARCHAR(750) NOT NULL COMMENT 'customers first name' ,
  `shipping_address` VARCHAR(750) NULL DEFAULT NULL COMMENT 'defualt shipping address' ,
  `shipping_city` VARCHAR(500) NULL DEFAULT NULL COMMENT 'defualt shipping address' ,
  `shipping_zip` INT(5) NULL DEFAULT NULL COMMENT 'defualt shipping address' ,
  `phone` INT(10) NULL DEFAULT NULL ,
  `email` VARCHAR(100) NOT NULL COMMENT 'email will be used for login' ,
  `password` VARCHAR(500) NOT NULL ,
  `billing_address` VARCHAR(750) NULL DEFAULT NULL COMMENT 'default billing address' ,
  `billing_city` VARCHAR(750) NULL DEFAULT NULL COMMENT 'default billing address' ,
  `billing_zip` VARCHAR(750) NULL DEFAULT NULL COMMENT 'default billing address' ,
  `billing_state` VARCHAR(2) NULL DEFAULT NULL COMMENT 'default billing address' ,
  `shipping_state` VARCHAR(2) NULL DEFAULT NULL COMMENT 'default shipping address' ,
  `shipping_id` INT(11) NULL DEFAULT NULL COMMENT 'default shipping address' ,
  `billing_id` INT(11) NULL COMMENT 'default billing address' ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_accounts_addresses1` (`shipping_id` ASC, `billing_id` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COMMENT = 'customer accounts';


-- -----------------------------------------------------
-- Table `quickshop`.`images`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `quickshop`.`images` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `caption` VARCHAR(64) NULL DEFAULT NULL ,
  `filename` VARCHAR(512) NULL DEFAULT NULL COMMENT 'the location of the image on the file system.' ,
  `product_id` INT(11) NULL DEFAULT NULL COMMENT 'the associated product' ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COMMENT = 'images for products';


-- -----------------------------------------------------
-- Table `quickshop`.`categories`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `quickshop`.`categories` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL DEFAULT NULL COMMENT 'the name of the category' ,
  `parent_id` INT(11) NULL DEFAULT NULL COMMENT 'a foriegn id to the categories table.  This points to this categories super category.' ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COMMENT = 'product categories and sub categories';


-- -----------------------------------------------------
-- Table `quickshop`.`products`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `quickshop`.`products` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(128) NOT NULL COMMENT 'the product name' ,
  `decription` TEXT NULL DEFAULT NULL COMMENT 'the product description.  All information about the product will go here.' ,
  `price` FLOAT NOT NULL ,
  `inventory` INT(11) NOT NULL COMMENT 'the number of units of this product in inventory.  -1 = backorder.' ,
  `image_id` INT(11) NULL DEFAULT NULL COMMENT 'an image for the product page' ,
  `thumbnail_id` INT(11) NULL DEFAULT NULL COMMENT 'an thumbnail of r product lists' ,
  `category_id` INT(11) NOT NULL COMMENT 'the products category' ,
  `manufacturer_id` INT(11) NULL DEFAULT NULL COMMENT 'not implemented' ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_products_images` (`image_id` ASC, `thumbnail_id` ASC) ,
  INDEX `fk_products_categories1` (`category_id` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COMMENT = 'products in the system inventory';


-- -----------------------------------------------------
-- Table `quickshop`.`cart_items`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `quickshop`.`cart_items` (
  `product_id` INT(11) NOT NULL COMMENT 'the product in the cart' ,
  `account_id` INT(11) NOT NULL COMMENT 'the customer who\'s cart it is' ,
  `amount` INT NOT NULL COMMENT 'the number of unit of this product in the cart' ,
  INDEX `fk_cart_items_products1` (`product_id` ASC) ,
  INDEX `fk_cart_items_accounts1` (`account_id` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `quickshop`.`orders`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `quickshop`.`orders` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `account_id` INT(11) NULL DEFAULT NULL COMMENT 'the associated account' ,
  `shipping_address` VARCHAR(750) NOT NULL COMMENT 'the address to which the order was shipped' ,
  `shipping_city` VARCHAR(750) NOT NULL COMMENT 'associated' ,
  `shipping_zip` INT(5) NOT NULL COMMENT 'associated' ,
  `credit_4` INT(4) NULL DEFAULT NULL COMMENT 'last four digits of the credit card used' ,
  `phone` INT(10) NOT NULL COMMENT 'the associated phone number' ,
  `billing_address` VARCHAR(750) NOT NULL COMMENT 'the associated billing address' ,
  `billing_city` VARCHAR(750) NOT NULL COMMENT 'the associated billing address' ,
  `billing_zip` VARCHAR(750) NOT NULL COMMENT 'the associated billing address' ,
  `shipping_name` VARCHAR(750) NOT NULL COMMENT 'the name associated with the shipping address' ,
  `billing_name` VARCHAR(750) NOT NULL COMMENT 'the name associated with the shipping address' ,
  `status` VARCHAR(1) NOT NULL COMMENT 'shipping / not shipped / etc.' ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_orders_accounts1` (`account_id` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COMMENT = 'customer orders';


-- -----------------------------------------------------
-- Table `quickshop`.`order_products`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `quickshop`.`order_products` (
  `order_id` INT(11) NOT NULL COMMENT 'the associated order' ,
  `product_id` INT(11) NOT NULL COMMENT 'the associated product' ,
  `amount` INT NOT NULL COMMENT 'the number of units of this product ordered' ,
  INDEX `fk_order_products_orders1` (`order_id` ASC) ,
  INDEX `fk_order_products_products1` (`product_id` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COMMENT = 'Join table to link products with an order.';



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
