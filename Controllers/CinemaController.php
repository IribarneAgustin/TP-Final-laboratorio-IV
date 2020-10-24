<?php

namespace Controllers;

use DAO\CinemaDAOJson;
use DAO\CinemaDAOMySQL;
use DAO\RoomDAO;
use Models\Cinema;
use Models\Room;


class CinemaController
{

    private $cinemaDAO;


    public function __construct()
    {
        $this->cinemaDAO = new CinemaDAOMySQL();
        $this->roomDAO = new RoomDAO();
    }

    public function showList($message = "")
    {

        $cinemaList = $this->cinemaDAO->getAll();
        require_once(VIEWS_PATH . "cinema-list.php");
    }

    public function showAddView($message = "")
    {
        require_once(VIEWS_PATH . "add-cinema.php");
    }

    public function add($name, $address, $ticketPrice, $capacity)
    {
        if ($this->cinemaDAO->existsName($name) == false) {

            $newCinema = new Cinema();
            $newCinema->setName($name);
            $newCinema->setAddress($address);
            $newCinema->setTicketPrice($ticketPrice);
            $newCinema->setCapacity($capacity);
            $this->cinemaDAO->add($newCinema);
            $this->showAddView($message = "Cinema added succesfully");
            
        } else {
            $this->showAddView($message = "Name already in use");
        }
    }

    public function remove($cinemaId)
    {

        $this->cinemaDAO->remove($cinemaId);

        $this->showList($message = "Cinema removed succesfully");
    }


    public function modify($id, $field, $newContent)
    {

        $toModify = $this->cinemaDAO->getById($id);

        if ($field == "name" && $this->cinemaDAO->existsName($newContent) == true) {
            $this->showList($message = "Name already in use");

        } else {

            if (isset($toModify)) {

                $myMetohd = "set" . $field;
                $toModify->$myMetohd($newContent);

                $this->cinemaDAO->update($toModify);
            }

            $this->showList($message = "Cinema modified succesfully");
        }
    }
    public function showRoomList($message=''){
        require_once(VIEWS_PATH . "room-list.php");
    }


    public function addRoom($cinemaId, $name, $capacity, $price){

        $cinema = $this->cinemaDAO->getById($cinemaId);       
        
        if ($cinema) {

            $newRoom = new Room();
            $newRoom->setName($name);
            $newRoom->setCapacity($capacity);
            $newRoom->setPrice($price);
            $cinema->addRoom($newRoom);
            $this->roomDAO->add($newRoom);
            $this->cinemaDAO->update($cinema);       
            $this->showRoomList("Room added succesfully");

        }

    }
}
