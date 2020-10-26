<?php
namespace DAO;
use Models\Movie;
use Models\Billboard;

class MovieXbillboardDAOMySQL{

    private $connection;
    private $tableName = "movieXbillboard";

    public function __construct()
    {
        $this->connection = new Connection();
    }
    public function add(Billboard $billboard, Movie $movie)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (idMovie, idBillboard, initDate, status) VALUES (:idMovie, :idBillboard, :initDate,:status);";

            $parameters["idMovie"] = $movie->getId();
            $parameters["idBillboard"] = $billboard->getId();
            $parameters["initDate"] = date("d/m/y");
            $parameters["status"] = true;

            
            $this->connection->execute("nonQuery",$query, $parameters);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }
    public function getMoviesByBillboardId($billboardId){
        try {
            $query = "SELECT m.id, m.title, m.img, m.realeseDate, m.language,m.overview, m.genres FROM movie as m JOIN " .$this->tableName. " as mxb on m.id = mxb.idMovie WHERE mxb.idBillboard =".$billboardId;
            $resultSet = $this->connection->execute('query',$query);
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
                array_push($moviesList,$movie);
            }
            return $moviesList;
        } catch (\PDOException $ex) {
            throw $ex;
        }


    }


}