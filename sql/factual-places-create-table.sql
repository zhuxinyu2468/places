
--create empty holding table
CREATE TABLE `factual_places` (
  `factual_id` VARCHAR(36)  NOT NULL,
  `name` VARCHAR(255)  NULL,
  `address` VARCHAR(255) NULL,
  `address_extended` VARCHAR(255) NULL,
  `locality` VARCHAR(255)  NULL,
  `region` VARCHAR(255)  NULL,
  `postcode` VARCHAR(255)  NULL,
  `country` VARCHAR(2)  NULL,
  `neighborhood` TEXT  NULL,
  `tel` VARCHAR(255)  NULL,
  `fax` VARCHAR(255)  NULL,
  `website` VARCHAR(255)  NULL,
  `latitude` DOUBLE NULL ,
  `longitude` DOUBLE NULL,
  `chain_name` VARCHAR(255)  NULL,
  `category_ids` VARCHAR(255)  NULL,
  `post-town` VARCHAR(255)  NULL,
  `chain_id` VARCHAR(36)  NULL,
  `admin_region` VARCHAR(255)  NULL,
  `po_box` VARCHAR(255)  NULL,
  `hours_display` TEXT  NULL,
  `email` VARCHAR(255)  NULL,
  `category_labels` VARCHAR(255)  NULL

)
ENGINE = MyISAM;


