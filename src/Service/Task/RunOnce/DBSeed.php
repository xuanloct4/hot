<?php

namespace Src\Service\Task\RunOnce;


use Src\System\Configuration;

class DBSeed
{
    public $statement;

    private $db = null;

    // Hold the class instance.
    private static $instance = null;

    // The constructor is private
    // to prevent initiation with outer code.
    private function __construct()
    {
        $this->db = Configuration::getInstance()->getConnection();
        $this->statement = file_get_contents('../../HOT.sql', FILE_USE_INCLUDE_PATH);

//        $this->statement = <<<EOS
//   CREATE DATABASE hot CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
//use hot;
//
//# user
//   CREATE TABLE IF NOT EXISTS `user` (
//        id INT NOT NULL AUTO_INCREMENT,
//		`name` TEXT NOT NULL,
//		`address` LONGTEXT DEFAULT NULL,
//		`location`  TEXT DEFAULT NULL,
//	    `phone` TEXT DEFAULT NULL,
//	    `gender` TEXT DEFAULT NULL,
//        `status` LONGTEXT DEFAULT NULL,
//        `authorized_id` INT UNIQUE NOT NULL,
//		`preferences`  LONGTEXT DEFAULT NULL,
//        `scopes` LONGTEXT DEFAULT NULL,
//		`is_deleted` TINYINT DEFAULT b'0',
//        `is_activated` TINYINT DEFAULT b'0',
//		`created_timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//		`last_updated_timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//        PRIMARY KEY (id)
//    ) ENGINE=INNODB;
//
//# user_device
//   CREATE TABLE IF NOT EXISTS user_device (
//        id INT NOT NULL AUTO_INCREMENT,
//		`name` TEXT NOT NULL,
//		`description` LONGTEXT DEFAULT NULL,
//		`model`  TEXT NOT NULL,
//	    `manufacturer` TEXT DEFAULT NULL,
//	    `version` TEXT NOT NULL,
//		`firmware`  TEXT DEFAULT NULL,
//        `os`  TEXT DEFAULT NULL,
//		`user_id` INT NOT NULL,
//        `status` LONGTEXT DEFAULT NULL,
//        `authorized_id` INT UNIQUE NOT NULL,
//		`configuration`  LONGTEXT DEFAULT NULL,
//        `scopes` LONGTEXT DEFAULT NULL,
//		`is_deleted` TINYINT DEFAULT b'0',
//        `is_activated` TINYINT DEFAULT b'0',
//		`created_timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//		`last_updated_timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//        PRIMARY KEY (id)
//    ) ENGINE=INNODB;
//
//    # device
//   CREATE TABLE IF NOT EXISTS device (
//        id INT NOT NULL AUTO_INCREMENT,
//		`model`  TEXT NOT NULL,
//	    `manufacturer` TEXT DEFAULT NULL,
//	    `version` TEXT NOT NULL,
//		`firmware`  TEXT DEFAULT NULL,
//        `os`  TEXT DEFAULT NULL,
//		`image`  MEDIUMTEXT DEFAULT NULL,
//		`configuration`  LONGTEXT DEFAULT NULL,
//	    `scopes` LONGTEXT DEFAULT NULL,
//		`is_deleted` TINYINT DEFAULT b'0',
//        `is_activated` TINYINT DEFAULT b'0',
//        PRIMARY KEY (id)
//    ) ENGINE=INNODB;
//
//# server_configuration
//   CREATE TABLE IF NOT EXISTS server_configuration (
//        id INT NOT NULL AUTO_INCREMENT,
//		`name` TEXT NOT NULL,
//		`description` LONGTEXT DEFAULT NULL,
//        `status` LONGTEXT DEFAULT NULL,
//        `authorized_id` INT UNIQUE NOT NULL,
//		`configuration`  LONGTEXT DEFAULT NULL,
//        `scopes` LONGTEXT DEFAULT NULL,
//		`is_deleted` TINYINT DEFAULT b'0',
//        `is_activated` TINYINT DEFAULT b'0',
//		`created_timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//		`last_updated_timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//        PRIMARY KEY (id)
//    ) ENGINE=INNODB;
//
//# board_configuration
//   CREATE TABLE IF NOT EXISTS board_configuration (
//        id INT NOT NULL AUTO_INCREMENT,
//		`board_id`  INT NOT NULL,
//	    `server_configuration_id` INT NOT NULL,
//	    `user_device_id` MEDIUMTEXT DEFAULT NULL,
//		`user_id`  MEDIUMTEXT DEFAULT NULL,
//        `topos`  LONGTEXT DEFAULT NULL,
//	    `status` LONGTEXT DEFAULT NULL,
//	    `authorized_id` INT UNIQUE NOT NULL,
//		`configuration`  LONGTEXT DEFAULT NULL,
//	    `scopes` LONGTEXT DEFAULT NULL,
//		`is_deleted` TINYINT DEFAULT b'0',
//        `is_activated` TINYINT DEFAULT b'0',
//		`created_timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//		`last_updated_timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//        PRIMARY KEY (id)
//    ) ENGINE=INNODB;
//
//# board
//   CREATE TABLE IF NOT EXISTS board (
//        id INT NOT NULL AUTO_INCREMENT,
//		`name` TEXT NOT NULL,
//		`description` LONGTEXT DEFAULT NULL,
//		`model`  TEXT NOT NULL,
//	    `manufacturer` TEXT DEFAULT NULL,
//	    `version` TEXT NOT NULL,
//		`firmware`  TEXT DEFAULT NULL,
//        `os`  TEXT DEFAULT NULL,
//		`image`  MEDIUMTEXT DEFAULT NULL,
//	    `sensors` LONGTEXT NOT NULL,
//		`boards`  LONGTEXT DEFAULT NULL,
//	    `public_contacts` LONGTEXT DEFAULT NULL,
//	    `internal_contacts` LONGTEXT DEFAULT NULL,
//        PRIMARY KEY (id)
//    ) ENGINE=INNODB;
//
//# sensor
//   CREATE TABLE IF NOT EXISTS sensor (
//        id INT NOT NULL AUTO_INCREMENT,
//		`name` TEXT NOT NULL,
//		`description` LONGTEXT DEFAULT NULL,
//		`model`  TEXT NOT NULL,
//	    `manufacturer` TEXT DEFAULT NULL,
//	    `version` TEXT NOT NULL,
//		`firmware`  TEXT DEFAULT NULL,
//		`image`  MEDIUMTEXT DEFAULT NULL,
//	    `public_contacts` LONGTEXT DEFAULT NULL,
//	    `internal_contacts` LONGTEXT DEFAULT NULL,
//        PRIMARY KEY (id)
//    ) ENGINE=INNODB;
//
//# topo
//   CREATE TABLE IF NOT EXISTS topo (
//        id INT NOT NULL AUTO_INCREMENT,
//		`board_internal_contact`  MEDIUMTEXT DEFAULT NULL,
//	    `sensor_internal_contact` MEDIUMTEXT DEFAULT NULL,
//	    `description` MEDIUMTEXT DEFAULT NULL,
//        PRIMARY KEY (id)
//    ) ENGINE=INNODB;
//
//# contact
//   CREATE TABLE IF NOT EXISTS contact (
//        id INT NOT NULL AUTO_INCREMENT,
//        `name` TEXT DEFAULT NULL,
//		`io`  INT NOT NULL,
//	    `input_ad` INT NOT NULL,
//	    `output_ad` INT NOT NULL,
//	    `max_input` DOUBLE NOT NULL,
//		`min_input` DOUBLE NOT NULL,
//	    `max_output` DOUBLE NOT NULL,
//		`min_output` DOUBLE NOT NULL,
//	    `frequency` BIGINT DEFAULT NULL,
//	    `wave_shape` INT DEFAULT NULL,
//	    `input_oscillation_function` LONGTEXT DEFAULT NULL,
//	    `output_oscillation_function` LONGTEXT DEFAULT NULL,
//        PRIMARY KEY (id)
//    ) ENGINE=INNODB;
//
//# uri
//   CREATE TABLE IF NOT EXISTS uri (
//        id INT NOT NULL AUTO_INCREMENT,
//		`representation`  MEDIUMTEXT NOT NULL,
//	    `content` LONGTEXT DEFAULT NULL,
//	    `virtual_address` MEDIUMTEXT DEFAULT NULL,
//	    `physical_address` MEDIUMTEXT DEFAULT NULL,
//		`authorized_id` INT UNIQUE DEFAULT NULL,
//	    `scopes` TEXT DEFAULT NULL,
//	    `type` TEXT DEFAULT NULL,
//        PRIMARY KEY (id)
//    ) ENGINE=INNODB;
//
//# scope
//   CREATE TABLE IF NOT EXISTS scope (
//        id INT NOT NULL AUTO_INCREMENT,
//	    `scope_pair` TEXT NOT NULL,
//	    `description` MEDIUMTEXT DEFAULT NULL,
//        PRIMARY KEY (id)
//    ) ENGINE=INNODB;
//
//# scope_definition
//   CREATE TABLE IF NOT EXISTS scope_definition (
//        id INT NOT NULL AUTO_INCREMENT,
//		`level` TEXT NOT NULL,
//	    `order` INT NOT NULL,
//	    `actions` TEXT DEFAULT NULL,
//	    `description` MEDIUMTEXT DEFAULT NULL,
//        PRIMARY KEY (id)
//    ) ENGINE=INNODB;
//
//# log
//   CREATE TABLE IF NOT EXISTS log (
//        id INT NOT NULL AUTO_INCREMENT,
//        `content` LONGTEXT DEFAULT NULL,
//        `configuration` INT NOT NULL,
//		`type` TEXT NOT NULL,
//        `level` INT NOT NULL,
//		`scopes` TEXT DEFAULT NULL,
//		`created_timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//		`last_updated_timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//        PRIMARY KEY (id)
//    ) ENGINE=INNODB;
//
//# configuration
//   CREATE TABLE IF NOT EXISTS configuration (
//        id INT NOT NULL AUTO_INCREMENT,
//        `files` LONGTEXT DEFAULT NULL,
//        `uris` LONGTEXT DEFAULT NULL,
//		`strings` LONGTEXT DEFAULT NULL,
//        `binary` LONGBLOB DEFAULT NULL,
//		`update_order` VARCHAR(256) NOT NULL,
//		`type` INT NOT NULL,
//		`scopes` VARCHAR(256) DEFAULT NULL,
//		`is_deleted` TINYINT DEFAULT b'0',
//        `is_activated` TINYINT DEFAULT b'0',
//		`created_timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//		`last_updated_timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//        PRIMARY KEY (id)
//    ) ENGINE=INNODB;
//
//# authorization
//   CREATE TABLE IF NOT EXISTS authorization (
//        id INT NOT NULL AUTO_INCREMENT,
//        `name` TEXT DEFAULT NULL,
//        `uuid` VARCHAR(256) UNIQUE NOT NULL,
//		`authorized_code` TEXT NOT NULL,
//        `tokens`  LONGTEXT DEFAULT NULL,
//		`created_timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//		`last_updated_timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//        `expired_interval` INT DEFAULT NULL,
//        PRIMARY KEY (id)
//    ) ENGINE=INNODB;
//
//# token
//   CREATE TABLE IF NOT EXISTS token (
//        id INT NOT NULL AUTO_INCREMENT,
//        `authorized_id` INT UNIQUE NOT NULL,
//        `token` VARCHAR(256) UNIQUE NOT NULL,
//		`created_timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//        `expired_interval` INT DEFAULT NULL,
//        PRIMARY KEY (id)
//    ) ENGINE=INNODB;
//
//EOS;
    }

    // The object is created from within the class itself
    // only if the class has no instance.
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new DBSeed();
        }

        return self::$instance;
    }

    public function seeding()
    {
        try {
            $createTable = $this->db->exec($this->statement);
            echo "Success!\n";
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}