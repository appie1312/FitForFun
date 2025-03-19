DROP DATABASE IF EXISTS `FitForFun`;

CREATE DATABASE `FitForFun`;

USE `FitForFun`;

CREATE TABLE Lessen	 
(
    les_id          INT PRIMARY                         KEY AUTO_INCREMENT,
    les_naam        VARCHAR(255)        NOT NULL,
    beschrijving                                        TEXT,
    duur            INT,  
    leraar          VARCHAR(255),
    datum           DATE
);

INSERT INTO Lessen 
(
    les_naam
    ,beschrijving
    ,duur
    ,leraar
    ,datum
) 


VALUES
('Yoga', 'Een algemene yogales waarbij verschillende houdingen (asanas) en ademhalingstechnieken (pranayama) worden beoefend om flexibiliteit, kracht en ontspanning te bevorderen.', 60, 'Anna de Vries', '2025-03-10'),
('Yin Yoga', 'Yin Yoga is een langzame, rustgevende yoga-stijl waarbij houdingen langer worden vastgehouden om dieper in het bindweefsel te rekken en ontspanning te bevorderen.', 75, 'Mark Jansen', '2025-03-12'),
('Meditatie', 'Meditatie sessies waarbij verschillende technieken worden gebruikt om de geest te kalmeren, focus te verbeteren en stress te verminderen.', 30, 'Sophie Bakker', '2025-03-15'),
('Pilates', 'Pilates richt zich op het versterken van de core-spieren, verbeteren van de houding en flexibiliteit door gecontroleerde bewegingen en ademhalingstechnieken.', 60, 'Tom de Wit', '2025-03-17');



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
('Jan', 'van', 'Dijk', 'jvandijk', 'wachtwoord123', 0, '2024-03-06', '2024-03-06', 1, 'Eerste gebruiker', NOW(), NOW()), 
('Lisa', NULL, 'Jansen', 'ljansen', 'geheim123', 1, '2024-03-06', '2024-03-06', 1, 'Tweede gebruiker', NOW(), NOW()), 
('Ahmed', 'el', 'Bakri', 'test123', 'test123', 0, '2024-03-06', '2024-03-06', 1, 'Derde gebruiker', NOW(), NOW());


CREATE TABLE Les (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Naam VARCHAR(50) NOT NULL,
    Datum DATE NOT NULL,
    Tijd TIME NOT NULL,
    MinAantalPersonen TINYINT NOT NULL CHECK (MinAantalPersonen >= 3),
    MaxAantalPersonen TINYINT NOT NULL CHECK (MaxAantalPersonen <= 9),
    Beschikbaarheid ENUM('Ingepland', 'Niet gestart', 'Gestart', 'Geannuleerd') NOT NULL,
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250) NULL,
    Datumaangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    Datumgewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);


INSERT INTO Les (Naam, Datum, Tijd, MinAantalPersonen, MaxAantalPersonen, Beschikbaarheid, Isactief, Opmerking) 
VALUES 
('Yoga Basics', '2025-03-10', '08:30:00', 3, 9, 'Ingepland', 1, 'Voor beginners, neem je eigen mat mee.'),
('Vinyasa Flow', '2025-03-12', '18:00:00', 3, 9, 'Niet gestart', 1, 'Dynamische yogales met ademhalingsoefeningen.'),
('Yin Yoga', '2025-03-15', '20:00:00', 3, 9, 'Ingepland', 1, 'Ontspannende les met lang aangehouden houdingen.');


CREATE DATABASE `Medewerkers`;


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