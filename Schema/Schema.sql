CREATE DATABASE cinemadb;

USE cinemadb;

CREATE TABLE cinema
(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    capacity INT NOT NULL,
    address VARCHAR(100) NOT NULL,
    ticketPrice INT NOT NULL

);

create table roomXcine(
 id INT NOT NULL AUTO_INCREMENT,
 idCinema INT NOT NULL,
 idRoom INT NOT NULL,
 
CONSTRAINT pk_idRxC primary key (id),
CONSTRAINT fk_idCinema_rxc foreign key (idCinema) references cinema (id),
CONSTRAINT fk_idRoom_rxc foreign key (idRoom) references room (id)
);

CREATE TABLE movie
(
    id INT NOT NULL PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    img VARCHAR(100) NOT NULL,
    realeseDate VARCHAR(100) NOT NULL,
    language VARCHAR(100) NOT NULL,
    overview VARCHAR(100) NOT NULL,
    genres VARCHAR(100) NOT NULL
);

insert into movie (id,title,img,realeseDate,language,overview,genres) values (413518,1,1,1,1,1,1)

CREATE TABLE genre
(   id INT NOT NULL PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);


CREATE TABLE user
(
    dni INT NOT NULL PRIMARY KEY,
    nameUser VARCHAR(20) NOT NULL,
    lastNameUser VARCHAR(20) NOT NULL,
    age INT NOT NULL,
    sex VARCHAR(10) NOT NULL,
    email VARCHAR(30) NOT NULL,
    pass VARCHAR(10) NOT NULL
);

CREATE TABLE room
(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(20) NOT NULL,
    price INT NOT NULL,
    capacity INT NOT NULL
);

CREATE TABLE billboard(
idBillboard INT NOT NULL auto_increment,
name VARCHAR(30) NOT NULL,
status boolean not null,
constraint pk_idBillboard primary key (idBillboard)
);


CREATE TABLE movieXbillboard(
idMovieXbillboard INT NOT NULL auto_increment,
idMovie int not null,
idBillboard int not null,
initDate date not null,
status boolean not null,

CONSTRAINT pk_idMovieXbillboard primary key (idMovieXbillboard),
CONSTRAINT fk_idMovie_mxb foreign key (idMovie) references movie (id),
CONSTRAINT fk_idBillboard_mxb foreign key (idBillboard) references billboard (idBillboard)
);
