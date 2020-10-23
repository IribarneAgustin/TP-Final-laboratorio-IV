<?php

namespace Controllers;

use DAO\roomDAO;
use DAO\cinemaDAOJson;
use Models\Room;
use Models\Cinema;


class RoomController
{

    private $roomDAO;
    private $cinemaDAO;


    public function __construct()
    {
        $this->roomDAO = new RoomDAO();
        $this->cinemaDAO = new CinemaDAOJson();
    }

    public function showListByCinemaId($cinemaId, $message = "")
    {
        $cinema = $this->cinemaDAO->getById($cinemaId);
        $roomList = $cinema->getRooms();
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
    
    public function add($cinemaId, $name, $capacity, $price){

        $cinema = $this->cinemaDAO->getById($cinemaId);       
        /*Agregar control del nombre en el mismo cine */
        if ($cinema) {

            $newRoom = new Room();
            $newRoom->setName($name);
            $newRoom->setCapacity($capacity);
            $newRoom->setPrice($price);
            $cinema->addRoom($newRoom);
            $this->roomDAO->add($newRoom);
            $this->cinemaDAO->update($cinema);            
            $this->showListByCinemaId($cinemaId,"Room added succesfully");

        }

    }

    public function remove($roomId)
    {
        $this->roomDAO->remove($roomId);
        $this->cinemaDAO->removeRoom($roomId);
        $this->showList();
    }


    public function modify($id, $field, $newContent)
    {

        $toModify = $this->roomDAO->getById($id);

        if ($field == "name" && $this->roomDAO->existsName($newContent) == true) {
            $this->showList($message = "Name already in use");
        } else {

            if (isset($toModify)) {

                $myMetohd = "set" . $field;
                $toModify->$myMetohd($newContent);
                $this->roomDAO->update($toModify);
                $this->cinemaDAO->updateRoom($toModify);
            }

            $this->showList();
        }
    }
}
