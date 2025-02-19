

DROP DATABASE IF EXISTS `FitForFun`;

CREATE DATABASE `FitForFun`;

USE `FitForFun`;

DROP TABLE reservations;

CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    time TIME NOT NULL,
	lesson_id       INT,
    reservation_date DATE NOT NULL,
    user_name       VARCHAR(255) NOT NULL,
    user_email      VARCHAR(255) NOT NULL,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id),
    UNIQUE KEY unique_reservation (date, time) 
);

INSERT INTO reservations 
(
 date
,time
,lesson_id
,reservation_date
,user_name
,user_email
)

VALUES
(1, '2025-03-01', 'John Doe', 'john.doe@example.com'),
(2, '2025-03-01', 'Jane Smith', 'jane.smith@example.com'),
(3, '2025-03-01', 'Emma Brown', 'emma.brown@example.com');

DROP TABLE lessons;


CREATE TABLE lessons (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    name            VARCHAR(255) NOT NULL,
    date            DATE NOT NULL,
    time            TIME NOT NULL
);


INSERT INTO lessons (name, date, time)
VALUES
('Yoga', '2025-03-01', '09:00'),
('Yin Yoga', '2025-03-01', '12:00');
('Meditatie', '2025-03-01', '10:00'),
('Pilates', '2025-03-01', '11:00'),
