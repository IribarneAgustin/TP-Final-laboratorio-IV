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
        try{
            session_start();   
            }catch (Exception $ex) {
                throw $ex;
        }
    }

    public function showListByCinemaId($cinemaId, $message = "")
    {
            require_once(VIEWS_PATH."validate-session-admin.php");
            $roomList = $this->roomDAO->getRoomsByCinemaId($cinemaId);
            require_once(VIEWS_PATH . "room-list.php");
        
    }

    public function showList($message = "")
    {
            require_once(VIEWS_PATH."validate-session-admin.php");
            $roomList = $this->roomDAO->getAll();
            require_once(VIEWS_PATH . "room-list.php");
       
    }

    public function showAddView($cinemaId, $message = '')
    {
            require_once(VIEWS_PATH."validate-session-admin.php");
            require_once(VIEWS_PATH . "add-room.php");
        
    }

    public function add($cinemaId, $name, $price, $capacity)
    {
            require_once(VIEWS_PATH."validate-session-admin.php");
            if ($this->roomDAO->existsName($name,$cinemaId) == false) {
                $newRoom = new Room();
                $newRoom->setName($name);
                $newRoom->setCapacity($capacity);
                $newRoom->setPrice($price);
                $newRoom->setStatus(true);
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
            require_once(VIEWS_PATH."validate-session-admin.php");
            $this->roomDAO->remove($roomId);
            $this->showList($message = "Room removed succesfully");
      
    }
    public function activate($roomId){
            require_once(VIEWS_PATH."validate-session-admin.php");
            $this->roomDAO->activate($roomId);
            $this->showList("Room actived succesfully");
       
    }


    public function modify($id, $field, $newContent)
    {
            require_once(VIEWS_PATH."validate-session-admin.php");
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
