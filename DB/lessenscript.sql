

DROP DATABASE IF EXISTS `FitForFun`;

CREATE DATABASE `FitForFun`;

USE `FitForFun`;

CREATE TABLE Les
(
    id                       INT                NOT NULL       AUTO_INCREMENT      PRIMARY KEY,
    Naam                     VARCHAR(50)         NOT NULL,
    datum                    DATE                NOT NULL,
    tijd                     TIME                NOT NULL,
    MinAantalPersonen        TINYINT            NOT NULL,
    MaxAantalPersonen        TINYINT            NOT NULL,
    Beschikbaarheid          VARCHAR(50)        NOT NULL,      
    Isactief                 BIT                NOT NULL,
    Opmerking                VARCHAR(250)       NULL,
    Datumaangemaakt          DATETIME(6)        NOT NULL,
    Datumgewijzigd           DATETIME(6)        NOT NULL,
    CHECK (MinAantalPersonen >= 3),
    CHECK (MaxAantalPersonen <= 9)
);

INSERT INTO Les
(
    Naam,
    datum,
    tijd,
    MinAantalPersonen,
    MaxAantalPersonen,
    Beschikbaarheid,
    Isactief,
    Opmerking,
    Datumaangemaakt,
    Datumgewijzigd
)
VALUES
('Emma Jansen', '2025-03-03', '09:00:00', 3, 8, 'Ingepland', 1, 'Ochtendles Yoga', NOW(), NOW()),
('Liam Verhoeven', '2025-03-04', '14:30:00', 3, 9, 'Gestart', 1, 'Groepstraining Yoga', NOW(), NOW()),
('Noah de Groot', '2025-03-05', '16:00:00', 3, 7, 'Niet gestart', 1, 'Ochtend Yoga', NOW(), NOW()),
('Sophie Bakker', '2025-03-06', '18:15:00', 3, 9, 'Geannuleerd', 0, 'Te weinig aanmeldingen', NOW(), NOW()),
('Daan van Dijk', '2025-03-07', '20:00:00', 3, 6, 'Ingepland', 1, 'MaandagAvond les Yoga', NOW(), NOW()),
('Lisa de Wit', '2025-03-08', '10:00:00', 3, 8, 'Gestart', 1, 'Zaterdagavond Yoga', NOW(), NOW()),
('Tom Willems', '2025-03-09', '11:30:00', 3, 5, 'Niet gestart', 1, 'Zondagochtend Yoga', NOW(), NOW());
