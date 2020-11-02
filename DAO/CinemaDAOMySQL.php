<?php

namespace DAO;

use DAO\ICinemaDAO as ICinemaDAO;
use Models\Cinema as Cinema;


class CinemaDAOMySQL implements ICinemaDAO
{
    private $connection;
    private $tableName = "cinema";

    public function __construct()
    {
        $this->connection = new Connection();
    }

    public function add(Cinema $cinema)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (name, address, status) VALUES (:name, :address, :status);";
            $parameters["name"] = $cinema->getName();
            $parameters["address"] = $cinema->getAddress();
            $parameters["status"] = $cinema->getStatus();

            $this->connection->execute("nonQuery", $query, $parameters);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function update(Cinema $modifiedCinema)
    {
        try {

            $name = $modifiedCinema->getName();
            $address = $modifiedCinema->getAddress();
            $id = $modifiedCinema->getId();
            $status = $modifiedCinema->getStatus();

            $query = "UPDATE $this->tableName SET name='$name',address= '$address', status='$status' WHERE id='$id'";
            $this->connection->execute('nonQuery', $query);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function remove($cinemaId)
    {
        try {
            
            $query = "UPDATE $this->tableName SET status=false WHERE id='$cinemaId'";
            $this->connection->execute('nonQuery', $query);

        } catch (\PDOException $ex) {
            throw $ex;
        }
    }
    public function activate($cinemaId){
        try {
            $status = true;
            $query = "UPDATE $this->tableName SET status=true WHERE id='$cinemaId'";
            $this->connection->execute('nonQuery', $query);

        } catch (\PDOException $ex) {
            throw $ex;
        }
        
    }

    public function getAll()
    {
        try {
            $cinemaList = array();

            $query = "SELECT * FROM " . $this->tableName;

            $resultSet = $this->connection->execute('query', $query);

            if (!empty($resultSet)) {
                foreach ($resultSet as $row) {

                    $cinema = new Cinema();
                    $cinema->setId($row["id"]);
                    $cinema->setName($row["name"]);
                    $cinema->setAddress($row["address"]);
                    $cinema->setStatus($row["status"]);

                    array_push($cinemaList, $cinema);
                }
            }

            return $cinemaList;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }


    public function getById($idCinema)
    {
        try {
            $query = "SELECT * FROM " . $this->tableName . " WHERE " . $this->tableName . ".id ='$idCinema'";

            $resultSet = $this->connection->execute('query', $query);
            $cinema = NULL;
            foreach ($resultSet as $row) {

                $cinema = new Cinema();
                $cinema->setId($row["id"]);
                $cinema->setName($row["name"]);
                $cinema->setAddress($row["address"]);
                $cinema->setStatus($row["status"]);
            }
            return $cinema;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function getCinemaByRoomId($roomId)
    {
        try {
            $query = "SELECT cinema.id, cinema.address, cinema.name, cinema.status from room join cinema on room.idCinema = cinema.id where room.id = 1";

            $resultSet = $this->connection->execute('query', $query);
            $cinema = NULL;
            foreach ($resultSet as $row) {

                $cinema = new Cinema();
                $cinema->setId($row["id"]);
                $cinema->setName($row["name"]);
                $cinema->setAddress($row["address"]);
                $cinema->setStatus($row["status"]);
            }
            return $cinema;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }


    public function existsName($name)
    {
        $exists = false;

        try {
            $query = "SELECT * FROM " . $this->tableName . " WHERE " . $this->tableName . ".name ='$name'";

            $resultSet = $this->connection->execute('query', $query);

            if (!empty($resultSet)) {
                $exists = true;
            }
            return $exists;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }
}
