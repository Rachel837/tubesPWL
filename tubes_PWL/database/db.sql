-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema db_tiket
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema db_tiket
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_tiket` DEFAULT CHARACTER SET utf8mb4 ;
-- -----------------------------------------------------
-- Schema db_tiket
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema db_tiket
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_tiket` DEFAULT CHARACTER SET utf8mb4 ;
USE `db_tiket` ;

-- -----------------------------------------------------
-- Table `db_tiket`.`event`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_tiket`.`event` ;

CREATE TABLE IF NOT EXISTS `db_tiket`.`event` (
  `idevent` INT(11) NOT NULL AUTO_INCREMENT,
  `nama_event` VARCHAR(100) NOT NULL,
  `date_start` DATE NOT NULL,
  `date_end` DATE NOT NULL,
  `location` VARCHAR(45) NOT NULL,
  `max_participant` INT(11) NOT NULL,
  `status` ENUM('aktif', 'tidak aktif') NOT NULL,
  `koordinator` INT(11) NOT NULL,
  `deskripsi` VARCHAR(500) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `kategori` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idevent`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `db_tiket`.`event_detail`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_tiket`.`event_detail` ;

CREATE TABLE IF NOT EXISTS `db_tiket`.`event_detail` (
  `idevent_detail` INT(11) NOT NULL AUTO_INCREMENT,
  `date` DATE NOT NULL,
  `sesi` VARCHAR(50) NOT NULL,
  `time_start` TIME NULL DEFAULT NULL,
  `time_end` TIME NULL DEFAULT NULL,
  `deskripsi` TEXT NOT NULL,
  `event_idevent` INT(11) NOT NULL,
  PRIMARY KEY (`idevent_detail`),
  UNIQUE INDEX `idevent_detail_UNIQUE` (`idevent_detail` ASC) ,
  INDEX `fk_event_detail_event1_idx` (`event_idevent` ASC) ,
  CONSTRAINT `fk_event_detail_event1`
    FOREIGN KEY (`event_idevent`)
    REFERENCES `db_tiket`.`event` (`idevent`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `db_tiket`.`tiket`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_tiket`.`tiket` ;

