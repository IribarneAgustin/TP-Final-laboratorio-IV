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

    public function showList()
    {

        $cinemaList = $this->cinemaDAO->getAll();
        require_once(VIEWS_PATH . "cinema-list.php");
    }
    public function showAddView(){
        require_once(VIEWS_PATH . "add-cinema.php");
    }

    public function add($name, $adress, $ticketPrice, $capacity)
    {

        $newCinema = new Cinema();
        $newCinema->setName($name);
        $newCinema->setAdress($adress);
        $newCinema->setTicketPrice($ticketPrice);
        $newCinema->setCapacity($capacity);

      
        $this->cinemaDAO->add($newCinema);

        $this->showAddView();
    }
}
