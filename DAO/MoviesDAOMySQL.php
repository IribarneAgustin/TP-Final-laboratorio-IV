<?php

namespace DAO;

use DAO\IMovieDAO as IMovieDAO;
use Models\Movie as Movie;
use DAO\Connection as Connection;
use \Exception as Exception;
use Models\Genre;

class MoviesDAOMySQL implements IMoviesDAO
{
    private $key;
    private $connection;
    private $tableName = "movie";

    public function __construct()
    {
    }
    public function addGenre($genreId, $name)
    {
        try {

            $query = "INSERT INTO genre (id,name) VALUES (:id,:name);";
            $parameters['id'] = $genreId;
            $parameters['name'] = $name;

            $this->connection = Connection::GetInstance();
            $this->connection->execute('nonQuery', $query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    public function addGenreXmovie($movieId, $genreId)
    {

        try {

            $query = "INSERT INTO genresXmovie (idMovie,idGenre) VALUES (:idMovie,:idGenre);";
            $parameters['idMovie'] = $movieId;
            $parameters['idGenre'] = $genreId;

            $this->connection = Connection::GetInstance();
            $this->connection->execute('nonQuery', $query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function add(Movie $movie)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (id, title, img, realeseDate, language, overview) VALUES (:id, :title, :img ,:realeseDate, :language, :overview);";
            $parameters["id"] = $movie->getId();
            $parameters["title"] = $movie->getTitle();
            $parameters["img"] = $movie->getImg();
            $parameters["realeseDate"] = $movie->getReleaseDate();
            $parameters["language"] = $movie->getLanguage();
            $parameters["overview"] = $movie->getOverview();


            $this->connection = Connection::GetInstance();

            $this->connection->Execute('nonQuery', $query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }


    public function delete($id)
    {
        try {
            $query = "DELETE FROM " . $this->tableName . " WHERE " . $this->tableName . ".id ='$id'";
            $this->connection = Connection::GetInstance();
            $this->connection->Execute('nonQuery', $query);
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    public function getGenreList()
    {
        try {
            $genreList = array();

            $query = "SELECT * FROM genre";

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute('query', $query);

            foreach ($resultSet as $row) {
                $genre = new Genre();

                $genre->setId($row["id"]);
                $genre->setName($row["name"]);

                array_push($genreList, $genre);
            }

            return $genreList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    public function getGenreById($id)
    {
        try {
            $query = "SELECT * FROM " . $this->tableName . " WHERE genre.id ='$id'";
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute('query', $query);
            $genre = NULL;

            foreach ($resultSet as $row) {
                $genre = new Genre();

                $genre->setId($row["id"]);
                $genre->setName($row["name"]);
            }

            return $genre;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    public function getGenresByMovieId($movieId)
    {
        try {
            $query = "SELECT genre.id, genre.name FROM genresxmovie JOIN genre ON genre.id = genresxmovie.idGenre WHERE genresXmovie.idMovie =$movieId";
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute('query', $query);
            $genre = NULL;
            $genresList = array();
            foreach ($resultSet as $row) {
                $genre = new Genre();

                $genre->setId($row["id"]);
                $genre->setName($row["name"]);

                array_push($genresList, $genre);
            }

            return $genresList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }


    public function getAll()
    {
        try {
            $movieList = array();

            $query = "SELECT * FROM " . $this->tableName;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute('query', $query);

            foreach ($resultSet as $row) {
                $movie = new Movie();
                $movie->setId($row["id"]);
                $movie->setTitle($row["title"]);
                $movie->setImg($row["img"]);
                $movie->setReleaseDate($row["realeseDate"]);
                $movie->setLanguage($row["language"]);
                $movie->setOverview($row["overview"]);


                array_push($movieList, $movie);
            }

            return $movieList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
