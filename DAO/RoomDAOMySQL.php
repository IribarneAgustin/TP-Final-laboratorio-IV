<?php
namespace DAO;
use Models\Room;


class RoomDAOMySQL// implements IRoomDAO
{


    private $connection;
    private $tableName = "room";

    public function __construct()
    {
        $this->connection = new Connection();
    }

    public function add(Room $room, $idCinema)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (idCinema, name, capacity, price) VALUES (:idCinema, :name, :capacity, :price);";

            $parameters["idCinema"] = $idCinema;
            $parameters["name"] = $room->getName();
            $parameters["capacity"] = $room->getCapacity();
            $parameters["price"] = $room->getPrice();

            $this->connection->execute("nonQuery",$query, $parameters);

        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function getAll()
    {
        try {
            $roomList = array();

            $query = "SELECT * FROM " . $this->tableName;

            $resultSet = $this->connection->execute('query',$query);

            if (!empty($resultSet)) {
                foreach ($resultSet as $row) {

                    $room = new Room();
                    $room->setId($row["id"]);
                    $room->setName($row["name"]);
                    $room->setCapacity($row["capacity"]);
                    $room->setPrice($row["price"]);

                    array_push($roomList, $room);
                }
            }

            return $roomList;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function getByName($name)
    {
        try {

            $room = false;

            $query = "SELECT * FROM room WHERE name='$name'";
            $resultSet = $this->connection->execute('query',$query);

            if (!empty($resultSet)) {
                foreach ($resultSet as $row) {

                    $room = new Room();
                    $room->setId($row["id"]);
                    $room->setName($row["name"]);
                    $room->setCapacity($row["capacity"]);
                    $room->setPrice($row["price"]);
    
                }
            }

            return $room;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function getById($idRoom){
        
        try {

            $room = false;

            $query = "SELECT * FROM room WHERE id='$idRoom'";
            $resultSet = $this->connection->execute('query',$query);

            if (!empty($resultSet)) {
                foreach ($resultSet as $row) {

                    $room = new Room();
                    $room->setId($row["id"]);
                    $room->setName($row["name"]);
                    $room->setCapacity($row["capacity"]);
                    $room->setPrice($row["price"]);
    
                }
            }

            return $room;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function update($modifiedRoom){

        try {
            
            $id = $modifiedRoom->getId();
            $name = $modifiedRoom->getName();
            $capacity = $modifiedRoom->getCapacity();
            $price = $modifiedRoom->getPrice();

            $query = "UPDATE $this->tableName SET name='$name',capacity= '$capacity',price= '$price' WHERE id='$id'";
            $this->connection->execute('nonQuery', $query);
        } catch (\PDOException $ex) {
            throw $ex;
        }

    }

    public function getRoomsByCinemaId($idCinema)
    {
        try {
            $query = "SELECT room.id, room.name, room.capacity, room.price FROM room WHERE room.idCinema=$idCinema";

            $resultSet = $this->connection->execute('query', $query);

            $room = NULL;
            $roomList = array();

            foreach ($resultSet as $row) {

                $room = new Room();
                $room->setId($row["id"]);
                $room->setName($row["name"]);
                $room->setCapacity($row["capacity"]);
                $room->setPrice($row["price"]);
                array_push($roomList,$room);
            }

            return $roomList;

            

        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function existsName($name,$idCinema)
    {
        $exists = false;
        try {
            $query = "SELECT * FROM room WHERE room.name ='$name' AND room.idCinema ='$idCinema'";
            $resultSet = $this->connection->execute('query',$query);
            if (!empty($resultSet)) {
                $exists = true;
            }
            return $exists;
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function remove($roomId)
    {
        try {
            $query = "DELETE FROM " . $this->tableName . " WHERE " . $this->tableName . ".id ='$roomId'";
            $this->connection->execute('nonQuery',$query);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }


    public function getCinemaId($roomId){

        try {

            $room = false;

            $query = "SELECT idCinema FROM room WHERE id='$roomId'";
            $resultSet = $this->connection->execute('query',$query);

            if (!empty($resultSet)) {
                foreach ($resultSet as $row) {
                    
                    $idCinema = $row['idCinema'];


                }
            }

            return $idCinema;
        } catch (\PDOException $ex) {
            throw $ex;
        }
        


    }


}