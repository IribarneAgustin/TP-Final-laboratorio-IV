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
        try{
            session_start();   
        }catch (Exception $ex) {
            throw $ex;
        }
    }


    public function calculateTotal($roomPrice, $quantity)
    {
        require_once(VIEWS_PATH."validate-session-logged.php");
        return ($roomPrice * $quantity);
    }

    public function buyTicketView($movieShowId, $message = "")
    {
        require_once(VIEWS_PATH."validate-session-logged.php");
        $movieShow = $this->movieshowDAO->getById($movieShowId);
        require_once(VIEWS_PATH . "buy-ticket.php");
    }

    public function processPurchase($movieShowId, $quantity)
    {
        require_once(VIEWS_PATH."validate-session-logged.php");
        $movieShow = $this->movieshowDAO->getById($movieShowId);
        $total =  $this->calculateTotal($movieShow->getRoom()->getPrice(), $quantity);
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
        require_once(VIEWS_PATH."validate-session-logged.php");
        require_once(VIEWS_PATH . "addToCartView.php");
    }

    public function addToCart($confirm = 0)
    {
        require_once(VIEWS_PATH."validate-session-logged.php");
        //Si el usuario la confirma, la guardo en base de datos
        if ($confirm == 1) {
            $ticket = $_SESSION['purchase'];
            $this->add($ticket);
            $this->showShoppingCart("Ticket added to cart succesfully");
        } else {
            $_SESSION['purchase'] = null;
            require_once(VIEWS_PATH . "userHome.php");
        }
    }

    public function showShoppingCart($message = '')
    {
        require_once(VIEWS_PATH."validate-session-logged.php");
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
        require_once(VIEWS_PATH."validate-session-logged.php");
        require_once(VIEWS_PATH . "validation-card.php");
    }


    public function validateCapacity(MovieShow $movieShow, $quantity)
    {
        require_once(VIEWS_PATH."validate-session-logged.php");
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
        require_once(VIEWS_PATH."validate-session-logged.php");
        $movieShow = $ticket->getMovieShow();
        $this->ticketDAO->add($ticket);
        $movieShow->setTicketsSold($movieShow->getTicketsSold() + $ticket->getQuantity());
        $this->movieshowDAO->updateTicketsSold($movieShow);
    }
}