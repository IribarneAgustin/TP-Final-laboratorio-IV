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
            $query = "INSERT INTO " . $this->tableName . " (name, address) VALUES (:name, :address);";

            $parameters["name"] = $cinema->getName();
            $parameters["address"] = $cinema->getAddress();

            $this->connection->execute("nonQuery",$query, $parameters);
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

            $query = "UPDATE $this->tableName SET name='$name',address= '$address' WHERE id='$id'";
            $this->connection->execute('nonQuery', $query);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function remove($cinemaId)
    {
        try {
            $query = "DELETE FROM " . $this->tableName . " WHERE " . $this->tableName . ".id ='$cinemaId'";
            $this->connection->execute('nonQuery',$query);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function getAll()
    {
        try {
            $cinemaList = array();

            $query = "SELECT * FROM " . $this->tableName;

            $resultSet = $this->connection->execute('query',$query);

            if (!empty($resultSet)) {
                foreach ($resultSet as $row) {

                    $cinema = new Cinema();
                    $cinema->setId($row["id"]);
                    $cinema->setName($row["name"]);
                    $cinema->setAddress($row["address"]);

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

            $resultSet = $this->connection->execute('query',$query);
            $cinema = NULL;
            foreach ($resultSet as $row) {

                $cinema = new Cinema();
                $cinema->setId($row["id"]);
                $cinema->setName($row["name"]);
                $cinema->setAddress($row["address"]);
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

            $resultSet = $this->connection->execute('query',$query);

            if (!empty($resultSet)) {
                $exists = true;
            }
            return $exists;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }
}
