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
