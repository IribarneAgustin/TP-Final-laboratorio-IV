<?php

namespace Controllers;

use DAO\CineDAO;
use Models\Cine;


class CineController
{


    private $cineDAO;


    public function __construct()
    {
        $this->cineDAO = new CineDAO();
    }

    public function showList()
    {

        $cineList = $this->cineDAO->getAll();
        require_once(VIEWS_PATH . "cine-list.php");
    }
    public function showAddView(){
        require_once(VIEWS_PATH . "add-cine.php");
    }

    public function add($name, $adress, $ticketPrice, $capacity)
    {

        $newCine = new Cine();
        $newCine->setName($name);
        $newCine->setAdress($adress);
        $newCine->setTicketPrice($ticketPrice);
        $newCine->setCapacity($capacity);

      
        $this->cineDAO->add($newCine);

        $this->showAddView();
    }
}
