<?php

namespace DAO;

use Models\MovieShow;
use Models\Room;
use Models\Movie;
use \Exception as Exception;

class MovieShowDAO implements IMovieShowDAO
{

    private $connection;
    private $tableName = "movieshow";


    public function __construct()
    {
        $this->connection = new Connection();
    }

    public function getMoviesByDate($date)
    {
        try {

            $query = "SELECT movie.id, movie.title, movie.img, movie.realeseDate, movie.language, movie.overview FROM movie JOIN movieshow on movieshow.idmovie = movie.id WHERE movieshow.date ='$date'";
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute('query', $query);
            $movie = NULL;
            $moviesList = array();
            foreach ($resultSet as $row) {

                $movie = new Movie();
                $movie->setId($row['id']);
                $movie->setTitle($row['title']);
                $movie->setImg($row['img']);
                $movie->setReleaseDate($row['realeseDate']);
                $movie->setLanguage($row['language']);
                $movie->setOverview($row['overview']);


                array_push($moviesList, $movie);
            }

            return $moviesList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function remove($id)
    {
        try {
            $query = "DELETE FROM " . $this->tableName . " WHERE " . $this->tableName . ".id ='$id'";
            $this->connection->Execute('nonQuery', $query);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function getMoviesByGenre($genreId)
    {
        try {
            $query = "SELECT movie.id, movie.title, movie.img, movie.realeseDate, movie.language, movie.overview FROM movie JOIN genresxmovie ON movie.id = genresxmovie.idmovie JOIN movieShow ON movieShow.idMovie = movie.id WHERE genresXmovie.idGenre =$genreId";
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute('query', $query);
            $movie = NULL;
            $moviesList = array();
            foreach ($resultSet as $row) {
                $movie = new Movie();
                $movie->setId($row['id']);
                $movie->setTitle($row['title']);
                $movie->setImg($row['img']);
                $movie->setReleaseDate($row['realeseDate']);
                $movie->setLanguage($row['language']);
                $movie->setOverview($row['overview']);


                array_push($moviesList, $movie);
            }

            return $moviesList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }



    public function add(MovieShow $movieShow, $roomId, $movieId)
    {
        try {


            $query = "INSERT INTO " . $this->tableName . " (idRoom, idMovie, date, time, ticketsSold) VALUES (:idRoom, :idMovie, :date, :time, :ticketsSold);";

            $parameters["idRoom"] = $roomId;
            $parameters["idMovie"] = $movieId;
            $parameters["date"] = $movieShow->getDate();
            $parameters["time"] = $movieShow->getTime();
            $parameters["ticketsSold"] = $movieShow->getTicketsSold();


            $this->connection->execute("nonQuery", $query, $parameters);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function getMovies()
    {
        try {
            $movieList = array();

            $query = "SELECT movie.id, movie.title, movie.img, movie.realeseDate, movie.language, movie.overview FROM movie join movieShow on movieshow.idmovie = movie.id";
            $resultSet = $this->connection->execute('query', $query);

            if (!empty($resultSet)) {
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
            }

            return $movieList;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }


    public function getAll()
    {
        try {
            $movieShowList = array();

            $query = "SELECT ms.id, ms.date, ms.time, ms.ticketsSold, ms.idMovie, ms.idRoom, m.title, m.img, m.realeseDate, m.language, m.overview,
            r.name, r.capacity, r.price FROM movieshow as ms join movie as m on ms.idmovie = m.id join room as r on r.id = ms.idRoom";
            $resultSet = $this->connection->execute('query', $query);

            if (!empty($resultSet)) {
                foreach ($resultSet as $row) {


                    $movieShow = new MovieShow();
                    $movieShow->setId($row["id"]);
                    $movieShow->setDate($row["date"]);
                    $movieShow->setTime($row["time"]);
                    $movieShow->setTicketsSold($row["ticketsSold"]);


                    $movie = new Movie();
                    $movie->setId($row["idMovie"]);
                    $movie->setTitle($row["title"]);
                    $movie->setImg($row["img"]);
                    $movie->setReleaseDate($row["realeseDate"]);
                    $movie->setLanguage($row["language"]);
                    $movie->setOverview($row["overview"]);

                    $room = new Room();
                    $room->setId($row["idRoom"]);
                    $room->setName($row["name"]);
                    $room->setCapacity($row["capacity"]);
                    $room->setPrice($row["price"]);

                    $movieShow->setMovie($movie);
                    $movieShow->setRoom($room);


                    array_push($movieShowList, $movieShow);
                }
            }

            return $movieShowList;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }
    public function getById($movieShowId)
    {

        try {
            
            $query = "SELECT ms.id, ms.date, ms.time, ms.ticketsSold, ms.idMovie, ms.idRoom, m.title, m.img, m.realeseDate, m.language, m.overview,
            r.name, r.capacity, r.price FROM movieshow as ms join movie as m on ms.idmovie = m.id join room as r on r.id = ms.idRoom WHERE ms.id = $movieShowId";
            $resultSet = $this->connection->execute('query', $query);
            $movieShow = null;

            if (!empty($resultSet)) {
                foreach ($resultSet as $row) {

                    $movieShow = new MovieShow();
                    $movieShow->setId($row["id"]);
                    $movieShow->setDate($row["date"]);
                    $movieShow->setTime($row["time"]);
                    $movieShow->setTicketsSold($row["ticketsSold"]);


                    $movie = new Movie();
                    $movie->setId($row["idMovie"]);
                    $movie->setTitle($row["title"]);
                    $movie->setImg($row["img"]);
                    $movie->setReleaseDate($row["realeseDate"]);
                    $movie->setLanguage($row["language"]);
                    $movie->setOverview($row["overview"]);

                    $room = new Room();
                    $room->setId($row["idRoom"]);
                    $room->setName($row["name"]);
                    $room->setCapacity($row["capacity"]);
                    $room->setPrice($row["price"]);

                    $movieShow->setMovie($movie);
                    $movieShow->setRoom($room);
                }
            }

            return $movieShow;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }
}
