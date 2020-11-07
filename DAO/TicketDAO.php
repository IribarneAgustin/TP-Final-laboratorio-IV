<?php

namespace DAO;

use Models\Ticket;
use Models\User;
use Models\MovieShow;
use Models\Movie;
use Models\Cinema;
use Models\Room;

class TicketDAO implements ITicketDAO
{

    private $connection;
    private $tableName = "ticket";

    public function __construct()
    {
        $this->connection = new Connection();
    }


    public function add(Ticket $ticket)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (idUser, idMovieShow, total, status) VALUES (:idUser, :idMovieShow, :total, :status);";

            $parameters["idUser"] = $ticket->getUser()->getId();
            $parameters["idMovieShow"] = $ticket->getMovieShow()->getId();
            $parameters["total"] = $ticket->getTotal();
            $parameters["status"] = $ticket->getStatus();

            $this->connection->execute("nonQuery", $query, $parameters);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function getTicketsByUserId($userId){

        try {

            $query = "SELECT t.id,t.total,t.status,ms.date,ms.time,movie.title FROM ticket as t JOIN movieshow as ms on ms.id = t.idMovieShow JOIN movie on ms.idMovie = movie.id WHERE t.idUser='$userId'";
            $resultSet = $this->connection->execute('query',$query);
            $ticketList = array();

            if (!empty($resultSet)) {
                foreach ($resultSet as $row) {

                    $ticket = new Ticket();
                    $ticket->setId($row["id"]);
                    $ticket->setTotal($row["total"]);
                    $ticket->setStatus($row["status"]);

                    
                    $movieShow = new MovieShow();
                    $movieShow->setTime($row["time"]); 
                    $movieShow->setDate($row["date"]);

                    $movie = new Movie();
                    $movie->setTitle($row["title"]);    
                    
                    $movieShow->setMovie($movie);
                    $ticket->setMovieShow($movieShow);


                    array_push($ticketList,$ticket);

                }
            }

            return $ticketList;
        } catch (\PDOException $ex) {
            throw $ex;
        }

    }

    public function getLastTicketByUserIdAndShowId($userId,$showId){

        try {

            $query = "SELECT r.name as rname, c.name as cname, MAX(t.id) as id,t.total,t.status,ms.date,ms.time,movie.title FROM ticket as t JOIN movieshow as ms on ms.id = t.idMovieShow JOIN movie on ms.idMovie = movie.id 
            JOIN room as r on r.id = ms.idRoom JOIN cinema as c on c.id = r.idCinema WHERE t.idUser='$userId' AND ms.id = $showId ";
            $resultSet = $this->connection->execute('query',$query);
           
            if (!empty($resultSet)) {
                foreach ($resultSet as $row) {

                    $ticket = new Ticket();
                    $ticket->setId($row["id"]);
                    $ticket->setTotal($row["total"]);
                    $ticket->setStatus($row["status"]);

                    
                    $movieShow = new MovieShow();
                    $movieShow->setTime($row["time"]); 
                    $movieShow->setDate($row["date"]);

                    $movie = new Movie();
                    $movie->setTitle($row["title"]);    

                    $room = new Room();
                    $room->setName($row["rname"]);

                    $cinema = new Cinema();
                    $cinema->setName($row["cname"]);

                    $room->setCinema($cinema); 
                    $movieShow->setRoom($room);                   
                    $movieShow->setMovie($movie);
                    $ticket->setMovieShow($movieShow);

                }
            }

            return $ticket;
        } catch (\PDOException $ex) {
            throw $ex;
        }





    }





}
