<?php

namespace Controllers;

use DAO\roomDAO;
use DAO\RoomDAOMySQL;
use Models\Room;

class RoomController
{

    private $roomDAO;

    public function __construct()
    {
        $this->roomDAO = new RoomDAOMySQL();
    }

    public function showListByCinemaId($cinemaId, $message = "")
    {
        $roomList = $this->roomDAO->getRoomsByCinemaId($cinemaId);
        require_once(VIEWS_PATH . "room-list.php");
    }

    public function showList($message = "")
    {

        $roomList = $this->roomDAO->getAll();
        require_once(VIEWS_PATH . "room-list.php");
    }

    public function showAddView($cinemaId, $message = '')
    {
        require_once(VIEWS_PATH . "add-room.php");
    }

    public function add($cinemaId, $name, $capacity)
    {
        if ($this->roomDAO->existsName($name,$cinemaId) == false) {
            $newRoom = new Room();
            $newRoom->setName($name);
            $newRoom->setCapacity($capacity);
            $this->roomDAO->add($newRoom,$cinemaId);
            $room = $this->roomDAO->getByName($name);
            $this->showAddView($cinemaId, "Room added succesfully");       
        } else {
            $this->showAddView($cinemaId, "Name already in use");
        }
    }

    public function remove($roomId)
    {
        $this->roomDAO->remove($roomId);
        $this->showList($message = "Room removed succesfully");
    }


    public function modify($id, $field, $newContent)
    {

        //Validar que no modifique el mismo nombre que las otras salas que estan en el mismo cine
        $toModify = $this->roomDAO->getById($id);

        if (isset($toModify)) {

            $myMetohd = "set" . $field;
            $toModify->$myMetohd($newContent);
            $this->roomDAO->update($toModify);
        }

        $this->showList();
    }
}
