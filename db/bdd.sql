-- MySQL Script generated by MySQL Workbench
-- Mon Jan  2 21:50:33 2017
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema ydays_dev_db
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema ydays_dev_db
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `ydays_dev_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `ydays_dev_db` ;

-- -----------------------------------------------------
-- Table `ydays_dev_db`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ydays_dev_db`.`user` ;

CREATE TABLE IF NOT EXISTS `ydays_dev_db`.`user` (
  `idUser` INT NOT NULL COMMENT '',
  `nom` VARCHAR(45) NULL COMMENT '',
  `prenom` VARCHAR(45) NULL COMMENT '',
  `email` VARCHAR(45) NULL COMMENT '',
  `password` VARCHAR(45) NULL COMMENT '',
  `isDeleted` INT NOT NULL DEFAULT 0 COMMENT '',
  PRIMARY KEY (`idUser`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ydays_dev_db`.`admin`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ydays_dev_db`.`admin` ;

CREATE TABLE IF NOT EXISTS `ydays_dev_db`.`admin` (
  `idAdmin` INT NOT NULL COMMENT '',
  `idUser` INT NULL COMMENT '',
  `idSociete` INT NULL COMMENT '',
  PRIMARY KEY (`idAdmin`)  COMMENT '',
  INDEX `idUser_idx` (`idUser` ASC)  COMMENT '',
  INDEX `idSociete_idx` (`idSociete` ASC)  COMMENT '',
  CONSTRAINT `idUser_admin`
    FOREIGN KEY (`idUser`)
    REFERENCES `ydays_dev_db`.`user` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `idSociete_admin`
    FOREIGN KEY (`idSociete`)
    REFERENCES `ydays_dev_db`.`societe` (`idSociete`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ydays_dev_db`.`secteur_societe`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ydays_dev_db`.`secteur_societe` ;

CREATE TABLE IF NOT EXISTS `ydays_dev_db`.`secteur_societe` (
  `idSecteur_societe` INT NOT NULL COMMENT '',
  `nom_secteur` VARCHAR(45) NULL COMMENT '',
  PRIMARY KEY (`idSecteur_societe`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ydays_dev_db`.`societe`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ydays_dev_db`.`societe` ;

CREATE TABLE IF NOT EXISTS `ydays_dev_db`.`societe` (
  `idSociete` INT NOT NULL COMMENT '',
  `nom` VARCHAR(45) NULL COMMENT '',
  `idSecteur_societe` INT NULL COMMENT '',
  `adresse` VARCHAR(45) NULL COMMENT '',
  `idAdmin` INT NULL COMMENT '',
  `Societecol` VARCHAR(45) NULL COMMENT '',
  PRIMARY KEY (`idSociete`)  COMMENT '',
  INDEX `idSecteur_idx` (`idSecteur_societe` ASC)  COMMENT '',
  INDEX `idAdmin_idx` (`idAdmin` ASC)  COMMENT '',
  CONSTRAINT `idAdmin_societe`
    FOREIGN KEY (`idAdmin`)
    REFERENCES `ydays_dev_db`.`admin` (`idAdmin`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `idSecteur_societe`
    FOREIGN KEY (`idSecteur_societe`)
    REFERENCES `ydays_dev_db`.`secteur_societe` (`idSecteur_societe`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ydays_dev_db`.`categorie_mission`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ydays_dev_db`.`categorie_mission` ;

CREATE TABLE IF NOT EXISTS `ydays_dev_db`.`categorie_mission` (
  `idCategorie_mission` INT NOT NULL COMMENT '',
  `label` VARCHAR(45) NULL COMMENT '',
  `couleur` VARCHAR(45) NULL COMMENT '',
  PRIMARY KEY (`idCategorie_mission`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ydays_dev_db`.`categorie_mission_societe`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ydays_dev_db`.`categorie_mission_societe` ;

CREATE TABLE IF NOT EXISTS `ydays_dev_db`.`categorie_mission_societe` (
  `idSociete` INT NULL COMMENT '',
  `idCategorie_mission` INT NULL COMMENT '',
  INDEX `idCategorie_mission_idx` (`idCategorie_mission` ASC)  COMMENT '',
  INDEX `idSociete_mission_idx` (`idSociete` ASC)  COMMENT '',
  CONSTRAINT `idCategorie_categorie_mission_societe`
    FOREIGN KEY (`idCategorie_mission`)
    REFERENCES `ydays_dev_db`.`categorie_mission` (`idCategorie_mission`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `idSociete_categorie_mission_societe`
    FOREIGN KEY (`idSociete`)
    REFERENCES `ydays_dev_db`.`societe` (`idSociete`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ydays_dev_db`.`employe`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ydays_dev_db`.`employe` ;

CREATE TABLE IF NOT EXISTS `ydays_dev_db`.`employe` (
  `idEmploye` INT NOT NULL COMMENT '',
  `idUser` INT NULL COMMENT '',
  `idSociete` INT NULL COMMENT '',
  PRIMARY KEY (`idEmploye`)  COMMENT '',
  INDEX `idUser_idx` (`idUser` ASC)  COMMENT '',
  INDEX `idSociete_idx` (`idSociete` ASC)  COMMENT '',
  CONSTRAINT `idUser_employe`
    FOREIGN KEY (`idUser`)
    REFERENCES `ydays_dev_db`.`user` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `idSociete_employe`
    FOREIGN KEY (`idSociete`)
    REFERENCES `ydays_dev_db`.`societe` (`idSociete`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ydays_dev_db`.`missions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ydays_dev_db`.`missions` ;

CREATE TABLE IF NOT EXISTS `ydays_dev_db`.`missions` (
  `idMissions` INT NOT NULL COMMENT '',
  `intitule` VARCHAR(45) NULL COMMENT '',
  `date_debut` DATETIME NULL COMMENT '',
  `date_fin` DATETIME NULL COMMENT '',
  `total_employe` INT NULL COMMENT '',
  `idSociete` INT NULL COMMENT '',
  PRIMARY KEY (`idMissions`)  COMMENT '',
  INDEX `idSociete_idx` (`idSociete` ASC)  COMMENT '',
  CONSTRAINT `idSociete_missions`
    FOREIGN KEY (`idSociete`)
    REFERENCES `ydays_dev_db`.`societe` (`idSociete`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ydays_dev_db`.`missions_employe`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ydays_dev_db`.`missions_employe` ;

CREATE TABLE IF NOT EXISTS `ydays_dev_db`.`missions_employe` (
  `idMissions_employe` INT NOT NULL COMMENT '',
  `idEmploye` INT NULL COMMENT '',
  `idMission` INT NULL COMMENT '',
  PRIMARY KEY (`idMissions_employe`)  COMMENT '',
  INDEX `idEmploye_idx` (`idEmploye` ASC)  COMMENT '',
  INDEX `idMission_idx` (`idMission` ASC)  COMMENT '',
  CONSTRAINT `idEmploye_missions_employe`
    FOREIGN KEY (`idEmploye`)
    REFERENCES `ydays_dev_db`.`employe` (`idEmploye`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `idMission_missions_employe`
    FOREIGN KEY (`idMission`)
    REFERENCES `ydays_dev_db`.`missions` (`idMissions`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ydays_dev_db`.`notification`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ydays_dev_db`.`notification` ;

CREATE TABLE IF NOT EXISTS `ydays_dev_db`.`notification` (
  `idNotification` INT NOT NULL COMMENT '',
  `intitule_titre` VARCHAR(45) NULL COMMENT '',
  `contenu` VARCHAR(45) NULL COMMENT '',
  `isValidation` INT NOT NULL DEFAULT 0 COMMENT '',
  `idDate` VARCHAR(45) NULL COMMENT '',
  `idMission` VARCHAR(45) NULL COMMENT '',
  `idCategorie_mission` VARCHAR(45) NULL COMMENT '',
  `idEmploye` VARCHAR(45) NULL COMMENT '',
  `idSociete` INT NULL COMMENT '',
  `idAdmin` INT NULL COMMENT '',
  PRIMARY KEY (`idNotification`)  COMMENT '',
  INDEX `idSociete_idx` (`idAdmin` ASC)  COMMENT '',
  CONSTRAINT `idAdmin_notification`
    FOREIGN KEY (`idAdmin`)
    REFERENCES `ydays_dev_db`.`admin` (`idAdmin`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
