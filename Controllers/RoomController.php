<?php

namespace Controllers;

use DAO\roomDAO;
use Models\Room;


class RoomController
{

    private $roomDAO;


    public function __construct()
    {
        $this->roomDAO = new RoomDAO();
    }

    public function showListByCinemaId($cinemaId,$message = "")
    {
        $roomList = $this->roomDAO->getRoomsByCinemaId($cinemaId);
        require_once(VIEWS_PATH . "room-list.php");
    }

    public function showList($message = "")
    {

        $roomList = $this->roomDAO->getAll();
        require_once(VIEWS_PATH . "room-list.php");
    }

    public function showAddView($cinemaId,$message='')
    {
        require_once(VIEWS_PATH . "add-room.php");
    }


    public function add($cinemaId,$name,$capacity,$price)
    {

        /*Corregir modificacion a solo los nombres de las salas del mismo cine */
        if ($this->roomDAO->existsName($name) == false) {

            $newRoom = new Room();
            $newRoom->setCinemaId($cinemaId);
            $newRoom->setName($name);
            $newRoom->setCapacity($capacity);
            $newRoom->setPrice($price);
            $this->roomDAO->add($newRoom);
            $this->showAddView("Room added succesfully");

        } else {
            $this->showAddView($cinemaId,$message = "Name already in use");
        }
    }

    public function remove($roomId)
    {

        $this->roomDAO->remove($roomId);

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
            }

            $this->showList();
        }
    }
}
