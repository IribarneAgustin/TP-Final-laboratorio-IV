<?php
namespace DAO;

use Models\MovieShow;
use Models\Room;
use Models\Movie;

class MovieShowDAO //implements IMovieShowDAO
{

    private $connection;
    private $tableName = "movieshow";
  

    public function __construct()
    {
        $this->connection = new Connection();
    }

    public function add(MovieShow $movieShow,$roomId,$movieId)
    {
        try {
            
            
            $query = "INSERT INTO " . $this->tableName . " (idRoom, idMovie, date, time, ticketsSold) VALUES (:idRoom, :idMovie, :date, :time, :ticketsSold);";

            $parameters["idRoom"] = $roomId;
            $parameters["idMovie"] = $movieId;
            $parameters["date"] = $movieShow->getDate();
            $parameters["time"] = $movieShow->getTime();
            $parameters["ticketsSold"] = $movieShow->getTicketsSold();


            $this->connection->execute("nonQuery",$query, $parameters);

        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function getAll()
    {
        try {
            $movieShowList = array();

            $query = "SELECT * FROM movieshow join movie on movieshow.idmovie = movie.id join room on room.id = movieshow.idRoom";
            $resultSet = $this->connection->execute('query',$query);

            if (!empty($resultSet)) {
                foreach ($resultSet as $row) {

                    $movieShow = new MovieShow();
                    $movieShow->setId($row["id"]);
                    $movieShow->setDate($row["date"]);
                    $movieShow->setTime($row["time"]);
                    $movieShow->setTicketsSold($row["ticketsSold"]);

                    $movie = new Movie();
                    $movie->setId($row["id"]);
                    $movie->setTitle($row["title"]);
                    $movie->setImg($row["img"]);
                    $movie->setReleaseDate($row["realeseDate"]);
                    $movie->setLanguage($row["language"]);
                    $movie->setOverview($row["overview"]);

                    $room = new Room();
                    $room->setId($row["id"]);
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



}