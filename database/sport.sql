-- Creation de la database
create database Sports;

--Pour voir tous les databases
show databases;

--Travaille sur cette database
use Sports;

--create table users
CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nom varchar(50) NOT NULL,
    email varchar(250) UNIQUE NOT NULL,
    telephone varchar(20) NOT NULL,
    password varchar(255) NOT NULL,
    role enum('sportif','coach')
);

--create table coach
CREATE TABLE coach (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user int ,
    experience int NOT NULL,
    biographie text NOT NULL,
    photo varchar(255) NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id_user),
);

--create table sportif
CREATE TABLE sportif (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user int ,
    niveau varchar(50),
    FOREIGN KEY (id_user) REFERENCES users(id_user)
);

--create table reserrvation
CREATE TABLE reservation (
    id_reserv INT AUTO_INCREMENT PRIMARY KEY,
    id_coach INT,
    id_sportif INT,
    date_r DATE,
    heure TIME,
    statut ENUM('acceptée','en_attente','refusée'),
    FOREIGN KEY (id_coach) REFERENCES coach(id),
    FOREIGN KEY (id_sportif) REFERENCES sportif(id)
);


--create table disponibilite
CREATE TABLE disponibilite(
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_coach INT NOT NULL,
    jour  DATE,
    heure_d TIME(0),
    heure_f TIME(0),
    FOREIGN KEY (id_coach) REFERENCES coach(id)
);

