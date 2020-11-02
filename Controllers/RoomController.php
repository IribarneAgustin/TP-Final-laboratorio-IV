<?php

namespace Controllers;

use DAO\CinemaDAOMySQL;
use DAO\roomDAO;
use DAO\RoomDAOMySQL;
use Models\Room;
use Controllers\HomeController; 

class RoomController
{

    private $roomDAO;
    private $cinemaDAO;
    private $home;

    public function __construct()
    {
        $this->roomDAO = new RoomDAOMySQL();
        $this->cinemaDAO = new CinemaDAOMySQL();
        $this->home = new HomeController();
        try{
            session_start();   
            }catch (Exception $ex) {
                throw $ex;
        }
    }

    public function showListByCinemaId($cinemaId, $message = "")
    {
        if ($_SESSION['user']->getRole() === 'admin')
        {
            $roomList = $this->roomDAO->getRoomsByCinemaId($cinemaId);
            require_once(VIEWS_PATH . "room-list.php");
        }else {
            $this->home->index();
        }
    }

    public function showList($message = "")
    {
        if ($_SESSION['user']->getRole() === 'admin')
        {
            $roomList = $this->roomDAO->getAll();
            require_once(VIEWS_PATH . "room-list.php");
        }else {
            $this->home->index();
        }
    }

    public function showAddView($cinemaId, $message = '')
    {
        if ($_SESSION['user']->getRole() === 'admin')
        {
            require_once(VIEWS_PATH . "add-room.php");
        }else {
            $this->home->index();
        }
    }

    public function add($cinemaId, $name, $price, $capacity)
    {
        if ($_SESSION['user']->getRole() === 'admin')
        {
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
        }else {
            $this->home->index();
        }
    }

    public function remove($roomId)
    {
        if ($_SESSION['user']->getRole() === 'admin')
        {
            $this->roomDAO->remove($roomId);
            $this->showList($message = "Room removed succesfully");
        }else {
            $this->home->index();
        }
    }
    public function activate($roomId){
        if ($_SESSION['user']->getRole() === 'admin')
        {
            $this->roomDAO->activate($roomId);
            $this->showList("Room actived succesfully");
        }else {
            $this->home->index();
        }
    }


    public function modify($id, $field, $newContent)
    {
        if ($_SESSION['user']->getRole() === 'admin')
        {
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
        }else {
            $this->home->index();
        }
    }
}
