<?php

namespace Controllers;

use DAO\CinemaDAOMySQL;
use DAO\MoviesDAOMySQL;
use DAO\MovieShowDAO;
use DAO\TicketDAO;
use Models\MovieShow;
use Models\Ticket as Ticket;
use \FFI\Exception as Exception;
use QRcode;

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
        try {
            session_start();
        } catch (Exception $ex) {
            throw $ex;
        }
    }


    public function calculateTotal($roomPrice, $quantity)
    {
        require_once(VIEWS_PATH . "validate-session-logged.php");
        return ($roomPrice * $quantity);
    }

    public function buyTicketView($movieShowId, $message = "")
    {
        require_once(VIEWS_PATH . "validate-session-logged.php");
        $movieShow = $this->movieshowDAO->getById($movieShowId);
        require_once(VIEWS_PATH . "buy-ticket.php");
    }

    public function processPurchase($movieShowId, $quantity)
    {
        require_once(VIEWS_PATH . "validate-session-logged.php");
        $movieShow = $this->movieshowDAO->getById($movieShowId);
        $total = $movieShow->getRoom()->getPrice();
        //Calculate total nos va a servir para cuando apliquemos descuentos
        //$total =  $this->calculateTotal($movieShow->getRoom()->getPrice(), $quantity);
        $user = $_SESSION['user'];

        $ticket = new Ticket();
        $ticket->setUser($user);
        $ticket->setTotal($total);
        $ticket->setMovieShow($movieShow);
        $ticket->setQuantity($quantity);
        $ticket->setStatus(1);

        //Valido la capacidad segun las entradas solicitadas
        if ($this->validateCapacity($movieShow, $ticket->getQuantity())) {

            //Guardo temporalmente la posible compra en sesion.
            $_SESSION['ticket'] = $ticket;

            //Muestro total
            $this->showTotal($movieShow, $ticket);
        } else {
            $this->buyTicketView($movieShow->getId(), "Tickets sold out!");
        }
    }

    public function showTotal(MovieShow $movieShow, Ticket $ticket)
    {
        require_once(VIEWS_PATH . "validate-session-logged.php");
        require_once(VIEWS_PATH . "addToCartView.php");
    }

    public function addToCart($confirm = 0)
    {
        require_once(VIEWS_PATH . "validate-session-logged.php");
        //Si el usuario la confirma, la guardo en sesión
        if ($confirm == 1) {

            if (!isset($_SESSION['purchase'])) {
                $purchase = array();
                array_push($purchase, $_SESSION['ticket']);
                $_SESSION['purchase'] = $purchase;
            } else {
                array_push($_SESSION['purchase'], $_SESSION['ticket']);
            }
            $this->showShoppingCart("Ticket added to cart succesfully");
        } else {
            $_SESSION['ticket'] = null;
            require_once(VIEWS_PATH . "userHome.php");
        }
    }

    public function showShoppingCart($message = '')
    {
        require_once(VIEWS_PATH . "validate-session-logged.php");
        if (!isset($_SESSION['purchase'])) {
            $ticketList = array();
        } else {
            $ticketList = $_SESSION['purchase'];
        }
        require_once(VIEWS_PATH . "shoppingCart.php");
    }

    public function calculateTotalShoppingCart($ticketList)
    {
        require_once(VIEWS_PATH . "validate-session-logged.php");

        $total = 0;
        foreach ($ticketList as $value) {
            $total += $value->getTotal();
        }

        return $total;
    }

    public function validationCardView()
    {
        require_once(VIEWS_PATH . "validate-session-logged.php");
        $total = $this->calculateTotalShoppingCart($_SESSION['purchase']);
        require_once(VIEWS_PATH . "validation-card.php");
    }

    public function generateQr(Ticket $ticket)
    {

        require_once("Data/qrcode/qrlib.php");

        $dir = "Data/qrs/";

        if (!file_exists($dir)) {
            mkdir($dir);
        }
        
        $fileName = $dir . "qr" . $ticket->getId() . ".png";
        $size = 10;
        $level = 'M';
        $frameSize = 1;
        $content = "Ticket Number: " . $ticket->getId() . " " . $ticket->getMovieShow()->getMovie()->getTitle() . " " . $ticket->getMovieShow()->getRoom()->getCinema()->getName() . " " . $ticket->getMovieShow()->getDate() . " " . $ticket->getMovieShow()->getTime();
        QRcode::png($content, $fileName, $level, $size, $frameSize);
        

    }

    public function validationCard($total, $cardOwner, $cardNumber, $expirationMM, $expirationYY, $cvv)
    {
        require_once(VIEWS_PATH . "validate-session-logged.php");

        if ($total != 0) {
            $ticketList = $_SESSION['purchase'];

            foreach ($ticketList as $value) {
                $count = 0;
                while ($value->getQuantity() > $count) {
                    
                    $this->add($value);
                    $ticket = $this->ticketDAO->getLastTicketByUserIdAndShowId($_SESSION['user']->getId(), $value->getMovieShow()->getId());
                    $this->generateQr($ticket);
                    $count++;
                }
            }

            unset($_SESSION['purchase']);
            $this->showTicketList();
        } else {
            $this->showShoppingCart("The shopping cart are empty!");
        }
    }

    public function showTicketList()
    {
        require_once(VIEWS_PATH . "validate-session-logged.php");
        $ticketList = $this->ticketDAO->getTicketsByUserId($_SESSION['user']->getId());
        require_once(VIEWS_PATH . "ticketList.php");
    }

    public function showOrderedList($order){
        require_once(VIEWS_PATH . "validate-session-logged.php");
        $ticketList = $this->ticketDAO->getTicketsByUserOrdered($_SESSION['user']->getId(),$order);
        require_once(VIEWS_PATH . "ticketList.php");
    }

    public function validateCapacity(MovieShow $movieShow, $quantity)
    {
        require_once(VIEWS_PATH . "validate-session-logged.php");
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
        require_once(VIEWS_PATH . "validate-session-logged.php");
        $movieShow = $ticket->getMovieShow();
        $this->ticketDAO->add($ticket);
        $movieShow->setTicketsSold($movieShow->getTicketsSold() + $ticket->getQuantity());
        $this->movieshowDAO->updateTicketsSold($movieShow);
    }

    public function removeShoppingCart($movieShowId)
    {
        require_once(VIEWS_PATH . "validate-session-logged.php");
        if (!isset($_SESSION['purchase'])) {
            session_start();
        }
        $ticketList = $_SESSION['purchase'];
        $newTicketList = array();
        foreach ($ticketList as $value) {
            if ($value->getMovieShow()->getId() != $movieShowId) {
                array_push($newTicketList, $value);
            }
        }

        $_SESSION['purchase'] = $newTicketList;

        $this->showShoppingCart();
    }

    public function showSalesView()
    {
        require_once(VIEWS_PATH . "validate-session-admin.php");
        $movieShowList = $this->movieshowDAO->getAll();
        require_once(VIEWS_PATH . "sales-stats.php");
    }
}