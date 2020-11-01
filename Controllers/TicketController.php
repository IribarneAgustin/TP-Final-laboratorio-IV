<?php

namespace Controllers;

use DAO\MovieShowDAO;
use Models\MovieShow;

class TicketController
{
    private $movieshowDAO;

    public function __construct()
    {
        $this->movieshowDAO = new MovieShowDAO();
    }
    
    public function buyTicket($movieShowId)
    {
     //   $movieShow = $this->movieshowDAO->getById($movieShowId);
        //$idUser = $_SESSION['loggedUser']->getId();

        
    }
}
