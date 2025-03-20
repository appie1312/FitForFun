DROP DATABASE IF EXISTS `FitForFun`;

CREATE DATABASE `FitForFun`;

USE `FitForFun`;

CREATE TABLE Lessen	 
(
    les_id              INT                     NOT NULL                    PRIMARY KEY AUTO_INCREMENT,
    naam                VARCHAR(50)             NOT NULL,
    tijd                TIME                    NOT NULL, 
    prijs               DECIMAL(5,2)            NOT NULL,
    datum               DATE                    NOT NULL, 
    tijdduur            TIME                    NOT NULL,
    MinAantalPersonen   TINYINT                 NOT NULL,   
    MaxAantalPersonen   TINYINT                 NOT NULL,
    Beschikbaarheid     VARCHAR(50)             NOT NULL,
    IsActief            BIT                     NOT NULL, 
    Opmerking           VARCHAR(250)            NOT NULL,
    DatumAangemaakt     DATETIME                NOT NULL,
    DatumGewijzigd      DATETIME                NOT NULL
);

INSERT INTO Lessen 
(
    naam
    ,tijd
    ,prijs
    ,datum
    ,tijdduur
    ,MinAantalPersonen
    ,MaxAantalPersonen
    ,Beschikbaarheid
    ,IsActief
    ,Opmerking
    ,DatumAangemaakt
    ,DatumGewijzigd
)


VALUES
('Yoga', '09:00', 29.99, NOW(), '01:00:00', 3, 9, 'Beschikbaar', 1, 'Ochtendles', SYSDATE(6), SYSDATE(6)),
('Yin Yoga', '20:00', 34.99, NOW(), '01:00:00', 3, 9, 'Beschikbaar', 1, 'Avondles', SYSDATE(6), SYSDATE(6)),
('Meditatie', '13:00',  24.99,NOW(), '01:30:00', 3, 9, 'Beschikbaar', 1, 'Middagles', SYSDATE(6), SYSDATE(6)),
('Pilates', '10:00', 29.99, NOW(),  '01:30:00', 3, 9, 'Beschikbaar', 1, 'Ochtendles', SYSDATE(6), SYSDATE(6));
    




CREATE TABLE Gebruiker (
    Id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Voornaam VARCHAR(50) NOT NULL,
    Tussenvoegsel VARCHAR(10) NULL,
    Achternaam VARCHAR(50) NOT NULL,
    Gebruikersnaam VARCHAR(100) NOT NULL,
    Wachtwoord VARCHAR(20) NOT NULL,
    IsIngelogd BIT NOT NULL,
    Ingelogd DATE NOT NULL,
    Uitgelogd DATE NOT NULL,
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250) NULL,
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL
);

INSERT INTO Gebruiker (Voornaam, Tussenvoegsel, Achternaam, Gebruikersnaam, Wachtwoord, IsIngelogd, Ingelogd, Uitgelogd, Isactief, Opmerking, Datumaangemaakt, Datumgewijzigd) 
VALUES 
('Ahmed', 'el', 'Bakri', '1', '1', 0, '2024-03-06', '2024-03-06', 1, 'Derde gebruiker', NOW(), NOW());

CREATE TABLE Rol (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    GebruikerId INT NOT NULL,
    Naam VARCHAR(100) NOT NULL CHECK (Naam IN ('Lid', 'Medewerker', 'Administrator', 'Gastgebruiker')),
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250) NULL,
    Datumaangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    Datumgewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    CONSTRAINT FK_Gebruiker FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id)
);


CREATE TABLE MedewerkersOverzicht
(
    Id                  INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    VoorNaam            VARCHAR(50) DEFAULT NULL,
    Tussenvoegsel       VARCHAR(10) NULL,
    Achternaam          VARCHAR(50) NOT NULL,
    Nummer              MEDIUMINT UNSIGNED NOT NULL,
    Medewerkersoort     VARCHAR(20) NOT NULL, 
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

