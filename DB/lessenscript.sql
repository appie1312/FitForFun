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

