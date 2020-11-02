CREATE DATABASE cinemadb;

USE cinemadb;


CREATE TABLE cinema
(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    address VARCHAR(100) NOT NULL,
    status boolean not null
);

CREATE TABLE movie
(
    id INT NOT NULL PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    img VARCHAR(100) NOT NULL,
    realeseDate VARCHAR(100) NOT NULL,
    language VARCHAR(100) NOT NULL,
    overview VARCHAR(700) NOT NULL
);

CREATE TABLE genre
(   
	id INT NOT NULL PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

create table genresXmovie
(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idGenre int not null,
    idMovie int not null,

    constraint fk_idGenre_gxm foreign key (idGenre) references genre (id),
    constraint fk_idMovie_gxm foreign key (idMovie) references movie (id)

);


CREATE TABLE user
(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) NOT NULL,
    email VARCHAR(30) NOT NULL,
    password VARCHAR(10) NOT NULL,
    role VARCHAR(15) NOT NULL,
);

CREATE TABLE room
(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idCinema INT NOT NULL,
    name VARCHAR(20) NOT NULL,
    capacity INT NOT NULL,
    price INT NOT NULL,
    status boolean not null,
    CONSTRAINT fk_idCinema foreign key (idCinema) references cinema (id)
);

CREATE TABLE movieShow
(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idRoom INT NOT NULL,
    idMovie INT NOT NULL,
    date VARCHAR(100) NOT NULL,
    time VARCHAR(100) NOT NULL,
    ticketsSold INT NOT NULL,
    status boolean not null,
    CONSTRAINT fk_idRoom foreign key (idRoom) references room (id),
    CONSTRAINT fk_idMovie foreign key (idMovie) references movie (id)
);

CREATE TABLE ticket(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idUser int not null,
    idMovieShow int not null,
    quantity int not null,
    total int not null,
    status boolean not null,

CONSTRAINT fk_idUser_ticket foreign key (idUser) references user (dni),
CONSTRAINT fk_idMovieShow_ticket foreign key (idMovieShow) references movieshow (id)
);
