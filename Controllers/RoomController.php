<?php

namespace Controllers;

use DAO\roomDAO;
use DAO\cinemaDAOJson;
use DAO\CinemaDAOMySQL;
use DAO\RoomDAOMySQL;
use DAO\RoomXcinemaDAOMySQL;
use Models\Room;
use Models\Cinema;


class RoomController
{

    private $roomDAO;
    private $cinemaDAO;
    private $roomXcinemaDAO;


    public function __construct()
    {
        $this->roomDAO = new RoomDAOMySQL();
        $this->cinemaDAO = new CinemaDAOMySQL();
        $this->roomXcinemaDAO = new RoomXcinemaDAOMySQL();
    }

    public function showListByCinemaId($cinemaId, $message = "")
    {
        $roomList = $this->roomXcinemaDAO->getRoomsByCinemaId($cinemaId);
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
            $this->roomDAO->add($newRoom);
            $room= $this->roomDAO->getByName($name);
            $this->roomXcinemaDAO->add($room,$cinema);            
            $this->showListByCinemaId($cinemaId,"Room added succesfully");

        }

    }

    public function remove($roomId)
    {
     //   $this->roomDAO->remove($roomId);
     //   $this->cinemaDAO->removeRoom($roomId);
        $this->showList();
    }


    public function modify($id, $field, $newContent)
    {

      //  $toModify = $this->roomDAO->getById($id);

      //  if ($field == "name" && $this->roomDAO->existsName($newContent) == true) {
            $this->showList($message = "Name already in use");
      //  } else {

            if (isset($toModify)) {

                $myMetohd = "set" . $field;
                $toModify->$myMetohd($newContent);
              //  $this->roomDAO->update($toModify);
            //    $this->cinemaDAO->updateRoom($toModify);
           // }

            $this->showList();
        }
    }
}
