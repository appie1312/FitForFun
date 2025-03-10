DROP DATABASE IF EXISTS `FitForFun`;

CREATE DATABASE `FitForFun`;

USE `FitForFun`;

CREATE TABLE IF NOT EXISTS lessons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL
);

INSERT INTO lessons (name, date, time)
VALUES
('Yoga', '2025-03-01', '09:00'),
('Yin Yoga', '2025-03-01', '12:00'),
('Meditatie', '2025-03-01', '10:00'),
('Pilates', '2025-03-01', '11:00');

CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    time TIME NOT NULL,
    lesson_id INT,
    reservation_date DATE NOT NULL,
    user_name VARCHAR(255) NOT NULL,
    user_email VARCHAR(255) NOT NULL,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id),
    UNIQUE KEY unique_reservation (date, time)
);

INSERT INTO reservations 
(
    date,
    time,
    lesson_id,
    reservation_date,
    user_name,
    user_email
)
VALUES
('Yoga', '2025-03-01', '09:00'),
('Yin Yoga', '2025-03-01', '12:00'),
('Meditatie', '2025-03-01', '10:00'),
('Pilates', '2025-03-01', '11:00'),


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
