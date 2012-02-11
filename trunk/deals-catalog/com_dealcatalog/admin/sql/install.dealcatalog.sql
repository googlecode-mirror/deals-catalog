
-- Table structure for table `#__deal_merchants`
CREATE TABLE IF NOT EXISTS 	`#__deal_merchants` (
`id` INT(11) NOT NULL AUTO_INCREMENT, 
`name` VARCHAR( 200 ) NOT NULL ,
`user_id` INT(11) NOT NULL DEFAULT '0', 
`username` VARCHAR(100) NOT NULL, 
`password` VARCHAR(100) NOT NULL, 
`firstname` VARCHAR(50) NOT NULL, 
`lastname` VARCHAR(50) NOT NULL,
`company_name` VARCHAR(250) NOT NULL, 
`address1` TEXT NOT NULL, 
`address2` TEXT NOT NULL,
`email_id` VARCHAR( 250 ) NOT NULL ,
`Contact_number` VARCHAR( 100 ) NOT NULL , 
`city` VARCHAR(50) NOT NULL, 
`states` VARCHAR(50) NOT NULL, 
`location_map` TEXT NOT NULL, 
`approved` BOOL NOT NULL DEFAULT '0', 
PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__deal_customers` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
`name` VARCHAR( 200 ) NOT NULL ,
`users_id` INT( 11 ) NOT NULL DEFAULT '0',
`username` VARCHAR( 150 ) NOT NULL ,
`password` VARCHAR( 100 ) NOT NULL ,
`firstname` VARCHAR( 50 ) NOT NULL ,
`lastname` VARCHAR( 50 ) NOT NULL ,
`address1` TEXT NOT NULL ,
`address2` TEXT NOT NULL ,
`email_id` VARCHAR( 250 ) NOT NULL ,
`Contact_number` VARCHAR( 100 ) NOT NULL ,
`city` VARCHAR( 50 ) NOT NULL ,
`states` VARCHAR( 50 ) NOT NULL ,
`approved` BOOL NOT NULL DEFAULT '0',
PRIMARY KEY ( `id` )
)TYPE=MyISAM AUTO_INCREMENT=1 CHARSET=utf8;

-- Table structure for table `#__deal_productcategories`
CREATE TABLE IF NOT EXISTS `#__deal_productcategories` (
`id` INT(11) NOT NULL AUTO_INCREMENT, 
`category_name` VARCHAR(150) NOT NULL, 
`category_desc` TEXT NOT NULL, PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 CHARSET=utf8;

-- Table structure for table `#__deal_manufacturer`
CREATE TABLE IF NOT EXISTS `#__deal_manufacturer` (
`id` INT(11) NOT NULL AUTO_INCREMENT, 
`manufacturer_name` VARCHAR(100) NOT NULL, PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 CHARSET=utf8;

-- Table structure for table `#__deal_products`
CREATE TABLE IF NOT EXISTS `#__deal_products` (
`id` INT(11) NOT NULL AUTO_INCREMENT, 
`product_name` VARCHAR(200) NOT NULL, 
`product_code` VARCHAR(50) NOT NULL, 
`product_desc` TEXT NOT NULL, 
`manufacturer_id` INT(11) NOT NULL, 
`category_id` INT(11) NOT NULL, 
`product_image1` VARCHAR(250) NOT NULL,
`product_thumbimage1` VARCHAR(250) NOT NULL,
PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 CHARSET=utf8;

-- Table structure for table `#__deal_productslisting_deals`
CREATE TABLE IF NOT EXISTS `#__deal_productslisting_deals` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
`vendor_id` INT( 11 ) NOT NULL DEFAULT '0',
`product_id` INT( 11 ) NOT NULL DEFAULT '0',
`stock_in` tinyint(1) NOT NULL DEFAULT '0',
`price` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
`discount_price` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
`listingstart_date` DATE NOT NULL DEFAULT '0000-00-00',
`listingend_date` DATE NOT NULL DEFAULT '0000-00-00',
`merchantproduct_desc` TEXT NOT NULL,
`merchantproduct_image1` VARCHAR(250) NOT NULL,
`merchantproduct_thumbimage1` VARCHAR(250) NOT NULL,
`is_deal` tinyint(1) NOT NULL DEFAULT '0',
`deal_price` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00',
`dealstart_date` DATE NOT NULL DEFAULT '0000-00-00',
`dealend_date` DATE NOT NULL DEFAULT '0000-00-00',
`promotion_type` tinyint(1) NOT NULL DEFAULT '0',
PRIMARY KEY ( `id` )
) TYPE=MyISAM AUTO_INCREMENT=1 CHARSET=utf8;

-- Table structure for table `#__deal_coupons`
CREATE TABLE IF NOT EXISTS `#__deal_coupons` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
`users_userid` INT( 11 ) NOT NULL DEFAULT '0',
`product_id` INT( 11 ) NOT NULL DEFAULT '0',
`vendor_id` INT( 11 ) NOT NULL DEFAULT '0',
`coupon_code` VARCHAR(50) NOT NULL,
PRIMARY KEY ( `id` )
) TYPE=MyISAM AUTO_INCREMENT=1 CHARSET=utf8;

-- Table structure for table `#__deal_productcounts`
CREATE TABLE IF NOT EXISTS `#__deal_productcounts` (
`id` INT(11) NOT NULL AUTO_INCREMENT, 
`product_id` INT(11) NOT NULL, 
`product_viewcount` INT(11) NOT NULL DEFAULT '0', 
`product_couponcount` INT(11) NOT NULL DEFAULT '0', 
PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 CHARSET=utf8;

-- Table structure for table `#__deal_promotiontype`
CREATE TABLE IF NOT EXISTS `#__deal_promotiontype` (
`id` INT(11) NOT NULL AUTO_INCREMENT, 
`promotion_type` VARCHAR(100) NOT NULL, 
PRIMARY KEY (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 CHARSET=utf8;

INSERT INTO `#__deal_promotiontype` (`id`, `promotion_type`) VALUES (NULL, 'Main Promoted Deals'), (NULL, 'Secondary Promoted Deals'), (NULL, 'Third Promoted Deals');