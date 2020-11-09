<?php
namespace DAO;
use Models\Room;
use Models\Cinema as Cinema;

class RoomDAOMySQL implements IRoomDAO
{


    private $connection;
    private $tableName = "room";

    public function __construct()
    {
        $this->connection = new Connection();
    }

    public function add(Room $room)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (idCinema, name, capacity, price, status) VALUES (:idCinema, :name, :capacity, :price, :status);";

            $parameters["idCinema"] = $room->getCinema()->getId();
            $parameters["name"] = $room->getName();
            $parameters["capacity"] = $room->getCapacity();
            $parameters["price"] = $room->getPrice();
            $parameters["status"] = $room->getStatus();

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
                    $room->setStatus($row["status"]);
                    
                    $cinema = new Cinema();
                    $cinema->setId($row["idCinema"]);
                    $room->setCinema($cinema);
                    

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
                    $room->setStatus($row["status"]);

                    $cinema = new Cinema();
                    $cinema->setId($row["idCinema"]);
                    $room->setCinema($cinema);
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
                    $room->setStatus($row["status"]);

                    $cinema = new Cinema();
                    $cinema->setId($row["idCinema"]);
                    $room->setCinema($cinema);
    
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
            $status = $modifiedRoom->getStatus();

            $query = "UPDATE $this->tableName SET name='$name',capacity= '$capacity',price= '$price', status='$status' WHERE id='$id'";
            $this->connection->execute('nonQuery', $query);
        } catch (\PDOException $ex) {
            throw $ex;
        }

    }

    public function getRoomsByCinemaId($idCinema)
    {
        try {
            $query = "SELECT room.id, room.name, room.capacity, room.price, room.status, room.idCinema FROM room WHERE room.idCinema=$idCinema";

            $resultSet = $this->connection->execute('query', $query);

            $room = NULL;
            $roomList = array();

            foreach ($resultSet as $row) {

                $room = new Room();
                $room->setId($row["id"]);
                $room->setName($row["name"]);
                $room->setCapacity($row["capacity"]);
                $room->setPrice($row["price"]);
                $room->setStatus($row["status"]);

                $cinema = new Cinema();
                $cinema->setId($row["idCinema"]);
                $room->setCinema($cinema);

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
            
            $query = "UPDATE $this->tableName SET status=false WHERE id='$roomId'";
            $this->connection->execute('nonQuery', $query);

        } catch (\PDOException $ex) {
            throw $ex;
        }
    }
    public function activate($roomId){
        try {
            $status = true;
            $query = "UPDATE $this->tableName SET status=true WHERE id='$roomId'";
            $this->connection->execute('nonQuery', $query);

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