

DROP DATABASE IF EXISTS `FitForFun`;

CREATE DATABASE `FitForFun`;

USE `FitForFun`;

CREATE TABLE reservations 
(
    id                      INT                                AUTO_INCREMENT      PRIMARY KEY
    ,Datum                   DATE                NOT NULL
    ,Tijd                   TIME                NOT NULL
    ,                       UNIQUE(date, time)
);




