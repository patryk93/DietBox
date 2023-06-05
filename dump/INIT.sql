-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema zamowienia
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `zamowienia` ;

-- -----------------------------------------------------
-- Schema zamowienia
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `zamowienia` DEFAULT CHARACTER SET utf8 ;
USE `zamowienia` ;

-- -----------------------------------------------------
-- Table `zamowienia`.`typ_konta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `zamowienia`.`typ_konta` ;

CREATE TABLE IF NOT EXISTS `zamowienia`.`typ_konta` (
  `id` INT NOT NULL,
  `nazwa` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zamowienia`.`konto_użytkownika`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `zamowienia`.`konto_użytkownika` ;

CREATE TABLE IF NOT EXISTS `zamowienia`.`konto_użytkownika` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(45) NOT NULL,
  `hashed_password` INT NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `typ_konta_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_konto_użytkownika_typ_konta1_idx` (`typ_konta_id` ASC) VISIBLE,
  CONSTRAINT `fk_konto_użytkownika_typ_konta1`
    FOREIGN KEY (`typ_konta_id`)
    REFERENCES `zamowienia`.`typ_konta` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zamowienia`.`klient`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `zamowienia`.`klient` ;

CREATE TABLE IF NOT EXISTS `zamowienia`.`klient` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `imie` VARCHAR(45) NOT NULL,
  `nazwisko` VARCHAR(45) NOT NULL,
  `ulica` VARCHAR(45) NOT NULL,
  `nr_domu` VARCHAR(45) NOT NULL,
  `nr_mieszkania` VARCHAR(45) NULL,
  `miasto` VARCHAR(45) NOT NULL,
  `kod_pocztowy` VARCHAR(45) NOT NULL,
  `nr_telefonu` VARCHAR(11) NOT NULL,
  `konto_użytkownika_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_klient_konto_użytkownika_idx` (`konto_użytkownika_id` ASC) VISIBLE,
  CONSTRAINT `fk_klient_konto_użytkownika`
    FOREIGN KEY (`konto_użytkownika_id`)
    REFERENCES `zamowienia`.`konto_użytkownika` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zamowienia`.`zalogowani_użytkownicy`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `zamowienia`.`zalogowani_użytkownicy` ;

