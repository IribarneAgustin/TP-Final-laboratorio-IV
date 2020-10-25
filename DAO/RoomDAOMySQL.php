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

    public function add(Room $room)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (name, price, capacity) VALUES (:name, :price, :capacity);";

            $parameters["name"] = $room->getName();
            $parameters["price"] = $room->getprice();
            $parameters["capacity"] = $room->getCapacity();

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
                    $room->setPrice($row["price"]);
                    $room->setCapacity($row["capacity"]);

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
                    $room->setPrice($row["price"]);
                    $room->setCapacity($row["capacity"]);
    
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
                    $room->setPrice($row["price"]);
                    $room->setCapacity($row["capacity"]);
    
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
            $price = $modifiedRoom->getPrice();
            $capacity = $modifiedRoom->getCapacity();


            $query = "UPDATE $this->tableName SET name='$name',price= '$price',capacity= '$capacity' WHERE id='$id'";
            $this->connection->execute('nonQuery', $query);
        } catch (\PDOException $ex) {
            throw $ex;
        }


    }

  /*  public function remove(){

        


    }
*/




}