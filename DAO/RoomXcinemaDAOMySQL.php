<?php

namespace DAO;

use Models\Room;
use Models\Cinema;

class RoomXcinemaDAOMySQL
{

    private $connection;
    private $tableName = "roomXcine";

    public function __construct()
    {
        $this->connection = new Connection();
    }
    public function add(Room $room, Cinema $cinema)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (idCinema,idRoom) VALUES (:idCinema,:idRoom);";

            $parameters["idCinema"] = $cinema->getId();
            $parameters["idRoom"] = $room->getId();

            $this->connection->execute("nonQuery", $query, $parameters);

        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function getRoomsByCinemaId($idCinema)
    {
        try {
            $query = "SELECT room.id, room.name, room.capacity, room.price FROM room JOIN roomXcine WHERE roomXcine.idCinema=$idCinema";

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
}
