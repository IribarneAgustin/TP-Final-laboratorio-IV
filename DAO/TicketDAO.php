<?php

namespace DAO;

use Models\Ticket;
use Models\User;


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
            $query = "INSERT INTO " . $this->tableName . " (idUser, idMovieShow, quantity, total, status) VALUES (:idUser, :idMovieShow, :quantity, :total, :status);";

            $parameters["idUser"] = $ticket->getUser()->getId();
            $parameters["idMovieShow"] = $ticket->getMovieShow()->getId();
            $parameters["quantity"] = $ticket->getQuantity();
            $parameters["total"] = $ticket->getTotal();
            $parameters["status"] = $ticket->getStatus();

            $this->connection->execute("nonQuery", $query, $parameters);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }
}
