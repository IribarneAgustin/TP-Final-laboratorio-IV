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
    overview VARCHAR(700) NOT NULL
);

CREATE TABLE genre
(   
	id INT NOT NULL PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);
select * from genresXmovie
create table genresXmovie
(
id int not null auto_increment PRIMARY KEY,
idGenre int not null,
idMovie int not null,

constraint fk_idGenre_gxm foreign key (idGenre) references genre (id),
constraint fk_idMovie_gxm foreign key (idMovie) references movie (id)

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

CREATE TABLE movieShow
(
    id INT NOT NULL PRIMARY KEY auto_increment,
    idRoom INT NOT NULL,
    idMovie INT NOT NULL,
    date VARCHAR(100) NOT NULL,
    time VARCHAR(100) NOT NULL,
    ticketsSold INT NOT NULL,
    CONSTRAINT fk_idRoom foreign key (idRoom) references room (id),
    CONSTRAINT fk_idMovie foreign key (idMovie) references movie (id)
);
