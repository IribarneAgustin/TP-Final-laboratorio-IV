<?php

namespace Controllers;

use DAO\CinemaDAOMySQL;
use DAO\roomDAO;
use DAO\RoomDAOMySQL;
use Models\Room;

class RoomController
{

    private $roomDAO;
    private $cinemaDAO;

    public function __construct()
    {
        $this->roomDAO = new RoomDAOMySQL();
        $this->cinemaDAO = new CinemaDAOMySQL();
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

    public function add($cinemaId, $name, $price, $capacity)
    {
        if ($this->roomDAO->existsName($name,$cinemaId) == false) {
            $newRoom = new Room();
            $newRoom->setName($name);
            $newRoom->setCapacity($capacity);
            $newRoom->setPrice($price);

            $cinema = $this->cinemaDAO->getById($cinemaId);


            $this->roomDAO->add($newRoom,$cinema);
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

            $myMethod = "set" . $field;
            $toModify->$myMethod($newContent);
            $this->roomDAO->update($toModify);
            $cinemaId = $this->roomDAO->getCinemaId($toModify->getId());
            $this->showListByCinemaId($cinemaId);
        }else{
            $this->showList();
        }

        
    }
}