CREATE TABLE IF NOT EXISTS `db_tiket`.`tiket` (
  `idtiket` INT(11) NOT NULL AUTO_INCREMENT,
  `jenis_tiket` VARCHAR(50) NOT NULL,
  `harga` INT(11) NOT NULL,
  `kuota` INT(11) NOT NULL,
  `deskripsi` TEXT NULL DEFAULT NULL,
  `event_detail_idevent_detail` INT(11) NOT NULL,
  PRIMARY KEY (`idtiket`),
  UNIQUE INDEX `idtiket_UNIQUE` (`idtiket` ASC) ,
  INDEX `fk_tiket_event_detail1_idx` (`event_detail_idevent_detail` ASC) ,
  CONSTRAINT `fk_tiket_event_detail1`
    FOREIGN KEY (`event_detail_idevent_detail`)
    REFERENCES `db_tiket`.`event_detail` (`idevent_detail`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `db_tiket`.`role`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_tiket`.`role` ;

CREATE TABLE IF NOT EXISTS `db_tiket`.`role` (
  `idrole` INT(25) NOT NULL,
  `nama_role` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idrole`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `db_tiket`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_tiket`.`users` ;

CREATE TABLE IF NOT EXISTS `db_tiket`.`users` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `remember_token` VARCHAR(100) NULL DEFAULT NULL,
  `status` ENUM('aktif', 'tidak aktif') NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `role_idrole` INT(25) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `users_email_unique` (`email` ASC) ,
  INDEX `fk_users_role_idx` (`role_idrole` ASC) ,
  CONSTRAINT `fk_users_role`
    FOREIGN KEY (`role_idrole`)
    REFERENCES `db_tiket`.`role` (`idrole`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `db_tiket`.`waiting_list`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_tiket`.`waiting_list` ;

CREATE TABLE IF NOT EXISTS `db_tiket`.`waiting_list` (
  `idwaiting_list` INT(11) NOT NULL,
  `status` VARCHAR(50) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `user_id_user` BIGINT NOT NULL,
  `event_idevent` INT(11) NOT NULL,
  `users_id` BIGINT(20) UNSIGNED NOT NULL,
  PRIMARY KEY (`idwaiting_list`, `users_id`),
  INDEX `fk_waiting_list_event1_idx` (`event_idevent` ASC) ,
  INDEX `fk_waiting_list_users1_idx` (`users_id` ASC) ,
  CONSTRAINT `fk_waiting_list_event1`
    FOREIGN KEY (`event_idevent`)
    REFERENCES `db_tiket`.`event` (`idevent`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_waiting_list_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `db_tiket`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `db_tiket`.`registrations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_tiket`.`registrations` ;

CREATE TABLE IF NOT EXISTS `db_tiket`.`registrations` (
  `idregistrations` INT(11) NOT NULL AUTO_INCREMENT,
  `status` ENUM('menunggu', 'gagal', 'selesai') NOT NULL,
  `qr_code` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `waiting_list_idwaiting_list` INT(11) NOT NULL,
  `tiket_idtiket` INT(11) NOT NULL,
  PRIMARY KEY (`idregistrations`),
  UNIQUE INDEX `idregistrations_UNIQUE` (`idregistrations` ASC) ,
  INDEX `fk_registrations_waiting_list1_idx` (`waiting_list_idwaiting_list` ASC) ,
  INDEX `fk_registrations_tiket1_idx` (`tiket_idtiket` ASC) ,
  CONSTRAINT `fk_registrations_tiket1`
    FOREIGN KEY (`tiket_idtiket`)
    REFERENCES `db_tiket`.`tiket` (`idtiket`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_registrations_waiting_list1`
    FOREIGN KEY (`waiting_list_idwaiting_list`)
    REFERENCES `db_tiket`.`waiting_list` (`idwaiting_list`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `db_tiket`.`payment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_tiket`.`payment` ;

CREATE TABLE IF NOT EXISTS `db_tiket`.`payment` (
  `idpayment` INT(11) NOT NULL AUTO_INCREMENT,
  `registrations_idregistrations` INT(11) NOT NULL,
  PRIMARY KEY (`idpayment`),
  INDEX `fk_payment_registrations1_idx` (`registrations_idregistrations` ASC) ,
  CONSTRAINT `fk_payment_registrations1`
    FOREIGN KEY (`registrations_idregistrations`)
    REFERENCES `db_tiket`.`registrations` (`idregistrations`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

USE `db_tiket` ;

-- -----------------------------------------------------
-- Table `db_tiket`.`cache`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_tiket`.`cache` ;

CREATE TABLE IF NOT EXISTS `db_tiket`.`cache` (
  `key` VARCHAR(255) NOT NULL,
  `value` MEDIUMTEXT NOT NULL,
  `expiration` INT(11) NOT NULL,
  PRIMARY KEY (`key`),
  INDEX `cache_expiration_index` (`expiration` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `db_tiket`.`cache_locks`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_tiket`.`cache_locks` ;

CREATE TABLE IF NOT EXISTS `db_tiket`.`cache_locks` (
  `key` VARCHAR(255) NOT NULL,
  `owner` VARCHAR(255) NOT NULL,
  `expiration` INT(11) NOT NULL,
  PRIMARY KEY (`key`),
  INDEX `cache_locks_expiration_index` (`expiration` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `db_tiket`.`failed_jobs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_tiket`.`failed_jobs` ;

CREATE TABLE IF NOT EXISTS `db_tiket`.`failed_jobs` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` VARCHAR(255) NOT NULL,
  `connection` TEXT NOT NULL,
  `queue` TEXT NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `exception` LONGTEXT NOT NULL,
  `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`),
  UNIQUE INDEX `failed_jobs_uuid_unique` (`uuid` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `db_tiket`.`job_batches`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_tiket`.`job_batches` ;

CREATE TABLE IF NOT EXISTS `db_tiket`.`job_batches` (
  `id` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `total_jobs` INT(11) NOT NULL,
  `pending_jobs` INT(11) NOT NULL,
  `failed_jobs` INT(11) NOT NULL,
  `failed_job_ids` LONGTEXT NOT NULL,
  `options` MEDIUMTEXT NULL DEFAULT NULL,
  `cancelled_at` INT(11) NULL DEFAULT NULL,
  `created_at` INT(11) NOT NULL,
  `finished_at` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `db_tiket`.`jobs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_tiket`.`jobs` ;

CREATE TABLE IF NOT EXISTS `db_tiket`.`jobs` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` VARCHAR(255) NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `attempts` TINYINT(3) UNSIGNED NOT NULL,
  `reserved_at` INT(10) UNSIGNED NULL DEFAULT NULL,
  `available_at` INT(10) UNSIGNED NOT NULL,
  `created_at` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `jobs_queue_index` (`queue` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;



-- -----------------------------------------------------
-- Table `db_tiket`.`password_reset_tokens`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_tiket`.`password_reset_tokens` ;

CREATE TABLE IF NOT EXISTS `db_tiket`.`password_reset_tokens` (
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`email`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `db_tiket`.`sessions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_tiket`.`sessions` ;

CREATE TABLE IF NOT EXISTS `db_tiket`.`sessions` (
  `id` VARCHAR(255) NOT NULL,
  `user_id` BIGINT(20) UNSIGNED NULL DEFAULT NULL,
  `ip_address` VARCHAR(45) NULL DEFAULT NULL,
  `user_agent` TEXT NULL DEFAULT NULL,
  `payload` LONGTEXT NOT NULL,
  `last_activity` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `sessions_user_id_index` (`user_id` ASC) ,
  INDEX `sessions_last_activity_index` (`last_activity` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
