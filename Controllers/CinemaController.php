<?php

namespace Controllers;

use DAO\CinemaDAO;
use Models\Cinema;


class CinemaController
{


    private $cinemaDAO;


    public function __construct()
    {
        $this->cinemaDAO = new CinemaDAO();
    }

    public function showList($message = '')
    {

        $cinemaList = $this->cinemaDAO->getAll();
        require_once(VIEWS_PATH . "cinema-list.php");
    }

    public function showAddView($message = '')
    {
        require_once(VIEWS_PATH . "add-cinema.php");
    }

    public function add($name, $adress, $ticketPrice, $capacity)
    {
        if ($this->cinemaDAO->existsName($name) == false) {

            $newCinema = new Cinema();
            $newCinema->setName($name);
            $newCinema->setAdress($adress);
            $newCinema->setTicketPrice($ticketPrice);
            $newCinema->setCapacity($capacity);

            $this->cinemaDAO->add($newCinema);
            $this->showAddView();
        }
        else{
            $this->showAddView($message = "El nombre ingresado ya existe");
        }
    }

    public function remove($cinemaId)
    {

        $this->cinemaDAO->remove($cinemaId);

        $this->showList();
    }


    public function modify($id, $field, $newContent)
    {

        $toModify = $this->cinemaDAO->getById($id);

        if (isset($toModify)) {

            $myMetohd = "set" . $field;
            $toModify->$myMetohd($newContent);

            $this->cinemaDAO->update($toModify);
        }

        $this->showList();
    }
}
