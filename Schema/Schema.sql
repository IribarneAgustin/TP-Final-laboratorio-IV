CREATE DATABASE cinemadb;


USE cinemadb;

CREATE TABLE cinema
(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    address VARCHAR(100) NOT NULL
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

insert into movie (id,title,img,realeseDate,language,overview,genres) values (413518,1,1,1,1,1,1);

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
    idCinema INT NOT NULL,
    name VARCHAR(20) NOT NULL,
    capacity INT NOT NULL,
    price INT NOT NULL,
    CONSTRAINT fk_idCinema foreign key (idCinema) references cinema (id)
);


CREATE TABLE movieXcinema
(
    idMovieXcinema INT NOT NULL auto_increment,
    idMovie int not null,
    idCinema int not null,
    status boolean not null,

    CONSTRAINT pk_idMovieXcinema primary key (idMovieXcinema),
    CONSTRAINT fk_idMovie_mxc foreign key (idMovie) references movie (id),
    CONSTRAINT fk_idCinema_mxc foreign key (idCinema) references cinema (id)
);
