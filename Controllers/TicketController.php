<?php

namespace Controllers;

use DAO\CinemaDAOMySQL;
use DAO\MoviesDAOMySQL;
use DAO\MovieShowDAO;
use DAO\TicketDAO;
use Models\MovieShow;
use Models\Ticket as Ticket;

class TicketController
{
    private $ticketDAO;
    private $movieshowDAO;
    private $cinemaDAO;
    private $movieDAO;

    public function __construct()
    {
        $this->ticketDAO = new TicketDAO();
        $this->movieshowDAO = new MovieShowDAO();
        $this->cinemaDAO = new CinemaDAOMySQL();
        $this->movieDAO = new MoviesDAOMySQL();
    }


    public function calculateTotal($roomPrice, $quantity)
    {
        return ($roomPrice * $quantity);
    }

    public function buyTicketView($movieShowId, $message = "")
    {
        $movieShow = $this->movieshowDAO->getById($movieShowId);
        require_once(VIEWS_PATH . "buy-ticket.php");
    }

    public function generateTicket($movieShowId, $quantity)
    {

        $movieShow = $this->movieshowDAO->getById($movieShowId);
        $total =  $this->calculateTotal($movieShow->getRoom()->getPrice(), $quantity);
        session_start();
        $user = $_SESSION['user'];

        $ticket = new Ticket();
        $ticket->setUser($user);
        $ticket->setTotal($total);
        $ticket->setMovieShow($movieShow);
        $ticket->setQuantity($quantity);
        $ticket->setStatus(true);

        if ($this->validateCapacity($movieShow, $ticket->getQuantity())) {
            //Mostrar total y pedir datos de tarjeta
            //$this->add($ticket,$movieShow);

        } else {
            $this->buyTicketView($movieShow->getId(), "Tickets sold out!");
        }
    }

    public function validationCard(Ticket $ticket,MovieShow $movieShow)
    {
        


    }

    public function validateCapacity(MovieShow $movieShow, $quantity)
    {

        $capacity = false;

        $ticketsSold = $movieShow->getTicketsSold();
        $ticketToSold =  $ticketsSold + $quantity;

        if ($ticketToSold <= $movieShow->getRoom()->getCapacity()) {
            $capacity = true;
        }

        return $capacity;
    }

    public function add(Ticket $ticket, MovieShow $movieShow)
    {
        $this->ticketDAO->add($ticket);
        $movieShow->setTicketsSold($movieShow->getTicketsSold() + $ticket->getQuantity());
        $this->movieshowDAO->updateTicketsSold($movieShow);
        $this->buyTicketView($movieShow->getId(), "Operation completed succesfully");
    }
}
