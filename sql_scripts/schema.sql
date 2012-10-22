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
  `account_id` INT(11) NOT NULL ,
  `address` VARCHAR(750) NOT NULL ,
  `city` VARCHAR(750) NOT NULL ,
  `state` VARCHAR(2) NOT NULL ,
  `zip` INT(5) NOT NULL ,
  `phone` INT(10) NULL DEFAULT NULL ,
  `name` VARCHAR(500) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_addresses_accounts1` (`account_id` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `quickshop`.`accounts`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `quickshop`.`accounts` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `first_name` VARCHAR(750) NOT NULL ,
  `last_name` VARCHAR(750) NOT NULL ,
  `shipping_address` VARCHAR(750) NULL DEFAULT NULL ,
  `shipping_city` VARCHAR(500) NULL DEFAULT NULL ,
  `shipping_zip` INT(5) NULL DEFAULT NULL ,
  `phone` INT(10) NULL DEFAULT NULL ,
  `email` VARCHAR(100) NOT NULL ,
  `password` VARCHAR(500) NOT NULL ,
  `billing_address` VARCHAR(750) NULL DEFAULT NULL ,
  `billing_city` VARCHAR(750) NULL DEFAULT NULL ,
  `billing_zip` VARCHAR(750) NULL DEFAULT NULL ,
  `billing_state` VARCHAR(2) NULL DEFAULT NULL ,
  `shipping_state` VARCHAR(2) NULL DEFAULT NULL ,
  `address_id` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_accounts_addresses1` (`address_id` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `quickshop`.`images`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `quickshop`.`images` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `caption` VARCHAR(64) NULL DEFAULT NULL ,
  `filename` VARCHAR(512) NULL DEFAULT NULL ,
  `product_id` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `quickshop`.`categories`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `quickshop`.`categories` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL DEFAULT NULL ,
  `parent_id` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `quickshop`.`products`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `quickshop`.`products` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(128) NOT NULL ,
  `decription` TEXT NULL DEFAULT NULL ,
  `price` FLOAT NOT NULL ,
  `inventory` INT(11) NOT NULL ,
  `image_id` INT(11) NULL DEFAULT NULL ,
  `thumbnail_id` INT(11) NULL DEFAULT NULL ,
  `category_id` INT(11) NOT NULL ,
  `manufacturer_id` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_products_images` (`image_id` ASC, `thumbnail_id` ASC) ,
  INDEX `fk_products_categories1` (`category_id` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `quickshop`.`cart_items`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `quickshop`.`cart_items` (
  `product_id` INT(11) NOT NULL ,
  `account_id` INT(11) NOT NULL ,
  INDEX `fk_cart_items_products1` (`product_id` ASC) ,
  INDEX `fk_cart_items_accounts1` (`account_id` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `quickshop`.`orders`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `quickshop`.`orders` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `account_id` INT(11) NULL DEFAULT NULL ,
  `shipping_address` VARCHAR(750) NOT NULL ,
  `shipping_city` VARCHAR(750) NOT NULL ,
  `shipping_zip` INT(5) NOT NULL ,
  `credit_4` INT(4) NULL DEFAULT NULL ,
  `phone` INT(10) NOT NULL ,
  `billing_address` VARCHAR(750) NOT NULL ,
  `billing_city` VARCHAR(750) NOT NULL ,
  `billing_zip` VARCHAR(750) NOT NULL ,
  `shipping_name` VARCHAR(750) NOT NULL ,
  `billing_name` VARCHAR(750) NOT NULL ,
  `status` VARCHAR(1) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_orders_accounts1` (`account_id` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `quickshop`.`order_products`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `quickshop`.`order_products` (
  `order_id` INT(11) NOT NULL ,
  `product_id` INT(11) NOT NULL ,
  INDEX `fk_order_products_orders1` (`order_id` ASC) ,
  INDEX `fk_order_products_products1` (`product_id` ASC) )
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
