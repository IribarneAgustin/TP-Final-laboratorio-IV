<?php

namespace Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception as MailerException;

use DAO\CinemaDAOMySQL;
use DAO\MoviesDAOMySQL;
use DAO\MovieShowDAO;
use DAO\TicketDAO;
use Models\MovieShow;
use Models\Ticket as Ticket;
use \FFI\Exception as Exception;
use QRcode;
use Models\Purchase;
use PHPMailer\PHPMailer\PHPMailer as PHPMailerPHPMailer;

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
        $ticket->setStatus(1);

        //Valido la capacidad segun las entradas solicitadas
        if ($this->validateCapacity($movieShow, $quantity)) {

            $purchase = new Purchase();
            $purchase->setTicket($ticket);
            $purchase->setQuantity($quantity);
            $purchase->setTotal($this->calculateTotal($movieShow->getRoom()->getPrice(), $quantity));

            //Verifico si aplica el descuento
            $dayOfTheWeek = date('w', strtotime($movieShow->getDate()));
            if ($quantity >= 2 &&  $dayOfTheWeek == 2 ||  $dayOfTheWeek == 3) {
                $ticket->setTotal($this->discountPrice($ticket->getTotal()));
                $purchase->setTicket($ticket);
                $purchase->setTotal($ticket->getTotal() * $purchase->getQuantity());
            }

            //Guardo temporalmente la posible compra en sesion.
            $_SESSION['purchase'] = $purchase;

            //Muestro total
            $this->showTotal($purchase);
        } else {
            $this->buyTicketView($movieShow->getId(), "Tickets sold out!");
        }
    }

    public function showTotal(Purchase $purchase)
    {
        require_once(VIEWS_PATH . "validate-session-logged.php");
        $movieShow = $purchase->getTicket()->getMovieShow();
        $total = $purchase->getTotal();
        require_once(VIEWS_PATH . "addToCartView.php");
    }

    public function addToCart($confirm = 0)
    {
        require_once(VIEWS_PATH . "validate-session-logged.php");
        //Si el usuario la confirma, la guardo en sesión
        if ($confirm == 1) {

            $purchase = $_SESSION['purchase'];
            $count = 0;

            if (!isset($_SESSION['ticketList'])) {
                $_SESSION['ticketList'] = array();
            }
            while ($purchase->getQuantity() > $count) {
                array_push($_SESSION['ticketList'], $purchase->getTicket());
                $count++;
            }

            $this->showShoppingCart("Ticket added to cart succesfully");
        } else {
            unset($_SESSION['purchase']);
            require_once(VIEWS_PATH . "userHome.php");
        }
    }

    public function showShoppingCart($message = '')
    {
        require_once(VIEWS_PATH . "validate-session-logged.php");
        if (!isset($_SESSION['ticketList'])) {
            $ticketList = array();
        } else {
            $ticketList = $_SESSION['ticketList'];
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
        $total = $this->calculateTotalShoppingCart($_SESSION['ticketList']);
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

        if (!isset($_SESSION['qrTickets'])) {
            $_SESSION['qrTickets'] = array();
        }
        array_push($_SESSION['qrTickets'], $fileName);
    }

    public function sendTicketToEmail()
    {
        require_once("Data/PHPMailer/src/Exception.php");
        require_once("Data/PHPMailer/src/PHPMailer.php");
        require_once("Data/PHPMailer/src/SMTP.php");


        $emailRecipient = $_SESSION['user']->getEmail();
        $qrCodes = $_SESSION['qrTickets'];

        $filesToSendList = array();
        $count = 0;

        foreach ($qrCodes as $qr) {

            $fileToSend =  "Data/qrs/email" . $count . ".png";
            fopen($fileToSend, "w");
            $img = file_get_contents("$qr"); //"Data/qrs/qr1.png");
            file_put_contents($fileToSend, $img);
            $count++;

            array_push($filesToSendList, $fileToSend);
        }

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'moviepasslabiv@gmail.com';                     // SMTP username
            $mail->Password   = 'laboratorio4';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('moviepasslabiv@gmail.com', 'MoviePass');
            $mail->addAddress($emailRecipient, 'MoviePass');     // Add a recipient

            // Attachments
            foreach ($filesToSendList as $file) {
                $mail->addAttachment($file);
            }


            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'MoviePass!';
            $mail->Body    = 'Thanks for buying your tickets in <b>MoviePass</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
        } catch (MailerException $e) {
            $this->showTicketList("Tickets could not be sent to the mail");
        }
    }

    public function discountPrice($price)
    {

        $discount = $price * 0.25;
        return ($price - $discount);
    }

    public function validationCard($total, $cardOwner, $cardNumber, $expirationMM, $expirationYY, $cvv)
    {
        require_once(VIEWS_PATH . "validate-session-logged.php");

        if ($total != 0) {
            $ticketList = $_SESSION['ticketList'];

            foreach ($ticketList as $value) {

                $this->add($value);
                $ticket = $this->ticketDAO->getLastTicketByUserIdAndShowId($_SESSION['user']->getId(), $value->getMovieShow()->getId());
                $this->generateQr($ticket);
            }

            $this->sendTicketToEmail();

            unset($_SESSION['qrTickets']);
            unset($_SESSION['purchase']);
            unset($_SESSION['ticketList']);
            
            $this->showTicketList("Thanks for buying your tickets in MoviePass!");
        } else {
            $this->showShoppingCart("The shopping cart are empty!");
        }
    }

    public function showTicketList($message = "")
    {
        require_once(VIEWS_PATH . "validate-session-logged.php");
        $ticketList = $this->ticketDAO->getTicketsByUserId($_SESSION['user']->getId());
        require_once(VIEWS_PATH . "ticketList.php");
    }

    public function showOrderedList($order)
    {
        require_once(VIEWS_PATH . "validate-session-logged.php");
        $ticketList = $this->ticketDAO->getTicketsByUserOrdered($_SESSION['user']->getId(), $order);
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
        $movieShow->setTicketsSold($movieShow->getTicketsSold() + 1);
        $this->movieshowDAO->updateTicketsSold($movieShow);
    }

    public function removeShoppingCart($movieShowId)
    {
        require_once(VIEWS_PATH . "validate-session-logged.php");
        if (!isset($_SESSION['ticketList'])) {
            session_start();
        }
        $ticketList = $_SESSION['ticketList'];
        foreach ($ticketList as $value) {
            if ($value->getMovieShow()->getId() == $movieShowId) {
                $key = array_search($value, $ticketList);
                unset($ticketList[$key]);
                break;
            }
        }
        $_SESSION['ticketList'] = $ticketList;


        $this->showShoppingCart();
    }

    public function showSalesView()
    {
        require_once(VIEWS_PATH . "validate-session-admin.php");
        $movieShowList = $this->movieshowDAO->getAll();
        require_once(VIEWS_PATH . "sales-stats.php");
    }
}
