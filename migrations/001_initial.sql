CREATE TABLE IF NOT EXISTS `kvstore_storage` (
  id INT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  kvstore_key VARCHAR(255) UNIQUE KEY NOT NULL,
  kvstore_value TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;