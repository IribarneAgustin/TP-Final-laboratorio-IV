<?php
namespace DAO;

use Models\MovieShow;

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

            $query = "SELECT * FROM " . $this->tableName;

            $resultSet = $this->connection->execute('query',$query);

            if (!empty($resultSet)) {
                foreach ($resultSet as $row) {

                    $movieShow = new MovieShow();
                    $movieShow->setId($row["id"]);
                    $movieShow->setDate($row["date"]);
                    $movieShow->setTime($row["time"]);
                    $movieShow->setTicketsSold($row["ticketsSold"]);

                    array_push($movieShowList, $movieShow);
                }
            }

            return $movieShowList;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }



}