<?php

namespace Controllers;

//use DAO\CinemaDAO;
use DAO\CinemaDAODB as CinemaDAO;
use Models\Cinema;


class CinemaController
{

    private $cinemaDAO;


    public function __construct()
    {
        $this->cinemaDAO = new CinemaDAO();
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
            $this->showAddView();
        } else {
            $this->showAddView($message = "Name already in use");
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

        if ($field == "name" && $this->cinemaDAO->existsName($newContent) == true) {
            $this->showList($message = "Name already in use");

        } else {

            if (isset($toModify)) {

                $myMetohd = "set" . $field;
                $toModify->$myMetohd($newContent);

                $this->cinemaDAO->update($toModify);
            }

            $this->showList();
        }
    }
}
