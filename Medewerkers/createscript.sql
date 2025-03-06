DROP DATABASE IF EXISTS `Medewerkers`;
CREATE DATABASE `Medewerkers`;
USE `Medewerkers`;

CREATE TABLE MedewerkersOverzicht
(
    Id                  INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    VoorNaam            VARCHAR(50) DEFAULT NULL,
    Tussenvoegsel       VARCHAR(10) NULL,
    Achternaam          VARCHAR(50) NOT NULL,
    Nummer              MEDIUMINT UNSIGNED NOT NULL,
    Medewerkersoort     ENUM('Manager', 'Beheerder', 'DiskMedewerker') NOT NULL,
    IsActief            BIT NOT NULL DEFAULT 1,
    Opmerking           VARCHAR(250) NULL,
    DatumAangemaakt     DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd      DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB;

INSERT INTO MedewerkersOverzicht 
(
    VoorNaam,
    Tussenvoegsel,
    Achternaam,
    Nummer,
    Medewerkersoort,
    IsActief,
    DatumAangemaakt,
    DatumGewijzigd
) 
VALUES 
  ('Arjan', 'de', 'Ruiter', 1, 'Manager', 1, SYSDATE(6), SYSDATE(6)),
  ('Nico', 'van', 'Brugen', 2, 'Beheerder', 1, SYSDATE(6), SYSDATE(6)),
  ('Denis', NULL, 'Law', 3, 'Beheerder', 1, SYSDATE(6), SYSDATE(6)),
  ('Robert', 'van', 'Hammer', 4, 'DiskMedewerker', 1, SYSDATE(6), SYSDATE(6));