CREATE TABLE IF NOT EXISTS `zamowienia`.`zalogowani_użytkownicy` (
  `session_id` VARCHAR(45) NOT NULL,
  `user_id` INT(11) NOT NULL,
  `last_update` DATETIME NOT NULL,
  `konto_użytkownika_id` INT NOT NULL,
  PRIMARY KEY (`session_id`),
  INDEX `fk_zalogowani_użytkownicy_konto_użytkownika1_idx` (`konto_użytkownika_id` ASC) VISIBLE,
  CONSTRAINT `fk_zalogowani_użytkownicy_konto_użytkownika1`
    FOREIGN KEY (`konto_użytkownika_id`)
    REFERENCES `zamowienia`.`konto_użytkownika` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zamowienia`.`zamowienia_zrealizowane`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `zamowienia`.`zamowienia_zrealizowane` ;

CREATE TABLE IF NOT EXISTS `zamowienia`.`zamowienia_zrealizowane` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `zalogowani_użytkownicy_session_id` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_zamowienia_zrealizowane_zalogowani_użytkownicy1_idx` (`zalogowani_użytkownicy_session_id` ASC) VISIBLE,
  CONSTRAINT `fk_zamowienia_zrealizowane_zalogowani_użytkownicy1`
    FOREIGN KEY (`zalogowani_użytkownicy_session_id`)
    REFERENCES `zamowienia`.`zalogowani_użytkownicy` (`session_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zamowienia`.`koszyk`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `zamowienia`.`koszyk` ;

CREATE TABLE IF NOT EXISTS `zamowienia`.`koszyk` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `zalogowani_użytkownicy_session_id` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_koszyk_zalogowani_użytkownicy1_idx` (`zalogowani_użytkownicy_session_id` ASC) VISIBLE,
  CONSTRAINT `fk_koszyk_zalogowani_użytkownicy1`
    FOREIGN KEY (`zalogowani_użytkownicy_session_id`)
    REFERENCES `zamowienia`.`zalogowani_użytkownicy` (`session_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zamowienia`.`zamówienia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `zamowienia`.`zamówienia` ;

CREATE TABLE IF NOT EXISTS `zamowienia`.`zamówienia` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `numer_zamówienia` VARCHAR(45) NOT NULL,
  `czas_zamowienia_od` DATETIME NOT NULL,
  `czas_zamówienia_do` DATETIME NOT NULL,
  `adres_zamówienia` VARCHAR(45) NOT NULL,
  `zamowienia_zrealizowane_id` INT NOT NULL,
  `koszyk_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_zamówienia_zamowienia_zrealizowane1_idx` (`zamowienia_zrealizowane_id` ASC) VISIBLE,
  INDEX `fk_zamówienia_koszyk1_idx` (`koszyk_id` ASC) VISIBLE,
  CONSTRAINT `fk_zamówienia_zamowienia_zrealizowane1`
    FOREIGN KEY (`zamowienia_zrealizowane_id`)
    REFERENCES `zamowienia`.`zamowienia_zrealizowane` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_zamówienia_koszyk1`
    FOREIGN KEY (`koszyk_id`)
    REFERENCES `zamowienia`.`koszyk` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zamowienia`.`płatność`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `zamowienia`.`płatność` ;

CREATE TABLE IF NOT EXISTS `zamowienia`.`płatność` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `typ_płatności` VARCHAR(45) NOT NULL,
  `czy_zapłacone` TINYINT NOT NULL,
  `zamówienia_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_płatność_zamówienia1_idx` (`zamówienia_id` ASC) VISIBLE,
  CONSTRAINT `fk_płatność_zamówienia1`
    FOREIGN KEY (`zamówienia_id`)
    REFERENCES `zamowienia`.`zamówienia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zamowienia`.`dostawa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `zamowienia`.`dostawa` ;

CREATE TABLE IF NOT EXISTS `zamowienia`.`dostawa` (
  `id` INT NOT NULL,
  `adres_dostawy` VARCHAR(45) NULL,
  `zamówienia_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_dostawa_zamówienia1_idx` (`zamówienia_id` ASC) VISIBLE,
  CONSTRAINT `fk_dostawa_zamówienia1`
    FOREIGN KEY (`zamówienia_id`)
    REFERENCES `zamowienia`.`zamówienia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zamowienia`.`alergeny`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `zamowienia`.`alergeny` ;

CREATE TABLE IF NOT EXISTS `zamowienia`.`alergeny` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `opis` TEXT NULL,
  `czy_zawiera` SET('tak', 'nie') NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zamowienia`.`składniki`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `zamowienia`.`składniki` ;

CREATE TABLE IF NOT EXISTS `zamowienia`.`składniki` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `opis` TEXT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zamowienia`.`dieta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `zamowienia`.`dieta` ;

CREATE TABLE IF NOT EXISTS `zamowienia`.`dieta` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nazwa` VARCHAR(45) NOT NULL,
  `koszyk_id` INT NOT NULL,
  `alergeny_id` INT NOT NULL,
  `składniki_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_dieta_koszyk1_idx` (`koszyk_id` ASC) VISIBLE,
  INDEX `fk_dieta_alergeny1_idx` (`alergeny_id` ASC) VISIBLE,
  INDEX `fk_dieta_składniki1_idx` (`składniki_id` ASC) VISIBLE,
  CONSTRAINT `fk_dieta_koszyk1`
    FOREIGN KEY (`koszyk_id`)
    REFERENCES `zamowienia`.`koszyk` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_dieta_alergeny1`
    FOREIGN KEY (`alergeny_id`)
    REFERENCES `zamowienia`.`alergeny` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_dieta_składniki1`
    FOREIGN KEY (`składniki_id`)
    REFERENCES `zamowienia`.`składniki` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zamowienia`.`cennik`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `zamowienia`.`cennik` ;

CREATE TABLE IF NOT EXISTS `zamowienia`.`cennik` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cena` DECIMAL NOT NULL,
  `cennikcol` VARCHAR(45) NULL,
  `dieta_id` INT NOT NULL,
  `koszyk_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_cennik_dieta1_idx` (`dieta_id` ASC) VISIBLE,
  INDEX `fk_cennik_koszyk1_idx` (`koszyk_id` ASC) VISIBLE,
  CONSTRAINT `fk_cennik_dieta1`
    FOREIGN KEY (`dieta_id`)
    REFERENCES `zamowienia`.`dieta` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cennik_koszyk1`
    FOREIGN KEY (`koszyk_id`)
    REFERENCES `zamowienia`.`koszyk` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zamowienia`.`promocje`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `zamowienia`.`promocje` ;

CREATE TABLE IF NOT EXISTS `zamowienia`.`promocje` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `kod_promocji` VARCHAR(45) NULL,
  `link_do_strony` VARCHAR(45) NULL,
  `obnizona_cena` DECIMAL NULL,
  `cennik_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_promocje_cennik1_idx` (`cennik_id` ASC) VISIBLE,
  CONSTRAINT `fk_promocje_cennik1`
    FOREIGN KEY (`cennik_id`)
    REFERENCES `zamowienia`.`cennik` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zamowienia`.`kontakt`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `zamowienia`.`kontakt` ;

CREATE TABLE IF NOT EXISTS `zamowienia`.`kontakt` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `chat` VARCHAR(45) NULL,
  `telefon` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `zamowienia`.`opinie_klientow`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `zamowienia`.`opinie_klientow` ;

CREATE TABLE IF NOT EXISTS `zamowienia`.`opinie_klientow` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `opinia` LONGTEXT NOT NULL,
  `zalogowani_użytkownicy_session_id` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_opinie_klientow_zalogowani_użytkownicy1_idx` (`zalogowani_użytkownicy_session_id` ASC) VISIBLE,
  CONSTRAINT `fk_opinie_klientow_zalogowani_użytkownicy1`
    FOREIGN KEY (`zalogowani_użytkownicy_session_id`)
    REFERENCES `zamowienia`.`zalogowani_użytkownicy` (`session_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
