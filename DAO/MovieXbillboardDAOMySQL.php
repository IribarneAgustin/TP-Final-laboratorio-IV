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
            $query = "SELECT * FROM " . $this->tableName . " WHERE " . "id$this->tableName  ='$billboardId'";

            $resultSet = $this->connection->execute('query',$query);
            $billboard = NULL;
            foreach ($resultSet as $row) {

                $billboard = new Billboard();
                $billboard->setId($row["idBillboard"]);
                $billboard->setName($row["name"]);
                $billboard->setStatus($row["status"]);
            }
            return $billboard;
        } catch (\PDOException $ex) {
            throw $ex;
        }


    }


}