<?php

namespace DAO;

use Models\Movie;
use Models\Cinema;

class BillboardDAO implements IBillboardDAO
{

    private $connection;
    private $tableName = "movieXcinema";

    public function __construct()
    {
        $this->connection = new Connection();
    }

    public function add(Movie $movie, Cinema $cinema)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (idMovie, idCinema, status) VALUES (:idMovie, :idCinema, :status);";

            $parameters["idMovie"] = $movie->getId();
            $parameters["idCinema"] = $cinema->getId();
            $parameters["status"] = true;
            $this->connection->execute("nonQuery", $query, $parameters);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }
    public function getMoviesByCinemaId($cinemaId)
    {
        try {
            $query = "SELECT * FROM movie as m JOIN " . $this->tableName . " as mxc ON m.id = mxc.idMovie WHERE mxc.cinemaId =" . $cinemaId;
            $resultSet = $this->connection->execute('query', $query);
            $moviesList = array();
            foreach ($resultSet as $row) {

                $movie = new Movie();
                $movie->setId($row["id"]);
                $movie->setTitle($row["title"]);
                $movie->setImg($row["img"]);
                $movie->setReleaseDate($row["realeseDate"]);
                $movie->setLanguage($row["language"]);
                $movie->setOverview($row["overview"]);
                $movie->setGenres($row["genres"]);
                array_push($moviesList, $movie);
            }
            return $moviesList;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function onBillboard(Movie $movie, Cinema $cinema)
    {
        try {

            $movieId = $movie->getId();
            $cinemaId = $cinema->getId();
            $exist = false;
            $query = "SELECT * FROM " . $this->tableName . " WHERE  idMovie=".$movieId." AND idCinema=".$cinemaId;

            $resultSet = $this->connection->execute('query', $query);
            
            if($resultSet != null){
                $exist = true;
            }


           
            return $exist;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }
}
