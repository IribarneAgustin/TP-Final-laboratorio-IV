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

    public function processPurchase($movieShowId, $quantity)
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
        $ticket->setStatus(0);

        //Valido la capacidad segun las entradas solicitadas
        if ($this->validateCapacity($movieShow, $ticket->getQuantity())) {

            //Guardo temporalmente la posible compra en sesion.
            $_SESSION['purchase'] = $ticket;

            //Muestro total
            $this->showTotal($movieShow, $ticket);
        } else {
            $this->buyTicketView($movieShow->getId(), "Tickets sold out!");
        }
    }

    public function showTotal(MovieShow $movieShow, Ticket $ticket)
    {
        require_once(VIEWS_PATH . "addToCartView.php");
    }

    public function addToCart($confirm = 0)
    {
        //Si el usuario la confirma, la guardo en base de datos
        if ($confirm == 1) {

            session_start();
            $ticket = $_SESSION['purchase'];
            $this->add($ticket);
            $this->showShoppingCart("Movie show added succesfully");
        } else {
            $_SESSION['purchase'] = null;
            require_once(VIEWS_PATH . "userHome.php");
        }
    }

    public function showShoppingCart($message = '')
    {
        if (!isset($_SESSION['user'])) {
            session_start();
        }

        $ticketToPayList = array();
        $ticketList = $this->ticketDAO->getTicketsByUserId($_SESSION['user']->getId());
        foreach ($ticketList as $value) {
            if ($value->getStatus() == false) {
                array_push($ticketToPayList, $value);
            }
        }
        require_once(VIEWS_PATH . "shoppingCart.php");
    }

    public function validateCard()
    {
        require_once(VIEWS_PATH . "validation-card.php");
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

    public function add(Ticket $ticket)
    {
        $movieShow = $ticket->getMovieShow();
        $this->ticketDAO->add($ticket);
        $movieShow->setTicketsSold($movieShow->getTicketsSold() + $ticket->getQuantity());
        $this->movieshowDAO->updateTicketsSold($movieShow);
    }
}
