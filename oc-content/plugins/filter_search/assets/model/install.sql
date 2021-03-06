CREATE TABLE IF NOT EXISTS /*TABLE_PREFIX*/t_residential_complex (
	`pk_i_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`fk_i_city_id` int(10) UNSIGNED NOT NULL,
	`s_name` VARCHAR(100) NOT NULL,
	PRIMARY KEY(`pk_i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS /*TABLE_PREFIX*/t_districts (
  `pk_i_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fk_i_city_id` int(10) UNSIGNED NOT NULL,
  `s_name` VARCHAR(100) NOT NULL,
  PRIMARY KEY(`pk_i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;